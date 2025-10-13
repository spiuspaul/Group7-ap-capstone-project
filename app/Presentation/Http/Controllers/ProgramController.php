<?php

namespace App\Presentation\Http\Controllers;

use Illuminate\Http\Request;
use App\Application\UseCases\CreateProgram;
use App\Application\UseCases\UpdateProgram;
use App\Application\UseCases\DeleteProgram;
use App\Application\DTOs\ProgramDTO;
use App\Domain\Exceptions\ProgramException;
use App\Models\Program;

class ProgramController extends Controller
{
    public function __construct(
        private CreateProgram $createProgram,
        private UpdateProgram $updateProgram,
        private DeleteProgram $deleteProgram
    ) {}

    public function index()
    {
        $programs = Program::all();
        return view('programs.index', compact('programs'));
    }

    public function create()
    {
        return view('programs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'national_alignment' => 'nullable|array',
            'focus_areas' => 'nullable|array',
            'phases' => 'nullable|array',
        ]);

        try {
            $dto = ProgramDTO::fromRequest($validated);
            $this->createProgram->execute($dto);
            
            return redirect()->route('programs.index')
                ->with('success', 'Program created successfully.');
        } catch (ProgramException $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show(Program $program)
    {
        return view('programs.show', compact('program'));
    }

    public function edit(Program $program)
    {
        return view('programs.edit', compact('program'));
    }

    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'national_alignment' => 'nullable|array',
            'focus_areas' => 'nullable|array',
            'phases' => 'nullable|array',
        ]);

        try {
            $dto = ProgramDTO::fromRequest($validated);
            $this->updateProgram->execute($program->program_id, $dto);
            
            return redirect()->route('programs.index')
                ->with('success', 'Program updated successfully.');
        } catch (ProgramException $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(Program $program)
    {
        try {
            $this->deleteProgram->execute($program->program_id);
            
            return redirect()->route('programs.index')
                ->with('success', 'Program deleted successfully.');
        } catch (ProgramException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function projects(Program $program)
    {
        $projects = $program->projects;
        return view('programs.projects', compact('program', 'projects'));
    }
}