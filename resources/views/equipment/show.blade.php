@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Equipment Details</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $equipment->name }}</p>
            <p><strong>Type:</strong> {{ $equipment->type }}</p>
            <p><strong>Description:</strong> {{ $equipment->description }}</p>
            <p><strong>Quantity:</strong> {{ $equipment->quantity }}</p>
            <p><strong>Facility:</strong> {{ $equipment->facility->name ?? 'N/A' }}</p>
        </div>
    </div>
    <a href="{{ route('equipments.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
