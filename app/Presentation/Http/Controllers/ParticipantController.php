<?php

namespace App\Presentation\Http\Controllers;

use Illuminate\Http\Request;
use App\Application\DTOs\ParticipantDTO;
use App\Application\UseCases\Participant\CreateParticipantUseCase;
use App\Application\UseCases\Participant\UpdateParticipantUseCase;
use App\Application\UseCases\Participant\DeleteParticipantUseCase;
use App\Domain\Exceptions\ParticipantException;
use App\Models\Participant;
use App\Models\Project;

class ParticipantController extends Controller
{
    public function __construct(
        private CreateParticipantUseCase $createParticipant,
        private UpdateParticipantUseCase $updateParticipant,
        private DeleteParticipantUseCase $deleteParticipant
    ) {}

    public function index()
    {
        $participants = Participant::with('project')->paginate(10);
        return view('participants.index', compact('participants'));
    }

    public function create()
    {
        $projects = Project::all();
        return view('participants.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'affiliation' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'cross_skill_trained' => 'nullable|boolean',
            'institution' => 'nullable|string|max:255',
            'project_id' => 'required|exists:projects,project_id',
        ]);

        try {
            $dto = ParticipantDTO::fromRequest($validated);
            $this->createParticipant->execute($dto);

            return redirect()->route('participants.index')
                ->with('success', 'Participant created successfully.');
        } catch (ParticipantException $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show(Participant $participant)
    {
        $participant->load('project');
        return view('participants.show', compact('participant'));
    }

    public function edit(Participant $participant)
    {
        $projects = Project::all();
        return view('participants.edit', compact('participant', 'projects'));
    }

    public function update(Request $request, Participant $participant)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'affiliation' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'cross_skill_trained' => 'nullable|boolean',
            'institution' => 'nullable|string|max:255',
            'project_id' => 'required|exists:projects,project_id',
        ]);

        try {
            $dto = ParticipantDTO::fromRequest($validated);
            $this->updateParticipant->execute($participant->participant_id, $dto);

            return redirect()->route('participants.index')
                ->with('success', 'Participant updated successfully.');
        } catch (ParticipantException $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(Participant $participant)
    {
        try {
            $this->deleteParticipant->execute($participant->participant_id);

            return redirect()->route('participants.index')
                ->with('success', 'Participant deleted successfully.');
        } catch (ParticipantException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function projects(Participant $participant)
    {
        $projects = Project::where('project_id', $participant->project_id)->get();
        return view('participants.projects', compact('participant', 'projects'));
    }
}
