@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Service Details</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $service->name }}</p>
            <p><strong>Description:</strong> {{ $service->description }}</p>
            <p><strong>Facility:</strong> {{ $service->facility->name ?? 'N/A' }}</p>
        </div>
    </div>
    <a href="{{ route('services.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
