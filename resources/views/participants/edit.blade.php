@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Participant</h2>

    <form action="{{ route('participants.update', $participant->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="full_name" value="{{ $participant->full_name }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ $participant->email }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Affiliation</label>
            <input type="text" name="affiliation" value="{{ $participant->affiliation }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Specialization</label>
            <input type="text" name="specialization" value="{{ $participant->specialization }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Cross-Skill Trained</label>
            <select name="cross_skill_trained" class="form-control">
                <option value="0" {{ !$participant->cross_skill_trained ? 'selected' : '' }}>No</option>
                <option value="1" {{ $participant->cross_skill_trained ? 'selected' : '' }}>Yes</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Institution</label>
            <input type="text" name="institution" value="{{ $participant->institution }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Assign to Project</label>
            <select name="project_id" class="form-control">
                @foreach($projects as $project)
                    <option value="{{ $project->project_id }}" {{ $participant->project_id == $project->project_id ? 'selected' : '' }}>
                        {{ $project->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection
