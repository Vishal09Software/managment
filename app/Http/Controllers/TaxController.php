<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tax;

class TaxController extends Controller
{
    public function index()
    {
        $taxes = Tax::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.setting.tax', compact('taxes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tax_name' => 'required|string|max:255',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'status' => 'required|boolean'
        ]);

        Tax::create($request->all());

        return redirect()->route('taxes.index')->with('success', 'Tax rate added successfully');
    }

    public function edit($id)
    {
        $tax = Tax::findOrFail($id);
        return response()->json($tax);
    }

    public function update(Request $request)
    {
        $request->validate([
            'tax_id' => 'required|exists:taxes,id',
            'tax_name' => 'required|string|max:255',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'status' => 'required|boolean'
        ]);

        $tax = Tax::findOrFail($request->tax_id);
        $tax->update($request->all());

        return redirect()->route('taxes.index')->with('success', 'Tax rate updated successfully');
    }

    public function destroy($id)
    {
        $tax = Tax::findOrFail($id);
        $tax->delete();
        return redirect()->route('taxes.index')->with('error', 'Tax rate deleted successfully');
    }
}
