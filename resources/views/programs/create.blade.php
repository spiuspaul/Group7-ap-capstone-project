@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h1 class="card-title mb-4">Create Program</h1>

        <form action="{{ route('programs.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">National Alignment</label>
                <input type="text" name="national_alignment" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Focus Areas</label>
                <input type="text" name="focus_areas" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Phases</label>
                <input type="text" name="phases" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('programs.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
