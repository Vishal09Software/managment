<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\PaymentIn;
use App\Models\Sale;


class TransactionsInController extends Controller
{
    public function index()
    {
        $customers = Customer::where('status', 1)
            ->orderBy('name')
            ->get();

        $payments = PaymentIn::with(['customer'])
            ->when(request('customer_id'), function($query) {
                return $query->where('customer_id', request('customer_id'));
            })
            ->when(request('payment_method'), function($query) {
                return $query->where('payment_method', request('payment_method'));
            })
            ->when(request('date_from'), function($query) {
                return $query->whereDate('payment_date', '>=', request('date_from'));
            })
            ->when(request('date_to'), function($query) {
                return $query->whereDate('payment_date', '<=', request('date_to'));
            })
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
        $payments = PaymentIn::with(['customer'])
            ->when(request('customer_id'), fn($q) => $q->where('customer_id', request('customer_id')))
            ->when(request('date_from'), fn($q) => $q->whereDate('payment_date', '>=', request('date_from')))
            ->when(request('date_to'), fn($q) => $q->whereDate('payment_date', '<=', request('date_to')))
            ->when(request('payment_method'), fn($q) => $q->where('payment_method', request('payment_method')))
            ->latest()
            ->get()
            ->map(fn($p) => [
                'Date' => $p->payment_date,
                'Reference No' => $p->reference_no,
                'Customer' => $p->customer->name ?? '',
                'Amount' => $p->amount,
                'Payment Method' => $p->payment_method,
            ]);

        $filename = 'payments_' . date('Y-m-d') . '.xlsx';

        return response()->streamDownload(function() use ($payments) {
            $excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $excel->getActiveSheet();

            $headers = array_keys($payments[0]);
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col++ . '1', $header);
            }

            $row = 2;
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
