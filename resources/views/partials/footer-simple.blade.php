<footer @if(isset($footerClass)) class="{{ $footerClass }}" @endif>
    <div class="footer-content">
        <div class="footer-section">
            <h3 class="footer-logo">The Lost Compass</h3>
            <p>{{ $footerDescription ?? 'Your guide to the pirate universe. Embark on the adventure of a lifetime.' }}</p>
        </div>
        <div class="footer-section">
            <h3>Quick Links</h3>
            <ul class="footer-links">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/characters') }}">Characters</a></li>
                <li><a href="{{ url('/ships') }}">Ships</a></li>
                <li><a href="{{ url('/map') }}">Map</a></li>
                <li><a href="{{ url('/vault') }}">Relics</a></li>
            </ul>
        </div>

    </div>
    <div class="footer-bottom">
        <p class="copyright">&copy; <span id="footer-year">{{ date('Y') }}</span> The Lost Compass. All rights reserved. 🏴‍☠️</p>
    </div>
</footer>
