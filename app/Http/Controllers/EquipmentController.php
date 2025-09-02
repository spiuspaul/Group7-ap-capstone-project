<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $equipment= equipment::with('facility')->get();
            return view('equipment.index', compact('equipments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
           $facilities = Facility::all();
           return view('equipments.create', compact('facilities')); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'name' => 'required',
        'facility_id' => 'required|exists:facilities,id',
    ]);

    equipment::create($request->all());

    return redirect()->route('equipments.index')->with('success', 'equipment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment)
    {
        return view('equipments.show',compact('equipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment)
    {
        $facilities = Facility::all();
        return view('equipments.edit', compact('equipment', 'facilities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipment $equipment)
    {
        $request->validate([
        'name' => 'required',
        'facility_id' => 'required|exists:facilities,id',
    ]);

    $service->update($request->all());

    return redirect()->route('equipment.index')->with('success', 'Equipment updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment)
    {
         $equipment->delete();
         return redirect()->route('equipments.index')->with('success', 'Equipment deleted.');

    }
}
