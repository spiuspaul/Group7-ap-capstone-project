@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Facility</h1>
    <form action="{{ route('facilities.update', $facility) }}" method="POST">
        @method('PUT')
        @include('facilities.form')
    </form>
</div>
@endsection
