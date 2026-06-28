@extends('admin.layout')

@section('title', 'Manage Rumors')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Tavern Rumors</h1>
    <a href="{{ route('admin.rumors.create') }}" class="btn btn-primary">Add New Rumor</a>
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
                    <th>Content</th>
                    <th>Source</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rumors as $rumor)
                <tr>
                    <td>{{ $rumor->id }}</td>
                    <td>{{ Str::limit($rumor->content, 50) }}</td>
                    <td>{{ $rumor->source }}</td>
                    <td>
                        @if($rumor->is_active)
                            <span class="badge bg-success">Yes</span>
                        @else
                            <span class="badge bg-secondary">No</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.rumors.edit', $rumor->id) }}" class="btn btn-sm btn-info">Edit</a>
                        <form action="{{ route('admin.rumors.destroy', $rumor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this rumor?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($rumors->isEmpty())
                <tr>
                    <td colspan="5" class="text-center">No rumors found.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
