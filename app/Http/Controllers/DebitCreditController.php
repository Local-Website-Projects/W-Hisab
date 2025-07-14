<?php

namespace App\Http\Controllers;

use App\Models\DebitCredits;
use App\Models\Project;
use App\Models\Supplier;
use Illuminate\Http\Request;

class DebitCreditController extends Controller
{
    public function index() {
        $projects = Project::where('status',1)->latest()->get();
        $suppliers = Supplier::latest()->get();
        $cashbooks = DebitCredits::with('project','supplier')->latest()->paginate(20)->onEachSide(1);
        return view('debitCredit.index',compact('projects','suppliers','cashbooks'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,project_id',
            'supplier_id' => 'required|exists:suppliers,supplier_id',
            'debit' => 'nullable|numeric|min:0',
            'credit' => 'nullable|numeric|min:0',
            'note' => 'required|string'
        ]);
        DebitCredits::create($validated);
        return redirect()->route('cashbook.index')->with('success','Debit credit created successfully');
    }

    public function destroy($id) {
        $data = DebitCredits::where('debit_credit_id',$id)->firstOrFail();
        $data->delete();
        return redirect()->route('cashbook.index')->with('success','Debit credit data deleted successfully');
    }

    public function edit ($id){
        $data = DebitCredits::where('debit_credit_id',$id)->firstOrFail();
        $projects = Project::where('status',1)->latest()->get();
        $suppliers = Supplier::latest()->get();
        return view('debitCredit.edit',compact('data','projects','suppliers'));
    }

    public function update(Request $request, DebitCredits $debitCredit)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,project_id',
            'supplier_id' => 'required|exists:suppliers,supplier_id',
            'debit' => 'nullable|numeric|min:0',
            'credit' => 'nullable|numeric|min:0',
            'note' => 'required|string'
        ]);
        $debitCredit->update($validated);
        return redirect()->route('cashbook.index')->with('success','Debit credit data updated successfully');
    }
}
