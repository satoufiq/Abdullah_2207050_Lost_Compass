<div class="loading-screen" id="loading-screen">
    <img src="{{ asset('assets/images/home/compass-rose.png') }}" alt="Loading compass" class="loading-compass">
    <p class="loading-text">{{ $message ?? 'Charting the Seas...' }}</p>
</div>
<script>
    window.addEventListener('load', function() {
        var loader = document.getElementById('loading-screen');
        if (loader) {
            loader.style.opacity = '0';
            loader.style.pointerEvents = 'none';
            setTimeout(function() { loader.style.display = 'none'; }, 800);
        }
    });
</script>
<style>
    #loading-screen { transition: opacity 0.8s ease; }
</style>
