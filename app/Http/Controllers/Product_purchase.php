<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Project;
use App\Models\Supplier;
use App\Models\ProductPurchase;
use Illuminate\Http\Request;

class Product_purchase extends Controller
{
    public function index()
    {
        $projects = Project::where('status', 1)->get();
        $suppliers = Supplier::where('supplier_type','Supplier')->get();
        $products = Product::all();

        $purchases = ProductPurchase::orderBy('created_at', 'desc')->paginate(20)->onEachSide(1);
        return view('productPurchase.index',compact('projects','suppliers','products','purchases'));
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'project_id' => 'required|exists:projects,project_id',
            'supplier_id' => 'required|exists:suppliers,supplier_id',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string',
            'unit_price' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
            'note' => 'nullable|string',
        ]);
        ProductPurchase::create($validatedData);
        return redirect()->back()->with('success','Product Purchase Created Successfully');
    }

    public function edit(ProductPurchase $purchase_id){
        $projects = Project::where('status', 1)->get();
        $suppliers = Supplier::where('supplier_type','Supplier')->get();
        $products = Product::all();

        return view('productPurchase.edit',compact('purchase_id','projects','suppliers','products'));
    }

    public function update(Request $request, ProductPurchase  $purchase_id){
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'project_id' => 'required|exists:projects,project_id',
            'supplier_id' => 'required|exists:suppliers,supplier_id',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string',
            'unit_price' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
            'note' => 'nullable|string',
        ]);
        $purchase_id -> update($validatedData);
        return redirect()->route('purchase-product.index')->with('success','Product Purchase Updated Successfully');
    }

    public function destroy(ProductPurchase $purchase_id){
        $purchase_id -> delete();
        return redirect()->route('purchase-product.index')->with('success','Product Purchase Deleted Successfully');
    }
}
