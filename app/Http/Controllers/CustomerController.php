<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->has('fields')) {
            $fields = $request->input('fields');
            foreach ($fields as $field => $value) {
                if (!empty($value)) {
                    $query->where($field, 'LIKE', "%{$value}%");
                }
            }
        } else {
            $query->latest();
        }

        $customers = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.customer.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers',
            'mobile' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'dob' => 'required|date',
            'gst_number' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'gst_number' => $request->gst_number,
            'status' => $request->status ? 1 : 0
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/customer'), $imageName);
            $data['image'] = $imageName;
        }

        Customer::create($data);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully');
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customer.show', compact('customer'));
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customer.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers,email,'.$id,
            'mobile' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'dob' => 'required|date',
            'gst_number' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $customer = Customer::findOrFail($id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'gst_number' => $request->gst_number,
            'status' => $request->status ? 1 : 0
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($customer->image && file_exists(public_path('images/customer/' . $customer->image))) {
                unlink(public_path('images/customer/' . $customer->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/customer'), $imageName);
            $data['image'] = $imageName;
        }

        $customer->update($data);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        // Delete customer image if exists
        if ($customer->image && file_exists(public_path('images/customer/' . $customer->image))) {
            unlink(public_path('images/customer/' . $customer->image));

            // Delete empty customer image folder if exists
            $folderPath = public_path('images/customer');
            if (is_dir($folderPath) && count(scandir($folderPath)) <= 2) { // . and .. directories
                rmdir($folderPath);
            }
        }

        $customer->delete();

        return redirect()->route('customers.index')->with('error', 'Customer deleted successfully');
    }

    public function customersearch(Request $request)
    {
        $search = $request->get('search');

        $results = Customer::where('status', '1')
            ->where(function($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('mobile', 'LIKE', "%{$search}%");
            })
            ->limit(10)
            ->get();
        return response()->json($results);
    }



}
