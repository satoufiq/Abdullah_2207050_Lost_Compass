@extends('admin.layout')

@section('title', 'Add New Rumor')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.rumors.index') }}" class="btn btn-secondary">&larr; Back to Rumors</a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Add New Rumor</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.rumors.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="content" class="form-label">Rumor Content <span class="text-danger">*</span></label>
                <textarea class="form-control" id="content" name="content" rows="3" required>{{ old('content') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="source" class="form-label">Source <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="source" name="source" value="{{ old('source', '— Mysterious Sailor') }}" required>
                <small class="form-text text-muted">e.g., "— Dockside Whispers"</small>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Active (Visible on Tavern Board)</label>
            </div>

            <button type="submit" class="btn btn-primary">Save Rumor</button>
        </form>
    </div>
</div>
@endsection
