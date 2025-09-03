@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ $facility->name }}</h1>
        <div>
            <a href="{{ route('facilities.index') }}" class="btn btn-secondary">Back to Facilities</a>
            <a href="{{ route('facilities.edit', $facility) }}" class="btn btn-warning">Edit Facility</a>
        </div>
    </div>

    <!-- Facility Information -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Facility Details</h5>
                </div>
                <div class="card-body">
                    @if($facility->location)
                        <p><strong>Location:</strong> {{ $facility->location }}</p>
                    @endif
                    @if($facility->facility_type)
                        <p><strong>Type:</strong> {{ $facility->facility_type }}</p>
                    @endif
                    @if($facility->partner_organization)
                        <p><strong>Partner Organization:</strong> {{ $facility->partner_organization }}</p>
                    @endif
                    @if($facility->description)
                        <p><strong>Description:</strong> {{ $facility->description }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Equipment and Services Tabs -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Equipment</h5>
                    <div>
                        <a href="{{ route('facilities.equipment', $facility) }}" class="btn btn-outline-primary btn-sm">View All</a>
                        <a href="{{ route('equipments.create') }}?facility_id={{ $facility->id }}" class="btn btn-primary btn-sm">Add Equipment</a>
                    </div>
                </div>
                <div class="card-body">
                    @if($facility->equipments)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($facility->equipments->take(5) as $equipment)
                                    <tr>
                                        <td>{{ $equipment->name }}</td>
                                        <td>{{ $equipment->type ?? 'N/A' }}</td>
                                        <td>{{ $equipment->quantity ?? 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($facility->equipments)
                            <p class="text-muted small">Showing 5 equipment items.</p>
                        @endif
                    @else
                        <p class="text-muted">No equipment registered for this facility.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Services</h5>
                    <div>
                        <a href="{{ route('facilities.services', $facility) }}" class="btn btn-outline-primary btn-sm">View All</a>
                        <a href="{{ route('services.create') }}?facility_id={{ $facility->id }}" class="btn btn-primary btn-sm">Add Service</a>
                    </div>
                </div>
                <div class="card-body">
                    @if($facility->services)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Skill Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($facility->services->take(5) as $service)
                                    <tr>
                                        <td>{{ $service->name }}</td>
                                        <td>
                                            @if($service->category)
                                                <span class="badge bg-primary">{{ $service->category }}</span>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if($service->skill_type)
                                                <span class="badge bg-secondary">{{ $service->skill_type }}</span>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($facility->services)
                            <p class="text-muted small">Showing 5 services.</p>
                        @endif
                    @else
                        <p class="text-muted">No services registered for this facility.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection