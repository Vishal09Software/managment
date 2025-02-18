<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentOut;
use App\Models\Vendor;
use App\Models\Vehicle;
use App\Models\Sale;

class TransactionsOutController extends Controller
{
    public function index()
    {
        $payments = PaymentOut::with(['vendor', 'vehicle'])
            ->when(request('type'), function($query) {
                $query->where('type', request('type'));

                if (request('type') === 'vendor' && request('vendor_id')) {
                    $query->where('vendor_id', request('vendor_id'));
                }

                if (request('type') === 'vehicle' && request('vehicle_id')) {
                    $query->where('vehicle_id', request('vehicle_id'));
                }

                return $query;
            })
            ->when(request('date_from'), function($query) {
                return $query->whereDate('payment_date', '>=', request('date_from'));
            })
            ->when(request('date_to'), function($query) {
                return $query->whereDate('payment_date', '<=', request('date_to'));
            })
            ->when(request('payment_method'), function($query) {
                return $query->where('payment_method', request('payment_method'));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $vendors = Vendor::where('status', 1)->get();
        $vehicles = Vehicle::all();

        return view('admin.paymentOut.index', compact('payments', 'vendors', 'vehicles'));
    }

    public function create()
    {
        $vendors = Vendor::where('status', 1)->get();
        $vehicles = Vehicle::get();
        return view('admin.paymentOut.create', compact('vendors', 'vehicles'));
    }


    public function getVendorAmounts()
    {
        $type = request()->get('type');
        $value = null;
        $totalVehicleAmount = 0;
        $totalPayments = 0;

        if ($type == 'vendor') {
            $vendorId = request()->get('vendor_id');
            $value = $vendorId;
            $totalVehicleAmount = Sale::where('vendor_id', $vendorId)
                ->where('p_total', '>', 0)
                ->sum('p_total');

            $totalPayments = PaymentOut::where('vendor_id', $vendorId)
                ->sum('amount');
        } else if ($type == 'vehicle') {
            $value = request()->get('vehicle_id');
            $totalVehicleAmount = Sale::where('vehicle_id', $value)
                ->where('v_total', '>', 0)
                ->sum('v_total');

            $totalPayments = PaymentOut::where('vehicle_id', $value)
                ->sum('amount');
        }

        $remainingAmount = $totalVehicleAmount - $totalPayments;

        return response()->json([
            'type' => $type,
            'value' => $value,
            'total_amount' => $totalVehicleAmount,
            'paid_amount' => $totalPayments,
            'remaining_amount' => $remainingAmount
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:vendor,vehicle',
            'vendor_id' => 'nullable|exists:vendors,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cash,bank,mobile_money',
            'payment_date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['reference_no'] = 'PAY-' . date('Ymd') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
        PaymentOut::create($data);
        return redirect()->route('transactions-out.index')->with('success', 'Payment created successfully');
    }

    public function edit($id)
    {
        $payment = PaymentOut::find($id);
        $vendors = Vendor::where('status', 1)->get();
        $vehicles = Vehicle::get();
        return view('admin.paymentOut.edit', compact('payment', 'vendors', 'vehicles'));
    }

    public function update(Request $request, $id)
    {
        $payment = PaymentOut::find($id);
        $payment->update($request->all());
        return redirect()->route('transactions-out.index')->with('success', 'Payment updated successfully');
    }

    public function destroy($id)
    {
        $payment = PaymentOut::find($id);
        $payment->delete();
        return redirect()->route('transactions-out.index')->with('error', 'Payment deleted successfully');
    }


    public function dataExport()
    {
        $payments = PaymentOut::with(['vendor', 'vehicle'])
            ->when(request('type'), fn($q) => $q->where('type', request('type')))
            ->when(request('vendor_id'), fn($q) => $q->where('vendor_id', request('vendor_id')))
            ->when(request('vehicle_id'), fn($q) => $q->where('vehicle_id', request('vehicle_id')))
            ->when(request('date_from'), fn($q) => $q->whereDate('payment_date', '>=', request('date_from')))
            ->when(request('date_to'), fn($q) => $q->whereDate('payment_date', '<=', request('date_to')))
            ->when(request('payment_method'), fn($q) => $q->where('payment_method', request('payment_method')))
            ->latest()
            ->get()
            ->map(fn($p) => [
                'Date' => $p->payment_date,
                'Reference No' => $p->reference_no,
                'Vendor' => $p->vendor?->name ?? 'N/A',
                'Vehicle' => $p->vehicle ? ($p->vehicle->driver_name ? $p->vehicle->driver_name . ' (' . $p->vehicle->vehicle_number . ')' : $p->vehicle->owner_name . ' (' . $p->vehicle->vehicle_number . ')') : 'N/A',
                'Amount' => number_format($p->amount, 2),
                'Payment Method' => ucwords(str_replace('_', ' ', $p->payment_method))
            ]);

        if ($payments->isEmpty()) {
            return redirect()->back()->with('error', 'No data available for export');
        }

        $filename = 'payments_out_' . date('Y-m-d_H-i-s') . '.xlsx';

        return response()->streamDownload(function() use ($payments) {
            $excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $excel->getActiveSheet();

            // Set headers style
            $headerStyle = [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E4E4E4']
                ]
            ];

            // Add headers
            $headers = array_keys($payments->first());
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . '1', $header);
                $sheet->getStyle($col . '1')->applyFromArray($headerStyle);
                $sheet->getColumnDimension($col)->setAutoSize(true);
                $col++;
            }

            // Add data
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
