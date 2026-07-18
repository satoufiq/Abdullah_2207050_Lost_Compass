@extends('layouts.app')

@section('title', ($user->pirate_name ?? $user->name ?? 'Captain') . ' | The Lost Compass')
@section('meta_description', 'Pirate Legend Archive — ' . ($user->pirate_name ?? $user->name))
@section('body_class', 'profile-page')
@section('use_base_css', true)

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Cinzel+Decorative:wght@700&family=Lora:ital,wght@0,400;0,600;1,400&family=Pirata+One&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/profile.css') }}?v={{ time() }}">
@endsection

@section('content')
@include('partials.loading', ['message' => 'Summoning your legend...'])
@include('partials.nav')

{{-- ═══════════════ HERO BANNER ═══════════════ --}}
<section class="pf-hero">
    <div class="pf-hero__bg">
        <img src="{{ asset('assets/images/profile/backgrounds/captain-cabin.jpg') }}" alt="" class="pf-hero__bg-img">
        <div class="pf-hero__bg-overlay"></div>
        <div class="pf-hero__bg-vignette"></div>
    </div>

    <div class="pf-hero__content">

        {{-- ── Identity Card ── --}}
        <div class="pf-card pf-identity" id="identity-card">

            {{-- Avatar column --}}
            <div class="pf-identity__avatar-col">
                <div class="pf-avatar-frame">
                    <img src="{{ $user->avatar_url }}"
                         alt="Avatar"
                         class="pf-avatar"
                         onerror="this.src='{{ asset('assets/images/profile/emblems/compass-rose.png') }}'">
                    <div class="pf-avatar-corner pf-avatar-corner--tl"></div>
                    <div class="pf-avatar-corner pf-avatar-corner--tr"></div>
                    <div class="pf-avatar-corner pf-avatar-corner--bl"></div>
                    <div class="pf-avatar-corner pf-avatar-corner--br"></div>
                </div>
                <span class="pf-rank-pill">{{ $rank }}</span>
            </div>

            {{-- Details column --}}
            <div class="pf-identity__details">
                <p class="pf-kicker">Pirate Legend · {{ $user->allegiance ?? $profile?->allegiance ?? 'Independent' }}</p>

                <h1 class="pf-pirate-name">
                    {{ $user->pirate_name ?? $profile?->pirate_name ?? $user->name ?? 'Captain Unknown' }}
                </h1>

                <p class="pf-role">
                    {{ $user->identity_character ?? $profile?->role ?? 'Undiscovered Legend' }}
                </p>

                {{-- Quick stats strip --}}
                <div class="pf-quick-stats">
                    <div class="pf-qs-item">
                        <span class="pf-qs-val">{{ number_format($stats['reputation']) }}</span>
                        <span class="pf-qs-label">Reputation</span>
                    </div>
                    <div class="pf-qs-divider"></div>
                    <div class="pf-qs-item">
                        <span class="pf-qs-val">{{ number_format($stats['gold_earned']) }}</span>
                        <span class="pf-qs-label">Gold</span>
                    </div>
                    <div class="pf-qs-divider"></div>
                    <div class="pf-qs-item">
                        <span class="pf-qs-val">{{ $stats['missions_completed'] }}</span>
                        <span class="pf-qs-label">Missions</span>
                    </div>
                    <div class="pf-qs-divider"></div>
                    <div class="pf-qs-item">
                        <span class="pf-qs-val">{{ $stats['relics_collected'] }}</span>
                        <span class="pf-qs-label">Relics</span>
                    </div>
                </div>

                {{-- Weapon badge --}}
                @if($weapon && $weapon !== 'Bare Hands')
                <div class="pf-weapon-tag">
                    <span class="pf-weapon-tag__icon">⚔</span>
                    <span class="pf-weapon-tag__name">{{ $weapon }}</span>
                </div>
                @endif

                {{-- Motto --}}
                @php $motto = $user->motto ?? $profile?->motto ?? null; @endphp
                <p class="pf-motto">"{{ $motto ?? 'The sea holds no prisoners.' }}"</p>

                <div class="pf-hero-actions">
                    <a href="{{ route('quiz') }}" class="pf-btn pf-btn--ghost">Rituals</a>
                    <a href="{{ route('missions') }}" class="pf-btn pf-btn--primary">Set Sail</a>
                </div>
            </div>

            <div class="pf-card__watermark">THE LOST COMPASS</div>
        </div>

    </div>
</section>

{{-- ═══════════════ CAPTAIN'S LOG (Stats) ═══════════════ --}}
<section class="pf-section pf-section--dark">
    <div class="pf-container">
        <div class="pf-section-head">
            <h2 class="pf-section-title">⚓ Captain's Log</h2>
            <p class="pf-section-sub">Your legend, by the numbers</p>
        </div>

        <div class="pf-stats-grid">
            <div class="pf-stat-card pf-reveal">
                <div class="pf-stat-card__icon">
                    <img src="{{ asset('assets/images/profile/icons/icon-missions-scroll.png') }}" alt="Missions" onerror="this.style.display='none'">
                </div>
                <p class="pf-stat-card__val">{{ $stats['missions_completed'] }}</p>
                <p class="pf-stat-card__label">Missions Completed</p>
                @if($stats['missions_completed'] === 0)
                    <p class="pf-stat-card__hint">Complete your first mission to earn gold &amp; relics</p>
                @endif
            </div>

            <div class="pf-stat-card pf-reveal">
                <div class="pf-stat-card__icon">
                    <img src="{{ asset('assets/images/profile/icons/icon-gold-coin.png') }}" alt="Gold" onerror="this.style.display='none'">
                </div>
                <p class="pf-stat-card__val">{{ number_format($stats['gold_earned']) }}</p>
                <p class="pf-stat-card__label">Gold Earned</p>
            </div>

            <div class="pf-stat-card pf-reveal">
                <div class="pf-stat-card__icon">
                    <img src="{{ asset('assets/images/profile/icons/icon-relic-gem.png') }}" alt="Relics" onerror="this.style.display='none'">
                </div>
                <p class="pf-stat-card__val">{{ $stats['relics_collected'] }}</p>
                <p class="pf-stat-card__label">Relics Collected</p>
            </div>

            <div class="pf-stat-card pf-reveal">
                <div class="pf-stat-card__icon">
                    <img src="{{ asset('assets/images/profile/icons/icon-battles-crossed-swords.png') }}" alt="Battles" onerror="this.style.display='none'">
                </div>
                <p class="pf-stat-card__val">{{ $stats['reputation'] }}</p>
                <p class="pf-stat-card__label">Total Reputation</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════ SHIP + WEAPON ═══════════════ --}}
<section class="pf-section pf-section--mid">
    <div class="pf-container">
        <div class="pf-section-head">
            <h2 class="pf-section-title">🏴‍☠️ Arsenal & Command</h2>
            <p class="pf-section-sub">Your vessel and your blade</p>
        </div>

        <div class="pf-gear-grid">

            {{-- Ship --}}
            <div class="pf-gear-card pf-reveal">
                <div class="pf-gear-card__badge">VESSEL</div>
                @php
                    $displayShipName = $shipName ?? 'No Ship Claimed';
                    $shipImg = 'ship-dreadnought.png';
                    if ($ship && $ship->image) {
                        $shipImg = $ship->image;
                    } elseif ($displayShipName !== 'No Ship Claimed') {
                        $sc = strtolower(str_replace([' ', "'", 'The '], ['-', '', ''], $displayShipName));
                        $shipImg = "ship-{$sc}.png";
                    }
                @endphp
                <div class="pf-gear-card__img-wrap">
                    <img src="{{ asset('assets/images/profile/ships/' . $shipImg) }}"
                         alt="{{ $displayShipName }}"
                         class="pf-gear-card__img"
                         onerror="this.src='{{ asset('assets/images/profile/ships/ship-dreadnought.png') }}'">
                    <div class="pf-gear-card__img-overlay"></div>
                </div>
                <div class="pf-gear-card__body">
                    <h3 class="pf-gear-card__name">{{ $displayShipName }}</h3>

                    @if($ship)
                    <div class="pf-attr-list">
                        <div class="pf-attr">
                            <span class="pf-attr__label">Speed</span>
                            <div class="pf-attr__bar"><div class="pf-attr__fill pf-attr__fill--speed" style="width:{{ $ship->speed * 10 }}%"></div></div>
                            <span class="pf-attr__val">{{ $ship->speed }}/10</span>
                        </div>
                        <div class="pf-attr">
                            <span class="pf-attr__label">Power</span>
                            <div class="pf-attr__bar"><div class="pf-attr__fill pf-attr__fill--power" style="width:{{ $ship->attack * 10 }}%"></div></div>
                            <span class="pf-attr__val">{{ $ship->attack }}/10</span>
                        </div>
                        @if($ship->special_ability)
                        <p class="pf-gear-card__ability">✨ {{ $ship->special_ability }}</p>
                        @endif
                    </div>
                    @else
                    <p class="pf-gear-card__empty">Complete the Ship Ritual to claim your vessel.</p>
                    @endif

                    <a href="{{ route('quiz') }}" class="pf-btn pf-btn--ghost pf-btn--sm" style="margin-top:1.2rem">
                        {{ $ship ? 'View Fleet' : 'Ship Ritual →' }}
                    </a>
                </div>
            </div>

            {{-- Weapon --}}
            <div class="pf-gear-card pf-reveal">
                <div class="pf-gear-card__badge">WEAPON</div>
                <div class="pf-gear-card__img-wrap pf-gear-card__img-wrap--weapon">
                    @if($weaponImage)
                    <img src="{{ asset('assets/images/profile/weapons/' . $weaponImage) }}"
                         alt="{{ $weapon }}"
                         class="pf-gear-card__img pf-gear-card__img--weapon"
                         onerror="this.src='{{ asset('assets/images/profile/weapons/weapon-cursed-cutlass.png') }}'">
                    @else
                    <div class="pf-gear-card__placeholder">⚔️</div>
                    @endif
                    <div class="pf-gear-card__img-overlay"></div>
                </div>
                <div class="pf-gear-card__body">
                    <h3 class="pf-gear-card__name">{{ $weapon }}</h3>

                    @if($weaponImage)
                    <p class="pf-gear-card__ability" style="text-align:center">
                        Claimed through the Weapon Ritual
                    </p>
                    @else
                    <p class="pf-gear-card__empty">Complete the Weapon Ritual to arm yourself.</p>
                    @endif

                    <a href="{{ route('quiz') }}" class="pf-btn pf-btn--ghost pf-btn--sm" style="margin-top:1.2rem">
                        {{ $weaponImage ? 'Change Weapon' : 'Weapon Ritual →' }}
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════ TREASURE VAULT ═══════════════ --}}
<section class="pf-section pf-section--dark">
    <div class="pf-container">
        <div class="pf-section-head">
            <h2 class="pf-section-title">💎 Treasure Vault</h2>
            <p class="pf-section-sub">Your collection of rare artifacts and cursed treasures.</p>
        </div>

        <div class="vault-stats-wrapper">
            <div class="vault-progress-col">
                <strong>Collection Progress:</strong> {{ $stats['relics_collected'] }} / {{ $stats['total_relics'] }} ({{ $stats['relic_progress'] }}%)
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill" style="width:{{ $stats['relic_progress'] }}%"></div>
                </div>
            </div>
            <div class="vault-rarity-counts">
                <div class="rarity-count rarity-legendary"><span>{{ $stats['legendary_relics'] }}</span><small>Legendary</small></div>
                <div class="rarity-count rarity-epic"><span>{{ $stats['epic_relics'] }}</span><small>Epic</small></div>
                <div class="rarity-count rarity-rare"><span>{{ $stats['rare_relics'] }}</span><small>Rare</small></div>
                <div class="rarity-count rarity-common"><span>{{ $stats['common_relics'] }}</span><small>Common</small></div>
            </div>
        </div>

        <div class="vault-controls">
            <form action="{{ route('profile') }}" method="GET">
                <input type="text" name="search" placeholder="Search relics..." value="{{ request('search') }}">
                
                <select name="category">
                    <option value="all">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>

                <select name="rarity">
                    <option value="all">All Rarities</option>
                    <option value="Legendary" {{ request('rarity') == 'Legendary' ? 'selected' : '' }}>Legendary</option>
                    <option value="Epic" {{ request('rarity') == 'Epic' ? 'selected' : '' }}>Epic</option>
                    <option value="Rare" {{ request('rarity') == 'Rare' ? 'selected' : '' }}>Rare</option>
                    <option value="Common" {{ request('rarity') == 'Common' ? 'selected' : '' }}>Common</option>
                </select>
                
                <button type="submit" class="pf-btn pf-btn--ghost pf-btn--sm">Filter</button>
            </form>
        </div>

        <div class="chest-section text-center">
            @if($availableChests > 0)
                <button id="openChestBtn" class="pf-btn pf-btn--primary">Open Treasure Chest ({{ $availableChests }} Available)</button>
            @else
                <button id="openChestBtn" class="pf-btn pf-btn--disabled" disabled>Complete Missions to Earn Chests</button>
            @endif
            <p id="chestMessage" style="display:none; color: #4ade80; margin-top: 1rem;"></p>
        </div>

        <div class="relic-gallery">
            @foreach($allRelics as $relic)
                @php
                    $isOwned = in_array($relic->id, $ownedRelicIds);
                @endphp
                <div class="relic-card {{ $isOwned ? 'unlocked' : 'locked' }}" data-id="{{ $relic->id }}">
                    <div class="relic-image-wrapper">
                        @if($isOwned)
                            <img src="{{ asset('assets/images/profile/relics/' . $relic->image) }}" alt="{{ $relic->name }}" onerror="this.src='{{ asset('assets/images/profile/relics/relic-captains-medal.png') }}'">
                        @else
                            <div class="silhouette" style="font-size:4rem; color:#333;">?</div>
                        @endif
                    </div>
                    <div class="relic-info">
                        <h4>{{ $isOwned ? $relic->name : 'Unknown Relic' }}</h4>
                        @if($relic->rarity == 'Legendary')
                            <span class="rarity-badge rarity-legendary">{{ $relic->rarity }}</span>
                        @elseif($relic->rarity == 'Epic')
                            <span class="rarity-badge rarity-epic">{{ $relic->rarity }}</span>
                        @elseif($relic->rarity == 'Rare')
                            <span class="rarity-badge rarity-rare">{{ $relic->rarity }}</span>
                        @else
                            <span class="rarity-badge rarity-common">{{ $relic->rarity }}</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Relic Modal -->
<div id="relicModal" class="pf-modal">
    <div class="pf-modal-content">
        <span class="close-modal">&times;</span>
        <div class="modal-image-col">
            <img id="modalImage" src="" alt="Relic">
        </div>
        <div class="modal-details-col">
            <h2 id="modalName">Relic Name</h2>
            <div class="modal-meta">
                <span id="modalRarity" class="rarity-badge">Rarity</span>
                <span id="modalCategory" class="modal-category-badge">Category</span>
            </div>
            <div class="modal-desc-list">
                <p><strong>Origin:</strong> <span id="modalOrigin"></span></p>
                <p><strong>Movie:</strong> <span id="modalMovie"></span></p>
                <p><strong>Power:</strong> <span id="modalPower"></span></p>
            </div>
            <p id="modalDesc" class="modal-story"></p>
        </div>
    </div>
</div>

{{-- ═══════════════ MISSION HISTORY ═══════════════ --}}
<section class="pf-section pf-section--mid">
    <div class="pf-container">
        <div class="pf-section-head">
            <h2 class="pf-section-title">📜 Mission Log</h2>
            <p class="pf-section-sub">Your voyages, battles, and discoveries</p>
        </div>

        @if($missionHistory->isEmpty())
        <div class="pf-empty-state pf-reveal">
            <span class="pf-empty-state__icon">🗺️</span>
            <h3>No Voyages Yet</h3>
            <p>Your captain's log is empty. Set sail and forge your legend.</p>
            <a href="{{ route('missions') }}" class="pf-btn pf-btn--primary">Start a Mission</a>
        </div>
        @else
        <div class="pf-mission-list">
            @foreach($missionHistory as $h)
            <div class="pf-mission-row pf-reveal">
                <div class="pf-mission-row__status pf-mission-row__status--{{ $h->status === 'completed' ? 'done' : 'active' }}">
                    {{ $h->status === 'completed' ? '✓' : '⚓' }}
                </div>
                <div class="pf-mission-row__info">
                    <h3 class="pf-mission-row__title">{{ $h->mission->title ?? 'Unknown Mission' }}</h3>
                    <p class="pf-mission-row__meta">{{ $h->updated_at->format('d M Y') }}</p>
                </div>
                <span class="pf-mission-row__badge pf-mission-row__badge--{{ $h->status }}">
                    {{ ucfirst($h->status) }}
                </span>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

{{-- ═══════════════ ACHIEVEMENTS ═══════════════ --}}
<section class="pf-section pf-section--dark">
    <div class="pf-container">
        <div class="pf-section-head">
            <h2 class="pf-section-title">🏆 Legendary Achievements</h2>
            <p class="pf-section-sub">Badges of honor earned through valor</p>
        </div>

        @if($userAchievements->isEmpty())
        <div class="pf-empty-state pf-reveal">
            <span class="pf-empty-state__icon">🎖️</span>
            <h3>No Achievements Yet</h3>
            <p>Complete missions and collect relics to earn prestigious badges of legend.</p>
        </div>
        @else
        <div class="pf-achievement-grid">
            @foreach($userAchievements as $ua)
            <div class="pf-achievement pf-reveal">
                <div class="pf-achievement__ring">
                    <img src="{{ asset('assets/images/profile/achievements/' . ($ua->achievement->icon ?? 'badge-master-navigator.png')) }}"
                         alt="{{ $ua->achievement->title }}"
                         class="pf-achievement__img"
                         onerror="this.src='{{ asset('assets/images/profile/achievements/badge-master-navigator.png') }}'">
                </div>
                <p class="pf-achievement__title">{{ $ua->achievement->title }}</p>
                <p class="pf-achievement__desc">{{ $ua->achievement->description }}</p>
                @if($ua->unlocked_at)
                <p class="pf-achievement__date">{{ $ua->unlocked_at->format('M Y') }}</p>
                @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

{{-- ═══════════════ FOOTER ═══════════════ --}}
<footer class="pf-footer">
    <div class="pf-footer__inner">
        <div class="pf-footer__brand">
            <h3>The Lost Compass</h3>
            <p>Your guide to the pirate universe.</p>
        </div>
        <div class="pf-footer__links">
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ url('/characters') }}">Characters</a>
            <a href="{{ url('/ships') }}">Ships</a>
            <a href="{{ url('/missions') }}">Missions</a>
            <a href="{{ url('/quiz') }}">Rituals</a>
        </div>
        <p class="pf-footer__copy">&copy; {{ date('Y') }} The Lost Compass 🏴‍☠️</p>
    </div>
</footer>

@endsection

@section('use_base_js', true)
@section('scripts')
<script>
// Reveal on scroll
const revealEls = document.querySelectorAll('.pf-reveal');
const io = new IntersectionObserver((entries) => {
    entries.forEach(e => { if(e.isIntersecting) { e.target.classList.add('pf-reveal--visible'); io.unobserve(e.target); } });
}, { threshold: 0.12 });
revealEls.forEach(el => io.observe(el));

// Vault Modal Logic
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('relicModal');
    const closeBtn = document.querySelector('.close-modal');
    
    document.querySelectorAll('.relic-card.unlocked').forEach(card => {
        card.addEventListener('click', function() {
            const id = this.dataset.id;
            fetch(`/profile/relic/${id}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('modalName').textContent = data.relic_name;
                    document.getElementById('modalOrigin').textContent = data.origin || 'Unknown';
                    document.getElementById('modalMovie').textContent = data.movie || 'Unknown';
                    document.getElementById('modalPower').textContent = data.power || 'None';
                    document.getElementById('modalDesc').textContent = data.description || '';
                    
                    const rBadge = document.getElementById('modalRarity');
                    rBadge.textContent = data.rarity;
                    if(data.rarity === 'Legendary') { rBadge.style.background = '#ffd700'; rBadge.style.color = '#000'; }
                    else if(data.rarity === 'Epic') { rBadge.style.background = '#a333c8'; rBadge.style.color = '#fff'; }
                    else if(data.rarity === 'Rare') { rBadge.style.background = '#2185d0'; rBadge.style.color = '#fff'; }
                    else { rBadge.style.background = '#666'; rBadge.style.color = '#fff'; }
                    
                    document.getElementById('modalCategory').textContent = data.category;
                    document.getElementById('modalImage').src = `/assets/images/profile/relics/${data.image}`;
                    document.getElementById('modalImage').onerror = function() { this.src = '/assets/images/profile/relics/relic-captains-medal.png'; };
                    
                    modal.style.display = 'block';
                });
        });
    });

    if(closeBtn) {
        closeBtn.onclick = function() { modal.style.display = 'none'; }
    }
    window.onclick = function(event) {
        if (event.target == modal) { modal.style.display = 'none'; }
    }

    // Chest Logic
    const chestBtn = document.getElementById('openChestBtn');
    if(chestBtn) {
        chestBtn.addEventListener('click', function() {
            const btn = this;
            btn.disabled = true;
            btn.textContent = 'Opening...';
            
            fetch('{{ route("profile.chest") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    const msg = document.getElementById('chestMessage');
                    msg.textContent = `${data.message} You got: ${data.reward.name} (${data.reward.rarity})!`;
                    msg.style.display = 'block';
                    setTimeout(() => window.location.href = "{{ route('profile') }}", 2000);
                } else {
                    alert(data.error || 'Failed to open chest');
                    btn.disabled = false;
                    btn.textContent = 'Open Treasure Chest';
                }
            })
            .catch(err => {
                console.error(err);
                btn.disabled = false;
                btn.textContent = 'Open Treasure Chest';
            });
        });
    }
});
</script>
@endsection
