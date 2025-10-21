@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h1 class="card-title mb-4">Create Program</h1>

        <form action="{{ route('programs.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">National Alignment</label>
                <input type="text" name="national_alignment" class="form-control">

                <!-- <select name="national_alignment[]" class="form-control" multiple>
                    <option value="NDPIII">NDPIII</option>
                    <option value="DigitalRoadmap2023_2028">Digital Roadmap 2023-2028</option>
                    <option value="4IR">4IR</option>
                </select>
                <small class="text-muted">Hold Ctrl/Cmd to select multiple options</small> -->
            </div>

            <div class="mb-3">
                <label class="form-label">Focus Areas</label>
                <input type="text" name="focus_areas[]" class="form-control" placeholder="Enter focus area">
            </div>

            <div class="mb-3">
                <label class="form-label">Phases</label>
                <div class="phase-item border p-3">
                    <div class="mb-2">
                        <input type="text" name="phases[0][name]" placeholder="Phase Name" class="form-control">
                    </div>
                    <div class="mb-2">
                        <input type="text" name="phases[0][description]" placeholder="Phase Description" class="form-control">
                    </div>
                    <div class="mb-2">
                        <input type="number" name="phases[0][duration]" placeholder="Duration (weeks)" class="form-control">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('programs.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
