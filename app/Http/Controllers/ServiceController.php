<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Facility;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('facility')->get();
        return view('services.index', compact('services'));
    }

    public function create()
    {
        $facilities = Facility::all();
        return view('services.create', compact('facilities'));
    }

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


        Service::create($request->all());

        return redirect()->route('services.index')->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        $facilities = Facility::all();
        return view('services.edit', compact('service', 'facilities'));
    }

    public function update(Request $request, Service $service)
    {
          $validated = $request->validate([
           'name' => 'required|string|max:255',
           'location' => 'nullable|string|max:255',
           'description' => 'nullable|string',
           'partner_organization' => 'nullable|string|max:255',
           'facility_type' => 'nullable|string|max:255',
           'capabilities' => 'nullable|string',
        ]);


        $service->update($request->all());

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }
}
