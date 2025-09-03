@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h1 class="card-title">Projects under <span class="text-primary">{{ $program->name }}</span></h1>

        @if($projects->isEmpty())
            <div class="alert alert-info mt-3">
                No projects available for this program yet.
            </div>
        @else
            <table class="table table-bordered table-striped mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>Title</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $project)
                        <tr>
                            <td>{{ $project->title }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('programs.index') }}" class="btn btn-secondary mt-3">Back to Programs</a>
    </div>
</div>
@endsection
