@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Project</h1>

    <form action="{{ route('projects.update', $project->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $project->title }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Facility</label>
            <select name="facility_id" class="form-control" required>
                <option value="">-- Select Facility --</option>
                @foreach($facilities as $facility)
                    <option value="{{ $facility->id }}" 
                        {{ $project->facility_id == $facility->id ? 'selected' : '' }}>
                        {{ $facility->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Program</label>
            <select name="program_id" class="form-control" required>
                <option value="">-- Select Program --</option>
                @foreach($programs as $program)
                    <option value="{{ $program->id }}" 
                        {{ $project->program_id == $program->id ? 'selected' : '' }}>
                        {{ $program->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ $project->description }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Nature of Project</label>
            <input type="text" name="nature_of_project" class="form-control" value="{{ $project->nature_of_project }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Innovation Focus</label>
            <input type="text" name="innovation_focus" class="form-control" value="{{ $project->innovation_focus }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Prototype Stage</label>
            <input type="text" name="prototype_stage" class="form-control" value="{{ $project->prototype_stage }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Testing Requirements</label>
            <textarea name="testing_requirements" class="form-control">{{ $project->testing_requirements }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Commercialization Plan</label>
            <textarea name="commercialization_plan" class="form-control">{{ $project->commercialization_plan }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
