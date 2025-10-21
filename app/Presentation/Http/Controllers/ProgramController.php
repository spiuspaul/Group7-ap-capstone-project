<?php

namespace App\Presentation\Http\Controllers;

use Illuminate\Http\Request;
use App\Application\UseCases\Program\CreateProgramUseCase as CreateProgram;
use App\Application\UseCases\Program\UpdateProgramUseCase as UpdateProgram;
use App\Application\UseCases\Program\DeleteProgramUseCase as DeleteProgram;
use App\Application\DTOs\ProgramDTO;
use App\Domain\Exceptions\ProgramException;
use App\Models\Program;
use Illuminate\Support\Facades\Log;

class ProgramController extends Controller
{
    public function __construct(
        private CreateProgram $createProgram,
        private UpdateProgram $updateProgram,
        private DeleteProgram $deleteProgram
    ) {}

    public function index()
    {
        try {
            $programs = Program::all();
            return view('programs.index', compact('programs'));
        } catch (\Exception $e) {
            Log::error('Failed to fetch programs', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Failed to load programs']);
        }
    }

    public function create()
    {
        return view('programs.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $this->validateProgramRequest($request);
            $dto = ProgramDTO::fromArray([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'nationalAlignment' => $validated['national_alignment'] ?? [],
                'focusAreas' => $validated['focus_areas'] ?? [],
                'phases' => $validated['phases'] ?? []
            ]);
            $program = $this->createProgram->execute($dto);
            Log::info('Program created', ['program_id' => $program->getId()]);

            return redirect()
                ->route('programs.index')
                ->with('success', 'Program created successfully');
        } catch (ProgramException $e) {
            Log::warning('Program creation failed', ['error' => $e->getMessage()]);
            return $this->handleProgramException($e);
        } catch (\Exception $e) {
            Log::error('Unexpected error in program creation', ['error' => $e->getMessage()]);
            return $this->handleUnexpectedException($e);
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
        try {
            $validated = $this->validateProgramRequest($request);
            $dto = ProgramDTO::fromArray([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'nationalAlignment' => $validated['national_alignment'] ?? [],
                'focusAreas' => $validated['focus_areas'] ?? [],
                'phases' => $validated['phases'] ?? []
            ]);

            $this->updateProgram->execute($program->getId(), $dto);
            Log::info('Program updated', ['program_id' => $program->getId()]);

            return redirect()
                ->route('programs.index')
                ->with('success', 'Program updated successfully');
        } catch (ProgramException $e) {
            return $this->handleProgramException($e);
        } catch (\Exception $e) {
            return $this->handleUnexpectedException($e);
        }
    }

    public function destroy(Program $program)
    {
        try {
            $this->deleteProgram->execute($program->id);
            
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

    private function validateProgramRequest(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'national_alignment' => 'required|string|in:NDPIII,DigitalRoadmap2023_2028,4IR',
            'focus_areas' => 'nullable|array',
            'focus_areas.*' => 'string',
            'phases' => 'nullable|array',
            'phases.*' => 'array:name,description,duration'
        ]);
    }

    private function handleProgramException(ProgramException $e)
    {
        return back()
            ->withErrors(['error' => $e->getMessage()])
            ->withInput();
    }

    private function handleUnexpectedException(\Exception $e)
    {
        return back()
            ->withErrors(['error' => 'An unexpected error occurred'])
            ->withInput();
    }
}