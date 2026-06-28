@extends('admin.layout')

@section('title', 'Manage Missions')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Missions</h1>
    <a href="{{ route('admin.missions.create') }}" class="btn btn-primary">Add New Mission</a>
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
                    <th>Title</th>
                    <th>Location</th>
                    <th>Difficulty</th>
                    <th>Featured</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($missions as $mission)
                <tr>
                    <td>{{ $mission->id }}</td>
                    <td>{{ $mission->title }}</td>
                    <td>{{ $mission->location_id ? ($mission->location_model->name ?? $mission->location_id) : $mission->location }}</td>
                    <td>
                        @for($i = 0; $i < $mission->difficulty; $i++)
                            ⭐
                        @endfor
                    </td>
                    <td>
                        @if($mission->featured)
                            <span class="badge bg-success">Yes</span>
                        @else
                            <span class="badge bg-secondary">No</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.missions.edit', $mission->id) }}" class="btn btn-sm btn-info">Edit</a>
                        <form action="{{ route('admin.missions.destroy', $mission->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this mission?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($missions->isEmpty())
                <tr>
                    <td colspan="6" class="text-center">No missions found.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
