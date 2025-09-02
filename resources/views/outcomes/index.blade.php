@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Outcomes for Project: {{ $project->name }}</h1>
    <a href="{{ route('projects.outcomes.create', $project) }}" class="btn btn-primary mb-3">Add Outcome</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Artifact</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($outcomes as $outcome)
            <tr>
                <td>{{ $outcome->title }}</td>
                <td>
                    @if($outcome->artifact_link)
                        <a href="{{ Storage::url($outcome->artifact_link) }}" target="_blank">View/Download</a>
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    <a href="{{ route('projects.outcomes.edit', [$project, $outcome]) }}" class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('projects.outcomes.destroy') }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this outcome?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
