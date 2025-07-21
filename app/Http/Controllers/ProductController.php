<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products = Product::latest()->paginate(10)->onEachSide(2);
        return view('product.index',compact('products'));
    }

    public function store (Request $request){
        $validated = $request->validate([
            'product_name' => 'required',
        ]);

        Product::create($validated);
        return redirect()->route('product.index')->with('success', 'Product Added Successfully');
    }

    public function edit($id){
        $product = Product::where('product_id',$id)->first();
        return view('product.edit',compact('product'));
    }

    public function update(Request $request, $product_id)
    {
        $product = Product::where('product_id', $product_id)->firstOrFail();

        $validated = $request->validate([
            'product_name' => 'required',
        ]);

        $product->update($validated);

        return redirect()->route('product.index')->with('success', 'Product Updated Successfully');
    }

    public function destroy($id){
        Product::where('product_id',$id)->delete();
        return redirect()->route('product.index')->with('success', 'Product Deleted Successfully');
    }
}
