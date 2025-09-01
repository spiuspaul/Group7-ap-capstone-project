<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('facilities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
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

        Facility::create($validated);
        return redirect()->route('facilities.index')->with('success', 'Facility registered successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Facility $facility)
    {
        return view('facilities.show', compact('facility'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facility $facility)
    {
        return view('facilities.edit', compact('facility'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Facility $facility)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'partner_organization' => 'nullable|string|max:255',
            'facility_type' => 'nullable|string|max:255',
            'capabilities' => 'nullable|string',
        ]);

        $facility->update($validated);
        return redirect()->route('facilities.index')->with('success', 'Facility updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facility $facility)
    {
        $facility->delete();
        return redirect()->route('facilities.index')->with('success', 'Facility deleted successfully.');
    }
}
