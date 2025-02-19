<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\State;
use App\Services\FileUploadService;

class CustomerController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

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
        $states = State::all();
        return view('admin.customer.create', compact('states'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers',
            'mobile' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'dob' => 'required|date',
            'gst_number' => 'nullable',
            'gst_code' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'country' => 'nullable',
            'zipcode' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $validated;
        $data['status'] = $request->status ? 1 : 0;
        if ($request->hasFile('image')) {
            $data['image'] = $this->fileUploadService->upload(
                $request->file('image'),
                'images/customer'
            );
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
        $states = State::all();
        return view('admin.customer.edit', compact('customer', 'states'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers,email,'.$id,
            'mobile' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'dob' => 'required|date',
            'gst_number' => 'nullable',
            'gst_code' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'country' => 'nullable',
            'zipcode' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $customer = Customer::findOrFail($id);

        $data = $validated;
        $data['status'] = $request->status ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $this->fileUploadService->upload(
                $request->file('image'),
                'images/customer',
                $customer->image
            );
        }

        $customer->update($data);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        if ($customer->image) {
            $this->fileUploadService->delete('images/customer/' . $customer->image);
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
