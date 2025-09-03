@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Equipment</h1>

    <form action="{{ route('equipments.update', $equipment->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $equipment->name }}" required>
        </div>
        <div class="mb-3">
            <label>Capabilities</label>
            <input type="text" name="capabilities" class="form-control" value="{{ $equipment->capabilities }}">
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $equipment->description }}</textarea>
        </div>
        <div class="mb-3">
            <label>Inventory Code</label>
            <input type="text" name="inventory_code" class="form-control" value="{{ $equipment->inventory_code }}">
        </div>
        <div class="mb-3">
            <label>Usage Domain</label>
            <input type="text" name="usage_domain" class="form-control" value="{{ $equipment->usage_domain }}">
        </div>
        <div class="mb-3">
            <label>Support Phase</label>
            <input type="text" name="support_phase" class="form-control" value="{{ $equipment->support_phase }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
