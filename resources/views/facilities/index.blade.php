@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Facilities</h1>

    <a href="{{ route('facilities.create') }}" class="btn btn-primary mb-3">Register Facility</a>

    <form method="GET" action="{{ route('facilities.index') }}" class="mb-3">
        <input type="text" name="partner" placeholder="Search by Partner" value="{{ request('partner') }}">
        <input type="text" name="type" placeholder="Search by Type" value="{{ request('type') }}">
        <input type="text" name="capability" placeholder="Search by Capability" value="{{ request('capability') }}">
        <button type="submit" class="btn btn-secondary">Filter</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <!-- <th>Location</th>
                <th>Type</th>
                <th>Partner</th> -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($facilities as $facility)
                <tr>
                    <td>{{ $facility->name }}</td>
                    <!-- <td>{{ $facility->location }}</td>
                    <td>{{ $facility->facility_type }}</td>
                    <td>{{ $facility->partner_organization }}</td> -->
                    <td>
                        <a href="{{ route('facilities.show', $facility) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('facilities.edit', $facility) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('facilities.destroy', $facility) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this facility?')" class="btn btn-danger btn-sm">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $facilities->links() }}
</div>
@endsection
