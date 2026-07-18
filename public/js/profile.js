/* ============================================
   PIRATE PROFILE PAGE - JAVASCRIPT
   ============================================ */

// Static profile data (will be replaced with quiz data later)
const userProfile = {
    name: "Captain Shahriar Stormcaller",
    title: "Navigator of the Shadow Tide",
    rank: "Pirate Captain",
    allegiance: "Independent",
    motto: "The sea holds no prisoners.",
    emblem: "compass-rose",
    reputation: 85,
    stats: {
        missionsCompleted: 12,
        goldEarned: 5250,
        relicsFound: 6,
        battlesWon: 8
    },
    currentShip: {
        name: "Black Pearl",
        speed: 9,
        power: 8,
        ability: "Shadow Navigation"
    },
    relics: [
        "relic-aztec-coin",
        "relic-kraken-tooth",
        "relic-cursed-compass",
        "relic-mermaid-locket",
        "relic-ghost-coin",
        "relic-black-pearl"
    ],
    achievements: [
        "badge-kraken-survivor",
        "badge-master-navigator",
        "badge-ghost-hunter",
        "badge-pirate-lord"
    ],
    missions: [
        { name: "Escape the Kraken", date: "2026-05-15", score: 95 },
        { name: "Duel at Tortuga", date: "2026-05-12", score: 88 },
        { name: "Recover the Aztec Coin", date: "2026-05-10", score: 92 },
        { name: "Ghost Hunter's Quest", date: "2026-05-08", score: 85 },
        { name: "Treasure of the South Seas", date: "2026-05-05", score: 90 }
    ]
};

// Initialize profile page when DOM loads
document.addEventListener('DOMContentLoaded', function() {
    initProfilePage();
});

function initProfilePage() {
    // Sync with relics page state stored in localStorage
    const savedRelics = localStorage.getItem('potc_relics_collected');
    if (savedRelics) {
        userProfile.relics = JSON.parse(savedRelics);
        userProfile.stats.relicsFound = userProfile.relics.length;
    }
    const savedDoubloons = localStorage.getItem('potc_doubloons');
    if (savedDoubloons) {
        userProfile.stats.goldEarned = 5250 + parseInt(savedDoubloons, 10);
    }

    setupLoadingScreen();
    populateProfileData();
    setupScrollAnimations();
    setupActionButtons();
    setupCustomCursor();
    setupNavigation();
    console.log('🏴‍☠️ Profile Page Initialized!');
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
// POPULATE PROFILE DATA
// ============================================

function populateProfileData() {
    // Hero identity card overrides removed to allow server-side rendering

    // Reputation bar animation (if it still exists)
    setTimeout(() => {
        const repFill = document.getElementById('reputation-fill');
        if(repFill) repFill.style.width = `${userProfile.reputation}%`;
    }, 500);

    // Statistics
    const elMissions = document.getElementById('stat-missions');
    if(elMissions) elMissions.textContent = userProfile.stats.missionsCompleted;
    
    const elGold = document.getElementById('stat-gold');
    if(elGold) elGold.textContent = userProfile.stats.goldEarned.toLocaleString();
    
    const elRelics = document.getElementById('stat-relics');
    if(elRelics) elRelics.textContent = userProfile.stats.relicsFound;
    
    const elBattles = document.getElementById('stat-battles');
    if(elBattles) elBattles.textContent = userProfile.stats.battlesWon;

    // Ship overrides removed

    // Animate ship stats
    setTimeout(() => {
        const speedFill = document.querySelector('.speed-fill');
        const powerFill = document.querySelector('.power-fill');
        if(speedFill) speedFill.style.width = `${(userProfile.currentShip.speed / 10) * 100}%`;
        if(powerFill) powerFill.style.width = `${(userProfile.currentShip.power / 10) * 100}%`;
    }, 1000);

    // Populate relics
    populateRelics();

    // Populate missions
    populateMissions();

    // Populate achievements
    populateAchievements();
}

// ============================================
// POPULATE RELICS
// ============================================

function populateRelics() {
    const inventory = document.getElementById('relic-inventory');
    inventory.innerHTML = '';

    userProfile.relics.forEach((relicId, index) => {
        const relicName = relicId.replace('relic-', '').replace('-', ' ').toUpperCase();
        
        const relicHTML = `
            <div class="relic-item reveal-on-scroll" style="animation-delay: ${index * 0.1}s">
                <div class="relic-card" data-relic="${relicId}">
                    <img src="assets/images/profile/relics/${relicId}.png" alt="${relicName}" class="relic-image">
                    <div class="relic-tooltip">${relicName}</div>
                </div>
            </div>
        `;
        
        inventory.insertAdjacentHTML('beforeend', relicHTML);
    });

    setupRelicInteractions();
}

// ============================================
// SETUP RELIC INTERACTIONS
// ============================================

function setupRelicInteractions() {
    document.querySelectorAll('.relic-card').forEach(card => {
        card.addEventListener('click', function(e) {
            e.preventDefault();
            const relicId = this.dataset.relic;
            showRelicDetails(relicId);
        });

        card.addEventListener('mouseenter', function() {
            this.style.zIndex = '10';
        });
    });
}

function showRelicDetails(relicId) {
    const relicName = relicId.replace('relic-', '').replace(/-/g, ' ');
    showProfileNotification(`You're admiring the ${relicName}! 💎`);
}

// ============================================
// POPULATE MISSIONS
// ============================================

function populateMissions() {
    const missionList = document.getElementById('mission-list');
    missionList.innerHTML = '';

    userProfile.missions.forEach((mission, index) => {
        const missionHTML = `
            <div class="mission-item reveal-on-scroll" style="animation-delay: ${index * 0.1}s">
                <div class="mission-status completed">✓</div>
                <div class="mission-details">
                    <h3 class="mission-name">${mission.name}</h3>
                    <p class="mission-date">${formatDate(mission.date)}</p>
                    <div class="mission-score">
                        <span class="score-label">Score:</span>
                        <span class="score-value">${mission.score} / 100</span>
                    </div>
                </div>
            </div>
        `;
        
        missionList.insertAdjacentHTML('beforeend', missionHTML);
    });

    setupMissionInteractions();
}

// ============================================
// SETUP MISSION INTERACTIONS
// ============================================

function setupMissionInteractions() {
    document.querySelectorAll('.mission-item').forEach(item => {
        item.addEventListener('click', function() {
            const missionName = this.querySelector('.mission-name').textContent;
            showProfileNotification(`Mission: ${missionName} 📖`);
        });

        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(10px)';
        });

        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });
}

// ============================================
// POPULATE ACHIEVEMENTS
// ============================================

function populateAchievements() {
    const grid = document.getElementById('achievements-grid');
    grid.innerHTML = '';

    const achievementDetails = {
        'badge-kraken-survivor': {
            name: 'Kraken Survivor',
            desc: 'Survived an encounter with the legendary Kraken'
        },
        'badge-master-navigator': {
            name: 'Master Navigator',
            desc: 'Successfully navigated through treacherous waters'
        },
        'badge-ghost-hunter': {
            name: 'Ghost Hunter',
            desc: 'Confronted and defeated supernatural threats'
        },
        'badge-pirate-lord': {
            name: 'Pirate Lord',
            desc: 'Achieved the highest rank among all pirates'
        }
    };

    userProfile.achievements.forEach((badgeId, index) => {
        const detail = achievementDetails[badgeId];
        
        const badgeHTML = `
            <div class="achievement-item reveal-on-scroll" style="animation-delay: ${index * 0.1}s">
                <div class="achievement-badge">
                    <img src="assets/images/profile/achievements/${badgeId}.png" alt="${detail.name}" class="badge-image">
                    <div class="achievement-tooltip">
                        <h4>${detail.name}</h4>
                        <p>${detail.desc}</p>
                    </div>
                </div>
            </div>
        `;
        
        grid.insertAdjacentHTML('beforeend', badgeHTML);
    });

    setupAchievementInteractions();
}

// ============================================
// SETUP ACHIEVEMENT INTERACTIONS
// ============================================

function setupAchievementInteractions() {
    document.querySelectorAll('.achievement-badge').forEach(badge => {
        badge.addEventListener('click', function() {
            const img = this.querySelector('.badge-image');
            const alt = img.alt;
            showProfileNotification(`🏆 ${alt}`);
        });
    });
}

// ============================================
// ACTION BUTTONS
// ============================================

function setupActionButtons() {
    document.querySelectorAll('.action-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const text = this.querySelector('.action-text').textContent;
            handleActionButton(text, this);
        });
    });
}

function handleActionButton(action, button) {
    const actions = {
        'CHANGE EMBLEM': () => {
            showProfileNotification('🎭 Emblem customization coming soon!');
        },
        'EDIT MOTTO': () => {
            const newMotto = prompt('Enter your new pirate motto:', userProfile.motto);
            if (newMotto) {
                userProfile.motto = newMotto;
                document.getElementById('pirate-motto').textContent = `"${newMotto}"`;
                showProfileNotification('✍️ Motto updated! ' + newMotto);
            }
        },
        'RETAKE QUIZ': () => {
            if (confirm('Retake the pirate identity quiz?')) {
                window.location.href = 'quiz.html';
            }
        },
        'EXPORT PROFILE': () => {
            exportProfile();
        }
    };

    if (actions[action]) {
        actions[action]();
        button.style.transform = 'scale(0.95)';
        setTimeout(() => {
            button.style.transform = 'scale(1)';
        }, 100);
    }
}

// ============================================
// EXPORT PROFILE
// ============================================

function exportProfile() {
    const profileText = `
=================================================
PIRATE PROFILE EXPORT
=================================================

NAME: ${userProfile.name}
TITLE: ${userProfile.title}
RANK: ${userProfile.rank}
ALLEGIANCE: ${userProfile.allegiance}
REPUTATION: ${userProfile.reputation}/100

=================================================
STATISTICS
=================================================
Missions Completed: ${userProfile.stats.missionsCompleted}
Gold Earned: ${userProfile.stats.goldEarned}
Relics Found: ${userProfile.stats.relicsFound}
Battles Won: ${userProfile.stats.battlesWon}

=================================================
CURRENT COMMAND
=================================================
Ship: ${userProfile.currentShip.name}
Speed: ${userProfile.currentShip.speed}/10
Power: ${userProfile.currentShip.power}/10
Ability: ${userProfile.currentShip.ability}

=================================================
ACHIEVEMENTS
=================================================
Total Badges: ${userProfile.achievements.length}

=================================================
MOTTO
=================================================
"${userProfile.motto}"

=================================================
Generated at: ${new Date().toLocaleString()}
=================================================
    `;

    const blob = new Blob([profileText], { type: 'text/plain' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `${userProfile.name.replace(/\s+/g, '_')}_Profile.txt`;
    document.body.appendChild(a);
    a.click();
    window.URL.revokeObjectURL(url);
    document.body.removeChild(a);

    showProfileNotification('📥 Profile exported!');
}

// ============================================
// NOTIFICATIONS
// ============================================

function showProfileNotification(message) {
    const notif = document.createElement('div');
    notif.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        background: linear-gradient(135deg, rgba(201, 164, 76, 0.95), rgba(216, 195, 165, 0.9));
        color: #2C1A12;
        padding: 15px 25px;
        border-radius: 8px;
        border: 2px solid #C9A44C;
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

// ============================================
// SCROLL ANIMATIONS
// ============================================

function setupScrollAnimations() {
    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -100px 0px' });

    document.querySelectorAll('.reveal-on-scroll').forEach(el => observer.observe(el));

    // Cabin glow animation based on scroll
    window.addEventListener('scroll', () => {
        const glow = document.getElementById('cabin-glow');
        if (glow) {
            const pct = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
            glow.style.opacity = (0.08 + (pct / 100) * 0.12).toString();
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
}

// ============================================
// UTILITY FUNCTIONS
// ============================================

function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('en-US', options);
}

// Console message
console.log('%c🏴‍☠️ Your Pirate Legend Awaits! 🗺️', 'color: #C9A44C; font-size: 16px; font-weight: bold;');
console.log('%cProfile System Ready for Quiz Integration', 'color: #D8C3A5; font-size: 12px;');

// Add CSS animations to document
const profileAnimations = document.createElement('style');
profileAnimations.textContent = `
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(400px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes slideOutRight {
        from { opacity: 1; transform: translateX(0); }
        to { opacity: 0; transform: translateX(400px); }
    }
`;
document.head.appendChild(profileAnimations);
