document.addEventListener('DOMContentLoaded', () => {
    const bgmToggle = document.getElementById('bgm-toggle');
    const bgmAudio = document.getElementById('global-bgm');

    if (!bgmToggle || !bgmAudio) return;

    // Check localStorage for user preference. Default is muted (true) 
    // so it doesn't suddenly blast music without them turning it on first.
    // If they previously turned it on, we'll try to autoplay.
    const isMuted = localStorage.getItem('bgm_muted') !== 'false';
    
    // Set initial state
    bgmAudio.muted = isMuted;
    bgmAudio.volume = 0.3; // 30% volume so it's not overpowering

    // Update icon visually
    updateIcon(isMuted);

    // Browsers block autoplay until user interaction, so we attempt it
    // and if it fails, we wait for ANY click on the document to start it (if not muted).
    if (!isMuted) {
        let playPromise = bgmAudio.play();
        if (playPromise !== undefined) {
            playPromise.catch(() => {
                // Autoplay blocked. We'll start on first interaction.
                document.addEventListener('click', () => {
                    if (localStorage.getItem('bgm_muted') === 'false') {
                        bgmAudio.play();
                    }
                }, { once: true });
            });
        }
    }

    // Toggle logic
    bgmToggle.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation(); // prevent document click from triggering
        
        const currentlyMuted = bgmAudio.muted;
        
        if (currentlyMuted) {
            bgmAudio.muted = false;
            bgmAudio.play();
            localStorage.setItem('bgm_muted', 'false');
            updateIcon(false);
        } else {
            bgmAudio.muted = true;
            bgmAudio.pause();
            localStorage.setItem('bgm_muted', 'true');
            updateIcon(true);
        }
    });

    function updateIcon(muted) {
        if (muted) {
            // Show muted (cross lines)
            bgmToggle.innerHTML = '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><line x1="23" y1="9" x2="17" y2="15"></line><line x1="17" y1="9" x2="23" y2="15"></line></svg>';
        } else {
            // Show unmuted (sound waves)
            bgmToggle.innerHTML = '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>';
        }
    }
});
