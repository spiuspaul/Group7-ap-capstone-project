@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Participants</h2>
    <a href="{{ route('participants.create') }}" class="btn btn-primary mb-3">Add Participant</a>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($participants as $participant)
            <tr>
                <td>{{ $participant->full_name }}</td>
                <td>
                    <a href="{{ route('participants.show', $participant->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('participants.edit', $participant->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('participants.destroy', $participant->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this participant?')">Delete</button>
                    </form>
                
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $participants->links() }}
</div>
@endsection
