@extends('admin.layout')

@section('title', 'Manage Wanted Notices')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Wanted Notices</h1>
    <a href="{{ route('admin.notices.create') }}" class="btn btn-primary">Add New Notice</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Reward</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notices as $notice)
                <tr>
                    <td>{{ $notice->id }}</td>
                    <td>{{ $notice->name }}</td>
                    <td>{{ $notice->reward }}</td>
                    <td>{{ $notice->image }}</td>
                    <td>
                        <a href="{{ route('admin.notices.edit', $notice->id) }}" class="btn btn-sm btn-info">Edit</a>
                        <form action="{{ route('admin.notices.destroy', $notice->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this notice?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($notices->isEmpty())
                <tr>
                    <td colspan="5" class="text-center">No notices found.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
