@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Participant</h2>

    <form action="{{ route('participants.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="full_name" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="mb-3">
            <label>Affiliation</label>
            <input type="text" name="affiliation" class="form-control">
        </div>

        <div class="mb-3">
            <label>Specialization</label>
            <input type="text" name="specialization" class="form-control">
        </div>

        <div class="mb-3">
            <label>Cross-Skill Trained</label>
            <select name="cross_skill_trained" class="form-control">
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Institution</label>
            <input type="text" name="institution" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Project</label>
            <select name="project_id" class="form-control" required>
                <option value="">-- Select Project --</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->title }}</option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('participants.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
