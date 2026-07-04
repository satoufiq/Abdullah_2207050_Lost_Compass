@extends('layouts.app')

@section('title', 'The Compass of Fate | The Lost Compass')
@section('meta_description', 'The Compass of Fate - Discover your pirate identity.')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/quiz.css') }}">
@endsection

@section('content')
    @include('partials.loading', ['message' => 'Charting the Fate...'])

    <div class="quiz-bg-layer"></div>
    <div class="fog fog-left"></div>
    <div class="fog fog-right"></div>

    @include('partials.nav')

    <main class="quiz-main" id="quiz-main">
        <section class="title-block reveal">
            <p class="ritual-kicker">Destiny Rituals</p>
            <h1>The Compass of Fate</h1>
            <p class="subtitle">Choose your trial. The sea remembers.</p>
            
            <div class="quiz-nav" style="margin-top: 1.5rem; display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                @if(!auth()->check())
                    <button type="button" class="ritual-btn" style="padding: 0.6rem 1.2rem; font-size: 0.85rem;" onclick="startQuiz('identity')">Identity Ritual</button>
                    <button type="button" class="ritual-btn locked" style="padding: 0.6rem 1.2rem; font-size: 0.85rem;" disabled title="Sign up first">Ship Ritual (Locked)</button>
                    <button type="button" class="ritual-btn locked" style="padding: 0.6rem 1.2rem; font-size: 0.85rem;" disabled title="Sign up first">Weapon Ritual (Locked)</button>
                @else
                    @if(auth()->user()->identity_character || auth()->user()->role)
                        <button type="button" class="ritual-btn locked" style="padding: 0.6rem 1.2rem; font-size: 0.85rem;" disabled title="Already completed">Identity Ritual (Completed)</button>
                    @else
                        <button type="button" class="ritual-btn" style="padding: 0.6rem 1.2rem; font-size: 0.85rem;" onclick="startQuiz('identity')">Identity Ritual</button>
                    @endif
                    
                    @if(auth()->user()->ship)
                        <button type="button" class="ritual-btn locked" style="padding: 0.6rem 1.2rem; font-size: 0.85rem;" disabled title="Already completed">Ship Ritual (Completed)</button>
                    @else
                        <button type="button" class="ritual-btn" style="padding: 0.6rem 1.2rem; font-size: 0.85rem;" onclick="startQuiz('ship')">Ship Ritual</button>
                    @endif
                    
                    @if(auth()->user()->weapon)
                        <button type="button" class="ritual-btn locked" style="padding: 0.6rem 1.2rem; font-size: 0.85rem;" disabled title="Already completed">Weapon Ritual (Completed)</button>
                    @else
                        <button type="button" class="ritual-btn" style="padding: 0.6rem 1.2rem; font-size: 0.85rem;" onclick="startQuiz('weapon')">Weapon Ritual</button>
                    @endif
                @endif
            </div>
        </section>

        <div id="identity-section">


        <section class="compass-stage reveal" aria-live="polite">
            <div class="lantern-glow"></div>
            <img src="{{ asset('assets/images/home/compass-rose.png') }}" alt="Ancient Compass" class="fate-compass" id="fate-compass">
            <div class="compass-halo"></div>
        </section>

        <section class="quiz-card-wrap reveal" id="quiz-card-wrap">
            <div class="question-candle-col" aria-hidden="true">
                <img src="{{ asset('assets/images/quiz/candle-removebg-preview.png') }}" alt="Ritual candle" class="question-candle">
            </div>
            <article class="question-card" id="question-card">
                <div class="question-meta">
                    <span id="question-count">Question 1 of 10</span>
                </div>
                <h2 id="question-text">When danger approaches, what do you trust most?</h2>

                <div class="answers-grid" id="answers-grid">
                    <button class="answer-btn" type="button">My instincts</button>
                    <button class="answer-btn" type="button">My sword</button>
                    <button class="answer-btn" type="button">My crew</button>
                    <button class="answer-btn" type="button">My luck</button>
                </div>

                <div class="progress-block">
                    <div class="progress-label-row">
                        <span>Voyage Progress</span>
                        <span id="progress-percent">0%</span>
                    </div>
                    <div class="progress-rail" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" aria-label="Quiz progress">
                        <div class="progress-fill" id="progress-fill"></div>
                    </div>
                </div>
            </article>
        </section>

        <section class="result-wrap" id="result-wrap" hidden>
            <div class="result-candle-col" aria-hidden="true">
                <img src="{{ asset('assets/images/quiz/candle-removebg-preview.png') }}" alt="Ritual candle" class="result-candle">
            </div>
            <article class="result-card" id="result-card">
                <img src="{{ asset('assets/images/quiz/wax_seal-removebg-preview.png') }}" alt="Wax seal" class="seal-image">
                <img src="" alt="Your Avatar" class="result-avatar-img" id="result-avatar-img" style="display: none; width: 100px; height: 100px; border-radius: 50%; border: 2px solid #C9A44C; margin: 0 auto 10px auto; object-fit: cover;">
                <p class="reveal-kicker">You are...</p>
                <div class="result-head">
                    <h2 id="result-title">CAPTAIN OF THE SHADOW TIDE</h2>
                </div>

                <div class="result-grid">
                    <div class="result-item">
                        <span class="label">Pirate Name</span>
                        <input class="result-name-input" id="result-name-input" type="text" value="Shahriar Stormcaller" maxlength="40" spellcheck="false" aria-label="Pirate Name">
                    </div>
                    <div class="result-item">
                        <span class="label">Role</span>
                        <span class="value" id="result-role">Navigator</span>
                    </div>
                    <div class="result-item">
                        <span class="label">Relic</span>
                        <span class="value" id="result-relic">Cursed Compass</span>
                    </div>
                    <div class="result-item">
                        <span class="label">Allegiance</span>
                        <span class="value" id="result-allegiance">Free Captain</span>
                    </div>

                    <div class="result-item">
                        <span class="label">Core Trait</span>
                        <span class="value" id="result-trait">Fearless</span>
                    </div>
                </div>

                <div class="result-actions">
                    <button type="button" class="ritual-btn" id="save-identity-btn">Save Identity</button>
                    <button type="button" class="ritual-btn" id="view-profile-btn">View Profile</button>
                    <button type="button" class="ritual-btn primary" id="start-mission-btn">Start First Mission</button>
                </div>
            </article>
        </section>
        </div>

        <!-- Removed manual ship and weapon sections as they are now interactive quizzes -->
    </main>

    <div class="embers" aria-hidden="true">
        <span></span><span></span><span></span><span></span><span></span><span></span>
    </div>

    <div class="toast" id="toast" role="status" aria-live="polite"></div>
@endsection

@section('scripts')
    <script>
        window.dbQuizData = {
            identity: @json($identityData),
            ship: @json($shipData),
            weapon: @json($weaponData)
        };
    </script>
    <script src="{{ asset('js/quiz.js') }}"></script>
@endsection
