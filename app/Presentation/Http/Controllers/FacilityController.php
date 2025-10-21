<?php

namespace App\Presentation\Http\Controllers;

use Illuminate\Http\Request;
use App\Application\UseCases\CreateFacility;
use App\Application\UseCases\UpdateFacility;
use App\Application\UseCases\DeleteFacility;
use App\Application\DTOs\FacilityDTO;
use App\Domain\Exceptions\FacilityException;
use App\Models\Facility;

class FacilityController extends Controller
{
    public function __construct(
        private CreateFacility $createFacility,
        private UpdateFacility $updateFacility,
        private DeleteFacility $deleteFacility
    ) {}

    public function index(Request $request)
    {
        $query = Facility::query();

        if ($request->filled('type')) {
            $query->where('facility_type', $request->type);
        }
        if ($request->filled('partner')) {
            $query->where('partner_organization', 'LIKE', '%' . $request->partner . '%');
        }
        if ($request->filled('capability')) {
            $query->where('capabilities', 'LIKE', '%' . $request->capability . '%');
        }

        $facilities = $query->paginate(10);
        return view('facilities.index', compact('facilities'));
    }

    public function create()
    {
        return view('facilities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'facility_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'partner_organization' => 'nullable|string|max:255',
            'capabilities' => 'nullable|array',
        ]);

        try {
            $dto = FacilityDTO::fromRequest($validated);
            $this->createFacility->execute($dto);
            
            return redirect()->route('facilities.index')
                ->with('success', 'Facility created successfully.');
        } catch (FacilityException $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show(Facility $facility)
    {
        return view('facilities.show', compact('facility'));
    }

    public function edit(Facility $facility)
    {
        return view('facilities.edit', compact('facility'));
    }

    public function update(Request $request, Facility $facility)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'facility_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'partner_organization' => 'nullable|string|max:255',
            'capabilities' => 'nullable|array',
        ]);

        try {
            $dto = FacilityDTO::fromRequest($validated);
            $this->updateFacility->execute($facility->facility_id, $dto);
            
            return redirect()->route('facilities.index')
                ->with('success', 'Facility updated successfully.');
        } catch (FacilityException $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(Facility $facility)
    {
        try {
            $this->deleteFacility->execute($facility->facility_id);
            
            return redirect()->route('facilities.index')
                ->with('success', 'Facility deleted successfully.');
        } catch (FacilityException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}