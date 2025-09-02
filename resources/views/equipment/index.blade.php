@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Equipments</h1>
    <a href="{{ route('equipments.create') }}" class="btn btn-primary mb-3">Add Equipment</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Facility</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipments as $equipment)
            <tr>
                <td>{{ $equipment->name }}</td>
                <td>{{ $equipment->type }}</td>
                <td>{{ $equipment->description }}</td>
                <td>{{ $equipment->quantity }}</td>
                <td>{{ $equipment->facility->name ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('equipments.edit', $equipment->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('equipments.destroy', $equipment->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this equipment?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
