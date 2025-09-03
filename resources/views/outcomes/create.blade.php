@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Outcome for Project: {{ $project->name }}</h1>

    <form action="{{ route('projects.outcomes.store', $project) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('outcomes.form')
        <button type="submit" class="btn btn-primary">Save Outcome</button>
    </form>
</div>
@endsection
