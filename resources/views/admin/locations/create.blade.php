@extends('admin.layout')

@section('title', 'Add New Location')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary">&larr; Back to Locations</a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Add New Map Location</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.locations.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="id" class="form-label">ID (slug format) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="id" name="id" value="{{ old('id') }}" required>
                    <small class="text-muted">e.g., "skull-island"</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                    <select class="form-select" id="type" name="type" required>
                        <option value="island">Island</option>
                        <option value="outpost">Outpost</option>
                        <option value="fortress">Fortress</option>
                        <option value="ruins">Ruins</option>
                        <option value="cave">Cave</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="danger_level" class="form-label">Danger Level (1-5) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="danger_level" name="danger_level" min="1" max="5" value="{{ old('danger_level', 1) }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="x_position" class="form-label">X Position (%) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="x_position" name="x_position" min="0" max="100" value="{{ old('x_position', 50) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="y_position" class="form-label">Y Position (%) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="y_position" name="y_position" min="0" max="100" value="{{ old('y_position', 50) }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="image" class="form-label">Background Image</label>
                    <input type="text" class="form-control" id="image" name="image" value="{{ old('image', 'default-island.jpg') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="icon" class="form-label">Map Icon</label>
                    <input type="text" class="form-control" id="icon" name="icon" value="{{ old('icon', '🏝️') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="icon_label" class="form-label">Icon Label</label>
                    <input type="text" class="form-control" id="icon_label" name="icon_label" value="{{ old('icon_label') }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save Location</button>
        </form>
    </div>
</div>
@endsection
