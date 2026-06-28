@extends('admin.layout')

@section('title', 'Add New Wanted Notice')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.notices.index') }}" class="btn btn-secondary">&larr; Back to Notices</a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Add New Wanted Notice</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.notices.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Wanted Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="reward" class="form-label">Reward <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="reward" name="reward" value="{{ old('reward', '50,000 Gold Pieces') }}" required>
            </div>

            <div class="mb-3">
                <label for="desc" class="form-label">Description <span class="text-danger">*</span></label>
                <textarea class="form-control" id="desc" name="desc" rows="3" required>{{ old('desc') }}</textarea>
                <small class="form-text text-muted">Brief description of crimes.</small>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image Filename</label>
                <input type="text" class="form-control" id="image" name="image" value="{{ old('image', 'wanted-default.jpg') }}">
                <small class="form-text text-muted">Filename inside public/assets/images/tavern/</small>
            </div>

            <button type="submit" class="btn btn-primary">Save Notice</button>
        </form>
    </div>
</div>
@endsection
