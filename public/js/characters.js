const FALLBACK_CHARACTER_IMAGE = 'assets/images/home/new images/crew showcase.jpeg';

const characters = [
  {
    id: 'jack-sparrow',
    name: 'Jack Sparrow',
    role: 'Captain of the Black Pearl',
    shortLine: 'Master of luck and deception across cursed tides.',
    quote: '"Why is the rum always gone?"',
    category: 'captains',
    tags: ['allies', 'legends'],
    image: 'assets/images/characters/captain jack sparrow.jpeg',
    biography: 'Jack Sparrow is a cunning pirate captain known for impossible escapes, bargains with dark forces, and a moral code hidden beneath chaos. His legend is built on risk, charm, and sheer survival.',
    ship: 'Black Pearl',
    weapon: 'Sword and flintlock pistol',
    firstAppearance: 'The Curse of the Black Pearl (2003)',
    allies: ['Will Turner', 'Elizabeth Swann', 'Gibbs'],
    enemies: ['Davy Jones', 'Cutler Beckett', 'Captain Salazar'],
  },
  {
    id: 'will-turner',
    name: 'Will Turner',
    role: 'Blacksmith Turned Sea Warrior',
    shortLine: 'A loyal fighter bound by love, duty, and destiny.',
    quote: '"No cause is lost if there is but one fool left to fight for it."',
    category: 'allies',
    tags: ['legends'],
    image: 'assets/images/home/will turner.jpg',
    biography: 'Will Turner begins as a blacksmith but becomes one of the greatest swordsmen at sea. Driven by honor and devotion, he stands at the center of pirate fate and eventually commands the Flying Dutchman.',
    ship: 'Flying Dutchman',
    weapon: 'Master-forged sword',
    firstAppearance: 'The Curse of the Black Pearl (2003)',
    allies: ['Elizabeth Swann', 'Jack Sparrow'],
    enemies: ['Davy Jones', 'East India Company'],
  },
  {
    id: 'elizabeth-swann',
    name: 'Elizabeth Swann',
    role: 'Pirate King of the Brethren Court',
    shortLine: 'Noble-born strategist who became a feared sea leader.',
    quote: '"I am disinclined to acquiesce to your request."',
    category: 'allies',
    tags: ['legends'],
    image: 'assets/images/characters/swann.png',
    biography: 'Elizabeth Swann transforms from governor\'s daughter into one of the strongest political minds in pirate history. She commands fleets, unites factions, and refuses to surrender her freedom.',
    ship: 'Empress (command in battle)',
    weapon: 'Rapier and command authority',
    firstAppearance: 'The Curse of the Black Pearl (2003)',
    allies: ['Will Turner', 'Captain Teague', 'Jack Sparrow'],
    enemies: ['Lord Beckett', 'Davy Jones'],
  },
  {
    id: 'hector-barbossa',
    name: 'Hector Barbossa',
    role: 'Cursed Captain and Master Tactician',
    shortLine: 'A ruthless navigator with a taste for ancient power.',
    quote: '"The code is more what you\'d call guidelines than actual rules."',
    category: 'captains',
    tags: ['villains', 'legends'],
    image: 'assets/images/characters/Barbosa.jpg',
    biography: 'Hector Barbossa is both feared and respected as a relentless captain. From cursed immortality to royal privateering, he constantly reinvents himself through cunning, ambition, and dark wit.',
    ship: 'Black Pearl / Queen Anne\'s Revenge',
    weapon: 'Sword and flintlock',
    firstAppearance: 'The Curse of the Black Pearl (2003)',
    allies: ['Jack Sparrow (uneasy)', 'Carina Smyth'],
    enemies: ['Jack Sparrow', 'Blackbeard', 'Salazar'],
  },
  {
    id: 'davy-jones',
    name: 'Davy Jones',
    role: 'Lord of the Flying Dutchman',
    shortLine: 'A broken soul ruling the abyss with terror.',
    quote: '"Do you fear death?"',
    category: 'villains',
    tags: ['legends'],
    image: 'assets/images/home/davy jones.jpeg',
    biography: 'Davy Jones commands the cursed Flying Dutchman and collects souls owed to the sea. Betrayed in love and transformed by grief, he becomes one of the most terrifying forces in pirate mythology.',
    ship: 'Flying Dutchman',
    weapon: 'Sword and Kraken command',
    firstAppearance: 'Dead Man\'s Chest (2006)',
    allies: ['The Kraken', 'Cutler Beckett (temporary)'],
    enemies: ['Jack Sparrow', 'Will Turner', 'Elizabeth Swann'],
  },
  {
    id: 'blackbeard',
    name: 'Blackbeard',
    role: 'Captain of Queen Anne\'s Revenge',
    shortLine: 'A dark sorcerer-pirate feared by every horizon.',
    quote: '"Fear me... if you dare."',
    category: 'villains',
    tags: ['captains', 'legends'],
    image: 'assets/images/characters/Black beard.jpg',
    biography: 'Blackbeard is a brutal captain wrapped in superstition and black magic. His command over rigging, flames, and fear turns every encounter into a nightmare for rival crews.',
    ship: 'Queen Anne\'s Revenge',
    weapon: 'Enchanted cutlass',
    firstAppearance: 'On Stranger Tides (2011)',
    allies: ['Crew of Queen Anne\'s Revenge'],
    enemies: ['Jack Sparrow', 'Barbossa', 'Angelica'],
  },
  {
    id: 'james-norrington',
    name: 'James Norrington',
    role: 'Commodore of the Royal Navy',
    shortLine: 'Duty-bound officer torn between honor and obsession.',
    quote: '"You are without a doubt the worst pirate I\'ve ever heard of."',
    category: 'allies',
    tags: ['legends'],
    image: 'assets/images/characters/norrington.jpg',
    biography: 'Commodore Norrington begins as a proud naval officer and ultimately walks a tragic path of redemption, rivalry, and sacrifice in the shifting war between empire and piracy.',
    ship: 'HMS Dauntless',
    weapon: 'Naval saber and pistol',
    firstAppearance: 'The Curse of the Black Pearl (2003)',
    allies: ['Elizabeth Swann', 'Will Turner'],
    enemies: ['Jack Sparrow', 'Davy Jones'],
  },
  {
    id: 'joshamee-gibbs',
    name: 'Joshamee Gibbs',
    role: 'First Mate of the Black Pearl',
    shortLine: 'Superstitious survivor and loyal sea storyteller.',
    quote: '"Take what you can, give nothing back."',
    category: 'allies',
    tags: ['legends'],
    image: 'assets/images/characters/Gibbs.jpg',
    biography: 'Gibbs is the conscience of many pirate crews, carrying sea lore, cautionary tales, and unwavering loyalty. He survives every cursed storm with wit and rum-soaked wisdom.',
    ship: 'Black Pearl',
    weapon: 'Pistol and boarding blade',
    firstAppearance: 'The Curse of the Black Pearl (2003)',
    allies: ['Jack Sparrow', 'Barbossa'],
    enemies: ['Royal Navy', 'East India Company'],
  },
  {
    id: 'tia-dalma',
    name: 'Tia Dalma (Calypso)',
    role: 'Sea Goddess in Mortal Form',
    shortLine: 'Mystic keeper of tides, bargains, and prophecy.',
    quote: '"Same story, different versions. All are true."',
    category: 'legends',
    tags: ['allies'],
    image: 'assets/images/characters/tia dalma.jpg',
    biography: 'Known as Tia Dalma among mortals, Calypso is the imprisoned goddess of the sea. Her choices reshape fate itself, empowering storms, monsters, and men alike.',
    ship: 'The Sea Itself',
    weapon: 'Ritual magic and prophecy',
    firstAppearance: 'Dead Man\'s Chest (2006)',
    allies: ['Will Turner', 'Barbossa', 'Pirate Lords'],
    enemies: ['Davy Jones', 'Brethren Court (historic)'],
  },
  {
    id: 'cutler-beckett',
    name: 'Lord Cutler Beckett',
    role: 'Chairman of the East India Trading Company',
    shortLine: 'Cold strategist determined to end piracy forever.',
    quote: '"It\'s just good business."',
    category: 'villains',
    tags: ['legends'],
    image: 'assets/images/characters/beckett.jpg',
    biography: 'Beckett commands fleets, law, and economics as weapons. He seeks total control of the seas by enslaving legends and crushing freedom under corporate empire.',
    ship: 'HMS Endeavour',
    weapon: 'Political power and naval command',
    firstAppearance: 'Dead Man\'s Chest (2006)',
    allies: ['Davy Jones (coerced)', 'Royal Navy'],
    enemies: ['Jack Sparrow', 'Brethren Court', 'Calypso'],
  },
  {
    id: 'angelica',
    name: 'Angelica',
    role: 'Daughter of Blackbeard',
    shortLine: 'Dangerous deceiver balancing revenge and survival.',
    quote: '"You haven\'t changed at all."',
    category: 'villains',
    tags: ['allies', 'legends'],
    image: 'assets/images/characters/angelica.jpg',
    biography: 'Angelica is a skilled manipulator with deep ties to Jack Sparrow and Blackbeard. Her faith, ambition, and unpredictable loyalties make her one of the deadliest players at sea.',
    ship: 'Queen Anne\'s Revenge',
    weapon: 'Swordsmanship and deception',
    firstAppearance: 'On Stranger Tides (2011)',
    allies: ['Blackbeard', 'Jack Sparrow (temporary)'],
    enemies: ['Barbossa', 'British forces'],
  },
  {
    id: 'armando-salazar',
    name: 'Captain Armando Salazar',
    role: 'Undead Hunter of Pirates',
    shortLine: 'Relentless ghost captain forged by vengeance.',
    quote: '"Death will go straight for him."',
    category: 'villains',
    tags: ['captains', 'legends'],
    image: 'assets/images/characters/salazar.jpeg',
    biography: 'Salazar, once Spain\'s feared pirate hunter, returns from the Devil\'s Triangle with a cursed crew and one purpose: destroy Jack Sparrow and every pirate legacy.',
    ship: 'Silent Mary',
    weapon: 'Rapier and spectral command',
    firstAppearance: 'Dead Men Tell No Tales (2017)',
    allies: ['Undead Silent Mary crew'],
    enemies: ['Jack Sparrow', 'Henry Turner', 'Carina Smyth'],
  },
  {
    id: 'henry-turner',
    name: 'Henry Turner',
    role: 'Royal Navy Sailor and Son of Legends',
    shortLine: 'Driven heir seeking to free his father from curse.',
    quote: '"I will break the curse."',
    category: 'allies',
    tags: ['legends'],
    image: 'assets/images/characters/Henry Turner.jpg',
    biography: 'Henry Turner sails to break the Dutchman\'s curse and reunite his family. Bold and stubborn, he bridges old legends with a new generation of sea-faring heroes.',
    ship: 'Royal Navy vessels / Black Pearl alliance',
    weapon: 'Naval sword',
    firstAppearance: 'Dead Men Tell No Tales (2017)',
    allies: ['Carina Smyth', 'Jack Sparrow'],
    enemies: ['Salazar'],
  },
  {
    id: 'carina-smyth',
    name: 'Carina Smyth',
    role: 'Astronomer and Keeper of the Stars',
    shortLine: 'Brilliant navigator armed with science and courage.',
    quote: '"My diary is not a diary. It\'s an astronomical journal."',
    category: 'allies',
    tags: ['legends'],
    image: 'assets/images/characters/Carina Smyth.jpg',
    biography: 'Carina deciphers celestial secrets that lead to Poseidon\'s Trident. Rational and fearless, she stands against superstition and rewrites pirate destiny with knowledge.',
    ship: 'Black Pearl alliance',
    weapon: 'Scientific knowledge and navigation',
    firstAppearance: 'Dead Men Tell No Tales (2017)',
    allies: ['Henry Turner', 'Barbossa', 'Jack Sparrow'],
    enemies: ['Salazar', 'Grave robbers'],
  },
  {
    id: 'sao-feng',
    name: 'Sao Feng',
    role: 'Pirate Lord of the South China Sea',
    shortLine: 'Power broker ruling trade, territory, and fear.',
    quote: '"The Brethren Court has failed us."',
    category: 'captains',
    tags: ['villains', 'legends'],
    image: 'assets/images/characters/Sao Feng.jpg',
    biography: 'Sao Feng commands one of the most powerful pirate domains in the world. Ruthless and strategic, he uses alliances as currency and power as the only truth.',
    ship: 'Empress',
    weapon: 'Curved dao sword',
    firstAppearance: 'At World\'s End (2007)',
    allies: ['Brethren Court (uneasy)', 'Elizabeth Swann (briefly)'],
    enemies: ['Cutler Beckett', 'Norrington'],
  },
  {
    id: 'bootstrap-bill',
    name: 'Bootstrap Bill Turner',
    role: 'Cursed Sailor of the Dutchman',
    shortLine: 'Broken father trapped beneath Jones\' command.',
    quote: '"Part of the ship, part of the crew."',
    category: 'allies',
    tags: ['legends'],
    image: 'assets/images/characters/Bootstrap Bill Turner.jpg',
    biography: 'Bootstrap Bill suffers the Dutchman\'s curse while trying to protect his son and redeem past sins. His story embodies sacrifice, regret, and parental devotion.',
    ship: 'Flying Dutchman',
    weapon: 'Boarding weapons and cursed resilience',
    firstAppearance: 'Dead Man\'s Chest (2006)',
    allies: ['Will Turner'],
    enemies: ['Davy Jones'],
  },
  {
    id: 'captain-teague',
    name: 'Captain Teague',
    role: 'Keeper of the Pirate Code',
    shortLine: 'Ancient authority with silent, deadly command.',
    quote: '"It\'s not just the code. It\'s the law."',
    category: 'captains',
    tags: ['legends', 'allies'],
    image: 'assets/images/characters/Captain Teague.jpg',
    biography: 'Captain Teague presides over pirate law with austere calm. His authority in the Brethren Court shapes the politics, justice, and rituals of pirate civilization.',
    ship: 'Brethren Court command',
    weapon: 'Pistol and Pirate Code authority',
    firstAppearance: 'At World\'s End (2007)',
    allies: ['Jack Sparrow', 'Pirate Lords'],
    enemies: ['East India Company'],
  },
  {
    id: 'marty',
    name: 'Marty',
    role: 'Black Pearl Crew Veteran',
    shortLine: 'Sharp-tongued deckhand with unshakeable grit.',
    quote: '"The world\'s still the same. There\'s just less in it."',
    category: 'allies',
    tags: ['legends'],
    image: 'assets/images/characters/Marty   .jpg',
    biography: 'Marty is among the most recognizable Black Pearl veterans, standing through mutinies, curses, and impossible voyages with dry humor and hardened resolve.',
    ship: 'Black Pearl',
    weapon: 'Boarding axe and pistols',
    firstAppearance: 'The Curse of the Black Pearl (2003)',
    allies: ['Jack Sparrow', 'Gibbs'],
    enemies: ['Royal Navy', 'Mutinous rivals'],
  },
  {
    id: 'pintel-ragetti',
    name: 'Pintel and Ragetti',
    role: 'Infamous Trickster Duo',
    shortLine: 'Chaotic crewmen surviving on nerve and luck.',
    quote: '"Parlay? Dammit, they have that word memorized!"',
    category: 'allies',
    tags: ['legends'],
    image: 'assets/images/characters/Pintel and Ragetti.jpg',
    biography: 'Pintel and Ragetti move between rival crews while delivering comic chaos, accidental bravery, and surprising loyalty in the deadliest moments on the seven seas.',
    ship: 'Black Pearl and allied ships',
    weapon: 'Pistols and improvised blades',
    firstAppearance: 'The Curse of the Black Pearl (2003)',
    allies: ['Jack Sparrow', 'Barbossa'],
    enemies: ['Royal Navy'],
  },
  {
    id: 'governor-weatherby-swann',
    name: 'Governor Weatherby Swann',
    role: 'Governor of Port Royal',
    shortLine: 'A father caught between empire and conscience.',
    quote: '"This is either madness... or brilliance."',
    category: 'allies',
    tags: ['legends'],
    image: 'assets/images/characters/Gov_Swann.jpg',
    biography: 'Governor Swann represents order and civility in a world of pirates, yet his devotion to Elizabeth leads him into dangerous political and moral conflicts.',
    ship: 'Port Royal administration',
    weapon: 'Political influence',
    firstAppearance: 'The Curse of the Black Pearl (2003)',
    allies: ['Elizabeth Swann', 'Norrington'],
    enemies: ['Cutler Beckett', 'Pirate threats'],
  },
  {
    id: 'cotton-and-parrot',
    name: 'Cotton and Parrot',
    role: 'Signalman of the Black Pearl',
    shortLine: 'Silent sailor whose parrot speaks for the crew.',
    quote: '"(Parrot) Mr. Cotton\'s parrot!"',
    category: 'allies',
    tags: ['legends'],
    image: 'assets/images/characters/Cotton and Parrot.jpg',
    biography: 'Cotton and his ever-chatty parrot are among the most iconic visuals aboard the Black Pearl, symbolizing the ragged personality and unity of pirate crews.',
    ship: 'Black Pearl',
    weapon: 'Deck rigging tools and pistols',
    firstAppearance: 'The Curse of the Black Pearl (2003)',
    allies: ['Jack Sparrow', 'Gibbs', 'Marty'],
    enemies: ['Royal Navy'],
  },
];

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

  renderTimer = setTimeout(() => {
    const filtered = characters.filter(character => matchesFilter(character) && matchesSearch(character, query));

    resultsText.style.opacity = '0';
    resultsText.style.transform = 'translateY(3px)';

    if (filtered.length === 0) {
      grid.innerHTML = '<p class="empty-state">No pirate record found. Try another name or category.</p>';
      resultsText.textContent = 'Showing 0 legendary records';
      requestAnimationFrame(() => {
        resultsText.style.opacity = '1';
        resultsText.style.transform = 'translateY(0)';
      });
      grid.classList.remove('is-refreshing');
      return;
    }

    grid.innerHTML = filtered.map(buildCard).join('');
    resultsText.textContent = `Showing ${filtered.length} legendary record${filtered.length === 1 ? '' : 's'}`;
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

    requestAnimationFrame(() => {
      grid.classList.remove('is-refreshing');
    });
  }, 120);
}

function renderChipList(list, container) {
  container.innerHTML = list.map(entry => `<span class="chip">${entry}</span>`).join('');
}

function openCharacterModal(characterId) {
  const record = characters.find(character => character.id === characterId);
  if (!record) {
    return;
  }

  modalImage.src = record.imageNeeded ? FALLBACK_CHARACTER_IMAGE : record.image;
  modalImage.alt = record.name;
  modalName.textContent = record.name;
  modalRole.textContent = record.role;
  modalQuote.textContent = record.quote;
  modalBio.textContent = record.biography;
  modalShip.textContent = record.ship;
  modalWeapon.textContent = record.weapon;
  modalAppearance.textContent = record.firstAppearance;
  modalCategory.textContent = titleCaseFromSlug(record.category);

  renderChipList(record.allies, modalAllies);
  renderChipList(record.enemies, modalEnemies);

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

initCharacterGalleryPage();
