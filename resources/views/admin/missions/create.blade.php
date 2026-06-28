@extends('admin.layout')

@section('title', 'Add New Mission')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.missions.index') }}" class="btn btn-secondary">&larr; Back to Missions</a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Add New Mission</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.missions.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Mission Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="location_id" class="form-label">Map Location</label>
                    <select class="form-select" id="location_id" name="location_id">
                        <option value="">-- Select Map Location --</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc->id }}" {{ old('location_id') == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Links this mission to a spot on the interactive map.</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="location" class="form-label">Location (Legacy Text)</label>
                    <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}">
                    <small class="text-muted">Will be auto-filled if Map Location is selected.</small>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="difficulty" class="form-label">Difficulty (1-5) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="difficulty" name="difficulty" min="1" max="5" value="{{ old('difficulty', 1) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="image" class="form-label">Image Filename</label>
                    <input type="text" class="form-control" id="image" name="image" value="{{ old('image', 'mission-default.jpg') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="ship_id" class="form-label">Required Ship</label>
                    <select class="form-select" id="ship_id" name="ship_id">
                        <option value="">-- None --</option>
                        @foreach($ships as $ship)
                            <option value="{{ $ship->id }}" {{ old('ship_id') == $ship->id ? 'selected' : '' }}>{{ $ship->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="featured" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}>
                <label class="form-check-label" for="featured">Featured (Shows on Home Page)</label>
            </div>

            <button type="submit" class="btn btn-primary">Save Mission</button>
        </form>
    </div>
</div>
@endsection
