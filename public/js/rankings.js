/* ============================================
   HALL OF LEGENDS (RANKINGS) - JAVASCRIPT
   ============================================ */

class LegendsLeaderboard {
  constructor() {
    this.captains = [];
    this.searchQuery = '';
    this.activeTab = 'all';

    this.init();
  }

  async init() {
    this.setupEventListeners();
    this.createParticles();
    this.animateOnScroll();
    
    // Load data dynamically
    await this.fetchStatistics();
    await this.fetchHallOfFame();
    await this.fetchUserRank();
    await this.fetchLeaderboardData();
  }

  setupEventListeners() {
    // Search input
    const searchInput = document.getElementById('leaderboard-search');
    if (searchInput) {
      searchInput.addEventListener('input', (e) => {
        this.searchQuery = e.target.value.toLowerCase();
        this.renderTable();
      });
    }

    // Leaderboard Tabs
    document.querySelectorAll('.tab-btn').forEach(btn => {
      btn.addEventListener('click', async (e) => {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        e.target.classList.add('active');
        this.activeTab = e.target.dataset.tab;
        await this.fetchLeaderboardData();
      });
    });

    // Modal controls
    const modal = document.getElementById('captain-modal');
    const modalOverlay = document.getElementById('captain-modal-overlay');
    const closeBtn = document.getElementById('captain-modal-close');

    if (closeBtn) {
      closeBtn.addEventListener('click', () => this.closeModal());
    }
    if (modalOverlay) {
      modalOverlay.addEventListener('click', () => this.closeModal());
    }
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') this.closeModal();
    });
  }
  
  async fetchStatistics() {
      try {
          const res = await fetch('/api/legends/statistics');
          if (res.ok) {
              const data = await res.json();
              document.getElementById('stat-total-pirates').textContent = data.total_users;
              document.getElementById('stat-total-missions').textContent = data.total_missions;
              document.getElementById('stat-total-relics').textContent = data.total_relics;
              document.getElementById('stat-total-gold').textContent = data.total_gold.toLocaleString();
          }
      } catch (e) {
          console.error("Failed to load statistics", e);
      }
  }
  
  async fetchHallOfFame() {
      try {
          const res = await fetch('/api/legends/hall-of-fame');
          if (res.ok) {
              const data = await res.json();
              const grid = document.getElementById('hall-of-fame-grid');
              if (grid) {
                  grid.innerHTML = '';
                  data.forEach(plaque => {
                      const div = document.createElement('div');
                      div.className = 'fame-plaque scroll-fade-in';
                      div.innerHTML = `
                          <div class="plaque-glow"></div>
                          <div class="plaque-medal ${plaque.medal_class}">${plaque.icon}</div>
                          <h3 class="plaque-title">${plaque.title}</h3>
                          <p class="plaque-desc">${plaque.description}</p>
                          <div class="plaque-holder">Holder: <strong>${plaque.holder}</strong></div>
                      `;
                      grid.appendChild(div);
                  });
              }
          }
      } catch (e) {
          console.error("Failed to load hall of fame", e);
      }
  }
  
  async fetchUserRank() {
      try {
          const res = await fetch('/api/legends/user-rank');
          if (res.ok) {
              const data = await res.json();
              
              // Only update if elements exist (in case user isn't logged in properly or DOM changed)
              const repEl = document.getElementById('user-spotlight-rep');
              if (repEl) {
                  repEl.textContent = data.reputation.toLocaleString(); // using reputation to match the label
                  
                  const relicsEl = document.getElementById('user-spotlight-relics');
                  if (relicsEl) relicsEl.textContent = `${data.relics} / 18`;
                  
                  const goldEl = document.getElementById('user-spotlight-gold');
                  if (goldEl) goldEl.textContent = data.gold.toLocaleString();
                  
                  document.getElementById('user-rank-badge').textContent = `Rank #${data.rank}`;
                  
                  // Update tiers logic dynamically if needed, 
                  // For now simple display mapping
                  let currentTier = 'Navigator';
                  let nextTier = 'Pirate Lord';
                  let baseThreshold = 0;
                  let nextThreshold = data.next_rank_points;

                  document.getElementById('current-tier').textContent = currentTier;
                  document.getElementById('next-tier').textContent = nextTier;

                  // Progress Bar Animation
                  setTimeout(() => {
                    const progressBar = document.getElementById('spotlight-progress-fill');
                    if (progressBar && data.next_rank_points > 0) {
                      const range = data.points_needed; // Just showing a visual relative
                      const progress = data.score;
                      const pct = Math.min((progress / (progress + range)) * 100, 100);
                      progressBar.style.width = `${pct}%`;
                    }
                  }, 400);

                  // Progress hint
                  const hint = document.getElementById('progress-hint-text');
                  if (hint) {
                    if (data.points_needed > 0) {
                      hint.textContent = `Earn ${data.points_needed} more points to overtake Rank #${data.rank - 1}.`;
                    } else {
                      hint.textContent = `You are at the top of the world!`;
                    }
                  }
              }
          }
      } catch (e) {
          console.error("Failed to load user rank", e);
      }
  }

  async fetchLeaderboardData() {
      try {
          const res = await fetch(`/api/legends/leaderboard?category=${this.activeTab}`);
          if (res.ok) {
              this.captains = await res.json();
              if (this.activeTab === 'all') {
                  this.renderTriumvirate();
              }
              this.renderTable();
          }
      } catch (e) {
          console.error("Failed to load leaderboard data", e);
      }
  }

  renderTable() {
    const tbody = document.getElementById('leaderboard-tbody');
    if (!tbody) return;
    tbody.innerHTML = '';

    // Filter by search query
    const filtered = this.captains.filter(c => 
      c.name.toLowerCase().includes(this.searchQuery) ||
      c.title.toLowerCase().includes(this.searchQuery)
    );

    filtered.forEach((captain, index) => {
      // True rank is derived from index since API returns sorted data
      const trueRank = index + 1;
      
      const tr = document.createElement('tr');
      
      // Highlight rows for top 3
      if (trueRank === 1) tr.className = 'row-rank-1';
      else if (trueRank === 2) tr.className = 'row-rank-2';
      else if (trueRank === 3) tr.className = 'row-rank-3';

      if (captain.id.startsWith('user-') && captain.id === `user-${document.body.dataset.userId || ''}`) {
        tr.classList.add('row-user-current');
      }

      // Rank badge rendering
      let rankHTML = `<span class="rank-badge-item">${trueRank}</span>`;
      if (trueRank === 1) rankHTML = `<span class="rank-badge-item first">🥇</span>`;
      else if (trueRank === 2) rankHTML = `<span class="rank-badge-item second">🥈</span>`;
      else if (trueRank === 3) rankHTML = `<span class="rank-badge-item third">🥉</span>`;

      // Use score as default display for rep column if "all" tab is selected, otherwise rep
      let displayPoints = this.activeTab === 'all' ? captain.score : captain.reputation;
      let displayPointsLabel = this.activeTab === 'all' ? 'pts (Combined)' : 'Reputation';

      tr.innerHTML = `
        <td class="col-rank" data-label="Rank">${rankHTML}</td>
        <td class="col-captain" data-label="Captain">
          <div class="captain-td-cell">
            <img src="${captain.emblem}" alt="emblem" class="captain-table-emblem" onerror="this.src='assets/images/profile/emblems/skull-crossbones.png'">
            <div class="captain-table-info">
              <span class="captain-table-name">${captain.name}</span>
              <span class="captain-table-title">${captain.title}</span>
            </div>
          </div>
        </td>
        <td class="col-rep" data-label="Reputation"><span class="rep-text text-gold">${displayPoints.toLocaleString()} ${displayPointsLabel}</span></td>
        <td class="col-missions" data-label="Missions">${captain.missions} Completed</td>
        <td class="col-relics" data-label="Relics">${captain.relics} / 18</td>
        <td class="col-gold" data-label="Gold"><span class="text-gold">💰 ${captain.gold.toLocaleString()}</span></td>
        <td class="col-action"><button class="btn-table-action" type="button">Details</button></td>
      `;

      // Event listener for details button
      tr.querySelector('.btn-table-action').addEventListener('click', () => {
        this.openModal(captain);
      });

      tbody.appendChild(tr);
    });
  }

  renderTriumvirate() {
    const container = document.getElementById('triumvirate-container');
    if (!container) return;
    
    // We expect this.captains to be sorted by score desc since it's the 'all' tab.
    const top3 = this.captains.slice(0, 3);
    if (top3.length === 0) return;

    // Ordered visually as: 2nd, 1st, 3rd
    const podiumOrder = [];
    if (top3[1]) podiumOrder.push({ captain: top3[1], rank: 2, class: 'silver', roman: 'II', style: 'barbossa' });
    if (top3[0]) podiumOrder.push({ captain: top3[0], rank: 1, class: 'gold-plinth', textClass: 'gold-text', roman: 'I', style: 'sparrow' });
    if (top3[2]) podiumOrder.push({ captain: top3[2], rank: 3, class: 'bronze', textClass: 'bronze-text', roman: 'III', style: 'davy-jones' });

    let html = '';
    podiumOrder.forEach(item => {
        const c = item.captain;
        // determine aesthetic details
        let crown = item.rank === 1 ? '<div class="statue-crown-holder">👑</div>' : '';
        let glowClass = item.rank === 1 ? 'gold' : (item.rank === 3 ? 'blue' : '');
        let stoneEffectClass = item.rank === 1 ? 'gold-tint' : (item.rank === 3 ? 'blue-tint' : '');
        let textClass = item.textClass ? item.textClass : item.class;
        
        let avatarSrc = c.emblem && !c.emblem.includes('skull-crossbones') ? c.emblem : 'assets/images/home/jack sparrow.jpg';

        html += `
            <div class="statue-podium ${item.style} scroll-fade-in" id="statue-podium-${item.rank}">
                ${crown}
                <div class="statue-wrapper">
                    <div class="statue-glow ${glowClass}"></div>
                    <img src="${c.emblem}" alt="${c.name} Statue" class="statue-img" onerror="this.src='assets/images/profile/emblems/skull-crossbones.png'">
                    <div class="statue-stone-effect ${stoneEffectClass}"></div>
                </div>
                <div class="plinth ${item.class}">
                    <div class="plinth-rank ${textClass}">${item.roman}</div>
                    <h3 class="plinth-name">${c.name}</h3>
                    <p class="plinth-title">${c.title}</p>
                </div>
                <div class="statue-info-scroll">
                    <h4>${c.name}</h4>
                    <ul>
                        <li><strong>Flagship:</strong> ${c.flagship}</li>
                        <li><strong>Missions:</strong> ${c.missions} Completed</li>
                        <li><strong>Relics:</strong> ${c.relics} Collected</li>
                        <li><strong>Gold:</strong> ${c.gold.toLocaleString()} Doubloons</li>
                    </ul>
                </div>
            </div>
        `;
    });

    container.innerHTML = html;
  }

  openModal(captain) {
    const modal = document.getElementById('captain-modal');
    const modalBody = document.getElementById('captain-modal-body');
    if (!modal || !modalBody) return;

    modalBody.innerHTML = `
      <div class="modal-profile-header">
        <img src="${captain.emblem}" alt="Emblem" class="modal-profile-emblem" onerror="this.src='assets/images/profile/emblems/skull-crossbones.png'">
        <div class="modal-profile-names">
          <h3>${captain.name}</h3>
          <p>${captain.title}</p>
        </div>
      </div>
      <div class="modal-profile-grid">
        <div class="modal-profile-section">
          <h4>Vessel Info</h4>
          <p><strong>Flagship:</strong> ${captain.flagship}</p>
          <p><strong>Allegiance:</strong> ${captain.allegiance}</p>
        </div>
        <div class="modal-profile-section">
          <h4>Rank Stats</h4>
          <p><strong>Combined Score:</strong> ${captain.score.toLocaleString()} pts</p>
          <p><strong>Reputation:</strong> ${captain.reputation.toLocaleString()} pts</p>
          <p><strong>Missions:</strong> ${captain.missions} Completed</p>
          <p><strong>Relics Found:</strong> ${captain.relics} / 18</p>
          <p><strong>Treasure gold:</strong> 💰 ${captain.gold.toLocaleString()}</p>
        </div>
        <div class="modal-profile-section" style="grid-column: span 2;">
          <h4>Captain Biography</h4>
          <p>${captain.bio}</p>
        </div>
        <div class="modal-profile-motto">
          "${captain.motto}"
        </div>
      </div>
    `;

    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  closeModal() {
    const modal = document.getElementById('captain-modal');
    if (modal) {
      modal.classList.remove('active');
      document.body.style.overflow = 'auto';
    }
  }

  createParticles() {
    const container = document.getElementById('hall-particles');
    if (!container) return;

    const count = 30;
    for (let i = 0; i < count; i++) {
      const p = document.createElement('div');
      p.className = 'hall-particle';
      p.style.left = Math.random() * 100 + '%';
      p.style.setProperty('--drift-x', `${(Math.random() - 0.5) * 150}px`);
      p.style.animationDelay = (Math.random() * 12) + 's';
      p.style.animationDuration = (8 + Math.random() * 6) + 's';
      container.appendChild(p);
    }
  }

  animateOnScroll() {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
        }
      });
    }, { threshold: 0.1 });

    document.querySelectorAll('.statue-podium, .fame-plaque, .spotlight-card, .table-wrapper').forEach(el => {
      el.classList.add('scroll-fade-in');
      observer.observe(el);
    });
  }
}

// INITIALIZE WHEN DOM IS READY
document.addEventListener('DOMContentLoaded', () => {
  // Hide loading screen
  const loadingScreen = document.getElementById('loading-screen');
  if (loadingScreen) {
    setTimeout(() => {
      loadingScreen.style.opacity = '0';
      loadingScreen.style.pointerEvents = 'none';
    }, 1000);
  }

  // Initialize Leaderboard
  new LegendsLeaderboard();
});
