<?php

namespace App\Http\Controllers;

use App\Models\DebitCredits;
use App\Models\Profile;
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
        Profile::create($validated);
        return redirect()->route('khotiyan.index')->with('success','Data inserted successfully');
    }

    public function destroy($id)
    {
        Profile::where('profile_id',$id)->delete();
        return redirect()->route('khotiyan.index')->with('success','Data deleted successfully');
    }

    public function edit($id) {
        $data = Profile::where('profile_id',$id)->findOrFail($id);
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

        $profile = Profile::where('profile_id', $id)->firstOrFail(); // Use profile_id if it's your primary key

        $profile->update($validated);

        return redirect()->route('khotiyan.index')->with('success', 'Data updated successfully');
    }

    public function report()
    {
        $projects = Project::latest()->get();
        $suppliers = Supplier::latest()->get();
        return view('reports.index',compact('projects','suppliers'));
    }
}
