/* ============================================
   TAVERN PAGE - JAVASCRIPT (FIXED)
   ============================================ */

// Initialize tavern page when DOM loads
document.addEventListener('DOMContentLoaded', function() {
    initTavernPage();
});

function initTavernPage() {
    // Setup loading screen
    setupLoadingScreen();
    
    // Setup modals
    setupModals();
    
    // Setup drink buttons
    setupDrinkButtons();
    
    // Setup story form
    setupStoryForm();
    
    // Setup rumor system
    setupRumorSystem();
    
    // Setup crew recruitment
    setupCrewRecruitment();
    
    // Setup interactions
    setupInteractions();
    
    // Setup sound toggle
    setupSoundToggle();
    
    // Setup scroll animations
    setupScrollAnimations();
    
    // Setup custom cursor
    setupCustomCursor();
    
    // Setup navigation
    setupNavigation();
    
    console.log('🏴‍☠️ Tavern Page Initialized!');
}

// ============================================
// LOADING SCREEN
// ============================================

function setupLoadingScreen() {
    window.addEventListener('load', function() {
        const loadingScreen = document.getElementById('loading-screen');
        if (loadingScreen) {
            setTimeout(() => {
                loadingScreen.style.transition = 'opacity 0.6s ease-out';
                loadingScreen.style.opacity = '0';
                setTimeout(() => {
                    loadingScreen.style.display = 'none';
                }, 600);
            }, 1500);
        }
    });
}

// ============================================
// MODAL MANAGEMENT
// ============================================

function setupModals() {
    const modals = {
        buyRum: document.getElementById('buy-rum-modal'),
        tellStory: document.getElementById('tell-story-modal'),
        hearRumor: document.getElementById('hear-rumor-modal'),
        recruitCrew: document.getElementById('recruit-crew-modal')
    };

    const openModal = (modal) => {
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    };

    const closeModal = (modal) => {
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    };

    // Close button handlers
    document.querySelectorAll('.modal-close').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const modal = btn.closest('.modal');
            closeModal(modal);
        });
    });

    // Outside click handlers
    Object.values(modals).forEach(modal => {
        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal(modal);
                }
            });
        }
    });

    // Button handlers
    const buyRumBtn = document.getElementById('btn-buy-rum');
    const tellStoryBtn = document.getElementById('btn-tell-story');
    const hearRumorBtn = document.getElementById('btn-hear-rumor');
    const recruitCrewBtn = document.getElementById('btn-recruit-crew');

    if (buyRumBtn) {
        buyRumBtn.addEventListener('click', (e) => {
            e.preventDefault();
            openModal(modals.buyRum);
        });
    }

    if (tellStoryBtn) {
        tellStoryBtn.addEventListener('click', (e) => {
            e.preventDefault();
            openModal(modals.tellStory);
        });
    }

    if (hearRumorBtn) {
        hearRumorBtn.addEventListener('click', (e) => {
            e.preventDefault();
            displayRandomRumor();
            openModal(modals.hearRumor);
        });
    }

    if (recruitCrewBtn) {
        recruitCrewBtn.addEventListener('click', (e) => {
            e.preventDefault();
            openModal(modals.recruitCrew);
        });
    }

    window.tavern = { openModal, closeModal, modals };
}

// ============================================
// RUM BUTTONS
// ============================================

function setupDrinkButtons() {
    document.querySelectorAll('.btn-drink').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const rumName = this.closest('.rum-card').querySelector('h4').textContent;
            showTavernNotification(`You bought ${rumName}! 🍺`);
            
            setTimeout(() => {
                if (window.tavern && window.tavern.modals.buyRum) {
                    window.tavern.closeModal(window.tavern.modals.buyRum);
                }
            }, 800);
        });
    });
}

// ============================================
// STORY FORM
// ============================================

function setupStoryForm() {
    const form = document.getElementById('story-form');
    const titleInput = document.getElementById('story-title');
    const contentInput = document.getElementById('story-content');
    const charCount = document.getElementById('char-count');

    if (contentInput) {
        contentInput.addEventListener('input', () => {
            const count = contentInput.value.length;
            if (charCount) {
                charCount.textContent = `${count}/500`;
                charCount.style.color = count > 400 ? 'var(--tavern-fire-orange)' : 'var(--tavern-smoky-gray)';
            }
        });
    }

    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const title = titleInput.value.trim();
            const content = contentInput.value.trim();
            
            if (title && content) {
                showTavernNotification('Your story has been posted! 📖');
                form.reset();
                if (charCount) charCount.textContent = '0/500';
                
                setTimeout(() => {
                    if (window.tavern) window.tavern.closeModal(window.tavern.modals.tellStory);
                }, 800);
            } else {
                showTavernNotification('Please fill in both fields! ⚠️');
            }
        });
    }
}

// ============================================
// RUMOR SYSTEM
// ============================================

const RUMORS = [
    { text: '"A ghost ship seen near Tortuga... The Black Pearl sails again!"', source: '— Mysterious Sailor' },
    { text: '"Treasure discovered in cursed caves. Fortune awaits the brave."', source: '— Captain Stormcaller' },
    { text: '"Barbossa recruiting crew for a daring heist. No cowards need apply."', source: '— Port Tavern Notice' },
    { text: '"The Kraken stirs... Ships missing near Devil\'s Triangle."', source: '— Dockside Whispers' },
    { text: '"Cursed gold found in sunken galleon. The curse claims three already."', source: '— Elderly Pirate' },
    { text: '"Jack Sparrow spotted in Port Royal. Chaos ensued."', source: '— Local News' },
    { text: '"A treasure map fragment was found. It leads somewhere unknown."', source: '— Mysterious Figure' },
    { text: '"The Flying Dutchman emerges from the mist at midnight."', source: '— Superstitious Sailor' }
];

function displayRandomRumor() {
    const rumor = RUMORS[Math.floor(Math.random() * RUMORS.length)];
    const textEl = document.getElementById('rumor-text');
    const sourceEl = document.getElementById('rumor-source');
    
    if (textEl) textEl.textContent = rumor.text;
    if (sourceEl) sourceEl.textContent = rumor.source;
}

function setupRumorSystem() {
    const nextBtn = document.getElementById('next-rumor-btn');
    if (nextBtn) {
        nextBtn.addEventListener('click', (e) => {
            e.preventDefault();
            displayRandomRumor();
        });
    }

    document.querySelectorAll('.rumor-card').forEach(card => {
        card.addEventListener('click', () => {
            const text = card.querySelector('.rumor-text').textContent;
            showTavernNotification(`${text.substring(0, 40)}...`);
        });
    });
}

// ============================================
// CREW RECRUITMENT
// ============================================

function setupCrewRecruitment() {
    const btn = document.getElementById('assemble-crew-btn');
    if (btn) {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            
            const selected = Array.from(document.querySelectorAll('.crew-card input:checked'))
                .map(cb => cb.closest('.crew-card').querySelector('h4').textContent);
            
            if (selected.length === 0) {
                showTavernNotification('Select at least one crew member! ⚓');
                return;
            }
            
            showTavernNotification(`Crew assembled: ${selected.join(', ')}! ⚓`);
            document.querySelectorAll('.crew-card input').forEach(cb => cb.checked = false);
            
            setTimeout(() => {
                if (window.tavern) window.tavern.closeModal(window.tavern.modals.recruitCrew);
            }, 800);
        });
    }
}

// ============================================
// INTERACTIONS
// ============================================

function setupInteractions() {
    // Discussion buttons
    document.querySelectorAll('.discussion-card').forEach(card => {
        const replyBtn = card.querySelector('.btn-reply');
        const reactBtn = card.querySelector('.btn-reaction');
        
        if (replyBtn) replyBtn.addEventListener('click', (e) => {
            e.preventDefault();
            showTavernNotification('Reply feature coming soon! 💬');
        });
        
        if (reactBtn) reactBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const match = reactBtn.textContent.match(/\d+/);
            const count = (parseInt(match ? match[0] : 0) || 0) + 1;
            reactBtn.textContent = `❤️ ${count}`;
            reactBtn.style.transform = 'scale(1.2)';
            setTimeout(() => reactBtn.style.transform = 'scale(1)', 200);
        });
    });

    // Notice cards
    document.querySelectorAll('.notice-card').forEach(card => {
        card.addEventListener('click', () => {
            const title = card.querySelector('h4').textContent;
            showTavernNotification(`Viewing: ${title}`);
        });
    });
}

// ============================================
// NOTIFICATIONS
// ============================================

function showTavernNotification(message) {
    const notif = document.createElement('div');
    notif.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        background: linear-gradient(135deg, rgba(196, 106, 45, 0.95), rgba(201, 164, 76, 0.9));
        color: white;
        padding: 15px 25px;
        border-radius: 8px;
        border: 2px solid var(--tavern-warm-gold);
        font-size: 1rem;
        font-family: 'Playfair Display', serif;
        z-index: 2000;
        animation: slideInRight 0.3s ease-out;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.6);
        max-width: 300px;
    `;
    notif.textContent = message;
    document.body.appendChild(notif);
    
    setTimeout(() => {
        notif.style.animation = 'slideOutRight 0.3s ease-out forwards';
        setTimeout(() => notif.remove(), 300);
    }, 3000);
}

// Add animation styles
const notifStyle = document.createElement('style');
notifStyle.textContent = `
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(400px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes slideOutRight {
        from { opacity: 1; transform: translateX(0); }
        to { opacity: 0; transform: translateX(400px); }
    }
`;
document.head.appendChild(notifStyle);

// ============================================
// SOUND TOGGLE
// ============================================

function setupSoundToggle() {
    const toggle = document.getElementById('tavern-sound-toggle');
    if (!toggle) return;
    
    let enabled = localStorage.getItem('tavernSound') !== 'false';
    
    if (!enabled) {
        toggle.classList.add('muted');
        toggle.innerHTML = '<span class="sound-icon">🔇</span>';
    }
    
    toggle.addEventListener('click', (e) => {
        e.preventDefault();
        enabled = !enabled;
        localStorage.setItem('tavernSound', enabled);
        
        toggle.classList.toggle('muted');
        toggle.innerHTML = enabled ? '<span class="sound-icon">🔊</span>' : '<span class="sound-icon">🔇</span>';
        showTavernNotification(enabled ? 'Tavern ambience enabled 🔊' : 'Tavern ambience disabled 🔇');
    });
}

// ============================================
// SCROLL ANIMATIONS
// ============================================

function setupScrollAnimations() {
    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) e.target.classList.add('visible');
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -100px 0px' });

    document.querySelectorAll('.reveal-on-scroll').forEach(el => observer.observe(el));

    window.addEventListener('scroll', () => {
        const glow = document.getElementById('tavern-glow');
        if (glow) {
            const pct = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
            glow.style.opacity = (0.1 + (pct / 100) * 0.2).toString();
        }
    });
}

// ============================================
// CUSTOM CURSOR
// ============================================

function setupCustomCursor() {
    const cursor = document.getElementById('cursor');
    const dot = document.getElementById('cursor-dot');
    if (!cursor || !dot) return;

    let x = 0, y = 0, cx = 0, cy = 0;
    
    document.addEventListener('mousemove', e => {
        x = e.clientX;
        y = e.clientY;
        dot.style.left = (x - 8) + 'px';
        dot.style.top = (y - 8) + 'px';
    }, { passive: true });
    
    function animate() {
        const dx = x - cx, dy = y - cy;
        if (Math.hypot(dx, dy) > 1) {
            cx += dx * 0.3;
            cy += dy * 0.3;
            cursor.style.left = (cx - 16) + 'px';
            cursor.style.top = (cy - 16) + 'px';
        }
        requestAnimationFrame(animate);
    }
    animate();
}

// ============================================
// NAVIGATION
// ============================================

function setupNavigation() {
    const toggle = document.getElementById('nav-toggle');
    const nav = document.getElementById('primary-navigation');
    
    if (toggle && nav) {
        toggle.addEventListener('click', () => {
            const open = nav.style.display === 'flex';
            nav.style.display = open ? 'none' : 'flex';
            toggle.setAttribute('aria-expanded', !open);
        });

        nav.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                nav.style.display = 'none';
                toggle.setAttribute('aria-expanded', 'false');
            });
        });
    }

    window.addEventListener('scroll', () => {
        const pos = window.scrollY;
        document.querySelectorAll('nav a[href*="#"]').forEach(link => {
            const id = link.getAttribute('href').substring(1);
            const section = document.getElementById(id);
            if (!section) return;
            
            const top = section.offsetTop - 100;
            const bottom = top + section.offsetHeight;
            
            if (pos >= top && pos < bottom) {
                document.querySelectorAll('nav a').forEach(a => a.classList.remove('active'));
                link.classList.add('active');
            }
        });
    });
}

// Console message
console.log('%c🏴‍☠️ Welcome to The Drunken Kraken Tavern! 🍺', 'color: #C9A44C; font-size: 16px; font-weight: bold;');
