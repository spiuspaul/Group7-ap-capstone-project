<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Application\UseCases\CreateProject;
use App\Application\UseCases\UpdateProject;
use App\Application\UseCases\DeleteProject;
use App\Application\DTOs\ProjectDTO;
use App\Domain\Exceptions\ProjectException;
use App\Models\Project;
use App\Models\Program;
use App\Models\Facility;

class ProjectController extends Controller
{
    public function __construct(
        private CreateProject $createProject,
        private UpdateProject $updateProject,
        private DeleteProject $deleteProject
    ) {}

    public function index()
    {
        $projects = Project::with(['program', 'facility'])->paginate(10);
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $programs = Program::all();
        $facilities = Facility::all();
        return view('projects.create', compact('programs', 'facilities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,program_id',
            'facility_id' => 'required|exists:facilities,facility_id',
            'title' => 'required|string|max:255',
            'status' => 'nullable|in:Planning,Active,Completed,On Hold',
            'nature_of_project' => 'nullable|string',
            'description' => 'nullable|string',
            'innovation_focus' => 'nullable|string',
            'prototype_stage' => 'nullable|string',
            'testing_requirements' => 'nullable|string',
            'commercialization_plan' => 'nullable|string',
            'technical_requirements' => 'nullable|array',
        ]);

        try {
            $dto = ProjectDTO::fromRequest($validated);
            $this->createProject->execute($dto);
            
            return redirect()->route('projects.index')
                ->with('success', 'Project created successfully.');
        } catch (ProjectException $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show(Project $project)
    {
        $project->load(['program', 'facility']);
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $programs = Program::all();
        $facilities = Facility::all();
        return view('projects.edit', compact('project', 'programs', 'facilities'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,program_id',
            'facility_id' => 'required|exists:facilities,facility_id',
            'title' => 'required|string|max:255',
            'status' => 'nullable|in:Planning,Active,Completed,On Hold',
            'nature_of_project' => 'nullable|string',
            'description' => 'nullable|string',
            'innovation_focus' => 'nullable|string',
            'prototype_stage' => 'nullable|string',
            'testing_requirements' => 'nullable|string',
            'commercialization_plan' => 'nullable|string',
            'technical_requirements' => 'nullable|array',
        ]);

        try {
            $dto = ProjectDTO::fromRequest($validated);
            $this->updateProject->execute($project->project_id, $dto);
            
            return redirect()->route('projects.index')
                ->with('success', 'Project updated successfully.');
        } catch (ProjectException $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(Project $project)
    {
        try {
            $this->deleteProject->execute($project->project_id);
            
            return redirect()->route('projects.index')
                ->with('success', 'Project deleted successfully.');
        } catch (ProjectException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function participants(Project $project)
    {
        $participants = $project->participants()->paginate(10);
        return view('projects.participants', compact('project', 'participants'));
    }
}