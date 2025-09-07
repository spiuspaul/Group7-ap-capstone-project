<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Project;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $participants = Participant::with('project')->paginate(10); 
        return view('participants.index', compact('participants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all();
        return view('participants.create', compact('projects'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:participants,email',
            'affiliation' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'cross_skill_trained' => 'nullable|boolean',
            'institution' => 'nullable|string|max:255',
            'project_id' => 'required|exists:projects,id',
        ]);

        Participant::create($data);

        return redirect()->route('participants.index')->with('success', 'Participant added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Participant $participant)
    {
        $participant->load('project');
        return view('participants.show', compact('participant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Participant $participant)
    {
        $projects = Project::all();
        return view('participants.edit', compact('participant', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Participant $participant)
    {
        $data =$request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:participants,email,' . $participant->id,
            'affiliation' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'cross_skill_trained' => 'nullable|boolean',
            'institution' => 'nullable|string|max:255',
            'project_id' => 'required|exists:projects,id',
        ]);

        $participant->update($data);

        return redirect()->route('participants.index')->with('success', 'Participant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Participant $participant)
    {
        $participant->delete();
        return redirect()->route('participants.index')->with('success', 'Participant deleted successfully.');
    }

    public function projects(Participant $participant)
    {
        $projects = Project::where('project_id', $participant->project_id)->get();
        return view('participants.projects', compact('participant', 'projects'));
    }
}
