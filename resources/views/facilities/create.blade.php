@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Register Facility</h1>
    <form action="{{ route('facilities.store') }}" method="POST">
        @include('facilities.form')
    </form>
</div>
@endsection
