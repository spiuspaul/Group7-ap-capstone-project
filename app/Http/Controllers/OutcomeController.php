<?php

namespace App\Http\Controllers;

use App\Models\Outcome;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OutcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $outcomes = $project->outcomes()->latest()->get();
        return view('outcomes.index', compact('project', 'outcomes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        return view('outcomes.create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'artifact' => 'nullable|file|max:10240', // max 10MB
            'outcome_type' => 'nullable|string|max:100',
            'quality_certification' => 'nullable|string|max:255',
            'commercialization_status' => 'nullable|string|max:255',
        ]);

        $path = $request->file('artifact') ? $request->file('artifact')->store('artifacts') : null;

        $project->outcomes()->create([
            'title' => $request->title,
            'description' => $request->description,
            'artifact_link' => $path,
            'outcome_type' => $request->outcome_type,
            'quality_certification' => $request->quality_certification,
            'commercialization_status' => $request->commercialization_status,
        ]);

        return redirect()->route('projects.outcomes.index', $project)->with('success', 'Outcome created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Outcome $outcome)
    {
        return view('outcomes.show', compact('project', 'outcome'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Outcome $outcome)
    {
        return view('outcomes.edit', compact('project', 'outcome'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project, Outcome $outcome)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'artifact' => 'nullable|file|max:10240',
            'outcome_type' => 'nullable|string|max:100',
            'quality_certification' => 'nullable|string|max:255',
            'commercialization_status' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('artifact')) {
            // Delete old file if exists
            if ($outcome->artifact_link) {
                Storage::delete($outcome->artifact_link);
            }
            $outcome->artifact_link = $request->file('artifact')->store('artifacts');
        }

        $outcome->update([
            'title' => $request->title,
            'description' => $request->description,
            'outcome_type' => $request->outcome_type,
            'quality_certification' => $request->quality_certification,
            'commercialization_status' => $request->commercialization_status,
        ]);

        return redirect()->route('projects.outcomes.index', $project)->with('success', 'Outcome updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Outcome $outcome)
    {
        if ($outcome->artifact_link) {
            Storage::delete($outcome->artifact_link);
        }

        $outcome->delete();

        return redirect()->route('projects.outcomes.index', $project)->with('success', 'Outcome deleted successfully.');
    }

    public function download(Project $project, Outcome $outcome)
    {
        if (!$outcome->artifact_link || !Storage::exists($outcome->artifact_link)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        return Storage::download($outcome->artifact_link);
    }
}


