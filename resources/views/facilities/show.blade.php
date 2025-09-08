@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $facility->name }}</h1>
    <p><strong>Location:</strong> {{ $facility->location }}</p>
    <p><strong>Type:</strong> {{ $facility->facility_type }}</p>
    <p><strong>Partner:</strong> {{ $facility->partner_organization }}</p>
    <p><strong>Description:</strong> {{ $facility->description }}</p>
    <p><strong>Capabilities:</strong> {{ $facility->capabilities }}</p>

    <a href="{{ route('facilities.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
