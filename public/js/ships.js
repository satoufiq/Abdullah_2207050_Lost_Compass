const FALLBACK_SHIP_IMAGE = 'assets/images/home/f9006df007e36bc5e6931a31ff420a9db7b1ef3da2ea876ebe9f7f26688bac76._SX1080_FMjpg_.jpg';

// Smart base URL detection: use window.APP_BASE if valid, else auto-detect from current URL
(function detectAppBase() {
  const injected = (window.APP_BASE || '').trim();
  // Validate: injected value must match the current host
  if (injected && window.location.href.startsWith(injected)) {
    return; // already correct
  }
  // Auto-detect: find the path segment that contains our app entry point
  const path = window.location.pathname; // e.g. /lost-compass/public/ships
  const match = path.match(/^(.*?\/(?:public|index\.php))/);
  window.APP_BASE = match ? (window.location.origin + match[1]) : window.location.origin;
}());
const APP_BASE = window.APP_BASE || window.location.origin;


let ships = []; // Will be loaded from backend API

const shipsGrid = document.getElementById('ships-grid');
const shipResultText = document.getElementById('ship-result-text');
const filterButtons = document.querySelectorAll('.filter-btn');
const shipSort = document.getElementById('ship-sort');
const lightningFlash = document.getElementById('lightning-flash');

const shipModal = document.getElementById('ship-modal');
const modalBackdrop = document.getElementById('modal-backdrop');
const modalClose = document.getElementById('modal-close');
const shipModalImage = document.getElementById('ship-modal-image');
const shipModalName = document.getElementById('ship-modal-name');
const shipModalCaptain = document.getElementById('ship-modal-captain');
const shipModalHistory = document.getElementById('ship-modal-history');
const shipModalType = document.getElementById('ship-modal-type');
const shipModalWeapons = document.getElementById('ship-modal-weapons');
const shipModalCurse = document.getElementById('ship-modal-curse');
const shipModalFate = document.getElementById('ship-modal-fate');
const shipModalStats = document.getElementById('ship-modal-stats');
const modalWaterParticles = document.getElementById('modal-water-particles');

const navContainer = document.querySelector('.nav-container');
const navToggle = document.getElementById('nav-toggle');
const navLinks = document.querySelectorAll('.nav-menu a');
const loginBtn = document.querySelector('.login-btn');
const signupBtn = document.querySelector('.signup-btn');

let activeFilter = 'all';
let revealObserver;
let closeTimer = null;
let renderTimer = null;
let lightningTimer = null;
let toastTimer = null;

class LoadingScreenManager {
  constructor() {
    this.loadingScreen = document.getElementById('loading-screen');
  }

  hideLoadingScreen() {
    if (!this.loadingScreen) return;
    this.loadingScreen.style.animation = 'fadeOut 1s ease-out forwards';
    setTimeout(() => {
      this.loadingScreen.style.display = 'none';
    }, 1000);
  }
}

function ensureToast() {
  let toast = document.getElementById('action-toast');
  if (toast) return toast;
  toast = document.createElement('div');
  toast.id = 'action-toast';
  toast.className = 'action-toast';
  toast.setAttribute('role', 'status');
  toast.setAttribute('aria-live', 'polite');
  document.body.appendChild(toast);
  return toast;
}

function showToast(message) {
  const toast = ensureToast();
  toast.textContent = message;
  toast.classList.add('is-visible');
  if (toastTimer) clearTimeout(toastTimer);
  toastTimer = setTimeout(() => {
    toast.classList.remove('is-visible');
    toastTimer = null;
  }, 2200);
}

function createParticleField() {
  if (!modalWaterParticles) return;
  modalWaterParticles.innerHTML = '';
  for (let i = 0; i < 22; i += 1) {
    const particle = document.createElement('span');
    particle.style.left = `${Math.random() * 100}%`;
    particle.style.bottom = `${-20 - Math.random() * 80}px`;
    particle.style.animationDuration = `${4.2 + Math.random() * 4.8}s`;
    particle.style.animationDelay = `${Math.random() * 2.2}s`;
    particle.style.opacity = `${0.35 + Math.random() * 0.55}`;
    modalWaterParticles.appendChild(particle);
  }
}

function getSortedShips(list) {
  const sorted = [...list];
  const sortKey = shipSort.value;
  if (sortKey === 'legend') {
    sorted.sort((a, b) => b.legendRank - a.legendRank);
    return sorted;
  }
  sorted.sort((a, b) => b.stats[sortKey] - a.stats[sortKey]);
  return sorted;
}

function matchesFilter(ship) {
  if (activeFilter === 'all') return true;
  return ship.category.includes(activeFilter);
}

function createCardMarkup(ship) {
  return `
    <article class="ship-card" data-id="${ship.id}">
      <div class="ship-image-wrap">
        <img src="${ship.image}" alt="${ship.name}" data-fallback="${FALLBACK_SHIP_IMAGE}">
      </div>
      <div class="ship-card-body">
        <h3>${ship.name}</h3>
        <p class="ship-meta">Captain: ${ship.captain}</p>
        <p class="ship-rating">${ship.shortPower}</p>
        <div class="ship-actions">
          <button type="button" class="ship-btn" data-action="details" data-id="${ship.id}">View Details</button>
        </div>
      </div>
    </article>
  `;
}

function bindFallbackImages() {
  shipsGrid.querySelectorAll('img[data-fallback]').forEach(image => {
    image.addEventListener('error', () => {
      image.src = image.dataset.fallback;
    }, { once: true });
  });
}

function setupCardReveal() {
  const cards = document.querySelectorAll('.ship-card');
  if (revealObserver) revealObserver.disconnect();
  revealObserver = new IntersectionObserver(
    entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          revealObserver.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.14, rootMargin: '0px 0px -30px 0px' }
  );
  cards.forEach(card => revealObserver.observe(card));
}

function renderShips() {
  if (renderTimer) clearTimeout(renderTimer);
  shipsGrid.classList.add('is-refreshing');

  renderTimer = setTimeout(() => {
    const filtered = getSortedShips(ships.filter(matchesFilter));

    if (filtered.length === 0) {
      shipsGrid.innerHTML = '<article class="ship-card is-visible"><div class="ship-card-body"><h3>No Ships Found</h3><p class="ship-meta">Try a different category.</p></div></article>';
      shipResultText.textContent = 'Showing 0 legendary vessels';
      shipsGrid.classList.remove('is-refreshing');
      return;
    }

    shipsGrid.innerHTML = filtered.map(createCardMarkup).join('');
    shipResultText.textContent = `Showing ${filtered.length} legendary vessel${filtered.length === 1 ? '' : 's'}`;

    bindFallbackImages();
    setupCardReveal();

    requestAnimationFrame(() => {
      shipsGrid.classList.remove('is-refreshing');
    });
  }, 120);
}

function renderStatBar(label, value) {
  const percent = Math.max(0, Math.min(100, (value / 10) * 100));
  return `
    <div class="stat-row">
      <div class="stat-head">
        <span class="stat-label">${label}</span>
        <span class="stat-value">${value}/10</span>
      </div>
      <div class="stat-bar"><span class="stat-fill" style="width:${percent}%"></span></div>
    </div>
  `;
}

// Backend AJAX integration
async function fetchShipsData() {
  try {
    const response = await fetch(`${APP_BASE}/api/ships`);
    const data = await response.json();
    ships = data;
    renderShips();
  } catch (err) {
    console.error("Failed to load ships from API:", err);
    shipsGrid.innerHTML = '<p style="color:white;text-align:center;">Failed to load fleet data. The compass is spinning wildly!</p>';
  }
}

async function openShipModal(shipId) {
  // Show loading state while fetching detailed info
  shipModalName.textContent = "Loading logs...";
  shipModalHistory.textContent = "";
  shipModalStats.innerHTML = "";
  shipModal.hidden = false;
  shipModal.classList.add('is-open');

  try {
    const response = await fetch(`${APP_BASE}/api/ships/${shipId}`);
    const ship = await response.json();

    if (closeTimer) {
      clearTimeout(closeTimer);
      closeTimer = null;
    }

    shipModalImage.src = ship.image;
    shipModalImage.alt = ship.name;
    shipModalName.textContent = ship.name;
    shipModalCaptain.textContent = `Captain: ${ship.captain}`;
    shipModalHistory.textContent = ship.history;
    shipModalType.textContent = ship.type;
    shipModalWeapons.textContent = ship.weapons;
    shipModalCurse.textContent = ship.curse;
    shipModalFate.textContent = ship.fate;

    let missionsHtml = "";
    if (ship.missions && ship.missions.length > 0) {
        missionsHtml = `<div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid rgba(255, 255, 255, 0.1);">
            <h3 style="color: #c9a44c; font-size: 1.2rem; margin-bottom: 0.8rem; font-family: 'Cinzel', serif;">Related Missions</h3>
            <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.5rem;">
                ${ship.missions.map(m => `
                    <li style="background: rgba(0,0,0,0.3); padding: 0.6rem 0.8rem; border-radius: 4px; border-left: 2px solid #c9a44c;">
                        <strong style="color: #fff; display: block; font-size: 0.95rem;">${m.title}</strong>
                        <span style="color: rgba(255,255,255,0.6); font-size: 0.85rem;">${m.description}</span>
                    </li>
                `).join('')}
            </ul>
        </div>`;
    }

    shipModalStats.innerHTML = [
      renderStatBar('Speed', ship.stats.speed),
      renderStatBar('Attack', ship.stats.attack),
      renderStatBar('Defense', ship.stats.defense),
      renderStatBar('Curse Level', ship.stats.curse),
    ].join('') + missionsHtml;

    createParticleField();

    requestAnimationFrame(() => {
      shipModal.classList.add('is-open');
    });

    document.body.style.overflow = 'hidden';

  } catch (err) {
      console.error("Failed to fetch ship details", err);
      showToast("Unable to read captain's log for this vessel.");
      closeShipModal();
  }
}

function closeShipModal() {
  shipModal.classList.remove('is-open');
  if (closeTimer) clearTimeout(closeTimer);
  closeTimer = setTimeout(() => {
    shipModal.hidden = true;
    closeTimer = null;
  }, 240);
  document.body.style.overflow = '';
}

function initShipFilters() {
  filterButtons.forEach(button => {
    button.addEventListener('click', () => {
      activeFilter = button.dataset.filter;
      filterButtons.forEach(other => {
        const isActive = other === button;
        other.classList.toggle('is-active', isActive);
        other.setAttribute('aria-pressed', isActive ? 'true' : 'false');
      });
      renderShips();
    });
  });

  shipSort.addEventListener('change', () => {
    renderShips();
  });
}

function initGridInteractions() {
  shipsGrid.addEventListener('click', event => {
    const details = event.target.closest('[data-action="details"]');
    if (details) {
      openShipModal(details.dataset.id);
    }
  });
}

function initModalInteractions() {
  modalBackdrop.addEventListener('click', closeShipModal);
  modalClose.addEventListener('click', closeShipModal);
  document.addEventListener('keydown', event => {
    if (event.key === 'Escape' && !shipModal.hidden) closeShipModal();
  });
}

function triggerLightning() {
  if (!lightningFlash) return;
  lightningFlash.classList.add('is-active');
  setTimeout(() => lightningFlash.classList.remove('is-active'), 120);
  setTimeout(() => lightningFlash.classList.add('is-active'), 230);
  setTimeout(() => lightningFlash.classList.remove('is-active'), 320);
  const nextDelay = 5500 + Math.random() * 8500;
  lightningTimer = setTimeout(triggerLightning, nextDelay);
}

function initMobileNavigation() {
  if (!navContainer || !navToggle) return;
  const closeMenu = () => {
    navContainer.classList.remove('nav-open');
    navToggle.setAttribute('aria-expanded', 'false');
  };
  navToggle.addEventListener('click', () => {
    const isOpen = navContainer.classList.toggle('nav-open');
    navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
  });
  navLinks.forEach(link => {
    link.addEventListener('click', () => {
      if (window.innerWidth <= 900) closeMenu();
    });
  });
  window.addEventListener('resize', () => {
    if (window.innerWidth > 900) closeMenu();
  });
}

function initAuthButtons() {
  if (loginBtn) {
    loginBtn.addEventListener('click', () => showToast('Captain login opens in the next voyage update.'));
  }
  if (signupBtn) {
    signupBtn.addEventListener('click', () => showToast('Crew sign-up opens soon. Prepare your identity.'));
  }
}

function initFooterYear() {
  const yearSpan = document.getElementById('footer-year');
  if(yearSpan) yearSpan.textContent = String(new Date().getFullYear());
}

function initShipsPage() {
  const loadingManager = new LoadingScreenManager();

  initMobileNavigation();
  initAuthButtons();
  initShipFilters();
  initGridInteractions();
  initModalInteractions();
  initFooterYear();
  triggerLightning();

  // Load backend data
  fetchShipsData().then(() => {
      setTimeout(() => {
        loadingManager.hideLoadingScreen();
      }, 700);
  });
}

initShipsPage();
