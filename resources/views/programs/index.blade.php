@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Programs</h1>
        <a href="{{ route('programs.create') }}" class="btn btn-primary">+ Add Program</a>
    </div>

    @if($programs->isEmpty())
        <div class="alert alert-info">No programs available yet.</div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <!-- <th>Alignment</th> -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($programs as $program)
                    <tr>
                        <td>{{ $program->name }}</td>
                        <!-- <td>{{ $program->national_alignment }}</td> -->
                        <td>
                            <a href="{{ route('programs.show', $program->id) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('programs.edit', $program->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('programs.destroy', $program->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                            <a href="{{ route('programs.projects', $program->id) }}" class="btn btn-sm btn-secondary">Projects</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection 
