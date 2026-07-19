@extends('layouts.app')

@section('title', 'The Drunken Kraken Tavern | The Lost Compass')
@section('meta_description', 'The Drunken Kraken Tavern - The social heart of the pirate world')
@section('body_class', 'tavern-page')

@section('use_base_css', true)

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/tavern.css?v=' . time()) }}">
@endsection

@section('content')
    {{-- Loading Screen --}}
    @include('partials.loading', ['message' => 'Gathering the crew...'])

    {{-- Navigation --}}
    @include('partials.nav')

    {{-- Tavern Atmosphere Layer --}}
    <div class="tavern-smoke" id="tavern-smoke" style="background-image: url('{{ asset('assets/images/tavern/effects/smoke-texture.png') }}');"></div>
    <div class="tavern-glow" id="tavern-glow" style="background-image: url('{{ asset('assets/images/tavern/effects/fire-glow.png') }}');"></div>

    {{-- Hero Tavern Section --}}
    <section class="tavern-hero" id="tavern-hero">
        <div class="tavern-hero-bg">
            <img src="{{ asset('assets/images/tavern/backgrounds/tavern-interior.jpg') }}" alt="Tavern interior" class="tavern-interior-img">
            <div class="tavern-hero-overlay"></div>
        </div>

        <div class="tavern-hero-content">
            <div class="tavern-decorations">
                <img src="{{ asset('assets/images/tavern/decorative/lantern-01.png') }}" alt="Lantern" class="lantern lantern-left">
                <img src="{{ asset('assets/images/tavern/decorative/lantern-02.png') }}" alt="Lantern" class="lantern lantern-right">
            </div>

            <h1 class="tavern-title">The Drunken Kraken Tavern</h1>
            <p class="tavern-subtitle">Every pirate has a story to tell.</p>

            <div class="tavern-buttons">
                <button class="btn btn-tavern" id="btn-buy-rum">🍺 Buy Rum</button>
                <button class="btn btn-tavern" id="btn-tell-story">📖 Tell Story</button>
                <button class="btn btn-tavern" id="btn-hear-rumor">👂 Hear Rumor</button>
                <button class="btn btn-tavern" id="btn-recruit-crew">⚓ Recruit Crew</button>
            </div>
        </div>

    </section>

    {{-- Rumor Board Section --}}
    <section class="rumor-board-section" id="rumor-section">
        <div class="rumor-board-container">
            <h2 class="section-title">⚓ Rumor Board</h2>
            <p class="section-subtitle">Whispers from the seven seas...</p>

            <div class="rumor-board" id="rumor-board-container" style="background-image: url('{{ asset('assets/images/tavern/backgrounds/tavern-wood-texture.jpg') }}');">
                <!-- Rumors will be injected here via JS -->
            </div>
        </div>
    </section>

    {{-- Discussion Feed Section --}}
    <section class="discussion-section" id="discussion-section">
        <div class="discussion-container">
            <h2 class="section-title">⚔️ Pirate Discussions</h2>
            <p class="section-subtitle">Join the conversation...</p>

            <div class="quick-post-box reveal-on-scroll">
                @auth
                    <img src="{{ auth()->user()->avatar_url ?? asset('assets/images/profile/avatars/avatar-captain-fearless.png') }}" alt="Your Avatar" class="quick-post-avatar">
                @else
                    <img src="{{ asset('assets/images/profile/avatars/avatar-captain-fearless.png') }}" alt="Guest Avatar" class="quick-post-avatar">
                @endauth
                <input type="text" id="quick-discussion-title" placeholder="Title your tale..." class="tavern-input-inline">
                <input type="text" id="quick-discussion-input" placeholder="What tale do you have for the tavern, Captain?" class="tavern-input-inline">
                <button class="btn btn-primary btn-quick-post" id="btn-quick-post">Post</button>
            </div>

            <div class="discussions-feed" id="discussions-feed">
                <!-- Discussions will be injected here via JS -->
            </div>
        </div>
    </section>

    {{-- Notice Board Section --}}
    <section class="notice-board-section" id="notice-section">
        <div class="notice-board-container">
            <h2 class="section-title">📜 Wanted Notices</h2>

            <div class="notices-grid" id="notices-container">
                <!-- Wanted notices will be injected here via JS -->
            </div>
        </div>
    </section>

   

    {{-- Tavern Interactions Modals --}}
    <div id="buy-rum-modal" class="modal">
        <div class="modal-content tavern-modal">
            <button class="modal-close">&times;</button>
            <h2>🍺 Raise Your Glass</h2>
            <p>Choose your drink and toast to adventure!</p>
            <div class="rum-selection">
                @php
                $drinks = [
                    ['name' => 'Caribbean Rum', 'price' => '50 Gold', 'desc' => 'A smooth, warming drink to ease the soul.'],
                    ['name' => 'Cursed Whiskey', 'price' => '100 Gold', 'desc' => 'Strong enough to make a pirate forget his sorrows... and sanity.'],
                    ['name' => 'Legendary Brandy', 'price' => '200 Gold', 'desc' => 'Aged in cursed barrels. Only for the brave.'],
                ];
                @endphp
                @foreach($drinks as $drink)
                <div class="rum-card" style="background-image: url('{{ asset('assets/images/tavern/backgrounds/tavern-wood-texture.jpg') }}');">
                    <h4>{{ $drink['name'] }}</h4>
                    <p class="rum-price">💰 {{ $drink['price'] }}</p>
                    <p class="rum-desc">{{ $drink['desc'] }}</p>
                    <button class="btn btn-drink">Order</button>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="tell-story-modal" class="modal">
        <div class="modal-content tavern-modal">
            <button class="modal-close">&times;</button>
            <h2>📖 Tell Your Tale</h2>
            <p>Share your pirate story with the tavern...</p>
            <form id="story-form" class="story-form">
                <input type="text" id="story-title" placeholder="Give your story a title..." maxlength="100" required>
                <textarea id="story-content" placeholder="Your tale awaits..." maxlength="500" rows="6" required></textarea>
                <div class="story-footer">
                    <span id="char-count">0/500</span>
                    <button type="submit" class="btn btn-primary">Post Story</button>
                </div>
            </form>
        </div>
    </div>

    <div id="hear-rumor-modal" class="modal">
        <div class="modal-content tavern-modal">
            <button class="modal-close">&times;</button>
            <h2>👂 What's the Latest?</h2>
            <div id="rumor-display" class="rumor-display">
                <p id="rumor-text" class="rumor-large-text"></p>
                <p id="rumor-source" class="rumor-source-large"></p>
            </div>
            <button id="next-rumor-btn" class="btn btn-secondary">Tell me another...</button>
        </div>
    </div>

    <div id="recruit-crew-modal" class="modal">
        <div class="modal-content tavern-modal">
            <button class="modal-close">&times;</button>
            <h2>⚓ Build Your Crew</h2>
            <p>Select your crew members for the journey ahead...</p>
            <div class="crew-selection">
                @php
                $crew = [
                    ['name' => 'Navigator', 'desc' => 'Expert in charts and compass. Essential for any voyage.'],
                    ['name' => 'Swordmaster', 'desc' => 'Fierce fighter. Will defend your crew with steel and courage.'],
                    ['name' => 'Treasure Hunter', 'desc' => 'Nose for gold. Better at finding cursed treasure.'],
                    ['name' => 'Ship Engineer', 'desc' => 'Keeps your vessel running. Will fix damages on the fly.'],
                    ['name' => 'Curse Breaker', 'desc' => 'Mystical knowledge. Can break curses and dispel hexes.'],
                    ['name' => 'Merchant', 'desc' => 'Negotiator. Gets better deals in trading ports.'],
                ];
                @endphp
                @foreach($crew as $member)
                <label class="crew-card">
                    <input type="checkbox">
                    <h4>{{ $member['name'] }}</h4>
                    <p>{{ $member['desc'] }}</p>
                </label>
                @endforeach
            </div>
            <button id="assemble-crew-btn" class="btn btn-primary">Assemble Crew</button>
        </div>
    </div>

    {{-- Footer --}}
    @include('partials.footer-main', ['showTavern' => true])

    {{-- Custom Cursor --}}
    <div class="cursor" id="cursor"></div>
    <div class="cursor-dot" id="cursor-dot"></div>
@endsection

@section('use_base_js', true)

@section('scripts')
    <script src="{{ asset('js/tavern.js?v=' . time()) }}"></script>
@endsection
