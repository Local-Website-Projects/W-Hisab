<?php

namespace App\Http\Controllers;

use App\Models\DebitCredits;
use App\Models\FlatSell;
use App\Models\Product;
use App\Models\ProductPurchase;
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
        $cashbooks = DebitCredits::with('project','supplier','product')->latest()->paginate(50)->onEachSide(1);
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
            'note' => 'required|string',
            'date' => 'required|date'
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

        $projectName = Project::where('project_id', $projectId)->first()->project_name;

        // Step 1: Fetch all grouped data
        $purchases = ProductPurchase::where('project_id', $projectId)
            ->selectRaw('supplier_id, SUM(total_price) as total_purchase')
            ->groupBy('supplier_id')
            ->get()
            ->keyBy('supplier_id');

        $sells = FlatSell::where('project_id', $projectId)
            ->selectRaw('supplier_id, SUM(total_amount) as total_amount')
            ->groupBy('supplier_id')
            ->get()
            ->keyBy('supplier_id');

        $debitCredits = DebitCredits::where('project_id', $projectId)
            ->selectRaw('supplier_id, SUM(credit) as total_credit, SUM(debit) as total_debit')
            ->groupBy('supplier_id')
            ->get()
            ->keyBy('supplier_id');


// Step 2: Get all unique supplier IDs
        $supplierIds = $purchases->keys()
            ->merge($sells->keys())
            ->merge($debitCredits->keys())
            ->unique();


// Step 3: Prepare final report
        $balance_sheets = $supplierIds->map(function ($id) use ($purchases, $sells, $debitCredits) {
            $supplier = Supplier::find($id);
            $purchase = $purchases[$id]->total_purchase ?? 0;
            $sell     = $sells[$id]->total_amount ?? 0;
            $credit   = $debitCredits[$id]->total_credit ?? 0;
            $debit    = $debitCredits[$id]->total_debit ?? 0;

            return [
                'supplier_id'   => $id,
                'supplier_name' => optional($supplier)->supplier_name ?? 'N/A',
                'total_purchase'=> $purchase,
                'total_sell'    => $sell,
                'total_credit'  => $credit,
                'total_debit'   => $debit,
                // Payable = purchase - debit
                'payable'       => $debit - $purchase,
                // Receivable = sell - credit
                'receivable'    => $credit,
            ];
        });

        return view('reports.projectwise-report', compact('balance_sheets','projectName'));
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
