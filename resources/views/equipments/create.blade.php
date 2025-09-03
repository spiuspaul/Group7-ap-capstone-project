@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Equipment</h1>

    <form action="{{ route('equipments.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Facility</label>
            <select name="facility_id" class="form-control" required>
                <option value="">-- Select Facility --</option>
                @foreach($facilities as $facility)
                    <option value="{{ $facility->id }}">{{ $facility->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Capabilities</label>
            <input type="text" name="capabilities" class="form-control">
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Inventory Code</label>
            <input type="text" name="inventory_code" class="form-control">
        </div>
        <div class="mb-3">
            <label>Usage Domain</label>
            <input type="text" name="usage_domain" class="form-control">
        </div>
        <div class="mb-3">
            <label>Support Phase</label>
            <input type="text" name="support_phase" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection
