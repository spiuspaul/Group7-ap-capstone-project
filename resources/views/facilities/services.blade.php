@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Services at {{ $facility->name }}</h1>
        <div>
            <a href="{{ route('facilities.show', $facility->id) }}" class="btn btn-secondary">Back to Facility</a>
            <a href="{{ route('services.create') }}?facility_id={{ $facility->id }}" class="btn btn-primary">Add Service</a>
        </div>
    </div>

    @if($facility->location || $facility->facility_type)
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Facility Information</h5>
            @if($facility->location)
                <p><strong>Location:</strong> {{ $facility->location }}</p>
            @endif
            @if($facility->facility_type)
                <p><strong>Type:</strong> {{ $facility->facility_type }}</p>
            @endif
            @if($facility->partner_organization)
                <p><strong>Partner:</strong> {{ $facility->partner_organization }}</p>
            @endif
        </div>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5>Services Offered</h5>
        </div>
        <div class="card-body">
            @if($services)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Skill Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $service)
                        <tr>
                            <td>{{ $service->name }}</td>
                            <td>{{ Str::limit($service->description, 50) }}</td>
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
                            <td>
                                <a href="{{ route('services.show', $service->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('services.edit', $service->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('services.destroy', $service->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this service?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-4">
                    <p class="text-muted">No services found for this facility.</p>
                    <a href="{{ route('services.create') }}?facility_id={{ $facility->id }}" class="btn btn-primary">Add First Service</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

