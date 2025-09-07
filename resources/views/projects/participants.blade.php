@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h1 class="card-title">Participants under <span class="text-primary">{{ $project->full_name}}</span></h1>

        @if($participants->isEmpty())
            <div class="alert alert-info mt-3">
                No participants available for this project yet.
            </div>
        @else
            <table class="table table-bordered table-striped mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($participants as $participant)
                        <tr>
                            <td>{{ $participant->full_name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('projects.index') }}" class="btn btn-secondary mt-3">Back to Projects</a>
    </div>
</div>
@endsection
