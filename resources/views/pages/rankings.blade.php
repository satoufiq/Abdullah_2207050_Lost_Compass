@extends('layouts.app')

@section('title', 'Hall of Legends | The Lost Compass')
@section('meta_description', 'Hall of Legends - Global rankings and legendary archives of the pirate world.')
@section('body_class', 'rankings-page')

@section('use_base_css', true)

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/rankings.css') }}">
@endsection

@section('content')
    {{-- Loading Screen --}}
    @include('partials.loading', ['message' => 'Opening the Hall of Legends...'])

    {{-- Animated background --}}
    <div class="hall-background" aria-hidden="true">
        <div class="hall-particles" id="hall-particles"></div>
        <div class="hall-glow hall-glow-gold"></div>
        <div class="hall-glow hall-glow-red"></div>
        <div class="hall-mist" id="hall-mist"></div>
        <div class="hall-overlay-texture"></div>
    </div>

    {{-- Navigation --}}
    @include('partials.nav')

    <main id="main-content">
        {{-- Hero Entrance Section --}}
        <section class="hall-hero">
            <div class="hero-doors-glow"></div>
            <div class="hall-hero-content">
                <h1 class="hall-title">Hall of Legends</h1>
                <p class="hall-subtitle">"Only the greatest pirates are remembered. Only the boldest sail forever."</p>
                <div class="gold-swords-divider" aria-hidden="true">⚔️</div>
            </div>
        </section>

        {{-- User Rank Spotlight --}}
        <section class="user-spotlight-section">
            <div class="spotlight-container">
                <div class="spotlight-card">
                    <div class="spotlight-header">
                        <div class="spotlight-badge">
                            <span class="badge-icon">🎖️</span>
                            <div class="badge-info">
                                <span class="badge-label">Your Current Rank</span>
                                <span class="badge-value" id="user-rank-badge">Rank #--</span>
                            </div>
                        </div>
                        <div class="spotlight-title-box">
                            <h3 id="user-display-name">{{ auth()->check() && auth()->user()->pirate_name ? auth()->user()->pirate_name : 'Unknown Captain' }}</h3>
                            <p id="user-standing-text">Sailing under the {{ auth()->check() && auth()->user()->allegiance ? auth()->user()->allegiance : 'Independent' }} Flag</p>
                        </div>
                    </div>
                    <div class="spotlight-body">
                        <div class="spotlight-stats">
                            <div class="spotlight-stat">
                                <span class="stat-label">Reputation Points</span>
                                <span class="stat-value text-gold" id="user-spotlight-rep">0</span>
                            </div>
                            <div class="spotlight-stat">
                                <span class="stat-label">Relics Found</span>
                                <span class="stat-value text-blue" id="user-spotlight-relics">6 / 18</span>
                            </div>
                            <div class="spotlight-stat">
                                <span class="stat-label">Doubloons Earned</span>
                                <span class="stat-value text-gold" id="user-spotlight-gold">0</span>
                            </div>
                        </div>
                        <div class="spotlight-progress-container">
                            <div class="progress-labels">
                                <span class="progress-current">Current: <span id="current-tier">Navigator</span></span>
                                <span class="progress-next">Next: <span id="next-tier">Pirate Lord</span></span>
                            </div>
                            <div class="progress-bar-wrapper">
                                <div class="progress-bar-fill" id="spotlight-progress-fill" style="width: 0%;"></div>
                            </div>
                            <span class="progress-hint" id="progress-hint-text">Earn 500 more points to claim the Pirate Lord status.</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Interactive Statue Chamber (Top 3 Legends) --}}
        <section class="statue-chamber-section">
            <div class="section-header-centered">
                <h2 class="hall-section-title">The Triumvirate of Sea Lords</h2>
                <p class="hall-section-subtitle">Behold the three legendary captains who command the eternal tides.</p>
            </div>

            <div class="statue-chamber" id="triumvirate-container">
                <!-- Top 3 Statues will be loaded here dynamically via JS -->
            </div>
        </section>

        {{-- World Statistics Section --}}
        <section class="statistics-section" style="padding: 2rem 0; text-align: center; color: white;">
            <div class="statistics-grid" style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap;">
                <div class="stat-box" style="background: rgba(0,0,0,0.6); padding: 1.5rem; border: 1px solid var(--potc-gold); border-radius: 8px; min-width: 200px;">
                    <h4 style="color: var(--potc-gold); margin-bottom: 0.5rem; font-size: 1.2rem;">Total Pirates</h4>
                    <span id="stat-total-pirates" style="font-size: 2rem; font-family: 'Pirata One', cursive;">--</span>
                </div>
                <div class="stat-box" style="background: rgba(0,0,0,0.6); padding: 1.5rem; border: 1px solid var(--potc-gold); border-radius: 8px; min-width: 200px;">
                    <h4 style="color: var(--potc-gold); margin-bottom: 0.5rem; font-size: 1.2rem;">Missions Completed</h4>
                    <span id="stat-total-missions" style="font-size: 2rem; font-family: 'Pirata One', cursive;">--</span>
                </div>
                <div class="stat-box" style="background: rgba(0,0,0,0.6); padding: 1.5rem; border: 1px solid var(--potc-gold); border-radius: 8px; min-width: 200px;">
                    <h4 style="color: var(--potc-gold); margin-bottom: 0.5rem; font-size: 1.2rem;">Relics Found</h4>
                    <span id="stat-total-relics" style="font-size: 2rem; font-family: 'Pirata One', cursive;">--</span>
                </div>
                <div class="stat-box" style="background: rgba(0,0,0,0.6); padding: 1.5rem; border: 1px solid var(--potc-gold); border-radius: 8px; min-width: 200px;">
                    <h4 style="color: var(--potc-gold); margin-bottom: 0.5rem; font-size: 1.2rem;">Gold Earned</h4>
                    <span id="stat-total-gold" style="font-size: 2rem; font-family: 'Pirata One', cursive;">--</span>
                </div>
            </div>
        </section>

        {{-- Global Leaderboard Section --}}
        <section class="leaderboard-section">
            <div class="leaderboard-container">
                <div class="leaderboard-header-row">
                    <h2 class="leaderboard-section-title">The Legend Ledger</h2>
                    <div class="leaderboard-controls">
                        <div class="search-box">
                            <span class="search-icon">🔍</span>
                            <input type="text" id="leaderboard-search" placeholder="Search Captain Name...">
                        </div>
                    </div>
                </div>

                <div class="leaderboard-tabs-container">
                    <div class="leaderboard-tabs">
                        <button class="tab-btn active" data-tab="all">All Legends</button>
                        <button class="tab-btn" data-tab="reputation">Most Reputed</button>
                        <button class="tab-btn" data-tab="relics">Treasure Hunters</button>
                        <button class="tab-btn" data-tab="missions">Mission Masters</button>
                        <button class="tab-btn" data-tab="gold">Richest Pirates</button>
                    </div>
                </div>

                <div class="table-wrapper">
                    <table class="leaderboard-table" id="leaderboard-table">
                        <thead>
                            <tr>
                                <th class="col-rank">Rank</th>
                                <th class="col-captain">Captain</th>
                                <th class="col-rep">Reputation</th>
                                <th class="col-missions">Missions</th>
                                <th class="col-relics">Relics</th>
                                <th class="col-gold">Gold (Doubloons)</th>
                                <th class="col-action">Details</th>
                            </tr>
                        </thead>
                        <tbody id="leaderboard-tbody"></tbody>
                    </table>
                </div>
            </div>
        </section>

        {{-- Hall of Fame Achievements --}}
        <section class="hall-of-fame-section">
            <div class="section-header-centered">
                <h2 class="hall-section-title">Hall of Fame</h2>
                <p class="hall-section-subtitle">Engraved plaques commemorating extraordinary deeds across the seas.</p>
            </div>

            <div class="plaques-grid" id="hall-of-fame-grid">
                <!-- Plaques will be loaded here dynamically via JS -->
            </div>
        </section>
    </main>

    {{-- Captain Profile Popup Modal --}}
    <div class="captain-modal" id="captain-modal">
        <div class="modal-overlay" id="captain-modal-overlay"></div>
        <div class="modal-content">
            <button class="modal-close" id="captain-modal-close" aria-label="Close modal">&times;</button>
            <div class="modal-body" id="captain-modal-body"></div>
        </div>
    </div>

    {{-- Footer --}}
    @include('partials.footer-simple', ['footerDescription' => 'Your guide to the pirate universe. Enter the hall. Build your legacy.'])
@endsection

@section('use_base_js', true)

@section('scripts')
    <script src="{{ asset('js/rankings.js') }}"></script>
@endsection
