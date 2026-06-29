@extends('layouts.app')

@section('title', 'Legendary Ships | The Lost Compass')
@section('meta_description', 'Legendary ships archive of the Pirates of the Caribbean universe.')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/ships.css') }}">
@endsection

@section('content')
    @include('partials.loading', ['message' => 'Entering the Hall of Ships...'])

    <div class="storm-overlay" aria-hidden="true"></div>
    <div class="storm-fog storm-fog-left" aria-hidden="true"></div>
    <div class="storm-fog storm-fog-right" aria-hidden="true"></div>
    <div class="lightning-flash" id="lightning-flash" aria-hidden="true"></div>
    <div class="side-decor side-decor-left" aria-hidden="true">
        <img src="{{ asset('assets/images/ships/broken sail.png') }}" alt="" class="side-decor-image side-broken-sail">
    </div>
    <div class="side-decor side-decor-right" aria-hidden="true">
        <img src="{{ asset('assets/images/ships/broken sail.png') }}" alt="" class="side-decor-image side-broken-sail side-broken-sail-right">
    </div>

    @include('partials.nav')

    <main>
        <section class="hero-ships">
            <video class="hero-sea-video" autoplay muted loop playsinline>
                <source src="{{ asset('assets/videos/home/Moonlit ocean background.mp4') }}" type="video/mp4">
            </video>
            <div class="hero-lightning-texture" aria-hidden="true"></div>
            <div class="hero-gradient"></div>
            <img src="{{ asset('assets/images/ships/black pearl for hero section.png') }}" alt="Black Pearl silhouette" class="hero-ship-silhouette">

            <div class="hero-content">
                <p class="hero-kicker">Naval Museum of Cursed Legends</p>
                <h1>Legends of the Seven Seas</h1>
                <p class="hero-subtitle">Every ship carries a curse... or a legend.</p>
            </div>
        </section>

        <section class="ships-toolbar" aria-label="Ship filters and sorting">
            <div class="filter-row" role="toolbar" aria-label="Ship category filters">
                <button type="button" class="filter-btn is-active" data-filter="all" aria-pressed="true">Legendary Ships</button>
                <button type="button" class="filter-btn" data-filter="cursed" aria-pressed="false">Cursed Ships</button>
                <button type="button" class="filter-btn" data-filter="navy" aria-pressed="false">Navy Ships</button>
                <button type="button" class="filter-btn" data-filter="ghost" aria-pressed="false">Ghost Ships</button>
            </div>

            <div class="sort-row">
                <label for="ship-sort">Sort by</label>
                <select id="ship-sort">
                    <option value="legend">Legend Rank</option>
                    <option value="speed">Speed</option>
                    <option value="attack">Attack</option>
                    <option value="defense">Defense</option>
                    <option value="curse">Curse Level</option>
                </select>
            </div>

            <p class="result-text" id="ship-result-text">Showing 6 legendary vessels</p>
        </section>

        <section class="ships-grid-section" aria-label="Legendary ships gallery">
            <div class="ships-grid" id="ships-grid"></div>
        </section>


    </main>

    <section class="ship-modal" id="ship-modal" hidden>
        <div class="modal-backdrop" id="modal-backdrop"></div>
        <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="ship-modal-name">
            <button class="modal-close" id="modal-close" type="button" aria-label="Close ship details">&times;</button>

            <div class="modal-water-particles" id="modal-water-particles" aria-hidden="true"></div>

            <div class="modal-media">
                <img id="ship-modal-image" src="" alt="">
            </div>

            <div class="modal-content">
                <p class="modal-kicker">Legendary Naval Record</p>
                <h2 id="ship-modal-name"></h2>
                <p class="modal-captain" id="ship-modal-captain"></p>
                <p class="modal-history" id="ship-modal-history"></p>

                <div class="modal-detail-grid">
                    <div class="detail-item"><span class="label">Type</span><span id="ship-modal-type"></span></div>
                    <div class="detail-item"><span class="label">Weapons</span><span id="ship-modal-weapons"></span></div>
                    <div class="detail-item"><span class="label">Curse</span><span id="ship-modal-curse"></span></div>
                    <div class="detail-item"><span class="label">Fate</span><span id="ship-modal-fate"></span></div>
                </div>

                <div class="stats-block" id="ship-modal-stats"></div>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-brand">
                <img src="{{ asset('assets/images/home/compass-rose.png') }}" alt="The Lost Compass">
                <p>The Lost Compass</p>
            </div>
            <ul class="footer-links">
                <li><a href="{{ url('/ships') }}">Ships</a></li>
                <li><a href="{{ url('/missions') }}">Missions</a></li>
                <li><a href="{{ url('/map') }}">Map</a></li>
            </ul>
            <p class="copyright">&copy; <span id="footer-year"></span> The Lost Compass. All rights reserved.</p>
        </div>
    </footer>
@endsection

@section('scripts')
    <script src="{{ asset('js/ships.js') }}"></script>
@endsection
