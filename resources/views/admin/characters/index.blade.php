@extends('admin.layout')

@section('title', 'Manage Characters')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>All Characters</h3>
        <a href="{{ route('admin.characters.create') }}" class="btn btn-primary">+ Add New Character</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Ship</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($characters as $char)
            <tr>
                <td>{{ $char->id }}</td>
                <td>
                    @if($char->image)
                        <img src="{{ asset($char->image) }}" alt="{{ $char->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                    @else
                        No Image
                    @endif
                </td>
                <td><strong>{{ $char->name }}</strong><br><small>{{ $char->role }}</small></td>
                <td>{{ ucfirst($char->category) }}</td>
                <td>{{ $char->ship_name ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('admin.characters.edit', $char->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.characters.destroy', $char->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this character?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
