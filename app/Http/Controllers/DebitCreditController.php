<?php

namespace App\Http\Controllers;

use App\Models\DebitCredits;
use App\Models\Product;
use App\Models\Project;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DebitCreditController extends Controller
{
    public function index() {
        $projects = Project::where('status',1)->latest()->get();
        $suppliers = Supplier::latest()->get();
        $products = Product::latest()->get();
        $cashbooks = DebitCredits::with('project','supplier','product')->latest()->paginate(20)->onEachSide(1);
        $totalCredit = DebitCredits::sum('credit');
        $totalDebit = DebitCredits::sum('debit');
        $cashOnHand = $totalCredit - $totalDebit;
        return view('debitCredit.index',compact('projects','suppliers','cashbooks','products','cashOnHand','totalCredit','totalDebit'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'project_id'   => 'required|exists:projects,project_id',
            'supplier_id'  => 'nullable|exists:suppliers,supplier_id',
            'product_id'   => 'nullable|exists:products,product_id',
            'debit'        => 'nullable|numeric|min:0',
            'credit'       => 'nullable|numeric|min:0',
            'note'         => 'required|string',
            'date'         => 'required|date',
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

    public function datewiseReport(Request $request)
    {
        $request->validate([
            'form' => 'required|date',
            'to' => 'required|date|after_or_equal:form',
        ]);

        $toDateForQuery = Carbon::createFromFormat('Y-m-d', $request->input('form'));

        $fromDate = Carbon::createFromFormat('Y-m-d', $request->input('form'))->startOfDay();
        $toDate = Carbon::createFromFormat('Y-m-d', $request->input('to'))->endOfDay();
        $cashbooks = DebitCredits::whereBetween('date', [$fromDate, $toDate])->with('project','supplier','product')->latest()->paginate(20)->onEachSide(1);

        $totalCredit = DebitCredits::whereDate('date', '<', $toDateForQuery)->sum('credit');
        $totalDebit = DebitCredits::whereDate('date', '<', $toDateForQuery)->sum('debit');
        $cashOnHand = $totalCredit - $totalDebit;
        return view ('reports.datewise-profile', compact('cashbooks', 'fromDate', 'toDate','cashOnHand'));
    }

    public function projectwiseReport(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,project_id'
        ]);

        $projectId = $request->input('project_id');

        $cashbooks = DebitCredits::select('supplier_id','product_id')
            ->selectRaw('SUM(debit) as total_debit')
            ->selectRaw('SUM(credit) as total_credit')
            ->where('project_id', $projectId)
            ->groupBy('supplier_id','product_id')
            ->with('supplier')
            ->get();
        $project = Project::where('project_id', $projectId)->first();
        return view('reports.projectwise-report', compact('cashbooks','project'));
    }

    public function supplierwiseReport(Request $request){
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,supplier_id'
        ]);

        $supplierId = $request->input('supplier_id');

        $cashbooks = DebitCredits::where('supplier_id', $supplierId)
            ->with('project', 'product')
            ->get();
        $supplier = Supplier::where('supplier_id', $supplierId)->first();
        return view('reports.supplierwise-report', compact('cashbooks','supplier'));
    }
}
