@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="card-title">Dashboard</h1>
            <p class="card-text">Welcome! Choose where to go:</p>

            <div class="list-group">
                <a href="{{ route('programs.index') }}" class="list-group-item list-group-item-action">
                    Programs
                </a>
                </a> 
            </div>
        </div>
    </div>
@endsection
