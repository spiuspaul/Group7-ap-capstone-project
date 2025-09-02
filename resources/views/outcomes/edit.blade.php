@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Outcome: {{ $outcome->title }}</h1>

    <form action="{{ route('projects.outcomes.update', [$project, $outcome]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('outcomes.form')
        <button type="submit" class="btn btn-primary">Update Outcome</button>
    </form>
</div>
@endsection
