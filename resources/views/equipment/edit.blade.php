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
            <label>Type</label>
            <input type="text" name="type" class="form-control" value="{{ $equipment->type }}">
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $equipment->description }}</textarea>
        </div>
        <div class="mb-3">
            <label>Quantity</label>
            <input type="number" name="quantity" class="form-control" value="{{ $equipment->quantity }}" required>
        </div>
        <div class="mb-3">
            <label>Facility</label>
            <select name="facility_id" class="form-control" required>
                @foreach($facilities as $facility)
                    <option value="{{ $facility->id }}" {{ $equipment->facility_id == $facility->id ? 'selected' : '' }}>
                        {{ $facility->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
