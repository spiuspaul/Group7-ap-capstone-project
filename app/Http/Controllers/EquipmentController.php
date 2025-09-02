<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Facility;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    // Show all equipment
    public function index()
    {
        $equipments = Equipment::with('facility')->get();
        return view('equipments.index', compact('equipments'));
    }

    // Show form to create equipment
    public function create()
    {
        $facilities = Facility::all();
        return view('equipments.create', compact('facilities'));
    }

    // Store new equipment
    public function store(Request $request)
    {
          $validated = $request->validate([
           'name' => 'required|string|max:255',
           'location' => 'nullable|string|max:255',
           'description' => 'nullable|string',
           'partner_organization' => 'nullable|string|max:255',
           'facility_type' => 'nullable|string|max:255',
           'capabilities' => 'nullable|string',
        ]);


        Equipment::create($request->all());

        return redirect()->route('equipments.index')->with('success', 'Equipment created successfully.');
    }

    // Edit form
    public function edit(Equipment $equipment)
    {
        $facilities = Facility::all();
        return view('equipments.edit', compact('equipment', 'facilities'));
    }

    // Update equipment
    public function update(Request $request, Equipment $equipment)
    {
         $validated = $request->validate([
           'name' => 'required|string|max:255',
           'location' => 'nullable|string|max:255',
           'description' => 'nullable|string',
           'partner_organization' => 'nullable|string|max:255',
           'facility_type' => 'nullable|string|max:255',
           'capabilities' => 'nullable|string',
        ]);


        $equipment->update($request->all());

        return redirect()->route('equipments.index')->with('success', 'Equipment updated successfully.');
    }

    // Delete equipment
    public function destroy(Equipment $equipment)
    {
        $equipment->delete();
        return redirect()->route('equipments.index')->with('success', 'Equipment deleted successfully.');
    }
}
