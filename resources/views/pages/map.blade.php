@extends('layouts.app')

@section('title', 'Chart the Seven Seas | The Lost Compass')
@section('meta_description', 'Chart the Seven Seas - Interactive World Map')
@section('body_class', 'map-page')

@section('use_base_css', true)

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/map.css') }}">
@endsection

@section('content')
    <div class="page-loader" id="page-loader" aria-hidden="true">
        <div class="page-loader-content">
            <img src="{{ asset('assets/images/home/compass-rose.png') }}" alt="Loading" class="page-loader-compass">
            <span class="page-loader-text">Charting the seas...</span>
        </div>
    </div>

    @include('partials.nav', ['navClass' => 'map-nav'])

    {{-- Page Background --}}
    <div class="map-background">
        <div class="parchment-overlay"></div>
        <div class="ink-markings"></div>
        <div class="torn-edges"></div>
    </div>

    {{-- Page Title --}}
    <section class="map-title-section">
        <div class="title-container">
            <h1 class="page-title">Chart the Seven Seas</h1>
            <p class="page-subtitle">Every island hides a story.</p>
            <div class="title-divider"></div>
        </div>
    </section>

    {{-- Search and Controls --}}
    <section class="map-controls">
        <div class="controls-container">
            <div class="search-wrapper">
                <input type="text" id="location-search" class="location-search" placeholder="Search locations..." aria-label="Search locations">
                <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
            </div>
            <button class="reset-map-btn" id="reset-map-btn">Reset View</button>
        </div>
    </section>

    {{-- Interactive Map --}}
    <section class="map-container">
        <div class="map-wrapper">
            <div class="map-canvas" id="map-canvas">
                <svg class="route-overlay" id="route-overlay" viewBox="0 0 1200 800" preserveAspectRatio="xMidYMid slice"></svg>
                <div class="markers-container" id="markers-container"></div>

                <div class="animated-ship" id="animated-ship">
                    <svg viewBox="0 0 48 32" width="48" height="32">
                        <path d="M8 16h32M16 12v8M24 10v12M32 12v8" stroke="#C9A44C" stroke-width="2" fill="none" stroke-linecap="round"/>
                        <polygon points="24,8 28,16 20,16" fill="#C9A44C" opacity="0.8"/>
                    </svg>
                </div>

                <div class="mini-compass" id="mini-compass">
                    <div class="compass-rose">
                        <img src="{{ asset('assets/images/map/ancient-compass-rose-stockcake.jpg') }}" alt="Compass rose" class="compass-rose-image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Location Detail Popup --}}
    <div class="location-popup" id="location-popup">
        <button class="popup-close" id="popup-close" aria-label="Close popup">×</button>
        <div class="popup-content">
            <div class="popup-image-container">
                <img id="popup-image" src="" alt="Location" class="popup-image">
                <div class="popup-image-overlay"></div>
            </div>
            <div class="popup-details">
                <h2 id="popup-title" class="popup-title">Location Name</h2>
                <div class="popup-section">
                    <h3 class="popup-section-title">About</h3>
                    <p id="popup-description" class="popup-description"></p>
                </div>
                <div class="popup-info-grid">
                    <div class="popup-info-item">
                        <span class="info-label">Type:</span>
                        <span id="popup-type" class="info-value"></span>
                    </div>
                    <div class="popup-info-item">
                        <span class="info-label">Danger Level:</span>
                        <span id="popup-danger" class="info-value"></span>
                    </div>
                </div>
                <div class="popup-section">
                    <h3 class="popup-section-title">Available Missions</h3>
                    <div id="popup-missions" class="popup-missions"></div>
                </div>
                <div class="popup-section">
                    <h3 class="popup-section-title">Notable Characters</h3>
                    <div id="popup-characters" class="popup-characters"></div>
                </div>
                <button class="travel-button" id="travel-button">Set Sail →</button>
            </div>
        </div>
    </div>

    {{-- Location Tooltip --}}
    <div class="location-tooltip" id="location-tooltip">
        <p id="tooltip-text"></p>
    </div>

    {{-- Footer --}}
    @include('partials.footer-simple', ['footerClass' => 'map-footer'])
@endsection

@section('use_base_js', true)

@section('scripts')
    <script src="{{ asset('js/map.js?v=3') }}"></script>
@endsection
