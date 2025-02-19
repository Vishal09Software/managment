<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Product;
use App\Models\Tax;
use App\Models\Sale;
use App\Models\Setting;
use App\Models\PaymentIn;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;
use App\Services\FileUploadService;

class SalesController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }
    public function index(Request $request)
    {
        $query = Sale::query();
        if ($request->has('fields')) {
            $fields = $request->input('fields');

            if (!empty($fields['vendor_name'])) {
                $query->where('vendor_name', 'like', '%' . $fields['vendor_name'] . '%');
            }

            if (!empty($fields['customer_name'])) {
                $query->where('customer_name', 'like', '%' . $fields['customer_name'] . '%');
            }

            if (!empty($fields['driver_name'])) {
                $query->where('driver_name', 'like', '%' . $fields['driver_name'] . '%');
            }

            if (!empty($fields['eway_bill_number'])) {
                $query->where('eway_bill_number', 'like', '%' . $fields['eway_bill_number'] . '%');
            }
        }

        $sales = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.sales.index', compact('sales'));
    }

    public function create()
    {
        $vendors = Vendor::where('status', '1')->get();
        $customers = Customer::where('status', '1')->get();
        $vehicles = Vehicle::get();
        $products = Product::where('status', '1')->get();
        $taxes = Tax::where('status', '1')->get();
        // $sales = Sale::all();
        return view('admin.sales.create', compact('vendors', 'customers', 'vehicles', 'products', 'taxes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required',
            'vendor_id' => 'required',
            'customer_id' => 'required',
            'eway_bill_number' => 'required',
            'vehicle_id' => 'required',
            'vehicle_rate' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'r_weight' => 'required|numeric',
            'k_weight' => 'required|numeric',
            'product_id' => 'required',
            'p_price' => 'required|numeric|gt:0',
            's_price' => 'required|numeric|gt:p_price',
            'tax_id' => 'required',
            'remark' => 'nullable',
            'p_total' => 'required|numeric',
            's_total' => 'required|numeric',
            'v_total' => 'required|numeric',
            'supply_place' => 'required',
        ]);

        // Generate invoice number
        $lastSale = Sale::latest()->first();
        $lastInvoiceNumber = $lastSale ? intval(substr($lastSale->invoice_number, 3)) : 0;
        $newInvoiceNumber = 'INV' . str_pad($lastInvoiceNumber + 1, 6, '0', STR_PAD_LEFT);
        $validated['invoice_number'] = $newInvoiceNumber;

        // Get customer details
        $validated = array_merge(
            $validated,
            Sale::getCustomerDetails($request->customer_id)
        );

        // Get vendor details
        $validated = array_merge(
            $validated,
            Sale::getVendorDetails($request->vendor_id)
        );

        // Get vehicle details
        $validated = array_merge(
            $validated,
            Sale::getVehicleDetails($request->vehicle_id)
        );

        // Get tax details
        $validated = array_merge(
            $validated,
            Sale::getTaxDetails($request->tax_id)
        );

        if ($request->hasFile('image')) {
            $validated['image'] = $this->fileUploadService->upload(
                $request->file('image'),
                'images/sales'
            );
        }

        $sale = Sale::create($validated);

        return redirect()->route('sales.index')
            ->with('success', 'Sale created successfully.');
    }

    public function show(Sale $sale)
    {
        return view('admin.sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $vendors = Vendor::where('status', '1')->get();
        $customers = Customer::where('status', '1')->get();
        $vehicles = Vehicle::get();
        $products = Product::where('status', '1')->get();
        $taxes = Tax::all();

        return view('admin.sales.edit', compact('sale', 'vendors', 'customers', 'vehicles', 'products', 'taxes'));
    }

    public function update(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'date' => 'required',
            'vendor_id' => 'required',
            'customer_id' => 'required',
            'eway_bill_number' => 'required',
            'vehicle_id' => 'required',
            'vehicle_rate' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'r_weight' => 'required|numeric',
            'k_weight' => 'required|numeric',
            'product_id' => 'required',
            'p_price' => 'required|numeric|gt:0',
            's_price' => 'required|numeric|gt:p_price',
            'tax_id' => 'required',
            'remark' => 'nullable',
            'p_total' => 'required|numeric',
            's_total' => 'required|numeric',
            'v_total' => 'required|numeric',
            'supply_place' => 'required',
        ]);

        // Get customer details
        $customer = Customer::find($request->customer_id);
        // Get customer details
        $validated = array_merge(
            $validated,
            Sale::getCustomerDetails($request->customer_id)
        );

        // Get vendor details
        $validated = array_merge(
            $validated,
            Sale::getVendorDetails($request->vendor_id)
        );

        // Get vehicle details
        $validated = array_merge(
            $validated,
            Sale::getVehicleDetails($request->vehicle_id)
        );

        // Get tax details
        $validated = array_merge(
            $validated,
            Sale::getTaxDetails($request->tax_id)
        );

        if ($request->hasFile('image')) {
            $validated['image'] = $this->fileUploadService->upload(
                $request->file('image'),
                'images/sales',
                $sale->image
            );
        }
        $sale->update($validated);
        return redirect()->route('sales.index')
            ->with('success', 'Sale updated successfully');
    }

    public function destroy(Sale $sale)
    {
        if ($sale->image) {
            $this->fileUploadService->delete('images/sales/' . $sale->image);
        }
        $sale->delete();
        return redirect()->route('sales.index')
            ->with('error', 'Sale deleted successfully');
    }

    public function invoice($id)
    {
        $sale = Sale::findOrFail($id);
        $company = Setting::first();
        $payment = PaymentIn::where('customer_id', $sale->customer_id)->first();
        $pdf = PDF::loadView('admin.sales.invoice', compact('sale', 'company', 'payment'));
        return $pdf->download('invoice-' . $sale->id . '.pdf');
    }

}
