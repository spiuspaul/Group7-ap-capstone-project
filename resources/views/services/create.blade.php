@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Service</h1>

    <form action="{{ route('services.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label for="name" class="form-label">Service Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                   id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" 
                      id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-control @error('category') is-invalid @enderror" 
                    id="category" name="category" required>
                <option value="">Select Category</option>
                <option value="Medical" {{ old('category') == 'Medical' ? 'selected' : '' }}>Medical</option>
                <option value="Surgical" {{ old('category') == 'Surgical' ? 'selected' : '' }}>Surgical</option>
                <option value="Diagnostic" {{ old('category') == 'Diagnostic' ? 'selected' : '' }}>Diagnostic</option>
                <option value="Emergency" {{ old('category') == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                <option value="Preventive" {{ old('category') == 'Preventive' ? 'selected' : '' }}>Preventive</option>
                <option value="Rehabilitation" {{ old('category') == 'Rehabilitation' ? 'selected' : '' }}>Rehabilitation</option>
                <option value="Mental Health" {{ old('category') == 'Mental Health' ? 'selected' : '' }}>Mental Health</option>
                <option value="Specialty" {{ old('category') == 'Specialty' ? 'selected' : '' }}>Specialty</option>
            </select>
            @error('category')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="skill_type" class="form-label">Skill Type</label>
            <select class="form-control @error('skill_type') is-invalid @enderror" 
                    id="skill_type" name="skill_type" required>
                <option value="">Select Skill Type</option>
                <option value="Basic" {{ old('skill_type') == 'Basic' ? 'selected' : '' }}>Basic</option>
                <option value="Intermediate" {{ old('skill_type') == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                <option value="Advanced" {{ old('skill_type') == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                <option value="Specialist" {{ old('skill_type') == 'Specialist' ? 'selected' : '' }}>Specialist</option>
                <option value="Expert" {{ old('skill_type') == 'Expert' ? 'selected' : '' }}>Expert</option>
            </select>
            @error('skill_type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="facility_id" class="form-label">Facility</label>
            <select class="form-control @error('facility_id') is-invalid @enderror" 
                    id="facility_id" name="facility_id" required>
                <option value="">Select Facility</option>
                @foreach($facilities as $facility)
                    <option value="{{ $facility->id }}" {{ old('facility_id') == $facility->id ? 'selected' : '' }}>
                        {{ $facility->name }}
                    </option>
                @endforeach
            </select>
            @error('facility_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Create Service</button>
            <a href="{{ route('services.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection