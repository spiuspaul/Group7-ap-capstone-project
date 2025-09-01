@csrf
<div class="form-group">
    <label>Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $facility->name ?? '') }}" required>
</div>

<div class="form-group">
    <label>Location</label>
    <input type="text" name="location" class="form-control" value="{{ old('location', $facility->location ?? '') }}">
</div>

<div class="form-group">
    <label>Description</label>
    <textarea name="description" class="form-control">{{ old('description', $facility->description ?? '') }}</textarea>
</div>

<div class="form-group">
    <label>Partner Organization</label>
    <input type="text" name="partner_organization" class="form-control" value="{{ old('partner_organization', $facility->partner_organization ?? '') }}">
</div>

<div class="form-group">
    <label>Facility Type</label>
    <input type="text" name="facility_type" class="form-control" value="{{ old('facility_type', $facility->facility_type ?? '') }}">
</div>

<div class="form-group">
    <label>Capabilities</label>
    <input type="text" name="capabilities" class="form-control" value="{{ old('capabilities', $facility->capabilities ?? '') }}">
</div>

<button type="submit" class="btn btn-success">Save</button>
