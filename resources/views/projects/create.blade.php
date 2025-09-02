@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Project</h1>

    <form action="{{ route('projects.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Facility</label>
            <select name="facility_id" class="form-control" required>
                <option value="">-- Select Facility --</option>
                @foreach($facilities as $facility)
                    <option value="{{ $facility->id }}">{{ $facility->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Program</label>
            <select name="program_id" class="form-control" required>
                <option value="">-- Select Program --</option>
                @foreach($programs as $program)
                    <option value="{{ $program->id }}">{{ $program->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Nature of Project</label>
            <input type="text" name="nature_of_project" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Innovation Focus</label>
            <input type="text" name="innovation_focus" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Prototype Stage</label>
            <input type="text" name="prototype_stage" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Testing Requirements</label>
            <textarea name="testing_requirements" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Commercialization Plan</label>
            <textarea name="commercialization_plan" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
