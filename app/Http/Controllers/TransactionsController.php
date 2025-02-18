<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\PaymentIn;
use App\Models\Vendor;
use App\Models\Vehicle;
use App\Models\PaymentOut;

class TransactionsController extends Controller
{
    public function paymentIn()
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

    public function paymentInCreate()
    {
        $customers = Customer::where('status', 1)->get();
        return view('admin.paymentIn.create', compact('customers'));
    }

    public function paymentInStore(Request $request)
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
        return redirect()->route('transactions.payment-in.index')->with('success', 'Payment created successfully');
    }

    public function paymentInEdit($id)
    {
        $payment = PaymentIn::find($id);
        $customers = Customer::where('status', 1)->get();
        return view('admin.paymentIn.edit', compact('payment', 'customers'));
    }

    public function paymentInUpdate(Request $request, $id)
    {
        $payment = PaymentIn::find($id);
        $payment->update($request->all());
        return redirect()->route('transactions.payment-in.index')->with('success', 'Payment updated successfully');
    }

    public function paymentInDestroy($id)
    {
        $payment = PaymentIn::find($id);
        $payment->delete();
        return redirect()->route('transactions.payment-in.index')->with('error', 'Payment deleted successfully');
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

    public function paymentOut()
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

    public function paymentOutCreate()
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

    public function paymentOutStore(Request $request)
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
        return redirect()->route('transactions.payment-out.index')->with('success', 'Payment created successfully');
    }

    public function paymentOutEdit($id)
    {
        $payment = PaymentOut::find($id);
        $vendors = Vendor::where('status', 1)->get();
        $vehicles = Vehicle::get();
        return view('admin.paymentOut.edit', compact('payment', 'vendors', 'vehicles'));
    }

    public function paymentOutUpdate(Request $request, $id)
    {
        $payment = PaymentOut::find($id);
        $payment->update($request->all());
        return redirect()->route('transactions.payment-out.index')->with('success', 'Payment updated successfully');
    }

    public function paymentOutDestroy($id)
    {
        $payment = PaymentOut::find($id);
        $payment->delete();
        return redirect()->route('transactions.payment-out.index')->with('error', 'Payment deleted successfully');
    }
}

