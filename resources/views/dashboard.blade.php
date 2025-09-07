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
                <a href="{{ route('facilities.index') }}" class="list-group-item list-group-item-action">
                    Facilities
                </a>
                <a href="{{ route('projects.index') }}" class="list-group-item list-group-item-action">
                    Projects
                </a> 
                <a href="{{ route('equipments.index') }}" class="list-group-item list-group-item-action">
                    Equipments
                </a>
                <a href="{{ route('services.index') }}" class="list-group-item list-group-item-action">
                    Services
                </a>
                <a href="{{ route('participants.index') }}" class="list-group-item list-group-item-action">
                    Participants
                </a>
            </div>
        </div>
    </div>
@endsection
