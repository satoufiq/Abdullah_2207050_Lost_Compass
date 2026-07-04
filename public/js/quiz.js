// quizData is now provided globally via dbQuizData injected from Blade
const quizData = window.dbQuizData || [];

const roleDisplay = {
  captain: {
    title: 'CAPTAIN OF THE SHADOW TIDE',
    role: 'Captain',
    relic: 'Flamebound Cutlass',
    ship: 'Black Pearl Style',
  },
  navigator: {
    title: 'WAYFINDER OF THE MIDNIGHT STAR',
    role: 'Navigator',
    relic: 'Cursed Compass',
    ship: 'Merchant Style',
  },
  strategist: {
    title: 'TACTICIAN OF THE DEEP CROWN',
    role: 'Strategist',
    relic: 'Ledger of Tides',
    ship: 'Merchant Style',
  },
  hunter: {
    title: 'HUNTER OF THE IRON WAKE',
    role: 'Treasure Hunter',
    relic: 'Kraken Harpoon Seal',
    ship: 'Royal Pursuit Style',
  },
  cursed: {
    title: 'WRAITH OF THE ABYSSAL LANTERN',
    role: 'Cursed Sailor',
    relic: 'Moon-Etched Relic',
    ship: 'Dutchman Style',
  },
};

const traitDisplay = {
  fearless: 'Fearless',
  loyal: 'Loyal',
  cunning: 'Cunning',
  mysterious: 'Mysterious',
};

const allegianceDisplay = {
  free: 'Free Captain',
  navy: 'Crown Fleet',
  merchant: 'Merchant Pact',
  mythic: 'Bound to the Deep',
};

class LoadingScreenManager {
  constructor() {
    this.loadingScreen = document.getElementById('loading-screen');
  }

  hideLoadingScreen() {
    if (this.loadingScreen) {
      this.loadingScreen.style.animation = 'fadeOut 1s ease-out forwards';
      setTimeout(() => {
        this.loadingScreen.style.display = 'none';
      }, 1000);
    }
  }
}

const loadingFadeStyle = document.createElement('style');
loadingFadeStyle.textContent = `
  @keyframes fadeOut {
    0% { opacity: 1; }
    100% { opacity: 0; pointer-events: none; }
  }
`;
document.head.appendChild(loadingFadeStyle);

class PirateIdentityQuiz {
  constructor(quizType = 'identity') {
    this.quizType = quizType;
    this.currentIndex = 0;
    this.answers = [];
    
    // Select correct data based on type
    const sourceData = window.dbQuizData ? window.dbQuizData[quizType] : [];
    this.questionDeck = this.shuffleQuestions(sourceData).slice(0, 10);
    this.totalQuestions = this.questionDeck.length;
    this.generatedPirateName = '';

    this.questionCountEl = document.getElementById('question-count');
    this.questionTextEl = document.getElementById('question-text');
    this.answersGridEl = document.getElementById('answers-grid');
    this.progressFillEl = document.getElementById('progress-fill');
    this.progressPercentEl = document.getElementById('progress-percent');
    this.progressBarEl = document.querySelector('.progress-rail');
    this.questionCardEl = document.getElementById('question-card');
    this.compassEl = document.getElementById('fate-compass');

    this.quizCardWrapEl = document.getElementById('quiz-card-wrap');
    this.resultWrapEl = document.getElementById('result-wrap');
    this.stageEl = document.querySelector('.compass-stage');

    this.resultTitleEl = document.getElementById('result-title');
    this.resultNameInputEl = document.getElementById('result-name-input');
    this.resultRoleEl = document.getElementById('result-role');
    this.resultRelicEl = document.getElementById('result-relic');
    this.resultAllegianceEl = document.getElementById('result-allegiance');
    this.resultShipEl = document.getElementById('result-ship');
    this.resultTraitEl = document.getElementById('result-trait');
    this.resultAvatarEl = document.getElementById('result-avatar-img');

    this.toastEl = document.getElementById('toast');
    this.saveBtn = document.getElementById('save-identity-btn');
    this.viewBtn = document.getElementById('view-profile-btn');
    this.missionBtn = document.getElementById('start-mission-btn');

    this.profileLink = document.getElementById('profile-link');

    // Make sure elements exist before proceeding
    if (!this.quizCardWrapEl) return;

    // Show the quiz wrap and hide result wrap
    this.quizCardWrapEl.hidden = false;
    this.resultWrapEl.hidden = true;
    if(this.stageEl) this.stageEl.hidden = false;

    this.bindStaticActions();
    this.renderQuestion();
  }

  bindStaticActions() {
    this.saveBtn.addEventListener('click', () => this.saveResult());
    this.viewBtn.addEventListener('click', () => {
      window.location.href = '/profile';
    });
    this.missionBtn.addEventListener('click', () => {
      window.location.href = '/missions';
    });

    if (this.profileLink) {
      this.profileLink.addEventListener('click', (event) => {
        window.location.href = '/profile';
      });
    }
  }

  renderQuestion() {
    const q = this.questionDeck[this.currentIndex];
    const questionNumber = this.currentIndex + 1;
    const total = this.totalQuestions;
    const answeredCount = this.currentIndex;
    const progress = Math.round((answeredCount / total) * 100);

    this.questionCountEl.textContent = `Question ${questionNumber} of ${total}`;
    this.questionTextEl.textContent = q.question;

    this.answersGridEl.innerHTML = '';

    const shuffledAnswers = this.shuffleQuestions(q.answers);

    shuffledAnswers.forEach((answer) => {
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'answer-btn';
      btn.textContent = answer.text;
      btn.addEventListener('click', () => this.selectAnswer(answer, btn));
      this.answersGridEl.appendChild(btn);
    });

    this.progressFillEl.style.width = `${progress}%`;
    this.progressPercentEl.textContent = `${progress}%`;
    this.progressBarEl.setAttribute('aria-valuenow', String(progress));
  }

  selectAnswer(answer, selectedButton) {
    const allButtons = Array.from(this.answersGridEl.querySelectorAll('.answer-btn'));
    allButtons.forEach((btn) => {
      btn.disabled = true;
      btn.classList.remove('selected');
    });
    selectedButton.classList.add('selected');

    this.answers.push(answer);
    this.playChoiceSound();

    this.compassEl.classList.remove('compass-react');
    void this.compassEl.offsetWidth;
    this.compassEl.classList.add('compass-react');

    this.questionCardEl.classList.remove('fade-in');
    this.questionCardEl.classList.add('fade-out');

    setTimeout(() => {
      this.currentIndex += 1;

      if (this.currentIndex < this.totalQuestions) {
        this.questionCardEl.style.animation = 'none';
        this.questionCardEl.offsetHeight;
        this.questionCardEl.style.animation = 'fadeInUp 0.6s ease-out';
        this.renderQuestion();
      } else {
        this.showResult();
      }
    }, 400);
  }

  showResult() {
    this.progressFillEl.style.width = '100%';
    this.progressPercentEl.textContent = '100%';
    this.progressBarEl.setAttribute('aria-valuenow', '100');

    const result = this.computeResult();

    if (this.quizType === 'identity') {
        this.resultTitleEl.textContent = result.title;
        if (this.resultNameInputEl) {
          this.resultNameInputEl.value = result.name;
        }
        if (this.resultRoleEl) this.resultRoleEl.textContent = result.role;
        if (this.resultTraitEl) this.resultTraitEl.textContent = result.trait;
        if (this.resultAllegianceEl) this.resultAllegianceEl.textContent = result.allegiance;
        if (this.resultRelicEl) this.resultRelicEl.textContent = result.relic;
        if (this.resultAvatarEl && result.avatar) {
            this.resultAvatarEl.src = `assets/images/profile/avatars/${result.avatar}`;
            this.resultAvatarEl.dataset.avatarName = result.avatar;
            this.resultAvatarEl.style.display = 'block';
        }
        this.saveBtn.textContent = "Save Identity";
        document.querySelector('.result-grid').style.display = 'grid';
        this.resultNameInputEl.style.display = 'block';
    } else if (this.quizType === 'ship') {
        this.resultTitleEl.textContent = result.ship;
        document.querySelector('.result-grid').style.display = 'none';
        if (this.resultNameInputEl) this.resultNameInputEl.style.display = 'none';
        this.saveBtn.textContent = "Claim Ship";
    } else if (this.quizType === 'weapon') {
        this.resultTitleEl.textContent = result.weapon;
        document.querySelector('.result-grid').style.display = 'none';
        if (this.resultNameInputEl) this.resultNameInputEl.style.display = 'none';
        this.saveBtn.textContent = "Take Weapon";
    }

    if(this.stageEl) this.stageEl.hidden = true;
    this.quizCardWrapEl.hidden = true;
    this.resultWrapEl.hidden = false;

    this.playRevealSound();
  }

  computeResult() {
    if (this.quizType === 'identity') {
        const roleScores = { captain: 0, navigator: 0, strategist: 0, hunter: 0, cursed: 0 };
        const traitScores = { fearless: 0, loyal: 0, cunning: 0, mysterious: 0 };
        const allegianceScores = { free: 0, navy: 0, merchant: 0, mythic: 0 };

        this.answers.forEach((entry) => {
          if (entry.role && roleScores[entry.role] !== undefined) roleScores[entry.role] += 1;
          if (entry.trait && traitScores[entry.trait] !== undefined) traitScores[entry.trait] += 1;
          if (entry.allegiance && allegianceScores[entry.allegiance] !== undefined) allegianceScores[entry.allegiance] += 1;
        });

        const topRole = this.getTopKey(roleScores);
        const topTrait = this.getTopKey(traitScores);
        const topAllegiance = this.getTopKey(allegianceScores);

        const roleInfo = roleDisplay[topRole] || roleDisplay['captain'];
        const pirateName = this.generatePirateName(topRole, topTrait);
        this.generatedPirateName = pirateName;
        
        // Only 10 avatar combos exist: map to nearest valid one
        const validAvatars = {
          'captain-cunning':     'avatar-captain-cunning.png',
          'captain-fearless':    'avatar-captain-fearless.png',
          'cursed-fearless':     'avatar-cursed-fearless.png',
          'cursed-mysterious':   'avatar-cursed-mysterious.png',
          'hunter-fearless':     'avatar-hunter-fearless.png',
          'hunter-mysterious':   'avatar-hunter-mysterious.png',
          'navigator-cunning':   'avatar-navigator-cunning.png',
          'navigator-loyal':     'avatar-navigator-loyal.png',
          'strategist-loyal':    'avatar-strategist-loyal.png',
          'strategist-mysterious': 'avatar-strategist-mysterious.png',
        };
        // Role-based trait fallback order
        const traitFallback = {
          captain:    ['cunning', 'fearless', 'loyal', 'mysterious'],
          navigator:  ['cunning', 'loyal', 'fearless', 'mysterious'],
          strategist: ['loyal', 'mysterious', 'cunning', 'fearless'],
          hunter:     ['fearless', 'mysterious', 'cunning', 'loyal'],
          cursed:     ['fearless', 'mysterious', 'cunning', 'loyal'],
        };
        let avatarName = validAvatars[`${topRole}-${topTrait}`];
        if (!avatarName) {
          const fallbackTraits = traitFallback[topRole] || ['fearless'];
          for (const t of fallbackTraits) {
            if (validAvatars[`${topRole}-${t}`]) { avatarName = validAvatars[`${topRole}-${t}`]; break; }
          }
        }
        avatarName = avatarName || 'avatar-captain-fearless.png';

        return {
          roleKey: topRole,
          title: roleInfo.title,
          role: roleInfo.role,
          relic: roleInfo.relic,
          trait: traitDisplay[topTrait],
          allegiance: allegianceDisplay[topAllegiance],
          name: pirateName,
          avatar: avatarName
        };
    } else if (this.quizType === 'ship') {
        const scores = {};
        this.answers.forEach((entry) => {
            if(entry.ship) {
                scores[entry.ship] = (scores[entry.ship] || 0) + 1;
            }
        });
        const allShips = ['The Iron Galleon', 'The Swift Sloop', 'The Phantom Brig', 'The Dreadnought', 'The Crimson Leviathan', 'The Silent Marauder', 'The Abyssal Queen', 'The Gilded Serpent', 'The Star-Catcher', 'The Tempest\'s Wrath'];
        const fallback = allShips[Math.floor(Math.random() * allShips.length)];
        return { ship: this.getTopKey(scores) || fallback };
    } else if (this.quizType === 'weapon') {
        const scores = {};
        this.answers.forEach((entry) => {
            if(entry.weapon) {
                scores[entry.weapon] = (scores[entry.weapon] || 0) + 1;
            }
        });
        const allWeapons = ['Cursed Cutlass', 'Gold-Inlaid Flintlock', 'Abyssal Dagger', 'Kraken Bone Axe', 'Volcanic Broadsword', 'Obsidian Rapier', 'Blunderbuss of the Deep', 'Venomous Harpoon', 'Starlit Scimitar', 'Shadow-Forged Cutlass'];
        const fallback = allWeapons[Math.floor(Math.random() * allWeapons.length)];
        return { weapon: this.getTopKey(scores) || fallback };
    }
  }

  shuffleQuestions(questions) {
    const shuffled = [...questions];
    for (let index = shuffled.length - 1; index > 0; index -= 1) {
      const swapIndex = Math.floor(Math.random() * (index + 1));
      [shuffled[index], shuffled[swapIndex]] = [shuffled[swapIndex], shuffled[index]];
    }
    return shuffled;
  }

  getTopKey(scoreMap) {
    const keys = Object.keys(scoreMap).sort(() => Math.random() - 0.5);
    if(keys.length === 0) return null;
    let highestKey = keys[0];
    let highestScore = scoreMap[highestKey];

    keys.forEach((key) => {
      const value = scoreMap[key];
      if (value > highestScore) {
        highestKey = key;
        highestScore = value;
      }
    });
    return highestKey;
  }

  generatePirateName(role, trait) {
    const firstByRole = {
      captain: ['Raven', 'Iron', 'Tempest', 'Scarlet'],
      navigator: ['Star', 'Tide', 'Compass', 'Northwind'],
      strategist: ['Cipher', 'Silver', 'Ledger', 'Harbor'],
      hunter: ['Kraken', 'Viper', 'Gale', 'Harpoon'],
      cursed: ['Wraith', 'Ashen', 'Nocturne', 'Phantom'],
    };

    const lastByTrait = {
      fearless: ['Stormcaller', 'Blackwake', 'Flintheart', 'Sea-Ward'],
      loyal: ['Anchorborn', 'Truehand', 'Harborcrest', 'Goldwatch'],
      cunning: ['Quickquill', 'Saltmind', 'Locke', 'Rook'],
      mysterious: ['Duskveil', 'Nighttide', 'Whispermark', 'Gravesong'],
    };

    const firstPool = firstByRole[role] || firstByRole['captain'];
    const lastPool = lastByTrait[trait] || lastByTrait['fearless'];

    const first = firstPool[Math.floor(Math.random() * firstPool.length)];
    const last = lastPool[Math.floor(Math.random() * lastPool.length)];

    return `${first} ${last}`;
  }

  saveResult() {
    const form = document.createElement('form');
    form.method = 'POST';
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const addHiddenInput = (name, value) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        form.appendChild(input);
    };
    addHiddenInput('_token', csrfToken);

    if (this.quizType === 'identity') {
        form.action = '/quiz/identity/submit';
        addHiddenInput('identity_character', this.resultTitleEl.textContent);
        
        let pirateName = this.generatedPirateName;
        if (this.resultNameInputEl && this.resultNameInputEl.value.trim() !== '') {
            pirateName = this.resultNameInputEl.value.trim();
        }
        addHiddenInput('pirate_name', pirateName);
        addHiddenInput('role', this.resultRoleEl.textContent);
        addHiddenInput('relic', this.resultRelicEl.textContent);
        addHiddenInput('allegiance', this.resultAllegianceEl.textContent);
        addHiddenInput('trait', this.resultTraitEl.textContent);
        if (this.resultAvatarEl && this.resultAvatarEl.dataset.avatarName) {
            addHiddenInput('avatar', this.resultAvatarEl.dataset.avatarName);
        }
    } else if (this.quizType === 'ship') {
        form.action = '/quiz/ship/submit';
        addHiddenInput('ship', this.resultTitleEl.textContent);
    } else if (this.quizType === 'weapon') {
        form.action = '/quiz/weapon/submit';
        addHiddenInput('weapon', this.resultTitleEl.textContent);
    }
    
    document.body.appendChild(form);
    form.submit();
  }

  showToast(message) {
    this.toastEl.textContent = message;
    this.toastEl.classList.add('show');
    setTimeout(() => {
      this.toastEl.classList.remove('show');
    }, 2200);
  }

  playChoiceSound() {
    this.playTone(360, 0.05, 'triangle', 0.03);
    setTimeout(() => this.playTone(520, 0.05, 'sine', 0.02), 50);
  }

  playRevealSound() {
    this.playTone(130, 0.16, 'sawtooth', 0.06);
    setTimeout(() => this.playTone(190, 0.22, 'triangle', 0.05), 110);
  }

  playTone(freq, duration, type, volume) {
    const Ctx = window.AudioContext || window.webkitAudioContext;
    if (!Ctx) return;

    const context = new Ctx();
    const oscillator = context.createOscillator();
    const gain = context.createGain();

    oscillator.type = type;
    oscillator.frequency.value = freq;

    gain.gain.setValueAtTime(volume, context.currentTime);
    gain.gain.exponentialRampToValueAtTime(0.0001, context.currentTime + duration);

    oscillator.connect(gain);
    gain.connect(context.destination);

    oscillator.start();
    oscillator.stop(context.currentTime + duration);

    oscillator.onended = () => {
      context.close();
    };
  }
}

// Global function to start a specific quiz
window.startQuiz = function(type) {
    document.getElementById('identity-section').scrollIntoView({ behavior: 'smooth' });
    document.getElementById('identity-section').hidden = false;
    
    // Update active nav buttons
    document.querySelectorAll('.ritual-btn').forEach(b => b.classList.remove('active'));
    event.target.classList.add('active');

    if (window.currentQuiz) {
        // We already have a quiz instantiated, we just reset it with new data
        // For now, simpler to just replace inner HTML or instantiate new.
    }
    
    window.currentQuiz = new PirateIdentityQuiz(type);
};

function initMobileNavigation() {
  const navContainer = document.querySelector('.nav-container');
  const navToggle = document.getElementById('nav-toggle');
  const navLinks = document.querySelectorAll('.nav-menu a');

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

  navLinks.forEach((link) => {
    link.addEventListener('click', () => {
      if (window.innerWidth <= 860) {
        closeMenu();
      }
    });
  });

  window.addEventListener('resize', () => {
    if (window.innerWidth > 860) {
      closeMenu();
    }
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      closeMenu();
    }
  });
}

document.addEventListener('DOMContentLoaded', () => {
  const loadingManager = new LoadingScreenManager();
  initMobileNavigation();

  setTimeout(() => {
    loadingManager.hideLoadingScreen();
  }, 1000);
  
  // Hide quiz sections initially
  const identitySection = document.getElementById('identity-section');
  if (identitySection) {
      identitySection.hidden = true;
  }
});
