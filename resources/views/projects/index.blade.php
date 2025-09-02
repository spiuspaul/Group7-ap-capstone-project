@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Projects</h1>

    <a href="{{ route('projects.create') }}" class="btn btn-primary mb-3">Create New Project</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Facility</th>
                <th>Program</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($projects as $project)
            <tr>
                <td>{{ $project->title }}</td>
                <td>{{ $project->facility->name ?? 'N/A' }}</td>
                <td>{{ $project->program->name ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('projects.show', $project) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">
                            Delete
                        </button>
                    </form>
                    <a href="{{ route('projects.outcomes.index', ['project' => $project->id]) }}" class="btn btn-secondary btn-sm">View Outcomes</a>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">No projects found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
