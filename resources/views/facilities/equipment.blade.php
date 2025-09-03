@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Equipment at {{ $facility->name }}</h1>
        <div>
            <a href="{{ route('facilities.show', $facility->id) }}" class="btn btn-secondary">Back to Facility</a>
            <a href="{{ route('equipments.create') }}?facility_id={{ $facility->id }}" class="btn btn-primary">Add Equipment</a>
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
            <h5>Equipment List</h5>
        </div>
        <div class="card-body">
            @if($equipments)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($equipments as $equipment)
                        <tr>
                            <td>{{ $equipment->name }}</td>
                            <td>{{ $equipment->type ?? 'N/A' }}</td>
                            <td>{{ Str::limit($equipment->description, 50) ?? 'N/A' }}</td>
                            <td>{{ $equipment->quantity ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('equipments.edit', $equipment->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('equipments.destroy', $equipment->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this equipment?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-4">
                    <p class="text-muted">No equipment found for this facility.</p>
                    <a href="{{ route('equipments.create') }}?facility_id={{ $facility->id }}" class="btn btn-primary">Add First Equipment</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection