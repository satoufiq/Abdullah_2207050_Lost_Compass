@extends('layouts.app')

@section('title', 'Legends of the Seven Seas | The Lost Compass')
@section('meta_description', 'Legendary pirate archive of the Pirates of the Caribbean universe.')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/characters.css') }}">
@endsection

@section('content')
    @include('partials.loading', ['message' => 'Opening the Pirate Archive...'])

    <div class="archive-overlay" aria-hidden="true"></div>

    @include('partials.nav')

    <main>
        <section class="hero-title-block">
            <p class="kicker">Captain's Secret Record Book</p>
            <h1>Legends of the Seven Seas</h1>
            <p class="subtitle">Every pirate leaves a mark upon the ocean.</p>
            <p class="intro-line">Wander the archive. Follow alliances, betrayals, and immortal rivalries carved into salt and smoke.</p>
        </section>

        <section class="control-panel" aria-label="Character search and category filters">
            <div class="search-wrap">
                <label for="character-search" class="sr-only">Search for a pirate</label>
                <input id="character-search" type="search" placeholder="Search a pirate..." autocomplete="off">
            </div>
            <div class="filter-tabs" role="toolbar" aria-label="Character categories">
                <button type="button" class="filter-btn is-active" data-filter="all" aria-pressed="true">All Legends</button>
                <button type="button" class="filter-btn" data-filter="captains" aria-pressed="false">Captains</button>
                <button type="button" class="filter-btn" data-filter="allies" aria-pressed="false">Allies</button>
                <button type="button" class="filter-btn" data-filter="villains" aria-pressed="false">Villains</button>
                <button type="button" class="filter-btn" data-filter="legends" aria-pressed="false">Legends</button>
            </div>
            <p class="results-text" id="results-text">Showing 6 legendary records</p>
        </section>

        <section class="character-gallery" aria-label="Character gallery">
            <div class="decor-rope" aria-hidden="true"></div>
            <div class="decor-compass" aria-hidden="true">
                <img src="{{ asset('assets/images/home/compass-rose.png') }}" alt="">
            </div>
            <div class="decor-map-corner" aria-hidden="true"></div>

            <div class="character-grid" id="character-grid"></div>
        </section>
    </main>

    <section class="character-modal" id="character-modal" hidden>
        <div class="modal-backdrop" id="modal-backdrop"></div>
        <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="modal-name">
            <button class="modal-close" id="modal-close" type="button" aria-label="Close character details">&times;</button>

            <div class="modal-media">
                <img id="modal-image" src="" alt="">
            </div>

            <div class="modal-content">
                <p class="modal-record">Legendary Dossier</p>
                <h2 id="modal-name"></h2>
                <p class="modal-role" id="modal-role"></p>
                <p class="modal-quote" id="modal-quote"></p>
                <p class="modal-bio" id="modal-bio"></p>

                <div class="detail-grid">
                    <div class="detail-item"><span class="label">Ship</span><span id="modal-ship"></span></div>
                    <div class="detail-item"><span class="label">Weapon</span><span id="modal-weapon"></span></div>
                    <div class="detail-item"><span class="label">First Appearance</span><span id="modal-appearance"></span></div>
                    <div class="detail-item"><span class="label">Category</span><span id="modal-category"></span></div>
                </div>

                <div class="relationship-block">
                    <div>
                        <h3>Allies</h3>
                        <div id="modal-allies" class="chip-list"></div>
                    </div>
                    <div>
                        <h3>Enemies</h3>
                        <div id="modal-enemies" class="chip-list"></div>
                    </div>
                </div>
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
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/characters') }}">Characters</a></li>
                <li><a href="{{ url('/quiz') }}">Compass of Fate</a></li>
            </ul>
            <p class="copyright">&copy; <span id="footer-year"></span> The Lost Compass. All rights reserved.</p>
        </div>
    </footer>
@endsection

@section('scripts')
    <script src="{{ asset('js/characters.js') }}"></script>
@endsection
