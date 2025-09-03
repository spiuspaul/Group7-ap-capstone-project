@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Services Across All Facilities</h1>
    <a href="{{ route('services.create') }}" class="btn btn-primary mb-3">Add Service</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Filter Form -->
    <form method="GET" action="{{ route('services.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="category" class="form-control" placeholder="Search by Category" value="{{ request('category') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="skill_type" class="form-control" placeholder="Search by Skill Type" value="{{ request('skill_type') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="facility" class="form-control" placeholder="Search by Facility" value="{{ request('facility') }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-secondary">Filter</button>
                <a href="{{ route('services.index') }}" class="btn btn-outline-secondary">Clear</a>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Skill Type</th>
                <th>Facility</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($services as $service)
            <tr>
                <td>{{ $service->name }}</td>
                <td>{{ Str::limit($service->description, 50) }}</td>
                <td>{{ $service->category ?? 'N/A' }}</td>
                <td>{{ $service->skill_type ?? 'N/A' }}</td>
                <td>
                    @if($service->facility)
                        <a href="{{ route('facilities.show', $service->facility->id) }}">
                            {{ $service->facility->name }}
                        </a>
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
            @empty
            <tr>
                <td colspan="6" class="text-center">No services found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection