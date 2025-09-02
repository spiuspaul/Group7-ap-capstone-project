<div class="mb-3">
    <label>Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $outcome->title ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Description</label>
    <textarea name="description" class="form-control">{{ old('description', $outcome->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label>Outcome Type</label>
    <input type="text" name="outcome_type" class="form-control" value="{{ old('outcome_type', $outcome->outcome_type ?? '') }}">
</div>

<div class="mb-3">
    <label>Quality Certification</label>
    <input type="text" name="quality_certification" class="form-control" value="{{ old('quality_certification', $outcome->quality_certification ?? '') }}">
</div>

<div class="mb-3">
    <label>Commercialization Status</label>
    <input type="text" name="commercialization_status" class="form-control" value="{{ old('commercialization_status', $outcome->commercialization_status ?? '') }}">
</div>

<div class="mb-3">
    <label>Artifact (file)</label>
    <input type="file" name="artifact" class="form-control">
    @if(!empty($outcome->artifact_link))
        <small>Current file: <a href="{{ Storage::url($outcome->artifact_link) }}" target="_blank">View/Download</a></small>
    @endif
</div>
