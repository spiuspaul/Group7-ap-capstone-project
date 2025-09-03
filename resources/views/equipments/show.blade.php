@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Equipment Details</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $equipment->name }}</p>
            <p><strong>Capabilities:</strong> {{ $equipment->capabilities }}</p>
            <p><strong>Description:</strong> {{ $equipment->description }}</p>
            <p><strong>Inventory Code:</strong> {{ $equipment->inventory_code }}</p>
            <p><strong>Usage Domain:</strong> {{ $equipment->usage_domain }}</p>
            <p><strong>Support Phase:</strong> {{ $equipment->support_phase }}</p>
        </div>
    </div>
    <a href="{{ route('equipments.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
