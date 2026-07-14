@extends('layouts.app')

@section('title', 'Login | The Lost Compass')
@section('meta_description', 'Login - Enter the Captain\'s Cabin | The Lost Compass')
@section('body_class', 'auth-page')

@section('use_base_css', true)

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    {{-- Loading Screen --}}
    @include('partials.loading', ['message' => 'Preparing your passport...'])

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
                <div class="wax-seal-badge" aria-hidden="true">☠️</div>

                <div class="auth-header">
                    <h2>Cabin Entrance</h2>
                    <p>Declare your pirate alias and secret key to resume your voyage.</p>
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

                <form class="auth-form" id="login-form" method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Alias Input --}}
                    <div class="input-group">
                        <label for="pirate-alias" class="input-label">Pirate Alias or Email</label>
                        <div class="input-wrapper">
                            <span class="input-icon">👤</span>
                            <input type="text" id="pirate-alias" name="alias" value="{{ old('alias') }}" placeholder="e.g. Captain Stormcaller" required autocomplete="username">
                        </div>
                    </div>

                    {{-- Secret Key Input --}}
                    <div class="input-group">
                        <label for="secret-key" class="input-label">Secret Key (Password)</label>
                        <div class="input-wrapper">
                            <span class="input-icon">🗝️</span>
                            <input type="password" id="secret-key" name="password" placeholder="Enter your secret credentials..." required autocomplete="current-password">
                            <button type="button" class="password-toggle" id="password-toggle" aria-label="Toggle password visibility">👁️</button>
                        </div>
                    </div>

                    {{-- Checkbox option --}}
                    <div class="auth-options">
                        <label class="checkbox-label">
                            <input type="checkbox" id="remember-crew" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span class="custom-checkbox"></span>
                            Remember my crew seal
                        </label>
                        <a href="#" class="forgot-key-link" id="forgot-key-trigger">Lost your compass?</a>
                    </div>

                    {{-- Embark Button --}}
                    <button type="submit" class="btn btn-auth-submit" id="btn-embark">
                        <span class="btn-text">Embark Voyage</span>
                        <span class="btn-glow" aria-hidden="true"></span>
                    </button>
                </form>

                <div class="auth-footer">
                    <p>New to these waters? <a href="{{ url('/signup') }}" class="auth-link">Sign the Articles</a></p>
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
        const loginForm = document.getElementById('login-form');
        const errorBanner = document.getElementById('auth-error-banner');
        const errorMsg = document.getElementById('auth-error-msg');

        if (loginForm) {
            loginForm.addEventListener('submit', (e) => {
                const aliasInput = document.getElementById('pirate-alias').value.trim();
                const keyInput = document.getElementById('secret-key').value;

                if (aliasInput.length < 3) {
                    e.preventDefault();
                    showError("Alias must be at least 3 letters long.");
                    return;
                }

                if (keyInput.length < 6) {
                    e.preventDefault();
                    showError("Your secret key must be at least 6 characters.");
                    return;
                }

                // If validation passes, the form submits naturally to the server
                const btn = document.getElementById('btn-embark');
                btn.disabled = true;
                btn.querySelector('.btn-text').textContent = 'Setting Sail...';
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

        // Lost compass trigger
        const forgotLink = document.getElementById('forgot-key-trigger');
        if (forgotLink) {
            forgotLink.addEventListener('click', (e) => {
                e.preventDefault();
                alert("🧙‍♂️ Speak to the Tavern barkeep to retrieve your secret key, or create a new pirate seal!");
            });
        }

        // Create floating particles
        const container = document.getElementById('auth-particles');
        if (container) {
            for (let i = 0; i < 15; i++) {
                const particle = document.createElement('div');
                particle.style.cssText = `
                    position: absolute;
                    width: 2px;
                    height: 2px;
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
