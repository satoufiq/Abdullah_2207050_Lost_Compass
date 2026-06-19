<footer>
    <div class="footer-content">
        <div class="footer-section">
            <h3 class="footer-logo">
                <img src="{{ asset('assets/images/home/compass-rose.png') }}" alt="Compass" class="footer-compass">
                The Lost Compass
            </h3>
            <p>
                A premium interactive pirate universe where legends sail beyond the horizon.
                Enter the world. Claim your destiny.
            </p>
        </div>
        <div class="footer-section">
            <h3>Navigation</h3>
            <ul class="footer-links">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/characters') }}">Characters</a></li>
                <li><a href="{{ url('/ships') }}">Legendary Ships</a></li>
                <li><a href="{{ url('/map') }}">World Map</a></li>
                <li><a href="{{ url('/missions') }}">Missions</a></li>
                @if(isset($showTavern) && $showTavern)
                    <li><a href="{{ url('/tavern') }}">Tavern</a></li>
                @endif
            </ul>
        </div>
        <div class="footer-section">
            <h3>Account</h3>
            <ul class="footer-links">
                <li><a href="{{ url('/profile') }}">Create Profile</a></li>
                <li><a href="{{ url('/login') }}">Login</a></li>
                <li><a href="{{ url('/quiz') }}">Take Quiz</a></li>
                <li><a href="#">My Treasure</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Follow Us</h3>
            <div class="social-links">
                <a href="#" title="Facebook">f</a>
                <a href="#" title="Twitter">𝕏</a>
                <a href="#" title="Instagram">📷</a>
                <a href="#" title="Discord">💬</a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} The Lost Compass. All rights reserved. The world of pirates awaits.</p>
    </div>
</footer>
