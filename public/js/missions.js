/* ============================================
   THE LOST COMPASS - MISSIONS PAGE LOGIC
   ============================================ */

let missions = []; // Loaded from API
let csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

// Base URL for API calls
const APP_BASE = window.APP_BASE || '';

const state = {
  selectedCategory: 'all',
  activeMission: null,
  activeScene: null,
  step: 0,
  history: [],
};

const historyKey = 'potc-mission-history';

const els = {
  cards: document.getElementById('mission-cards'),
  categoryFilters: document.getElementById('category-filters'),
  storyTitle: document.getElementById('story-title'),
  storyText: document.getElementById('story-text'),
  storyImage: document.getElementById('story-image'),
  choiceButtons: document.getElementById('choice-buttons'),
  resultPanel: document.getElementById('result-panel'),
  resultText: document.getElementById('result-text'),
  rewardPanel: document.getElementById('reward-panel'),
  rewardList: document.getElementById('reward-list'),
  completionActions: document.getElementById('completion-actions'),
  progressLabel: document.getElementById('progress-label'),
  progressFill: document.getElementById('progress-fill'),
  activeMissionName: document.getElementById('active-mission-name'),
  historyList: document.getElementById('history-list'),
  impactText: document.getElementById('impact-text'),
  
  // Loot Modal Elements
  lootModal: document.getElementById('loot-modal'),
  lootItems: document.getElementById('loot-items'),
  closeLootModalBtn: document.getElementById('close-loot-modal')
};

const bgmAudio = new Audio();
bgmAudio.loop = true;
bgmAudio.volume = 0.35;

function stars(level) {
  return '★'.repeat(level) + '☆'.repeat(Math.max(0, 3 - level));
}

function updateProgress() {
  const total = state.activeMission ? state.activeMission.maxSteps || 5 : 0;
  const step = state.activeMission ? Math.min(state.step, total) : 0;
  els.progressLabel.textContent = `Step ${step} of ${total}`;
  els.progressFill.style.width = total ? `${(step / total) * 100}%` : '0%';
}

function playSfx(path) {
  if (!path) return;
  const src = path.startsWith('http') || path.startsWith('/') ? path : '/' + path;
  const sfx = new Audio(src);
  sfx.volume = 0.45;
  sfx.play().catch(() => {});
}

function switchBgm(path) {
  if (!path) {
    bgmAudio.pause();
    return;
  }
  const src = path.startsWith('http') || path.startsWith('/') ? path : '/' + path;
  if (bgmAudio.src.endsWith(src)) {
    bgmAudio.play().catch(() => {});
    return;
  }
  bgmAudio.src = src;
  bgmAudio.play().catch(() => {});
}

function resetPanels() {
  els.activeMissionName.textContent = state.activeMission ? state.activeMission.title : 'No voyage selected';
  updateProgress();
  els.resultText.textContent = 'Your decisions shape the narrative.';
  els.impactText.textContent = '';
  els.rewardList.innerHTML = '';
  els.completionActions.innerHTML = '';
  renderChoices([]);
  renderHistory();
}

function setMood(mood) {
  document.body.dataset.mood = mood || 'neutral';
}

function filteredMissions() {
  if (state.selectedCategory === 'all') return missions;
  return missions.filter((m) => m.category === state.selectedCategory);
}

function renderMissionCards() {
  const data = filteredMissions();
  els.cards.innerHTML = '';

  data.forEach((mission) => {
    const card = document.createElement('article');
    card.className = `ms-card${state.activeMission && state.activeMission.id === mission.id ? ' active' : ''}`;
    card.innerHTML = `
      <img class="ms-card__img" src="${mission.image}" alt="${mission.title}">
      <div class="ms-card__body">
        <h3 class="ms-card__title">${mission.title}</h3>
        <div class="ms-card__meta">
          <span class="ms-card__difficulty">${stars(mission.difficulty)}</span>
          <span class="ms-card__reward">${mission.rewardText}</span>
        </div>
        <p class="ms-card__desc">${mission.summary}</p>
      </div>
    `;

    card.addEventListener('click', () => startMission(mission.db_id || mission.id));
    els.cards.appendChild(card);
  });
}

function updateStory(scene) {
  els.storyTitle.textContent = scene.title;
  els.storyText.textContent = scene.text;
  if (scene.image) {
    els.storyImage.src = scene.image;
  }
}

function renderChoices(choices) {
  els.choiceButtons.innerHTML = '';

  if (!choices || choices.length === 0) {
    const disabled = document.createElement('button');
    disabled.className = 'ms-btn ms-btn--choice ms-btn--disabled';
    disabled.disabled = true;
    disabled.textContent = 'No more choices';
    els.choiceButtons.appendChild(disabled);
    return;
  }

  choices.forEach((choice) => {
    const button = document.createElement('button');
    button.className = 'ms-btn ms-btn--choice';
    button.textContent = choice.label;
    button.addEventListener('click', () => handleChoice(choice));
    els.choiceButtons.appendChild(button);
  });
}

function renderRewards(rewards) {
  els.rewardList.innerHTML = '';
  if (!rewards) return;
  
  let rewardsArray = rewards;
  if (typeof rewards === 'string') {
      try {
          rewardsArray = JSON.parse(rewards);
      } catch (e) {
          rewardsArray = [rewards];
      }
  }

  if (Array.isArray(rewardsArray)) {
    rewardsArray.forEach((reward) => {
        const item = document.createElement('li');
        item.textContent = reward;
        els.rewardList.appendChild(item);
    });
  }
}

function renderCompletionActions(outcome) {
  els.completionActions.innerHTML = '';

  const retry = document.createElement('button');
  retry.className = 'ms-btn ms-btn--ghost';
  retry.textContent = 'Play Again';
  retry.addEventListener('click', () => {
    if (state.activeMission) {
      startMission(state.activeMission.db_id || state.activeMission.id);
    }
  });

  els.completionActions.appendChild(retry);

  const claimBtn = document.createElement('button');
  claimBtn.className = 'ms-btn ms-btn--primary';
  claimBtn.textContent = 'Claim Rewards';
  claimBtn.addEventListener('click', () => claimReward(claimBtn));
  
  els.completionActions.prepend(claimBtn);
}

// === ENGINE API CALLS ===

async function fetchMissions() {
    try {
        const response = await fetch(`${APP_BASE}/api/engine/missions`);
        missions = await response.json();
        renderMissionCards();
        checkUrlParams();
    } catch (e) {
        console.error("Failed to load missions", e);
    }
}

async function startMission(missionDbId) {
  const mission = missions.find((item) => item.db_id === missionDbId || item.db_id == missionDbId || item.id === missionDbId);
  if (!mission) {
    console.error('Mission not found for id:', missionDbId);
    return;
  }

  state.activeMission = mission;
  state.step = 1;
  resetPanels();

  setMood(mission.mood);
  switchBgm(mission.bgm);
  
  els.storyTitle.textContent = "Loading...";
  els.storyText.textContent = "Connecting to the compass...";
  els.choiceButtons.innerHTML = '';
  els.activeMissionName.textContent = mission.title;
  renderMissionCards();

  document.getElementById('mission-experience').scrollIntoView({ behavior: 'smooth' });

  try {
      const dbId = mission.db_id;
      if (!dbId) {
          els.storyText.textContent = 'Mission data error: missing DB id. Please refresh the page.';
          return;
      }
      const response = await fetch(`${APP_BASE}/api/engine/missions/${dbId}/load`);
      const scene = await response.json();

      if (response.ok) {
          processScene(scene);
      } else {
          els.storyText.textContent = "Failed to load mission. You might need to log in.";
      }
  } catch (e) {
      console.error(e);
      els.storyText.textContent = "Error loading mission.";
  }
}

async function handleChoice(choice) {
    if (!state.activeMission || !state.activeScene) return;

    playSfx(choice.sfx);
    els.resultText.textContent = choice.consequence || 'You made a choice...';
    
    state.step++;
    els.choiceButtons.innerHTML = '<button class="ms-btn ms-btn--choice ms-btn--disabled" disabled>Loading next scene...</button>';

    try {
        const dbId = state.activeMission.db_id;
        const response = await fetch(`${APP_BASE}/api/engine/missions/${dbId}/choice`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ choice_id: choice.id, current_scene_id: state.activeScene?.scene_id })
        });

        const scene = await response.json();
        if (response.ok) {
            processScene(scene);
        } else {
            els.resultText.textContent = "Error making choice.";
        }
    } catch (e) {
        console.error(e);
    }
}

function processScene(scene) {
    state.activeScene = scene;
    updateStory(scene);
    updateProgress();
    
    if (scene.is_ending) {
        els.progressFill.style.width = '100%';
        renderChoices([]);
        els.resultText.textContent = `${scene.title}: ${scene.text}`;

        renderRewards(scene.rewards);
        renderCompletionActions(scene.outcome);
        
        const now = new Date();
        saveHistory({
            title: state.activeMission.title,
            outcome: scene.outcome || 'completed',
            rewards: typeof scene.rewards === 'string' ? JSON.parse(scene.rewards) : scene.rewards,
            time: now.toLocaleString()
        });

    } else {
        renderChoices(scene.choices || []);
    }
}

async function claimReward(btn) {
    btn.disabled = true;
    btn.textContent = 'Claiming...';
    
    try {
        const dbId = state.activeMission.db_id || state.activeMission.id;
        const response = await fetch(`${APP_BASE}/api/engine/missions/${dbId}/claim`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        });

        const result = await response.json();
        if (response.ok) {
            btn.textContent = 'Claimed!';
            if (result.gained) {
                showLootOverlay(result.gained);
            }
        } else {
            btn.textContent = 'Already Claimed / Error';
        }
    } catch (e) {
        btn.textContent = 'Error Claiming';
    }
}

function showLootOverlay(gained) {
    els.lootItems.innerHTML = '';
    
    // Add Gold
    if (gained.gold) {
        els.lootItems.innerHTML += `
            <div class="ms-loot-item">
                <div class="ms-loot-item__icon"><img src="${APP_BASE}/assets/images/profile/icons/icon-gold-coin.png" alt="Gold"></div>
                <h4 class="ms-loot-item__val">+${gained.gold}</h4>
                <p class="ms-loot-item__label">Gold Pieces</p>
            </div>
        `;
    }
    
    // Add Rep
    if (gained.reputation) {
        els.lootItems.innerHTML += `
            <div class="ms-loot-item">
                <div class="ms-loot-item__icon"><img src="${APP_BASE}/assets/images/map/compass%20rose.png" alt="Reputation"></div>
                <h4 class="ms-loot-item__val">+${gained.reputation}</h4>
                <p class="ms-loot-item__label">Reputation</p>
            </div>
        `;
    }
    
    // Add Relics
    if (gained.relics && gained.relics.length > 0) {
        gained.relics.forEach(relic => {
            let imagePath = relic.image || 'relic-default.png';
            if (!imagePath.includes('/') && !imagePath.startsWith('http')) {
                imagePath = `assets/images/profile/relics/${imagePath}`;
            }
            const cleanPath = imagePath.startsWith('/') ? imagePath.substring(1) : imagePath;
            const imgSrc = imagePath.startsWith('http') ? imagePath : `${APP_BASE}/${cleanPath}`;
            
            els.lootItems.innerHTML += `
                <div class="ms-loot-item">
                    <div class="ms-loot-item__icon"><img src="${imgSrc}" alt="${relic.name}"></div>
                    <h4 class="ms-loot-item__val" style="font-size:0.9rem;">${relic.name}</h4>
                    <p class="ms-loot-item__label">${relic.rarity || 'Relic'}</p>
                </div>
            `;
        });
    }

    // Add Achievements
    if (gained.achievements && gained.achievements.length > 0) {
        gained.achievements.forEach(ach => {
            let iconPath = ach.icon || 'badge-default.png';
            if (!iconPath.includes('/') && !iconPath.startsWith('http')) {
                iconPath = `assets/images/profile/achievements/${iconPath}`;
            }
            const cleanPath = iconPath.startsWith('/') ? iconPath.substring(1) : iconPath;
            const imgSrc = iconPath.startsWith('http') ? iconPath : `${APP_BASE}/${cleanPath}`;
            
            els.lootItems.innerHTML += `
                <div class="ms-loot-item" style="border-color: #f0c030;">
                    <div class="ms-loot-item__icon"><img src="${imgSrc}" alt="${ach.title}"></div>
                    <h4 class="ms-loot-item__val" style="font-size:0.9rem;">${ach.title}</h4>
                    <p class="ms-loot-item__label">Achievement</p>
                </div>
            `;
        });
    }

    if (els.lootItems.innerHTML === '') {
        els.lootItems.innerHTML = '<p class="ms-loot-item__label">No substantial loot found.</p>';
    }

    els.lootModal.setAttribute('aria-hidden', 'false');
}

function saveHistory(entry) {
  state.history.unshift(entry);
  state.history = state.history.slice(0, 12);
  localStorage.setItem(historyKey, JSON.stringify(state.history));
  // If we have an API, the backend already saved it as a UserMission. 
  // We'll just re-render the local state so it shows up instantly.
  renderHistory();
}

function renderHistory() {
  els.historyList.innerHTML = '';
  
  let displayHistory = state.history;
  if (state.activeMission) {
      displayHistory = state.history.filter(entry => entry.title === state.activeMission.title);
  }

  if (!displayHistory.length) {
    if (state.activeMission) {
        els.historyList.innerHTML = '<li><span class="ms-log__time">Your logbook is empty for this voyage. Set sail!</span></li>';
    } else {
        els.historyList.innerHTML = '<li><span class="ms-log__time">Your logbook is empty. Set sail!</span></li>';
    }
    return;
  }

  displayHistory.forEach((entry) => {
    const li = document.createElement('li');
    li.innerHTML = `
      <div>
          <div class="ms-log__title">${entry.title}</div>
          <div class="ms-log__time">${entry.time} • ${(entry.rewards || []).join(', ')}</div>
      </div>
      <span class="ms-log__outcome ${entry.outcome}">${entry.outcome}</span>
    `;
    els.historyList.appendChild(li);
  });
}

async function initHistory() {
  try {
    const response = await fetch(`${APP_BASE}/api/engine/history`);
    if (response.ok) {
        const data = await response.json();
        state.history = data || [];
        renderHistory();
        return;
    }
  } catch (e) {
    console.log("Could not fetch history from API, falling back to local storage.");
  }

  // Fallback for guests
  try {
    const stored = JSON.parse(localStorage.getItem(historyKey) || '[]');
    if (Array.isArray(stored)) {
      state.history = stored;
    }
  } catch (_error) {
    state.history = [];
  }
  
  renderHistory();
}

function bindFilters() {
  if (!els.categoryFilters) return;
  
  els.categoryFilters.addEventListener('click', (event) => {
    const btn = event.target.closest('.ms-filter-btn');
    if (!btn) return;

    state.selectedCategory = btn.dataset.category;
    const buttons = els.categoryFilters.querySelectorAll('.ms-filter-btn');
    buttons.forEach((button) => button.classList.remove('active'));
    btn.classList.add('active');

    renderMissionCards();
  });
}

function bindModals() {
    if (els.closeLootModalBtn) {
        els.closeLootModalBtn.addEventListener('click', () => {
            els.lootModal.setAttribute('aria-hidden', 'true');
        });
    }
}

function checkUrlParams() {
    const params = new URLSearchParams(window.location.search);
    const locationFilter = params.get('location');
    const missionName = params.get('missionName');

    let targetMission = null;

    if (missionName) {
        targetMission = missions.find(m => m.title === missionName);
    } else if (locationFilter) {
        const locationMissionMap = {
            'tortuga': 'duel-tortuga',
            'port-royal': 'port-royal-ledger',
            'isla-muerta': 'aztec-coin',
            'shipwreck-cove': 'shipwreck-cove-court',
            'devils-triangle': 'devils-triangle-crossing',
            'kraken-depths': 'escape-kraken'
        };
        const mappedId = locationMissionMap[locationFilter];
        if (mappedId) {
            targetMission = missions.find(m => m.id === mappedId || m.slug === mappedId);
        }
    }

    if (targetMission) {
        setTimeout(() => {
            startMission(targetMission.db_id || targetMission.id);
        }, 500);
    }
}

function initMissionsPage() {
  initHistory();
  bindFilters();
  bindModals();
  resetPanels();
  
  fetchMissions();
}

document.addEventListener('DOMContentLoaded', initMissionsPage);
