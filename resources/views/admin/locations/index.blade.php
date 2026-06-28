@extends('admin.layout')

@section('title', 'Manage Map Locations')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Map Locations</h1>
    <a href="{{ route('admin.locations.create') }}" class="btn btn-primary">Add New Location</a>
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
                    <th>Type</th>
                    <th>Danger</th>
                    <th>Coordinates</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($locations as $location)
                <tr>
                    <td>{{ $location->id }}</td>
                    <td>{{ $location->name }}</td>
                    <td>{{ ucfirst($location->type) }}</td>
                    <td>
                        @for($i = 0; $i < $location->danger_level; $i++)
                            ☠️
                        @endfor
                    </td>
                    <td>{{ $location->x_position }}%, {{ $location->y_position }}%</td>
                    <td>
                        <a href="{{ route('admin.locations.edit', $location->id) }}" class="btn btn-sm btn-info">Edit</a>
                        <form action="{{ route('admin.locations.destroy', $location->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this location?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($locations->isEmpty())
                <tr>
                    <td colspan="6" class="text-center">No locations found.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
