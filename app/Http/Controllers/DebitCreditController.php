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
            'to'   => 'required|date|after_or_equal:form',
        ]);

        $fromDate = Carbon::createFromFormat('Y-m-d', $request->input('form'))->startOfDay();
        $toDate   = Carbon::createFromFormat('Y-m-d', $request->input('to'))->endOfDay();

        // Data to display in table (within the selected range)
        $cashbooks = DebitCredits::whereBetween('date', [
            $fromDate->toDateString(),
            $toDate->toDateString()
        ])
            ->with('project', 'supplier', 'product')
            ->orderBy('date')
            ->get();

        // Opening Balance (before from date)
        $openingCredit = DebitCredits::whereDate('date', '<', $fromDate->toDateString())->sum('credit');
        $openingDebit  = DebitCredits::whereDate('date', '<', $fromDate->toDateString())->sum('debit');
        $openingBalance = (float)$openingCredit - (float)$openingDebit;

        // Period totals
        $periodCredit = $cashbooks->sum('credit');
        $periodDebit  = $cashbooks->sum('debit');

        // Closing Cash on Hand
        $cashOnHand = $openingBalance + ($periodCredit - $periodDebit);

        return view('reports.datewise-profile', compact(
            'cashbooks', 'fromDate', 'toDate', 'openingBalance', 'cashOnHand'
        ));
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

        $supplier = Supplier::with([
            'purchases.product',
            'payments.product'
        ])->where('supplier_id', $request->supplier_id)->firstOrFail();
        $name = Supplier::where('supplier_id', $supplierId)->first();
        return view('reports.supplierwise-report', compact('name','supplier'));
    }

    public function purchaserReport(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,supplier_id'
        ]);

        $supplierId = $request->input('supplier_id');

        $supplier = Supplier::with([
            'flatsell.project', // Each flat purchase belongsTo a project
            'payments.project'  // Each payment belongsTo a project
        ])->where('supplier_id', $supplierId)->firstOrFail();

        $name = $supplier; // Already fetched, no need for a separate query

        return view('reports.purchaser-report', compact('name', 'supplier'));
    }
}
