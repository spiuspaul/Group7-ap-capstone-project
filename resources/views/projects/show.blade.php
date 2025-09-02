@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Project Details</h1>

    <div class="card">
        <div class="card-body">
            <h3>{{ $project->title }}</h3>
            <p><strong>Description:</strong> {{ $project->description ?? 'N/A' }}</p>
            <p><strong>Innovation Focus:</strong> {{ $project->innovation_focus ?? 'N/A' }}</p>
            <p><strong>Prototype Stage:</strong> {{ $project->prototype_stage ?? 'N/A' }}</p>
            <p><strong>Commercialization Plan:</strong> {{ $project->commercialization_plan ?? 'N/A' }}</p>
        </div>
    </div>

    <a href="{{ route('projects.index') }}" class="btn btn-primary mt-3">Back to Projects</a>
</div>
@endsection



