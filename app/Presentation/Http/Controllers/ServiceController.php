<?php

namespace App\Presentation\Http\Controllers;

use Illuminate\Http\Request;
use App\Application\DTOs\ServiceDTO;
use App\Application\UseCases\Service\CreateServiceUseCase;
use App\Application\UseCases\Service\UpdateServiceUseCase;
use App\Application\UseCases\Service\DeleteServiceUseCase;
use App\Domain\Exceptions\ServiceException;
use App\Infrastructure\Persistence\Eloquent\Models\ServiceModel as Service;

class ServiceController extends Controller
{
    public function __construct(
        private CreateServiceUseCase $createService,
        private UpdateServiceUseCase $updateService,
        private DeleteServiceUseCase $deleteService
    ) {}

    public function index(Request $request)
    {
        $services = Service::with('facility')->paginate(10);
        return view('services.index', compact('services'));
    }

    public function create()
    {
        $facilities = \App\Infrastructure\Persistence\Eloquent\Models\Facility::all();
        return view('services.create', compact('facilities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'facility_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'skill_type' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            $dto = ServiceDTO::fromRequest($validated);
            $this->createService->execute($dto);

            return redirect()->route('services.index')
                ->with('success', 'Service created successfully.');
        } catch (ServiceException $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function edit(Service $service)
    {
        $facilities = \App\Infrastructure\Persistence\Eloquent\Models\Facility::all();
        return view('services.edit', compact('service', 'facilities'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'facility_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'skill_type' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            $dto = ServiceDTO::fromRequest($validated);
            $this->updateService->execute($service->service_id, $dto);

            return redirect()->route('services.index')
                ->with('success', 'Service updated successfully.');
        } catch (ServiceException $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(Service $service)
    {
        try {
            $this->deleteService->execute($service->service_id);

            return redirect()->route('services.index')
                ->with('success', 'Service deleted successfully.');
        } catch (ServiceException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
