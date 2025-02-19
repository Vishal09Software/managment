<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\State;
use App\Services\FileUploadService;
class VendorController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }
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
        $states = State::all();
        return view('admin.vendor.create', compact('states'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:vendors',
            'mobile' => 'required',
            'gst_number' => 'nullable',
            'address' => 'nullable',
            'gst_code' => 'nullable',
            'gender' => 'nullable',
            'dob' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'country' => 'nullable',
            'zip_code' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $validated;
        $data['status'] = $request->status ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $this->fileUploadService->upload(
                $request->file('image'),
                'images/vendor'
            );
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
        $states = State::all();
        $vendor = Vendor::findOrFail($id);
        return view('admin.vendor.edit', compact('vendor', 'states'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:vendors,email,'.$id,
            'mobile' => 'required',
            'gst_number' => 'nullable',
            'gst_code' => 'nullable',
            'address' => 'nullable',
            'gender' => 'nullable',
            'dob' => 'nullable|date',
            'city' => 'nullable',
            'state' => 'nullable',
            'country' => 'nullable',
            'zip_code' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $vendor = Vendor::findOrFail($id);

        $data = $validated;
        $data['status'] = $request->status ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $this->fileUploadService->upload(
                $request->file('image'),
                'images/vendor',
                $vendor->image
            );
        }

        $vendor->update($data);

        return redirect()->route('vendors.index')->with('success', 'Vendor updated successfully');
    }

    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);
        if ($vendor->image) {
            $this->fileUploadService->delete('images/vendor/' . $vendor->image);
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
