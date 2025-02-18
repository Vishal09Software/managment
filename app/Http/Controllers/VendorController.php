<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\GST;
class VendorController extends Controller
{
    public function index(Request $request)
    {
        $query = Vendor::query();

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

        $vendors = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.vendor.index', compact('vendors'));
    }

    public function create()
    {
        $gsts = GST::all();
        return view('admin.vendor.create', compact('gsts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:vendors',
            'mobile' => 'required',
            'gst_number' => 'required',
            'address' => 'required',
            'gst_code' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'gst_number' => $request->gst_number,
            'address' => $request->address,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'zip_code' => $request->zip_code,
            'status' => $request->status ? 1 : 0,
            'gst_code' => $request->gst_code,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/vendor'), $imageName);
            $data['image'] = $imageName;
        }

        Vendor::create($data);

        return redirect()->route('vendors.index')->with('success', 'Vendor created successfully');
    }

    public function show($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('admin.vendor.show', compact('vendor'));
    }

    public function edit($id)
    {
        $gsts = GST::all();
        $vendor = Vendor::findOrFail($id);
        return view('admin.vendor.edit', compact('vendor', 'gsts'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:vendors,email,'.$id,
            'mobile' => 'required',
            'gst_number' => 'required',
            'gst_code' => 'required',
            'address' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $vendor = Vendor::findOrFail($id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'gst_number' => $request->gst_number,
            'address' => $request->address,
            'status' => $request->status ? 1 : 0,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'zip_code' => $request->zip_code,
            'gst_code' => $request->gst_code,
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($vendor->image && file_exists(public_path('images/vendor/' . $vendor->image))) {
                unlink(public_path('images/vendor/' . $vendor->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/vendor'), $imageName);
            $data['image'] = $imageName;
        }

        $vendor->update($data);

        return redirect()->route('vendors.index')->with('success', 'Vendor updated successfully');
    }

    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);

        // Delete vendor image if exists
        if ($vendor->image && file_exists(public_path('images/vendor/' . $vendor->image))) {
            unlink(public_path('images/vendor/' . $vendor->image));

            // Delete empty vendor image folder if exists
            $folderPath = public_path('images/vendor');
            if (is_dir($folderPath) && count(scandir($folderPath)) <= 2) { // . and .. directories
                rmdir($folderPath);
            }
        }

        $vendor->delete();

        return redirect()->route('vendors.index')->with('error', 'Vendor deleted successfully');
    }

    public function vendorsearch(Request $request)
    {
        $search = $request->get('search');

        $results = Vendor::where('status', '1')
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
