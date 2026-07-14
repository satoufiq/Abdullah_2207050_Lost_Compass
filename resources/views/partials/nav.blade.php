<nav @if(isset($navClass)) class="{{ $navClass }}" @endif id="main-nav">
    <div class="nav-particle-strip" aria-hidden="true"></div>

    <div class="nav-container" id="nav-container">

        {{-- ── Logo ── --}}
        <a href="{{ url('/') }}" class="nav-logo" aria-label="The Lost Compass — Home">
            <img src="{{ asset('assets/images/home/compass-rose.png') }}" alt="" class="logo-compass" aria-hidden="true">
            <span class="logo-text">
                <span class="logo-name">The Lost Compass</span>
                <span class="logo-subtitle">Chart Your Destiny</span>
            </span>
        </a>

        {{-- ── Hamburger ── --}}
        <button type="button" class="nav-toggle" id="nav-toggle"
                aria-expanded="false" aria-controls="primary-navigation" aria-label="Toggle navigation menu">
            <span class="nav-toggle-bar"></span>
            <span class="nav-toggle-bar"></span>
            <span class="nav-toggle-bar"></span>
        </button>

        {{-- ── Menu ── --}}
        <ul class="nav-menu" id="primary-navigation" role="menubar">
            <li role="none">
                <a href="{{ url('/') }}"
                   class="nav-home {{ request()->is('/') ? 'active' : '' }}"
                   @if(request()->is('/')) aria-current="page" @endif role="menuitem">
                    Home
                </a>
            </li>
            <li role="none">
                <a href="{{ url('/characters') }}"
                   class="nav-characters {{ request()->is('characters') ? 'active' : '' }}"
                   @if(request()->is('characters')) aria-current="page" @endif role="menuitem">
                    Characters
                </a>
            </li>
            <li role="none">
                <a href="{{ url('/quiz') }}"
                   class="nav-quiz {{ request()->is('quiz') ? 'active' : '' }}"
                   @if(request()->is('quiz')) aria-current="page" @endif role="menuitem">
                    Rituals
                </a>
            </li>
            <li role="none">
                <a href="{{ url('/ships') }}"
                   class="nav-ships {{ request()->is('ships') ? 'active' : '' }}"
                   @if(request()->is('ships')) aria-current="page" @endif role="menuitem">
                    Ships
                </a>
            </li>
            <li role="none">
                <a href="{{ url('/map') }}"
                   class="nav-map {{ request()->is('map') ? 'active' : '' }}"
                   @if(request()->is('map')) aria-current="page" @endif role="menuitem">
                    Map
                </a>
            </li>
            <li role="none">
                <a href="{{ url('/missions') }}"
                   class="nav-missions {{ request()->is('missions') ? 'active' : '' }}"
                   @if(request()->is('missions')) aria-current="page" @endif role="menuitem">
                    Missions
                </a>
            </li>
            <li role="none">
                <a href="{{ url('/rankings') }}"
                   class="nav-rankings {{ request()->is('rankings') ? 'active' : '' }}"
                   @if(request()->is('rankings')) aria-current="page" @endif role="menuitem">
                    Rankings
                </a>
            </li>
            <li role="none">
                <a href="{{ url('/tavern') }}"
                   class="nav-tavern {{ request()->is('tavern') ? 'active' : '' }}"
                   @if(request()->is('tavern')) aria-current="page" @endif role="menuitem">
                    Tavern
                </a>
            </li>
            <li role="none">
                <a href="{{ url('/trivia') }}"
                   class="nav-trivia {{ request()->is('trivia') ? 'active' : '' }}"
                   @if(request()->is('trivia')) aria-current="page" @endif role="menuitem">
                    Lore
                </a>
            </li>
        </ul>

        {{-- ── Auth ── --}}
        <div class="nav-auth-buttons" id="primary-auth-actions">
            @auth
                <span class="nav-pirate-name" title="{{ Auth::user()->pirateProfile?->pirate_name ?? Auth::user()->name }}">
                    ⚓ {{ Str::limit(Auth::user()->pirateProfile?->pirate_name ?? Auth::user()->name, 14) }}
                </span>
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn-auth" style="text-decoration:none;">⚙ Dashboard</a>
                @else
                    <a href="{{ route('profile') }}" class="btn-auth" style="text-decoration:none;">🧭 Profile</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display:inline;margin:0;padding:0;">
                    @csrf
                    <button type="submit" class="btn-auth" style="cursor:pointer;">Logout</button>
                </form>
            @else
                <a href="{{ url('/login') }}"
                   class="btn-auth login-btn {{ request()->is('login') ? 'active' : '' }}"
                   style="text-decoration:none;">Login</a>
                <a href="{{ url('/signup') }}"
                   class="btn-auth signup-btn {{ request()->is('signup') ? 'active' : '' }}"
                   style="text-decoration:none;">Join Crew</a>
            @endauth
        </div>

    </div><!-- /.nav-container -->
</nav>

<script>
/* ── Navbar: scroll awareness + mobile toggle ────────── */
(function () {
    var nav       = document.getElementById('main-nav');
    var toggle    = document.getElementById('nav-toggle');
    var container = document.getElementById('nav-container');
    if (!nav || !toggle || !container) return;

    /* scroll class */
    function onScroll() {
        nav.classList.toggle('scrolled', window.scrollY > 35);
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    /* toggle */
    toggle.addEventListener('click', function () {
        var isOpen = container.classList.toggle('nav-open');
        toggle.setAttribute('aria-expanded', String(isOpen));
    });

    /* close on outside click */
    document.addEventListener('click', function (e) {
        if (!container.contains(e.target)) {
            container.classList.remove('nav-open');
            toggle.setAttribute('aria-expanded', 'false');
        }
    });

    /* close on menu link click (mobile) */
    container.querySelectorAll('.nav-menu a').forEach(function (link) {
        link.addEventListener('click', function () {
            container.classList.remove('nav-open');
            toggle.setAttribute('aria-expanded', 'false');
        });
    });
}());
</script>
