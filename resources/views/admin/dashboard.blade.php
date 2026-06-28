@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="card">
    <h3>Overview</h3>
    <p>Welcome to the Admin Control Panel. Here you can manage the content for The Lost Compass.</p>
    <p class="text-muted"><em>Note: All data listed below are submitted and managed by the Admin.</em></p>
    
    <div style="display: flex; gap: 20px; margin-top: 20px; flex-wrap: wrap;">
        <div style="background: #3498db; color: white; padding: 20px; border-radius: 5px; flex: 1; min-width: 150px;">
            <h4>Characters</h4>
            <div style="font-size: 2rem; font-weight: bold;">{{ $characterCount }}</div>
        </div>
        <div style="background: #e67e22; color: white; padding: 20px; border-radius: 5px; flex: 1; min-width: 150px;">
            <h4>Missions</h4>
            <div style="font-size: 2rem; font-weight: bold;">{{ $missionCount }}</div>
        </div>
        <div style="background: #2ecc71; color: white; padding: 20px; border-radius: 5px; flex: 1; min-width: 150px;">
            <h4>Locations</h4>
            <div style="font-size: 2rem; font-weight: bold;">{{ $locationCount }}</div>
        </div>
        <div style="background: #9b59b6; color: white; padding: 20px; border-radius: 5px; flex: 1; min-width: 150px;">
            <h4>Ships</h4>
            <div style="font-size: 2rem; font-weight: bold;">{{ $shipCount }}</div>
        </div>
        <div style="background: #f1c40f; color: white; padding: 20px; border-radius: 5px; flex: 1; min-width: 150px;">
            <h4>Rumors</h4>
            <div style="font-size: 2rem; font-weight: bold;">{{ $rumorCount }}</div>
        </div>
        <div style="background: #e74c3c; color: white; padding: 20px; border-radius: 5px; flex: 1; min-width: 150px;">
            <h4>Notices</h4>
            <div style="font-size: 2rem; font-weight: bold;">{{ $noticeCount }}</div>
        </div>
    </div>
</div>
@endsection
