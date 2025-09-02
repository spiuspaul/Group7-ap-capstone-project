@csrf
<div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $service->name ?? '') }}" required>
</div>
<div class="mb-3">
    <label>Description</label>
    <textarea name="description" class="form-control">{{ old('description', $service->description ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label>Facility</label>
    <select name="facility_id" class="form-control" required>
        <option value="">Select Facility</option>
        @foreach($facilities as $facility)
            <option value="{{ $facility->id }}" 
                {{ (old('facility_id', $service->facility_id ?? '') == $facility->id) ? 'selected' : '' }}>
                {{ $facility->name }}
            </option>
        @endforeach
    </select>
</div>
