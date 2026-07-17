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
    
    // Fetch dynamic data
    fetchRumors();
    fetchPosts();
    fetchLeaderboard();
    fetchNotices();
    
    // Setup story form
    setupStoryForm();
    
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
    const hideLoader = () => {
        const loadingScreen = document.getElementById('loading-screen');
        if (loadingScreen) {
            setTimeout(() => {
                loadingScreen.style.transition = 'opacity 0.6s ease-out';
                loadingScreen.style.opacity = '0';
                setTimeout(() => {
                    loadingScreen.style.display = 'none';
                }, 600);
            }, 1000);
        }
    };

    if (document.readyState === 'complete') {
        hideLoader();
    } else {
        window.addEventListener('load', hideLoader);
    }
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
                // Post the story via AJAX
                fetch(`${window.APP_BASE || ''}/api/tavern/posts`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    },
                    body: JSON.stringify({ title, content })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showTavernNotification('Your story has been posted! 📖');
                        form.reset();
                        if (charCount) charCount.textContent = '0/500';
                        
                        setTimeout(() => {
                            if (window.tavern) window.tavern.closeModal(window.tavern.modals.tellStory);
                        }, 800);

                        // Reload posts
                        fetchPosts();
                    } else if (data.error) {
                        showTavernNotification(data.error + ' ⚠️');
                    }
                })
                .catch(err => {
                    console.error('Error posting story:', err);
                    showTavernNotification('Failed to post story. Are you logged in? ⚠️');
                });
            } else {
                showTavernNotification('Please fill in both fields! ⚠️');
            }
        });
    }
}

// ============================================
// RUMOR SYSTEM
// ============================================

let activeRumors = [];

async function fetchRumors() {
    try {
        const response = await fetch(`${window.APP_BASE || ''}/api/tavern/rumors`);
        if (!response.ok) throw new Error('Failed to fetch rumors');
        
        activeRumors = await response.json();
        renderRumorBoard(activeRumors);
        
        // Also hook up the hear rumor modal
        const nextBtn = document.getElementById('next-rumor-btn');
        if (nextBtn) {
            nextBtn.addEventListener('click', (e) => {
                e.preventDefault();
                displayRandomRumor();
            });
        }
    } catch (e) {
        console.error(e);
    }
}

function renderRumorBoard(rumors) {
    const container = document.getElementById('rumor-board-container');
    if (!container) return;
    
    // Keep up to 5 rumors for the board
    const displayRumors = rumors.slice(0, 5);
    container.innerHTML = '';
    
    displayRumors.forEach((rumor, index) => {
        const pinHtml = `
            <div class="rumor-pin rumor-pin-${index + 1}">
                <div class="rumor-card" data-id="${rumor.id}">
                    <span class="rumor-icon">${rumor.icon || '👻'}</span>
                    <p class="rumor-text">${rumor.text}</p>
                    <span class="rumor-source">${rumor.source}</span>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', pinHtml);
    });

    // Reattach listeners
    container.querySelectorAll('.rumor-card').forEach(card => {
        card.addEventListener('click', () => {
            const text = card.querySelector('.rumor-text').textContent;
            showTavernNotification(`${text.substring(0, 40)}...`);
        });
    });
}

function displayRandomRumor() {
    if (activeRumors.length === 0) return;
    const rumor = activeRumors[Math.floor(Math.random() * activeRumors.length)];
    const textEl = document.getElementById('rumor-text');
    const sourceEl = document.getElementById('rumor-source');
    
    if (textEl) textEl.textContent = rumor.text;
    if (sourceEl) sourceEl.textContent = rumor.source;
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
// DYNAMIC FETCH & RENDER LOGIC
// ============================================

async function fetchPosts() {
    try {
        const response = await fetch(`${window.APP_BASE || ''}/api/tavern/posts`);
        if (!response.ok) throw new Error('Failed to fetch posts');
        
        const posts = await response.json();
        const container = document.getElementById('discussions-feed');
        if (!container) return;
        
        container.innerHTML = '';
        
        posts.forEach(post => {
            const html = `
                <div class="discussion-card reveal-on-scroll visible">
                    <div class="discussion-header">
                        <img src="${post.avatar}" alt="${post.author}" class="discussion-avatar">
                        <div class="discussion-user-info">
                            <h3 class="discussion-author">${post.author}</h3>
                            <span class="discussion-time">${post.time}</span>
                        </div>
                    </div>
                    <div class="discussion-content">
                        <h4 class="discussion-title">${post.title}</h4>
                        <p class="discussion-message">${post.message}</p>
                    </div>
                    <div class="discussion-footer">
                        <button class="btn-reply" data-id="${post.id}">💬 ${post.replies} Replies</button>
                        <button class="btn-reaction ${post.has_liked ? 'liked' : ''}" data-id="${post.id}">❤️ <span class="like-count">${post.likes}</span></button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        });

        // Reattach interaction listeners
        setupInteractions();
    } catch (e) {
        console.error(e);
    }
}

async function fetchLeaderboard() {
    try {
        const response = await fetch(`${window.APP_BASE || ''}/api/tavern/leaderboard`);
        if (!response.ok) throw new Error('Failed to fetch leaderboard');
        
        const leaderboard = await response.json();
        const container = document.getElementById('leaderboard-body');
        if (!container) return;
        
        container.innerHTML = '';
        
        leaderboard.forEach(entry => {
            const html = `
                <div class="leaderboard-row ${entry.class}">
                    <div class="rank-col">${entry.rank}</div>
                    <div class="captain-col">
                        <img src="${entry.avatar}" alt="${entry.name}" class="lb-avatar">
                        <span>${entry.name}</span>
                    </div>
                    <div class="reputation-col">${entry.rep}</div>
                    <div class="missions-col">${entry.missions}</div>
                    <div class="relics-col">${entry.relics}</div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        });
    } catch (e) {
        console.error(e);
    }
}

async function fetchNotices() {
    try {
        const response = await fetch(`${window.APP_BASE || ''}/api/tavern/notices`);
        if (!response.ok) throw new Error('Failed to fetch notices');
        
        const notices = await response.json();
        const container = document.getElementById('notices-container');
        if (!container) return;
        
        container.innerHTML = '';
        
        notices.forEach(notice => {
            const html = `
                <div class="notice-card reveal-on-scroll visible">
                    <img src="${window.APP_BASE || ''}/assets/images/tavern/wanted-posters/${notice.image}" alt="Wanted: ${notice.name}" class="notice-image">
                    <div class="notice-info">
                        <h4>${notice.name}</h4>
                        <p class="notice-reward">💰 Reward: ${notice.reward}</p>
                        <p class="notice-description">${notice.desc}</p>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        });
    } catch (e) {
        console.error(e);
    }
}

function setupInteractions() {
    // Post Reaction buttons
    document.querySelectorAll('.btn-reaction').forEach(btn => {
        // Prevent multiple bindings
        if (btn.dataset.bound) return;
        btn.dataset.bound = "true";
        
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const postId = btn.getAttribute('data-id');
            const likeCountSpan = btn.querySelector('.like-count');
            
            fetch(`${window.APP_BASE || ''}/api/tavern/posts/${postId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    likeCountSpan.textContent = data.likes;
                    if (data.action === 'liked') {
                        btn.classList.add('liked');
                    } else {
                        btn.classList.remove('liked');
                    }
                    
                    btn.style.transform = 'scale(1.2)';
                    setTimeout(() => btn.style.transform = 'scale(1)', 200);
                } else if (data.error) {
                    showTavernNotification(data.error + ' ⚠️');
                }
            })
            .catch(err => {
                console.error('Error toggling like:', err);
                showTavernNotification('Action failed. Are you logged in? ⚠️');
            });
        });
    });

    // Discussion Reply buttons
    document.querySelectorAll('.btn-reply').forEach(btn => {
        if (btn.dataset.bound) return;
        btn.dataset.bound = "true";
        
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            showTavernNotification('Reply feature coming soon! 💬');
        });
    });

    // Notice cards
    document.querySelectorAll('.notice-card').forEach(card => {
        if (card.dataset.bound) return;
        card.dataset.bound = "true";
        
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
