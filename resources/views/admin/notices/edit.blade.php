@extends('admin.layout')

@section('title', 'Edit Wanted Notice')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.notices.index') }}" class="btn btn-secondary">&larr; Back to Notices</a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Wanted Notice</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.notices.update', $notice->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Wanted Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $notice->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="reward" class="form-label">Reward <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="reward" name="reward" value="{{ old('reward', $notice->reward) }}" required>
            </div>

            <div class="mb-3">
                <label for="desc" class="form-label">Description <span class="text-danger">*</span></label>
                <textarea class="form-control" id="desc" name="desc" rows="3" required>{{ old('desc', $notice->desc) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image Filename</label>
                <input type="text" class="form-control" id="image" name="image" value="{{ old('image', $notice->image) }}">
            </div>

            <button type="submit" class="btn btn-primary">Update Notice</button>
        </form>
    </div>
</div>
@endsection
