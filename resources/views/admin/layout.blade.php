<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Panel | The Lost Compass</title>
    <!-- Use some basic styles or Tailwind if it was available, but we will use inline or a simple style tag here for the admin panel to keep it distinct from the pirate theme -->
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; margin: 0; padding: 0; background-color: #f4f4f9; color: #333; }
        .admin-sidebar { width: 250px; background-color: #2c3e50; color: white; position: fixed; height: 100vh; overflow-y: auto; }
        .admin-sidebar h2 { padding: 20px; margin: 0; background-color: #1a252f; font-size: 1.2rem; }
        .admin-sidebar a { display: block; padding: 15px 20px; color: #ecf0f1; text-decoration: none; border-bottom: 1px solid #34495e; }
        .admin-sidebar a:hover { background-color: #34495e; }
        .admin-content { margin-left: 250px; padding: 20px; }
        .admin-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ccc; padding-bottom: 15px; margin-bottom: 20px; }
        .admin-header a { text-decoration: none; color: #3498db; }
        .card { background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        .table th { background-color: #f8f9fa; }
        .btn { padding: 8px 12px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; font-size: 0.9rem; }
        .btn-primary { background-color: #3498db; color: white; }
        .btn-danger { background-color: #e74c3c; color: white; }
        .btn-warning { background-color: #f1c40f; color: black; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-control { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>

    <div class="admin-sidebar">
        <h2>Admin Panel</h2>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('admin.characters.index') }}" class="sidebar-link {{ request()->routeIs('admin.characters.*') ? 'active' : '' }}">Characters</a>
        <a href="{{ route('admin.ships.index') }}" class="sidebar-link {{ request()->routeIs('admin.ships.*') ? 'active' : '' }}">Ships</a>
        <a href="{{ route('admin.locations.index') }}" class="sidebar-link {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}">Map Locations</a>
        <a href="{{ route('admin.missions.index') }}" class="sidebar-link {{ request()->routeIs('admin.missions.*') ? 'active' : '' }}">Missions</a>
        <a href="{{ route('admin.rumors.index') }}" class="sidebar-link {{ request()->routeIs('admin.rumors.*') ? 'active' : '' }}">Tavern Rumors</a>
        <a href="{{ route('admin.notices.index') }}" class="sidebar-link {{ request()->routeIs('admin.notices.*') ? 'active' : '' }}">Wanted Notices</a>
        <a href="{{ route('home') }}" class="sidebar-link">← Back to Site</a>
    </div>

    <div class="admin-content">
        <div class="admin-header">
            <h1>@yield('title')</h1>
            <div>Logged in as: {{ auth()->user()->name }}</div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>

</body>
</html>
