@extends('layouts.app')

@section('title', 'The Lost Compass | Interactive Pirate Experience')
@section('meta_description', 'The Lost Compass - An Interactive Pirates Universe Experience')

@section('use_base_css', true)

@section('content')
    {{-- Loading Screen --}}
    @include('partials.loading', ['message' => 'Charting the Seas...'])

    {{-- Navigation --}}
    @include('partials.nav')

    {{-- Hero Section --}}
    <section class="hero" id="home">
        <video class="hero-video" autoplay muted loop playsinline>
            <source src="{{ asset('assets/videos/home/Moonlit ocean background.mp4') }}" type="video/mp4">
        </video>

        <div class="hero-overlay"></div>

        <div class="hero-content">
            @if($isLoggedIn)
                <h1 class="hero-title">The Lost Compass</h1>
                <p class="hero-subtitle">{{ $greeting }}</p>

                <div class="hero-buttons">
                    @if($continueMission)
                        <a href="{{ url('/missions') }}" class="btn btn-primary" id="continue-voyage-btn" style="text-decoration: none;">Continue Voyage: {{ $continueMission->title }}</a>
                    @endif
                    <a href="{{ $ctaLink }}" class="btn btn-primary" id="begin-voyage-btn" style="text-decoration: none;">{{ $ctaText }}</a>
                    <a href="{{ url('/profile') }}" class="btn btn-secondary" id="view-profile-btn" style="text-decoration: none;">Captain's Cabin</a>
                </div>
            @else
                <h1 class="hero-title">The Lost Compass</h1>
                <p class="hero-subtitle">{{ $greeting }}</p>

                <div class="hero-buttons">
                    <a href="{{ $ctaLink }}" class="btn btn-primary" id="begin-voyage-btn" style="text-decoration: none;">{{ $ctaText }}</a>
                    <a href="{{ url('/quiz') }}" class="btn btn-secondary" id="discover-fate-btn" style="text-decoration: none;">Explore the Seas</a>
                </div>
            @endif
        </div>
    </section>

    {{-- Welcome / Introduction Section --}}
    <section class="welcome-section" id="welcome">
        <div class="welcome-container">
            <div class="welcome-image reveal-on-scroll">
                <div class="ship-showcase">
                    <img src="{{ asset('assets/images/ships/black pearl for hero section.png') }}" alt="Black Pearl" class="ship-large">
                </div>
            </div>
            <div class="welcome-content reveal-on-scroll">
                @if($isLoggedIn)
                    <h2>Your Legend Continues</h2>
                    <p>
                        Captain {{ $pirateName }}, the seas grow restless. Your rank of <strong>{{ $pirateRank }}</strong> precedes you,
                        and whispers of your exploits echo across every port. The compass still points true — where will it lead you next?
                    </p>
                @else
                    <h2>Step Into Legend</h2>
                    <p>
                        The Lost Compass is not merely a place—it's a world where the impossible becomes reality.
                        Where cursed treasures gleam in moonlit waters, and legendary captains command the seven seas.
                    </p>
                @endif
                <ul>
                    <li>Discover ancient pirate legends</li>
                    <li>Uncover cursed treasures and relics</li>
                    <li>Meet fearless legendary captains</li>
                    <li>Navigate dangerous and magical seas</li>
                </ul>
                <div class="legend-tags">
                    <span>Ancient Relics</span>
                    <span>Cursed Waters</span>
                    <span>Legendary Duels</span>
                    <span>Secret Ports</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Features / Preview Cards Section (Dynamic from DB) --}}
    <section class="features-section" id="features-v3" style="position: relative; overflow: hidden;">
        <h2 class="section-title reveal-on-scroll">Explore Our World</h2>
        <div class="features-container-v3" style="position: relative; z-index: 2;">
            <div class="feature-card-v3 reveal-on-scroll">
                <div class="feature-image-v3">
                    <img src="{{ asset('assets/images/home/551567-1920x1080-desktop-1080p-will-turner-pirates-of-the-caribbean-background-photo.jpg') }}" alt="Meet the Captains">
                    <div class="feature-overlay-gradient"></div>
                </div>
                <div class="feature-content-v3">
                    <h3 class="feature-title-v3">Meet the Captains</h3>
                    <p class="feature-text-v3">
                        Encounter legendary pirates like Jack Sparrow, Will Turner, and many more. Each with their own story,
                        powers, and cursed connections.
                    </p>
                    <a href="{{ url('/characters') }}" class="feature-link">Explore Characters →</a>
                </div>
            </div>
            <div class="feature-card-v3 reveal-on-scroll">
                <div class="feature-image-v3">
                    <img src="{{ asset('assets/images/home/f9006df007e36bc5e6931a31ff420a9db7b1ef3da2ea876ebe9f7f26688bac76._SX1080_FMjpg_.jpg') }}" alt="Legendary Ships">
                    <div class="feature-overlay-gradient"></div>
                </div>
                <div class="feature-content-v3">
                    <h3 class="feature-title-v3">Legendary Ships</h3>
                    <p class="feature-text-v3">
                        Sail the seven seas aboard the Black Pearl, the Flying Dutchman, or Queen Anne's Revenge.
                        Each ship holds dark secrets and ancient curses.
                    </p>
                    <a href="{{ url('/ships') }}" class="feature-link">View Ships →</a>
                </div>
            </div>
            <div class="feature-card-v3 reveal-on-scroll">
                <div class="feature-image-v3">
                    <img src="{{ asset('assets/images/home/5d293ce66407ed52f19a20b8680bb319.jpg') }}" alt="Treasure Missions">
                    <div class="feature-overlay-gradient"></div>
                </div>
                <div class="feature-content-v3">
                    <h3 class="feature-title-v3">Treasure Missions</h3>
                    <p class="feature-text-v3">
                        Embark on dangerous quests. Recover cursed coins, escape the Kraken, duel rival captains,
                        and discover hidden wealth.
                    </p>
                    <a href="{{ url('/missions') }}" class="feature-link">Accept Quest →</a>
                </div>
            </div>
        </div>
    </section>

    {{-- Featured Missions Section (Dynamic from DB) --}}
    @if($featuredMissions->count() > 0)
    <section class="features-section" id="featured-missions-v3" style="position: relative; overflow: hidden; margin-top: 40px;">
        <h2 class="section-title reveal-on-scroll">Featured Missions</h2>
        <div class="features-container-v3" style="position: relative; z-index: 2;">
            @foreach($featuredMissions as $mission)
                <div class="feature-card-v3 reveal-on-scroll">
                    <div class="feature-image-v3">
                        @if($mission->image)
                            <img src="{{ asset($mission->image) }}" alt="{{ $mission->title }}">
                        @else
                            <img src="{{ asset('assets/images/home/5d293ce66407ed52f19a20b8680bb319.jpg') }}" alt="{{ $mission->title }}">
                        @endif
                        <div class="feature-overlay-gradient"></div>
                    </div>
                    <div class="feature-content-v3">
                        <h3 class="feature-title-v3">{{ $mission->title }}</h3>
                        <p class="feature-text-v3">
                            {{ $mission->description ?? 'Embark on this dangerous quest and claim your reward.' }}
                        </p>
                        <a href="{{ url('/missions') }}" class="feature-link">Accept Quest →</a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Captain's Log Highlights --}}
    <section class="voyage-highlights" id="highlights">
        <div class="highlights-inner reveal-on-scroll">
            <h2 class="section-title">Captain's Log Highlights</h2>
            <p class="highlights-intro">
                Fresh whispers from the horizon. Follow what is rising in The Lost Compass this season.
            </p>
            <div class="highlight-grid">
                <article class="highlight-card">
                    <img src="{{ asset('assets/images/home/new images/kraken hunt.jpg') }}" alt="Kraken Hunt event" class="highlight-media">
                    <span class="highlight-kicker">Live Event</span>
                    <h3>Kraken Hunt Week</h3>
                    <p>Form your crew, track the beast through storm routes, and win rare relic rewards.</p>
                </article>
                <article class="highlight-card">
                    <img src="{{ asset('assets/images/home/new images/Compass codex.jpg') }}" alt="Compass Codex lore" class="highlight-media">
                    <span class="highlight-kicker">New Lore</span>
                    <h3>The Compass Codex</h3>
                    <p>Unlocked scroll entries now reveal hidden links between cursed captains and lost islands.</p>
                </article>
                <article class="highlight-card">
                    <img src="{{ asset('assets/images/home/new images/crew showcase.jpeg') }}" alt="Crew showcase" class="highlight-media">
                    <span class="highlight-kicker">Community</span>
                    <h3>Crew Showcase</h3>
                    <p>Featured crews and fan voyages are now pinned in the tavern hall each fortnight.</p>
                </article>
            </div>

            <div class="captain-strip reveal-on-scroll">
                <article class="captain-chip">
                    <img src="{{ asset('assets/images/home/new images/jack sparrow.jpg') }}" alt="Captain Jack Sparrow" class="captain-chip-image">
                    <div class="captain-chip-copy">
                        <h4>Jack Sparrow</h4>
                        <p>Master of misdirection and impossible escapes.</p>
                    </div>
                </article>
                <article class="captain-chip">
                    <img src="{{ asset('assets/images/home/new images/barbosa.jpg') }}" alt="Captain Barbossa" class="captain-chip-image">
                    <div class="captain-chip-copy">
                        <h4>Barbossa</h4>
                        <p>Cunning strategist with an eye on every horizon.</p>
                    </div>
                </article>
                <article class="captain-chip">
                    <img src="{{ asset('assets/images/home/new images/salazar.jpeg') }}" alt="Captain Salazar" class="captain-chip-image">
                    <div class="captain-chip-copy">
                        <h4>Salazar</h4>
                        <p>Relentless hunter haunting the Devil's Triangle.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    {{-- Quote Section (Dynamic from DB) --}}
    <section class="quote-section-v3" id="quote-v3" style="position: relative; overflow: hidden;">
        <img
            src="{{ asset('assets/images/home/Moonlit ocean background.png') }}"
            alt=""
            aria-hidden="true"
            style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; opacity:0.42; z-index:0; pointer-events:none;"
        >
        <div
            id="quote-bg-v3"
            style="position:absolute; inset:0; background-size:cover; background-position:center; background-attachment:fixed; opacity:0.45; z-index:1; pointer-events:none; transition: background-image 0.8s cubic-bezier(0.4, 0, 0.2, 1);">
        </div>
        <div style="position:absolute; inset:0; background:linear-gradient(135deg, rgba(8,20,35,0.62) 0%, rgba(11,31,51,0.75) 100%); z-index:1; pointer-events:none;"></div>
        <div class="quote-container-v3" style="position: relative; z-index: 2;">
            @if($allQuotes->count() > 0)
                @foreach($allQuotes as $index => $q)
                    <div class="quote-item-v3 {{ $index === 0 ? 'active' : '' }}" data-character="{{ $q->speaker }}">
                        <p class="quote-text-v3">"{{ $q->quote }}"</p>
                        <p class="quote-author-v3">— {{ $q->speaker }}</p>
                    </div>
                @endforeach
            @else
                {{-- Fallback static quotes --}}
                <div class="quote-item-v3 active" data-character="Jack Sparrow">
                    <p class="quote-text-v3">"Not all treasure is silver and gold, mate."</p>
                    <p class="quote-author-v3">— Captain Jack Sparrow</p>
                </div>
                <div class="quote-item-v3" data-character="Davy Jones">
                    <p class="quote-text-v3">"Do you fear death? Do you fear that dark abyss?"</p>
                    <p class="quote-author-v3">— Davy Jones</p>
                </div>
                <div class="quote-item-v3" data-character="Barbossa">
                    <p class="quote-text-v3">"The problem is not the problem. The problem is your attitude about the problem."</p>
                    <p class="quote-author-v3">— Captain Barbossa</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Footer --}}
    @include('partials.footer-main')

    <!-- Ambient Ocean Waves (Looping) -->
    <!-- Audio files not provided -->

    {{-- Custom Cursor --}}
    <div class="cursor" id="cursor"></div>
    <div class="cursor-dot" id="cursor-dot"></div>
@endsection

@section('use_base_js', true)

@section('scripts')
@endsection
