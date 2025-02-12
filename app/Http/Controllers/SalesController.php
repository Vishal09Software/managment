<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Product;
use App\Models\Tax;
use App\Models\Sale;
class SalesController extends Controller
{
    public function index()
    {
        $sales = Sale::orderBy('created_at', 'desc')->paginate(10);
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
            'p_price' => 'required|numeric',
            's_price' => 'required|numeric',
            'tax_id' => 'required',
            'remark' => 'nullable',
            'p_total' => 'required|numeric',
            's_total' => 'required|numeric',
            'v_total' => 'required|numeric'
        ]);

        // Get customer details
        $customer = Customer::find($request->customer_id);
        $validated['customer_id'] = $customer->id;
        $validated['customer_name'] = $customer->name;
        $validated['customer_mobile'] = $customer->mobile;

        // Get vendor details
        $vendor = Vendor::find($request->vendor_id);
        $validated['vendor_id'] = $vendor->id;
        $validated['vendor_name'] = $vendor->name;
        $validated['vendor_mobile'] = $vendor->mobile;

        // Get vehicle details
        $vehicle = Vehicle::find($request->vehicle_id);
        $validated['vehicle_id'] = $vehicle->id;
        $validated['driver_name'] = $vehicle->driver_name;
        $validated['driver_phone'] = $vehicle->driver_phone;
        $validated['vehicle_number'] = $vehicle->vehicle_number;

        // Get tax details
        $tax = Tax::find($request->tax_id);
        $validated['tax_id'] = $tax->id;
        $validated['tax_name'] = $tax->tax_name;
        $validated['tax_rate'] = $tax->tax_rate;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/sales'), $imageName);
            $validated['image'] = $imageName;
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
            'p_price' => 'required|numeric',
            's_price' => 'required|numeric',
            'tax_id' => 'required',
            'remark' => 'nullable',
            'p_total' => 'required|numeric',
            's_total' => 'required|numeric',
            'v_total' => 'required|numeric'
        ]);

        // Get customer details
        $customer = Customer::find($request->customer_id);
        $validated['customer_id'] = $customer->id;
        $validated['customer_name'] = $customer->name;
        $validated['customer_mobile'] = $customer->mobile;

        // Get vendor details
        $vendor = Vendor::find($request->vendor_id);
        $validated['vendor_id'] = $vendor->id;
        $validated['vendor_name'] = $vendor->name;
        $validated['vendor_mobile'] = $vendor->mobile;

        // Get vehicle details
        $vehicle = Vehicle::find($request->vehicle_id);
        $validated['vehicle_id'] = $vehicle->id;
        $validated['driver_name'] = $vehicle->driver_name;
        $validated['driver_phone'] = $vehicle->driver_phone;
        $validated['vehicle_number'] = $vehicle->vehicle_number;

        // Get tax details
        $tax = Tax::find($request->tax_id);
        $validated['tax_id'] = $tax->id;
        $validated['tax_name'] = $tax->tax_name;
        $validated['tax_rate'] = $tax->tax_rate;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($sale->image) {
                $oldImagePath = public_path('images/sales/') . $sale->image;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/sales'), $imageName);
            $validated['image'] = $imageName;
        }

        $sale->update($validated);

        return redirect()->route('sales.index')
            ->with('success', 'Sale updated successfully');
    }

    public function destroy(Sale $sale)
    {
        if ($sale->image) {
            $imagePath = public_path('images/sales/') . $sale->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $sale->delete();

        return redirect()->route('sales.index')
            ->with('error', 'Sale deleted successfully');
    }

}
