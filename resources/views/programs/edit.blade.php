@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h1 class="card-title mb-4">Edit Program</h1>

        <form action="{{ route('programs.update', $program->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" value="{{ $program->name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ $program->description }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">National Alignment</label>
                <input type="text" name="national_alignment" value="{{ $program->national_alignment }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Focus Areas (CSV/JSON)</label>
                <input type="text" name="focus_areas" value="{{ $program->focus_areas }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Phases (CSV/JSON)</label>
                <input type="text" name="phases" value="{{ $program->phases }}" class="form-control">
            </div>

            <button type="submit" class="btn btn-warning">Update</button>
            <a href="{{ route('programs.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
