@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Participant Profile</h2>

    <p><strong>Name:</strong> {{ $participant->full_name }}</p>
    <p><strong>Email:</strong> {{ $participant->email }}</p>
    <p><strong>Affiliation:</strong> {{ $participant->affiliation }}</p>
    <p><strong>Specialization:</strong> {{ $participant->specialization }}</p>
    <p><strong>Cross Skill Trained:</strong> {{ $participant->cross_skill_trained ? 'Yes' : 'No' }}</p>
    <p><strong>Institution:</strong> {{ $participant->institution }}</p>
    <p><strong>Project:</strong> {{ $participant->project->title ?? 'N/A' }}</p>

    <a href="{{ route('participants.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
