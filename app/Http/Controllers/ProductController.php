<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Tax;
use Illuminate\Http\Request;
use App\Services\FileUploadService;

class ProductController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function index(Request $request)
    {
        $query = Product::query();

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

        $taxes = Tax::all();
        $products = $query->latest()->paginate(10);

        if ($products->isEmpty()) {
            return view('admin.product.index', compact('products', 'taxes'))->with('error', 'No products found');
        }

        return view('admin.product.index', compact('products', 'taxes'));
    }

    public function create()
    {
        $taxes = Tax::all();
        return view('admin.product.create', compact('taxes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'hsn_code' => 'nullable|string|max:50',
            'grade' => 'nullable|string|max:50',
            'tax_id' => 'nullable|exists:taxes,id',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'boolean'
        ]);

        $validated['status'] = $request->status ? 1 : 0;

        if ($request->hasFile('image')) {
            $validated['image'] = $this->fileUploadService->upload(
                $request->file('image'),
                'images/product'
            );
        }

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $taxes = Tax::all();
        return view('admin.product.edit', compact('product', 'taxes'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'hsn_code' => 'nullable|string|max:50',
            'grade' => 'nullable|string|max:50',
            'tax_id' => 'nullable|exists:taxes,id',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'boolean'
        ]);
        $validated['status'] = $request->status ? 1 : 0;

        if ($request->hasFile('image')) {
            $validated['image'] = $this->fileUploadService->upload(
                $request->file('image'),
                'images/product',
                $product->image
            );
        }

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

   public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete product image if exists
        if ($product->image) {
            $this->fileUploadService->delete('images/product/' . $product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
