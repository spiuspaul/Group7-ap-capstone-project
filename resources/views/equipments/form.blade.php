@csrf
<div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $equipment->name ?? '') }}" required>
</div>
<div class="mb-3">
    <label>Type</label>
    <input type="text" name="type" class="form-control" value="{{ old('type', $equipment->type ?? '') }}">
</div>
<div class="mb-3">
    <label>Description</label>
    <textarea name="description" class="form-control">{{ old('description', $equipment->description ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label>Quantity</label>
    <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $equipment->quantity ?? 0) }}" required>
</div>
<div class="mb-3">
    <label>Facility</label>
    <select name="facility_id" class="form-control" required>
        <option value="">Select Facility</option>
        @foreach($facilities as $facility)
            <option value="{{ $facility->id }}" 
                {{ (old('facility_id', $equipment->facility_id ?? '') == $facility->id) ? 'selected' : '' }}>
                {{ $facility->name }}
            </option>
        @endforeach
    </select>
</div>
