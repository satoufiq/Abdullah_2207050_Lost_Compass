<nav @if(isset($navClass)) class="{{ $navClass }}" @endif>
    <div class="nav-container">
        <a href="{{ url('/') }}" class="nav-logo">
            <img src="{{ asset('assets/images/home/compass-rose.png') }}" alt="The Lost Compass" class="logo-compass">
            <span class="logo-text">The Lost Compass</span>
        </a>
        <button type="button" class="nav-toggle" id="nav-toggle" aria-expanded="false" aria-controls="primary-navigation" aria-label="Toggle navigation menu">
            <span class="nav-toggle-bar"></span>
            <span class="nav-toggle-bar"></span>
            <span class="nav-toggle-bar"></span>
        </button>
        <ul class="nav-menu" id="primary-navigation">
            <li><a href="{{ url('/') }}" class="nav-home {{ request()->is('/') ? 'active' : '' }}" @if(request()->is('/')) aria-current="page" @endif>Home</a></li>
            <li><a href="{{ url('/characters') }}" class="nav-characters {{ request()->is('characters') ? 'active' : '' }}" @if(request()->is('characters')) aria-current="page" @endif>Characters</a></li>
            <li><a href="{{ url('/ships') }}" class="nav-ships {{ request()->is('ships') ? 'active' : '' }}" @if(request()->is('ships')) aria-current="page" @endif>Ships</a></li>
            <li><a href="{{ url('/map') }}" class="nav-map {{ request()->is('map') ? 'active' : '' }}" @if(request()->is('map')) aria-current="page" @endif>Map</a></li>
            <li><a href="{{ url('/missions') }}" class="nav-missions {{ request()->is('missions') ? 'active' : '' }}" @if(request()->is('missions')) aria-current="page" @endif>Missions</a></li>
            <li><a href="{{ url('/relics') }}" class="nav-relics {{ request()->is('relics') ? 'active' : '' }}" @if(request()->is('relics')) aria-current="page" @endif>Relics</a></li>
            <li><a href="{{ url('/rankings') }}" class="nav-rankings {{ request()->is('rankings') ? 'active' : '' }}" @if(request()->is('rankings')) aria-current="page" @endif>Rankings</a></li>
            <li><a href="{{ url('/tavern') }}" class="nav-tavern {{ request()->is('tavern') ? 'active' : '' }}" @if(request()->is('tavern')) aria-current="page" @endif>Tavern</a></li>
            <li><a href="{{ url('/profile') }}" class="nav-profile {{ request()->is('profile') ? 'active' : '' }}" @if(request()->is('profile')) aria-current="page" @endif>Profile</a></li>
        </ul>
        <div class="nav-auth-buttons" id="primary-auth-actions">
            <a href="{{ url('/login') }}" class="btn-auth login-btn {{ request()->is('login') ? 'active' : '' }}" style="text-decoration: none; display: inline-block;">Login</a>
            <a href="{{ url('/signup') }}" class="btn-auth signup-btn {{ request()->is('signup') ? 'active' : '' }}" style="text-decoration: none; display: inline-block;">Sign Up</a>
        </div>
    </div>
</nav>
