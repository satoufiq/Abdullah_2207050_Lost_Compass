@extends('layouts.app')

@section('title', 'Missions | The Lost Compass')
@section('meta_description', 'The Lost Compass missions - choose your voyage, make choices, and earn pirate rewards.')
@section('body_class', 'missions-page')
@section('body_attributes', 'data-mood="neutral"')

@section('use_base_css', true)

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/missions.css?v=2') }}">
@endsection

@section('content')
    @include('partials.nav', ['navClass' => 'ms-nav'])

    <main class="ms-container">
        
        {{-- Hero Header --}}
        <header class="ms-hero">
            <h4 class="ms-hero__kicker">Captain's Orders</h4>
            <h1 class="ms-hero__title">Your Next Voyage</h1>
            <p class="ms-hero__subtitle">Every choice changes the tide. The sea awaits.</p>
        </header>

        {{-- Mission Selection Board --}}
        <section class="ms-board" aria-labelledby="board-title">
            <div class="ms-board__header">
                <h2 id="board-title" class="ms-board__title">Available Expeditions</h2>
            </div>
            
            <div class="ms-cards" id="mission-cards">
                {{-- JS injects mission cards here --}}
            </div>
        </section>

        {{-- Mission Engine (Gameplay) --}}
        <section class="ms-engine" id="mission-experience" aria-live="polite">
            <div class="ms-engine__inner">
                
                {{-- Progress Header --}}
                <div class="ms-progress">
                    <div class="ms-progress__meta">
                        <span id="active-mission-name" class="ms-progress__title">No voyage selected</span>
                        <span id="progress-label" class="ms-progress__step">Step 0 of 0</span>
                    </div>
                    <div class="ms-progress__bar">
                        <div class="ms-progress__fill" id="progress-fill"></div>
                    </div>
                </div>

                <div class="ms-grid">
                    {{-- Scene Display --}}
                    <div class="ms-scene">
                        <figure class="ms-scene__figure">
                            <img id="story-image" src="{{ asset('assets/images/map/map_background.jpg') }}" alt="Mission scene" class="ms-scene__img">
                            <div class="ms-scene__overlay"></div>
                        </figure>
                        <div class="ms-scene__content">
                            <h3 id="story-title" class="ms-scene__title">Choose a mission to begin</h3>
                            <p id="story-text" class="ms-scene__text">Select one of the expeditions above to unlock branching choices, consequences, and legendary loot.</p>
                        </div>
                    </div>

                    {{-- Sidebar (Choices & Results) --}}
                    <div class="ms-sidebar">
                        <div class="ms-choices-panel">
                            <h4 class="ms-panel-title">Your Orders</h4>
                            <div class="ms-choices" id="choice-buttons">
                                <button class="ms-btn ms-btn--choice ms-btn--disabled" disabled>Awaiting mission...</button>
                            </div>
                        </div>

                        <div class="ms-result-panel" id="result-panel">
                            <h4 class="ms-panel-title">Consequence</h4>
                            <p id="result-text" class="ms-result__text">Your decisions shape the narrative.</p>
                            <p id="impact-text" class="ms-result__impact"></p>
                        </div>

                        <div class="ms-reward-panel" id="reward-panel">
                            <h4 class="ms-panel-title">Loot Secured</h4>
                            <ul id="reward-list" class="ms-reward-list"></ul>
                            <div class="ms-actions" id="completion-actions"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Mission Log (History) --}}
        <section class="ms-log-section" aria-labelledby="log-title">
            <h2 id="log-title" class="ms-board__title">Captain's Log</h2>
            <div class="ms-log">
                <ul id="history-list" class="ms-log__list">
                    {{-- JS injects history --}}
                </ul>
            </div>
        </section>
    </main>

    {{-- Cinematic Loot Overlay (Hidden by default) --}}
    <div class="ms-loot-modal" id="loot-modal" aria-hidden="true">
        <div class="ms-loot-modal__backdrop"></div>
        <div class="ms-loot-modal__content">
            <h2 class="ms-loot-modal__title">Loot Acquired</h2>
            <div class="ms-loot-modal__items" id="loot-items">
                {{-- JS injects granted items here (Gold, Relics, Achievements) --}}
            </div>
            <button class="ms-btn ms-btn--primary ms-loot-modal__close" id="close-loot-modal">Return to Map</button>
        </div>
    </div>

    @include('partials.footer-simple', ['footerClass' => 'ms-footer'])
@endsection

@section('use_base_js', true)

@section('scripts')
    <script src="{{ asset('js/missions.js?v=7') }}"></script>
@endsection
