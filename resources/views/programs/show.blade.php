@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h1 class="card-title">{{ $program->name }}</h1>
        <p class="card-text">{{ $program->description }}</p>

        <ul class="list-group mb-3">
            <li class="list-group-item"><strong>National Alignment:</strong> {{ $program->national_alignment }}</li>
            <li class="list-group-item"><strong>Focus Areas:</strong> {{ $program->focus_areas }}</li>
            <li class="list-group-item"><strong>Phases:</strong> {{ $program->phases }}</li>
        </ul>

        <a href="{{ route('programs.index') }}" class="btn btn-secondary">Back to Programs</a>
        <a href="{{ route('programs.edit', $program->id) }}" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection
