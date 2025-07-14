<?php

namespace App\Http\Controllers;

use App\Models\profile;
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
        return view('reports.index');
    }
}
