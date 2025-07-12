<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(){
        $projects = Project::latest()->paginate(10)->onEachside(2);
        return view('project.index',compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_name' => 'required|string|max:255',
            'initial_balance' => 'required|numeric',
            'note' => 'nullable|string',
        ]);

        Project::create($validated);

        return redirect()->back()->with('success', 'Project added successfully!');
    }
    public function destroy($id)
    {
        Project::where('project_id', $id)->delete();
        return back()->with('success', 'Project deleted successfully!');
    }

    public function edit($id){
        $project = Project::where('project_id', $id)->firstOrFail();
        return (view('project.edit', compact('project')));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'project_name' => 'required|string|max:255',
            'initial_balance' => 'required|numeric',
            'status' => 'required|string',
            'note' => 'nullable|string',
        ]);

        $project->update($validated);
        $projects = Project::latest()->paginate(10)->onEachside(2);

        return redirect()->route('project.index',compact('projects'))->with('success', 'Project updated successfully!');
    }
}
