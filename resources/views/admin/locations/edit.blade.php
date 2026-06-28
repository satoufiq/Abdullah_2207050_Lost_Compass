@extends('admin.layout')

@section('title', 'Edit Location')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary">&larr; Back to Locations</a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Location: {{ $location->name }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.locations.update', $location->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="id" class="form-label">ID (slug format)</label>
                    <input type="text" class="form-control" id="id" value="{{ $location->id }}" disabled>
                    <small class="text-muted">ID cannot be changed after creation.</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $location->name) }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                    <select class="form-select" id="type" name="type" required>
                        <option value="island" {{ $location->type == 'island' ? 'selected' : '' }}>Island</option>
                        <option value="outpost" {{ $location->type == 'outpost' ? 'selected' : '' }}>Outpost</option>
                        <option value="fortress" {{ $location->type == 'fortress' ? 'selected' : '' }}>Fortress</option>
                        <option value="ruins" {{ $location->type == 'ruins' ? 'selected' : '' }}>Ruins</option>
                        <option value="cave" {{ $location->type == 'cave' ? 'selected' : '' }}>Cave</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="danger_level" class="form-label">Danger Level (1-5) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="danger_level" name="danger_level" min="1" max="5" value="{{ old('danger_level', $location->danger_level) }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $location->description) }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="x_position" class="form-label">X Position (%) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="x_position" name="x_position" min="0" max="100" value="{{ old('x_position', $location->x_position) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="y_position" class="form-label">Y Position (%) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="y_position" name="y_position" min="0" max="100" value="{{ old('y_position', $location->y_position) }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="image" class="form-label">Background Image</label>
                    <input type="text" class="form-control" id="image" name="image" value="{{ old('image', $location->image) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="icon" class="form-label">Map Icon</label>
                    <input type="text" class="form-control" id="icon" name="icon" value="{{ old('icon', $location->icon) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="icon_label" class="form-label">Icon Label</label>
                    <input type="text" class="form-control" id="icon_label" name="icon_label" value="{{ old('icon_label', $location->icon_label) }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Location</button>
        </form>
    </div>
</div>
@endsection
