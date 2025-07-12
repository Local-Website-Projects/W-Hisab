<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->paginate(10)->onEachSide(2);
        return view('supplier.index',compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
           'supplier_name' => 'required|string',
           'supplier_phone' => 'required|string',
           'supplier_address' => 'nullable|string',
           'note' => 'nullable|string',
        ]);
        Supplier::create($validate);
        return redirect()->route('supplier.index')->with('success', 'Supplier Added Successfully');
    }

    public function destroy($id)
    {
        Supplier::where('supplier_id', $id)->delete();
        return back()->with('success', 'Supplier deleted successfully!');
    }

    public function edit($id){
        $supplier = Supplier::where('supplier_id', $id)->firstOrFail();
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'supplier_name' => 'required|string',
            'supplier_phone' => 'required|string',
            'supplier_address' => 'nullable|string',
            'note' => 'nullable|string',
        ]);
        $supplier->update($validated);
        $suppliers = Supplier::latest()->paginate(10)->onEachSide(2);
        return redirect()->route('supplier.index',compact('suppliers'))->with('success', 'Supplier Updated Successfully');
    }
}
