<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\PaymentIn;
use App\Models\Sale;
use App\Services\TransactionService;


class TransactionsInController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index()
    {
        $customers = Customer::where('status', 1)
            ->orderBy('name')
            ->get();

        $payments = $this->transactionService->filterTransactions(PaymentIn::with('customer'))
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.paymentIn.index', compact('customers', 'payments'));
    }

    public function create()
    {
        $customers = Customer::where('status', 1)->get();
        return view('admin.paymentIn.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cash,bank,mobile_money',
            'payment_date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['reference_no'] = 'PAY-' . date('Ymd') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
        PaymentIn::create($data);
        return redirect()->route('transactions-in.index')->with('success', 'Payment created successfully');
    }

    public function edit($id)
    {
        $payment = PaymentIn::find($id);
        $customers = Customer::where('status', 1)->get();
        return view('admin.paymentIn.edit', compact('payment', 'customers'));
    }

    public function update(Request $request, $id)
    {
        $payment = PaymentIn::find($id);
        $payment->update($request->all());
        return redirect()->route('transactions-in.index')->with('success', 'Payment updated successfully');
    }

    public function destroy($id)
    {
        $payment = PaymentIn::find($id);
        $payment->delete();
        return redirect()->route('transactions-in.index')->with('error', 'Payment deleted successfully');
    }


    public function getCustomerAmounts($customerId)
    {
        $totalSales = Sale::where('customer_id', $customerId)
            ->sum('s_total');

        $totalPayments = PaymentIn::where('customer_id', $customerId)
            ->sum('amount');

        $remainingAmount = $totalSales - $totalPayments;

        return response()->json([
            'total_amount' => $totalSales,
            'paid_amount' => $totalPayments,
            'remaining_amount' => $remainingAmount
        ]);
    }

    public function paymentInReceipt($id)
    {
        $payment = PaymentIn::with(['customer'])->findOrFail($id);
        return view('admin.paymentIn.receipt', compact('payment'));
    }

    public function dataExport()
    {
        $payments = $this->transactionService->filterTransactions(PaymentIn::with(['customer']))
            ->latest()
            ->get()
            ->map(fn($p) => [
                'Date' => $p->payment_date,
                'Reference No' => $p->reference_no,
                'Customer' => $p->customer?->name ?? 'N/A',
                'Amount' => number_format($p->amount, 2),
                'Payment Method' => ucwords(str_replace('_', ' ', $p->payment_method))
            ]);

        if ($payments->isEmpty()) {
            return redirect()->back()->with('error', 'No data available for export');
        }

        $filename = 'payments_in_' . date('Y-m-d_H-i-s') . '.xlsx';

        return response()->streamDownload(function() use ($payments) {
            $excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $excel->getActiveSheet();

            // Add title row with date range
            $dateFrom = request('date_from') ?? 'Start';
            $dateTo = request('date_to') ?? 'End';
            $sheet->setCellValue('A1', "Payment In Report ($dateFrom to $dateTo)");
            $sheet->mergeCells('A1:E1');

            // Style the title
            $sheet->getStyle('A1')->getFont()->setBold(true);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            // Set headers style
            $headerStyle = [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E4E4E4']
                ]
            ];

            // Add headers in row 2
            $headers = array_keys($payments->first());
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . '2', $header);
                $sheet->getStyle($col . '2')->applyFromArray($headerStyle);
                $sheet->getColumnDimension($col)->setAutoSize(true);
                $col++;
            }

            // Add data starting from row 3
            $row = 3;
            foreach ($payments as $payment) {
                $col = 'A';
                foreach ($payment as $value) {
                    $sheet->setCellValue($col++ . $row, $value);
                }
                $row++;
            }

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
            $writer->save('php://output');
        }, $filename);
    }


}
