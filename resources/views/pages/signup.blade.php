@extends('layouts.app')

@section('title', 'Sign Up | The Lost Compass')
@section('meta_description', 'Sign Up - Sign the Pirate Articles | The Lost Compass')
@section('body_class', 'auth-page')

@section('use_base_css', true)

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    {{-- Loading Screen --}}
    @include('partials.loading', ['message' => 'Forging your pirate seal...'])

    {{-- Background overlay --}}
    <div class="auth-background" aria-hidden="true">
        <div class="auth-overlay"></div>
        <div class="auth-particles" id="auth-particles"></div>
    </div>

    {{-- Navigation --}}
    @include('partials.nav')

    <main id="main-content" class="auth-main">
        <div class="auth-card-container">
            <div class="auth-card">
                {{-- Wax Seal decorative badge --}}
                <div class="wax-seal-badge" aria-hidden="true">📜</div>

                <div class="auth-header">
                    <h2>Sign the Articles</h2>
                    <p>Pledge your allegiance and register your name in the global pirate ledger.</p>
                </div>

                {{-- Server-side error banner --}}
                @if ($errors->any())
                    <div class="auth-error-banner" id="auth-error-banner" style="display: flex;">
                        <span class="error-icon">⚠️</span>
                        <span class="error-msg" id="auth-error-msg">{{ $errors->first() }}</span>
                    </div>
                @else
                    <div class="auth-error-banner" id="auth-error-banner" style="display: none;">
                        <span class="error-icon">⚠️</span>
                        <span class="error-msg" id="auth-error-msg"></span>
                    </div>
                @endif

                @if(session('quiz_message'))
                    <div class="auth-error-banner" style="display: flex; background: rgba(201, 164, 76, 0.15); border-color: #c9a44c; color: #f2dec0; margin-bottom: 1rem;">
                        <span class="error-icon" style="color: #c9a44c;">⚓</span>
                        <span class="error-msg">{{ session('quiz_message') }}<br><small>Your Identity: <strong>{{ session('identity_character') }}</strong> will be saved to your profile.</small></span>
                    </div>
                @endif

                <form class="auth-form" id="signup-form" method="POST" action="{{ route('signup') }}">
                    @csrf

                    {{-- Captain Name Input --}}
                    <div class="input-group">
                        <label for="pirate-name" class="input-label">Captain's Name (Alias)</label>
                        <div class="input-wrapper">
                            <span class="input-icon">👤</span>
                            <input type="text" id="pirate-name" name="pirate_name" value="{{ old('pirate_name', session('quiz_identity_data.pirate_name', '')) }}" placeholder="e.g. Captain Jack Vane" required autocomplete="name">
                        </div>
                    </div>

                    {{-- Email Input --}}
                    <div class="input-group">
                        <label for="pirate-email" class="input-label">Communication Scroll (Email)</label>
                        <div class="input-wrapper">
                            <span class="input-icon">✉️</span>
                            <input type="email" id="pirate-email" name="email" value="{{ old('email') }}" placeholder="e.g. vane@shadowtide.com" required autocomplete="email">
                        </div>
                    </div>

                    {{-- Secret Key Input --}}
                    <div class="input-group">
                        <label for="secret-key" class="input-label">Secret Credentials (Password)</label>
                        <div class="input-wrapper">
                            <span class="input-icon">🗝️</span>
                            <input type="password" id="secret-key" name="password" placeholder="Establish your secret key..." required autocomplete="new-password">
                            <button type="button" class="password-toggle" id="password-toggle" aria-label="Toggle password visibility">👁️</button>
                        </div>
                    </div>

                    {{-- Allegiance Selector --}}
                    <div class="input-group">
                        <label for="pirate-allegiance" class="input-label">Choose Your Allegiance</label>
                        <div class="input-wrapper">
                            <span class="input-icon">🚩</span>
                            <select id="pirate-allegiance" name="allegiance" required>
                                @php $selectedAllegiance = old('allegiance', session('quiz_identity_data.allegiance', '')); @endphp
                                <option value="" disabled {{ $selectedAllegiance ? '' : 'selected' }}>Select faction...</option>
                                <option value="Independent" {{ $selectedAllegiance === 'Independent' || $selectedAllegiance === 'Free' ? 'selected' : '' }}>Independent (Mercenary)</option>
                                <option value="Brethren of the Coast" {{ $selectedAllegiance === 'Brethren of the Coast' || $selectedAllegiance === 'Pirate Council' ? 'selected' : '' }}>Brethren of the Coast (Pirate Council)</option>
                                <option value="Royal Navy" {{ $selectedAllegiance === 'Royal Navy' || $selectedAllegiance === 'Navy' ? 'selected' : '' }}>Royal Navy (Crown Navy)</option>
                                <option value="Spanish Fleet" {{ $selectedAllegiance === 'Spanish Fleet' || $selectedAllegiance === 'Merchant' ? 'selected' : '' }}>Spanish Armada (Imperial)</option>
                            </select>
                        </div>
                    </div>

                    {{-- Oath checkbox --}}
                    <div class="auth-options">
                        <label class="checkbox-label">
                            <input type="checkbox" id="oath-agreement" required>
                            <span class="custom-checkbox"></span>
                            I sign these articles, bound by code of honor.
                        </label>
                    </div>

                    {{-- Hidden attributes from Quiz --}}
                    @if(session()->has('quiz_identity_data'))
                        @foreach(session('quiz_identity_data') as $key => $value)
                            @if(!in_array($key, ['pirate_name', 'allegiance', 'ship', 'weapon']))
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                    @endif

                    {{-- Submit Button --}}
                    <button type="submit" class="btn btn-auth-submit" id="btn-sign-articles">
                        <span class="btn-text">Sign Articles</span>
                        <span class="btn-glow" aria-hidden="true"></span>
                    </button>
                </form>

                <div class="auth-footer">
                    <p>Already signed the articles? <a href="{{ url('/login') }}" class="auth-link">Return to Cabin</a></p>
                </div>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    @include('partials.footer-simple')
@endsection

@section('use_base_js', true)

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Hide loading screen
        const loadingScreen = document.getElementById('loading-screen');
        if (loadingScreen) {
            setTimeout(() => {
                loadingScreen.style.opacity = '0';
                loadingScreen.style.pointerEvents = 'none';
            }, 800);
        }

        // Password toggle visibility
        const secretKey = document.getElementById('secret-key');
        const toggleBtn = document.getElementById('password-toggle');
        if (toggleBtn && secretKey) {
            toggleBtn.addEventListener('click', () => {
                const isPassword = secretKey.getAttribute('type') === 'password';
                secretKey.setAttribute('type', isPassword ? 'text' : 'password');
                toggleBtn.textContent = isPassword ? '🙈' : '👁️';
            });
        }

        // Client-side validation (supplement to server-side)
        const signupForm = document.getElementById('signup-form');
        const errorBanner = document.getElementById('auth-error-banner');
        const errorMsg = document.getElementById('auth-error-msg');

        if (signupForm) {
            signupForm.addEventListener('submit', (e) => {
                const nameInput = document.getElementById('pirate-name').value.trim();
                const emailInput = document.getElementById('pirate-email').value.trim();
                const keyInput = document.getElementById('secret-key').value;
                const allegianceInput = document.getElementById('pirate-allegiance').value;
                const oathCheck = document.getElementById('oath-agreement').checked;

                if (nameInput.length < 3) {
                    e.preventDefault();
                    showError("Captain name must be at least 3 characters.");
                    return;
                }

                if (keyInput.length < 6) {
                    e.preventDefault();
                    showError("Secret key must be at least 6 characters.");
                    return;
                }

                if (!allegianceInput) {
                    e.preventDefault();
                    showError("Please declare your allegiance to a faction.");
                    return;
                }

                if (!oathCheck) {
                    e.preventDefault();
                    showError("You must pledge your oath to sign the articles!");
                    return;
                }

                // If validation passes, the form submits naturally to the server
                const btn = document.getElementById('btn-sign-articles');
                btn.disabled = true;
                btn.querySelector('.btn-text').textContent = 'Signing Seal...';
            });
        }

        function showError(message) {
            errorMsg.textContent = message;
            errorBanner.style.display = 'flex';
            errorBanner.style.animation = 'shake-banner 0.4s ease-out';
            setTimeout(() => {
                errorBanner.style.animation = '';
            }, 500);
        }

        // Create floating particles
        const container = document.getElementById('auth-particles');
        if (container) {
            for (let i = 0; i < 15; i++) {
                const particle = document.createElement('div');
                particle.style.cssText = `
                    position: absolute;
                    width: 2.5px;
                    height: 2.5px;
                    background: #f0b449;
                    border-radius: 50%;
                    bottom: 0;
                    left: ${Math.random() * 100}%;
                    opacity: ${0.2 + Math.random() * 0.4};
                    box-shadow: 0 0 5px #f0b449;
                    animation: auth-float ${8 + Math.random() * 6}s ease-in-out infinite;
                    animation-delay: ${Math.random() * 8}s;
                `;
                container.appendChild(particle);
            }
        }
    });
</script>
@endsection
