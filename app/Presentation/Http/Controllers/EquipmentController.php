<?php

namespace App\Presentation\Http\Controllers;

use Illuminate\Http\Request;
use App\Application\UseCases\Equipment\CreateEquipmentUseCase;
use App\Application\UseCases\Equipment\UpdateEquipmentUseCase;
use App\Application\UseCases\Equipment\DeleteEquipmentUseCase;
use App\Application\DTOs\EquipmentDTO;
use App\Domain\Exceptions\EquipmentException;
use App\Infrastructure\Eloquent\Models\EquipmentModel;
use App\Infrastructure\Eloquent\Models\Facility;

class EquipmentController extends Controller
{
    public function __construct(
        private CreateEquipmentUseCase $createEquipment,
        private UpdateEquipmentUseCase $updateEquipment,
        private DeleteEquipmentUseCase $deleteEquipment
    ) {}

    public function index(Request $request)
    {
        $query = EquipmentModel::with('facility');

        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        $equipments = $query->paginate(10);
        return view('equipments.index', compact('equipments'));
    }

    public function create()
    {
        $facilities = Facility::all();
        return view('equipments.create', compact('facilities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'facility_id' => 'required|integer|exists:facilities,facility_id',
            'name' => 'required|string|max:255',
            'inventory_code' => 'required|string|max:255',
            'capabilities' => 'nullable|string',
            'description' => 'nullable|string',
            'usage_domain' => 'nullable|string',
            'support_phase' => 'nullable|string',
        ]);

        try {
            $dto = EquipmentDTO::fromRequest($validated);
            $this->createEquipment->execute($dto);
            return redirect()->route('equipments.index')
                ->with('success', 'Equipment created successfully.');
        } catch (EquipmentException $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function edit(EquipmentModel $equipment)
    {
        $facilities = Facility::all();
        return view('equipments.edit', compact('equipment', 'facilities'));
    }

    public function update(Request $request, EquipmentModel $equipment)
    {
        $validated = $request->validate([
            'facility_id' => 'required|integer|exists:facilities,facility_id',
            'name' => 'required|string|max:255',
            'inventory_code' => 'required|string|max:255',
            'capabilities' => 'nullable|string',
            'description' => 'nullable|string',
            'usage_domain' => 'nullable|string',
            'support_phase' => 'nullable|string',
        ]);

        try {
            $dto = EquipmentDTO::fromRequest($validated);
            $this->updateEquipment->execute($equipment->equipment_id, $dto);
            return redirect()->route('equipments.index')
                ->with('success', 'Equipment updated successfully.');
        } catch (EquipmentException $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(EquipmentModel $equipment)
    {
        try {
            $this->deleteEquipment->execute($equipment->equipment_id);
            return redirect()->route('equipments.index')
                ->with('success', 'Equipment deleted successfully.');
        } catch (EquipmentException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}