@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2>Ships</h2>
    <a href="{{ route('admin.ships.create') }}" class="btn">Add New Ship</a>
</div>

@if(session('success'))
    <div style="background: rgba(46, 204, 113, 0.2); color: #2ecc71; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
        {{ session('success') }}
    </div>
@endif

<div class="card" style="overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 1px solid rgba(255,255,255,0.1); text-align: left;">
                <th style="padding: 1rem;">Image</th>
                <th style="padding: 1rem;">Name</th>
                <th style="padding: 1rem;">Captain</th>
                <th style="padding: 1rem;">Type</th>
                <th style="padding: 1rem;">Legend Rank</th>
                <th style="padding: 1rem;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ships as $ship)
            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                <td style="padding: 1rem;">
                    @if($ship->image)
                        <img src="{{ asset($ship->image) }}" alt="{{ $ship->name }}" style="height: 50px; border-radius: 4px; object-fit: cover;">
                    @else
                        No Image
                    @endif
                </td>
                <td style="padding: 1rem;">{{ $ship->name }}</td>
                <td style="padding: 1rem;">{{ $ship->captain ? $ship->captain->name : 'None' }}</td>
                <td style="padding: 1rem;">{{ $ship->type }}</td>
                <td style="padding: 1rem;">{{ $ship->legend_rank }}/10</td>
                <td style="padding: 1rem;">
                    <a href="{{ route('admin.ships.edit', $ship->id) }}" class="btn" style="padding: 0.3rem 0.6rem; font-size: 0.9rem; margin-right: 0.5rem;">Edit</a>
                    <form action="{{ route('admin.ships.destroy', $ship->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" style="background: #e74c3c; border-color: #c0392b; padding: 0.3rem 0.6rem; font-size: 0.9rem;" onclick="return confirm('Are you sure you want to delete this ship?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach

            @if($ships->isEmpty())
            <tr>
                <td colspan="6" style="padding: 2rem; text-align: center; color: rgba(255,255,255,0.5);">No ships found in the database.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
