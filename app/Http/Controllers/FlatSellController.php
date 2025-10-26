<?php

namespace App\Http\Controllers;

use App\Models\FlatSell;
use App\Models\Project;
use App\Models\Supplier;
use Illuminate\Http\Request;

class FlatSellController extends Controller
{
    public function index(){
        $projects = Project::where('status', 1)->get();
        $purchasers = Supplier::where('supplier_type','Purchaser')->get();
        $flatSells = FlatSell::orderby('created_at', 'desc')->paginate(20)->onEachSide(1);
        return view('flatSell.index',compact('purchasers','flatSells','projects'));
    }

    public function store(Request $request){
        $validated = $request->validate([
           'supplier_id' => 'required|exists:suppliers,supplier_id',
           'project_id' => 'required|exists:projects,project_id',
            'total_amount' => 'required|numeric',
            'date' => 'required|date',
            'note' => 'nullable|string',
        ]);
        FlatSell::create($validated);
        return redirect()->back()->with('success','FlatSell added successfully');
    }

    public function edit(FlatSell $id){
        $projects = Project::where('status', 1)->get();
        $purchasers = Supplier::where('supplier_type','Purchaser')->get();
        return view('flatSell.edit',compact('id','projects','purchasers'));
    }

    public function update(Request $request, FlatSell $id){
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,supplier_id',
            'project_id' => 'required|exists:projects,project_id',
            'total_amount' => 'required|numeric',
            'date' => 'required|date',
            'note' => 'nullable|string',
        ]);
        $id->update($validated);
        return redirect()->route('flat-sell.index')->with('success','FlatSell updated successfully');
    }

    public function destroy (FlatSell $id){
        $id->delete();
        return redirect()->route('flat-sell.index')->with('success','FlatSell deleted successfully');
    }
}
