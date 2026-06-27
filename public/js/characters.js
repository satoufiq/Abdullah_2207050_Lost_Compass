const FALLBACK_CHARACTER_IMAGE = 'assets/images/home/new images/crew showcase.jpeg';

// Base URL injected by Blade layout (supports XAMPP subpath like /lost-compass/public)
const APP_BASE = window.APP_BASE || '';

let charactersCache = [];
let isFetching = false;

const grid = document.getElementById('character-grid');
const searchInput = document.getElementById('character-search');
const filterButtons = document.querySelectorAll('.filter-btn');
const resultsText = document.getElementById('results-text');

const modal = document.getElementById('character-modal');
const modalBackdrop = document.getElementById('modal-backdrop');
const modalClose = document.getElementById('modal-close');
const modalImage = document.getElementById('modal-image');
const modalName = document.getElementById('modal-name');
const modalRole = document.getElementById('modal-role');
const modalQuote = document.getElementById('modal-quote');
const modalBio = document.getElementById('modal-bio');
const modalShip = document.getElementById('modal-ship');
const modalWeapon = document.getElementById('modal-weapon');
const modalAppearance = document.getElementById('modal-appearance');
const modalCategory = document.getElementById('modal-category');
const modalAllies = document.getElementById('modal-allies');
const modalEnemies = document.getElementById('modal-enemies');

const navContainer = document.querySelector('.nav-container');
const navToggle = document.getElementById('nav-toggle');
const navLinks = document.querySelectorAll('.nav-menu a');
const loginBtn = document.querySelector('.login-btn');
const signupBtn = document.querySelector('.signup-btn');

let activeFilter = 'all';
let revealObserver;
let renderTimer = null;
let modalCloseTimer = null;
let actionToastTimer = null;

class LoadingScreenManager {
  constructor() {
    this.loadingScreen = document.getElementById('loading-screen');
  }

  hideLoadingScreen() {
    if (!this.loadingScreen) {
      return;
    }

    this.loadingScreen.style.animation = 'fadeOut 1s ease-out forwards';
    setTimeout(() => {
      this.loadingScreen.style.display = 'none';
    }, 1000);
  }
}

function normalizeForSearch(value) {
  return String(value || '')
    .toLowerCase()
    .normalize('NFKD')
    .replace(/[\u0300-\u036f]/g, '')
    .replace(/[^a-z0-9\s]/g, ' ')
    .replace(/\s+/g, ' ')
    .trim();
}

function titleCaseFromSlug(slug) {
  return slug
    .split('-')
    .map(part => part.charAt(0).toUpperCase() + part.slice(1))
    .join(' ');
}

function matchesFilter(character) {
  if (activeFilter === 'all') {
    return true;
  }
  return character.category === activeFilter || character.tags.includes(activeFilter);
}

function matchesSearch(character, query) {
  const normalizedQuery = normalizeForSearch(query);
  if (!normalizedQuery) {
    return true;
  }

  const haystack = normalizeForSearch([
    character.name,
    character.id,
    character.role,
    character.category,
    ...character.tags,
    character.shortLine,
    character.biography,
    character.ship,
    character.weapon,
    character.firstAppearance,
    ...character.allies,
    ...character.enemies,
  ].join(' '));

  const terms = normalizedQuery.split(' ').filter(Boolean);
  return terms.every(term => haystack.includes(term));
}

function buildCard(character) {
  const portrait = character.imageNeeded ? FALLBACK_CHARACTER_IMAGE : character.image;
  const pendingNote = character.imageNeeded
    ? '<p class="card-asset-note">Portrait pending archival restoration.</p>'
    : '';

  return `
    <article class="character-card" data-id="${character.id}">
      <div class="card-image">
        <img src="${portrait}" alt="${character.name}" data-fallback="${FALLBACK_CHARACTER_IMAGE}">
      </div>
      <div class="card-content">
        <h3 class="card-name">${character.name}</h3>
        <p class="card-role">${character.role}</p>
        <p class="card-line">${character.shortLine}</p>
        ${pendingNote}
        <button type="button" class="view-more-btn" data-action="view" data-id="${character.id}">View More</button>
      </div>
    </article>
  `;
}

function renderFilteredCharacters() {
  const query = searchInput.value;

  if (renderTimer) {
    clearTimeout(renderTimer);
  }

  grid.classList.add('is-refreshing');

  renderTimer = setTimeout(async () => {
    resultsText.style.opacity = '0';
    resultsText.style.transform = 'translateY(3px)';

    try {
      const response = await fetch(`${APP_BASE}/api/characters?category=${activeFilter}&search=${encodeURIComponent(query)}`);
      if (!response.ok) throw new Error('Network response was not ok');
      const filtered = await response.json();

      if (filtered.length === 0) {
        grid.innerHTML = '<p class="empty-state">No pirate record found. Try another name or category.</p>';
        resultsText.textContent = 'Showing 0 legendary records';
      } else {
        grid.innerHTML = filtered.map(buildCard).join('');
        resultsText.textContent = `Showing ${filtered.length} legendary record${filtered.length === 1 ? '' : 's'}`;
      }

      requestAnimationFrame(() => {
        resultsText.style.opacity = '1';
        resultsText.style.transform = 'translateY(0)';
      });

      // Guard against missing files so cards stay visually consistent.
      grid.querySelectorAll('img[data-fallback]').forEach(image => {
        image.addEventListener('error', () => {
          image.src = image.dataset.fallback;
        }, { once: true });
      });

      setupCardReveal();
    } catch (error) {
      console.error("Error fetching characters:", error);
      grid.innerHTML = '<p class="empty-state">Failed to load archive records. The compass spins wildly.</p>';
    } finally {
      requestAnimationFrame(() => {
        grid.classList.remove('is-refreshing');
      });
    }
  }, 300);
}

function renderChipList(list, container) {
  container.innerHTML = list.map(entry => `<span class="chip">${entry}</span>`).join('');
}

async function openCharacterModal(characterId) {
  try {
    const response = await fetch(`${APP_BASE}/api/characters/${characterId}`);
    if (!response.ok) throw new Error('Network response was not ok');
    const record = await response.json();

    const fallbackImage = FALLBACK_CHARACTER_IMAGE; // We could use record.imageNeeded if available, else fallback
    modalImage.src = record.image || fallbackImage;
    modalImage.alt = record.name;
    modalName.textContent = record.name;
    modalRole.textContent = record.role;
    modalQuote.textContent = record.quote;
    modalBio.textContent = record.biography;
    modalShip.textContent = record.ship || 'Unknown';
    modalWeapon.textContent = record.weapon || 'Unknown';
    modalAppearance.textContent = record.firstAppearance || 'Unknown';
    modalCategory.textContent = titleCaseFromSlug(record.category);

    renderChipList(record.allies || [], modalAllies);
    renderChipList(record.enemies || [], modalEnemies);

    if (modalCloseTimer) {
      clearTimeout(modalCloseTimer);
      modalCloseTimer = null;
    }

    modal.hidden = false;
    requestAnimationFrame(() => {
      modal.classList.add('is-open');
    });
    document.body.style.overflow = 'hidden';
    playOpenSound();
  } catch (error) {
    console.error("Failed to load character details:", error);
    showActionToast("Failed to retrieve character dossier from the archive.");
  }
}

function closeCharacterModal() {
  modal.classList.remove('is-open');
  if (modalCloseTimer) {
    clearTimeout(modalCloseTimer);
  }
  modalCloseTimer = setTimeout(() => {
    modal.hidden = true;
    modalCloseTimer = null;
  }, 240);
  document.body.style.overflow = '';
}

function setupCardReveal() {
  const cards = document.querySelectorAll('.character-card');

  if (revealObserver) {
    revealObserver.disconnect();
  }

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

function playOpenSound() {
  try {
    const context = new (window.AudioContext || window.webkitAudioContext)();
    const osc = context.createOscillator();
    const gain = context.createGain();

    osc.type = 'triangle';
    osc.frequency.setValueAtTime(360, context.currentTime);
    osc.frequency.exponentialRampToValueAtTime(220, context.currentTime + 0.14);

    gain.gain.setValueAtTime(0.0001, context.currentTime);
    gain.gain.exponentialRampToValueAtTime(0.04, context.currentTime + 0.03);
    gain.gain.exponentialRampToValueAtTime(0.0001, context.currentTime + 0.16);

    osc.connect(gain);
    gain.connect(context.destination);
    osc.start(context.currentTime);
    osc.stop(context.currentTime + 0.18);

    setTimeout(() => context.close(), 220);
  } catch (error) {
    // Keep page silent if browser blocks audio context.
  }
}

function initSearchAndFilters() {
  searchInput.addEventListener('input', () => {
    renderFilteredCharacters();
  });

  searchInput.addEventListener('search', () => {
    renderFilteredCharacters();
  });

  filterButtons.forEach(button => {
    button.addEventListener('click', () => {
      activeFilter = button.dataset.filter;

      filterButtons.forEach(other => {
        const isActive = other === button;
        other.classList.toggle('is-active', isActive);
        other.setAttribute('aria-pressed', isActive ? 'true' : 'false');
      });

      renderFilteredCharacters();
    });
  });
}

function initModalEvents() {
  grid.addEventListener('click', event => {
    const button = event.target.closest('[data-action="view"]');
    if (!button) {
      return;
    }

    openCharacterModal(button.dataset.id);
  });

  modalBackdrop.addEventListener('click', closeCharacterModal);
  modalClose.addEventListener('click', closeCharacterModal);

  document.addEventListener('keydown', event => {
    if (event.key === 'Escape' && !modal.hidden) {
      closeCharacterModal();
    }
  });
}

function initMobileNavigation() {
  if (!navContainer || !navToggle) {
    return;
  }

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
      if (window.innerWidth <= 900) {
        closeMenu();
      }
    });
  });

  window.addEventListener('resize', () => {
    if (window.innerWidth > 900) {
      closeMenu();
    }
  });
}

function initFooterYear() {
  const yearSpan = document.getElementById('footer-year');
  yearSpan.textContent = String(new Date().getFullYear());
}

function ensureActionToast() {
  let toast = document.getElementById('action-toast');
  if (toast) {
    return toast;
  }

  toast = document.createElement('div');
  toast.id = 'action-toast';
  toast.className = 'action-toast';
  toast.setAttribute('role', 'status');
  toast.setAttribute('aria-live', 'polite');
  document.body.appendChild(toast);
  return toast;
}

function showActionToast(message) {
  const toast = ensureActionToast();
  toast.textContent = message;
  toast.classList.add('is-visible');

  if (actionToastTimer) {
    clearTimeout(actionToastTimer);
  }

  actionToastTimer = setTimeout(() => {
    toast.classList.remove('is-visible');
    actionToastTimer = null;
  }, 2200);
}

function initAuthButtons() {
  if (loginBtn) {
    loginBtn.addEventListener('click', () => {
      showActionToast('Captain login will be unlocked in the next voyage update.');
    });
  }

  if (signupBtn) {
    signupBtn.addEventListener('click', () => {
      showActionToast('Crew registration opens soon. Prepare your pirate identity.');
    });
  }
}

function initButtonInteractionFeedback() {
  document.addEventListener('click', event => {
    const button = event.target.closest('.btn-auth, .filter-btn, .view-more-btn, .modal-close');
    if (!button) {
      return;
    }

    button.classList.remove('is-pressed');
    requestAnimationFrame(() => {
      button.classList.add('is-pressed');
      setTimeout(() => {
        button.classList.remove('is-pressed');
      }, 220);
    });
  });
}

function initCharacterGalleryPage() {
  const loadingManager = new LoadingScreenManager();
  initMobileNavigation();
  initAuthButtons();
  initButtonInteractionFeedback();
  initSearchAndFilters();
  initModalEvents();
  initFooterYear();
  renderFilteredCharacters();

  window.addEventListener('load', () => {
    setTimeout(() => {
      loadingManager.hideLoadingScreen();
    }, 700);
  });
}

// === IDENTITY QUIZ LOGIC ===
const identityQuizQuestions = [
  {
    question: "When facing a vastly superior enemy ship, what is your first order?",
    options: [
      { text: "Negotiate a parley to buy time.", points: { "Jack Sparrow": 2, "Hector Barbossa": 1 } },
      { text: "Fight to the last man. No surrender.", points: { "Davy Jones": 2, "Blackbeard": 1 } },
      { text: "Use the environment to outmaneuver them.", points: { "Will Turner": 2, "Elizabeth Swann": 1 } }
    ]
  },
  {
    question: "What do you value most in this world?",
    options: [
      { text: "Freedom and the horizon.", points: { "Jack Sparrow": 3 } },
      { text: "Power and control over others.", points: { "Davy Jones": 2, "Blackbeard": 2 } },
      { text: "Love and loyalty.", points: { "Will Turner": 2, "Elizabeth Swann": 2 } },
      { text: "Wealth and fine apples.", points: { "Hector Barbossa": 3 } }
    ]
  },
  {
    question: "If you were cursed to live forever, how would you spend eternity?",
    options: [
      { text: "Ruling the seas with an iron fist.", points: { "Davy Jones": 3, "Blackbeard": 1 } },
      { text: "Enjoying every pleasure the world offers.", points: { "Jack Sparrow": 2, "Hector Barbossa": 2 } },
      { text: "Seeking a way to break the curse.", points: { "Will Turner": 3, "Elizabeth Swann": 2 } }
    ]
  }
];

let currentQuestionIndex = 0;
let characterScores = {};

const quizModal = document.getElementById('identity-quiz-modal');
const startQuizBtn = document.getElementById('start-identity-quiz-btn');
const quizCloseBtn = document.getElementById('quiz-modal-close');
const quizQuestionText = document.getElementById('quiz-question-text');
const quizOptionsContainer = document.getElementById('quiz-options-container');
const quizQuestionContainer = document.getElementById('quiz-question-container');
const quizResultContainer = document.getElementById('quiz-result-container');
const quizResultName = document.getElementById('quiz-result-name');
const identityInputField = document.getElementById('identity-input-field');

function initQuiz() {
  if (!startQuizBtn) return;
  
  startQuizBtn.addEventListener('click', openQuiz);
  quizCloseBtn.addEventListener('click', closeQuiz);
  
  document.getElementById('quiz-modal-backdrop').addEventListener('click', closeQuiz);
}

function openQuiz() {
  currentQuestionIndex = 0;
  characterScores = {
    "Jack Sparrow": 0, "Hector Barbossa": 0, "Davy Jones": 0, 
    "Blackbeard": 0, "Will Turner": 0, "Elizabeth Swann": 0
  };
  
  quizQuestionContainer.hidden = false;
  quizResultContainer.hidden = true;
  document.getElementById('quiz-modal-title').textContent = "The Compass Spins...";
  
  renderQuestion();
  
  quizModal.hidden = false;
  requestAnimationFrame(() => {
    quizModal.classList.add('is-open');
  });
  document.body.style.overflow = 'hidden';
}

function closeQuiz() {
  quizModal.classList.remove('is-open');
  setTimeout(() => {
    quizModal.hidden = true;
  }, 240);
  document.body.style.overflow = '';
}

function renderQuestion() {
  if (currentQuestionIndex >= identityQuizQuestions.length) {
    showQuizResult();
    return;
  }
  
  const q = identityQuizQuestions[currentQuestionIndex];
  quizQuestionText.textContent = q.question;
  quizOptionsContainer.innerHTML = '';
  
  q.options.forEach(opt => {
    const btn = document.createElement('button');
    btn.className = 'view-more-btn';
    btn.style.width = '100%';
    btn.textContent = opt.text;
    btn.addEventListener('click', () => {
      for (const [character, pts] of Object.entries(opt.points)) {
        characterScores[character] += pts;
      }
      currentQuestionIndex++;
      renderQuestion();
    });
    quizOptionsContainer.appendChild(btn);
  });
}

function showQuizResult() {
  quizQuestionContainer.hidden = true;
  quizResultContainer.hidden = false;
  document.getElementById('quiz-modal-title').textContent = "Your Destiny is Revealed";
  
  let topCharacter = Object.keys(characterScores).reduce((a, b) => characterScores[a] > characterScores[b] ? a : b);
  
  quizResultName.textContent = topCharacter;
  identityInputField.value = topCharacter;
}

initCharacterGalleryPage();
initQuiz();
