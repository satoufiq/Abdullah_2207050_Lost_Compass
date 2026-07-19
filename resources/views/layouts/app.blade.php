<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ rtrim(config('app.url'), '/') }}">
    <meta name="description" content="@yield('meta_description', 'The Lost Compass - An Interactive Pirates Universe Experience')">
    <title>@yield('title', 'The Lost Compass')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pirata+One&family=Playfair+Display:wght@400;600;700;800&family=Cormorant+Garamond:wght@300;400;500;600;700&family=Cinzel:wght@400;600;700;800&family=Cinzel+Decorative:wght@700&family=Lora:wght@400;500;600;700&family=Merriweather:wght@400;700&family=IM+Fell+English+SC&display=swap" rel="stylesheet">

    <!-- Base Stylesheet -->
    @hasSection('use_base_css')
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}?v={{ time() }}">
    @endif

    <!-- Page-specific Styles -->
    @yield('styles')

    <!-- Unified Navbar Styles -->
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}?v={{ time() }}">
</head>
<body @hasSection('body_class') class="@yield('body_class')" @endif @hasSection('body_attributes') @yield('body_attributes') @endif>

    {{-- Global Flash Messages (For Middlewares & Actions) --}}
    @if(session('success') || session('error'))
        <div id="flash-message" class="global-flash-message {{ session('success') ? 'flash-success' : 'flash-error' }}">
            {{ session('success') ?? session('error') }}
            <button onclick="document.getElementById('flash-message').style.display='none'">&times;</button>
        </div>
        <style>
            .global-flash-message {
                position: fixed;
                top: 85px; /* Below the navbar */
                right: 20px;
                z-index: 100000;
                padding: 12px 20px;
                border-radius: 6px;
                font-family: 'Cinzel', serif;
                font-weight: 600;
                font-size: 0.9rem;
                box-shadow: 0 8px 25px rgba(0,0,0,0.8);
                display: flex;
                align-items: center;
                gap: 15px;
                animation: slideInRight 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), fadeOutDown 0.5s ease-in 5s forwards;
            }
            .flash-success {
                background: linear-gradient(135deg, rgba(20,40,20,0.95), rgba(10,20,10,0.98));
                border: 1px solid #4ade80;
                color: #4ade80;
                box-shadow: 0 0 15px rgba(74, 222, 128, 0.2);
            }
            .flash-error {
                background: linear-gradient(135deg, rgba(50,15,15,0.95), rgba(25,10,10,0.98));
                border: 1px solid #f87171;
                color: #f87171;
                box-shadow: 0 0 15px rgba(248, 113, 113, 0.2);
            }
            .global-flash-message button {
                background: none;
                border: none;
                color: inherit;
                font-size: 1.3rem;
                cursor: pointer;
                opacity: 0.7;
                padding: 0;
                line-height: 1;
            }
            .global-flash-message button:hover {
                opacity: 1;
            }
            @keyframes slideInRight {
                from { transform: translateX(120%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes fadeOutDown {
                from { opacity: 1; transform: translateY(0); }
                to { opacity: 0; transform: translateY(20px); visibility: hidden; }
            }
        </style>
    @endif

    @yield('content')
    {{ $slot ?? '' }}

    <!-- Base Script -->
    @hasSection('use_base_js')
        <script src="{{ asset('js/main.js') }}"></script>
    @endif

    <!-- App base URL: injected early so all page JS can use window.APP_BASE -->
    <script>
    (function () {
        var injected = '{{ rtrim(config("app.url"), "/") }}';
        // Validate: injected value must match the current origin + start of path
        if (injected && window.location.href.indexOf(injected) === 0) {
            window.APP_BASE = injected;
        } else {
            // Auto-detect from current URL: grab everything up to /public or /index.php
            var path = window.location.pathname;
            var m = path.match(/^(.*?\/(?:public|index\.php))/);
            window.APP_BASE = m
                ? (window.location.origin + m[1])
                : (window.location.origin + path.replace(/\/[^\/]*$/, ''));
        }
    }());
    </script>

    <!-- Page-specific Scripts -->
    @yield('scripts')

    <!-- Global Background Music -->
    <style>
        .bgm-toggle-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            background: rgba(10, 10, 15, 0.8);
            color: #d4af37;
            border: 2px solid #8b6b22;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.5);
        }
        .bgm-toggle-btn:hover {
            background: rgba(20, 20, 25, 0.9);
            transform: scale(1.1);
            color: #ffd700;
            border-color: #ffd700;
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.4);
        }
    </style>
    <audio id="global-bgm" loop>
        <source src="{{ asset('assets/audio/bgm.mp3') }}" type="audio/mpeg">
    </audio>
    <button id="bgm-toggle" class="bgm-toggle-btn" aria-label="Toggle Background Music">
        <!-- SVG injected by JS -->
    </button>
    <script src="{{ asset('js/bgm.js') }}"></script>

</body>
</html>
