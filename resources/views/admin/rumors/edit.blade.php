@extends('admin.layout')

@section('title', 'Edit Rumor')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.rumors.index') }}" class="btn btn-secondary">&larr; Back to Rumors</a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Rumor</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.rumors.update', $rumor->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="content" class="form-label">Rumor Content <span class="text-danger">*</span></label>
                <textarea class="form-control" id="content" name="content" rows="3" required>{{ old('content', $rumor->content) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="source" class="form-label">Source <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="source" name="source" value="{{ old('source', $rumor->source) }}" required>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $rumor->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Active (Visible on Tavern Board)</label>
            </div>

            <button type="submit" class="btn btn-primary">Update Rumor</button>
        </form>
    </div>
</div>
@endsection
