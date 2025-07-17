<?php

namespace App\Http\Controllers;

use App\Models\DebitCredits;
use App\Models\profile;
use App\Models\Project;
use App\Models\Supplier;
use Illuminate\Http\Request;
use function Pest\Laravel\post;

class ProfileDeExController extends Controller
{
    public function index() {
        $datas = profile::latest()->paginate(10)->onEachSide(2);
        return view('profileDeEx.index',compact('datas'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'date' => 'required|date',
            'note' => 'required|string',
            'deposit_amount' => 'nullable|numeric',
            'expense_amount' => 'nullable|numeric',
        ]);
        profile::create($validated);
        return redirect()->route('khotiyan.index')->with('success','Data inserted successfully');
    }

    public function destroy($id)
    {
        profile::where('profile_id',$id)->delete();
        return redirect()->route('khotiyan.index')->with('success','Data deleted successfully');
    }

    public function edit($id) {
        $data = profile::where('profile_id',$id)->findOrFail($id);
        return view('profileDeEx.edit',compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'note' => 'required|string',
            'deposit_amount' => 'nullable|numeric',
            'expense_amount' => 'nullable|numeric',
        ]);

        $profile = profile::where('profile_id', $id)->firstOrFail(); // Use profile_id if it's your primary key

        $profile->update($validated);

        return redirect()->route('khotiyan.index')->with('success', 'Data updated successfully');
    }

    public function report()
    {
        $projects = Project::latest()->get();
        $suppliers = Supplier::latest()->get();
        return view('reports.index',compact('projects','suppliers'));
    }

    public function datewiseReport(Request $request)
    {
        $request->validate([
            'form' => 'required|date',
            'to' => 'required|date|after_or_equal:form',
        ]);

        $fromDate = $request->input('form');
        $toDate = $request->input('to');

        $profiles = Profile::whereBetween('date', [$fromDate, $toDate])->latest()->get();

        return view ('reports.datewise-profile', compact('profiles', 'fromDate', 'toDate'));
    }

    public function projectwiseReport(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,project_id'
        ]);

        $projectId = $request->input('project_id');

        $cashbooks = DebitCredits::select('supplier_id')
            ->selectRaw('SUM(debit) as total_debit')
            ->selectRaw('SUM(credit) as total_credit')
            ->where('project_id', $projectId)
            ->groupBy('supplier_id')
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

        $cashbooks = DebitCredits::select('project_id')
            ->selectRaw('SUM(debit) as total_debit')
            ->selectRaw('SUM(credit) as total_credit')
            ->where('supplier_id', $supplierId)
            ->groupBy('project_id')
            ->with('project')
            ->get();
        $supplier = Supplier::where('supplier_id', $supplierId)->first();
        return view('reports.supplierwise-report', compact('cashbooks','supplier'));
    }
}
