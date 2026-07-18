/* ============================================
   THE LOST COMPASS - MAP PAGE JAVASCRIPT
   Interactive World Map System
   ============================================ */

// Base URL injected by Blade layout (supports XAMPP subpath like /lost-compass/public)
const APP_BASE = window.APP_BASE || '';

let locationsData = []; // Will be loaded from backend API

class MapManager {
  constructor() {
    this.mapCanvas = document.getElementById('map-canvas');
    this.markersContainer = document.getElementById('markers-container');
    this.locationPopup = document.getElementById('location-popup');
    this.popupClose = document.getElementById('popup-close');
    this.locationTooltip = document.getElementById('location-tooltip');
    this.routeOverlay = document.getElementById('route-overlay');
    this.animatedShip = document.getElementById('animated-ship');
    this.miniCompass = document.getElementById('mini-compass');
    this.locationSearch = document.getElementById('location-search');
    this.resetMapBtn = document.getElementById('reset-map-btn');
    
    this.locations = locationsData;
    this.activeLocation = null;
    this.filteredLocations = this.locations;
    this.drawnRoutes = new Set();

    this.init();
  }

  init() {
    this.fetchLocations();
  }

  async fetchLocations() {
    try {
      const response = await fetch(`${APP_BASE}/api/locations`);
      const data = await response.json();
      this.locations = data;
      this.filteredLocations = this.locations;
      
      this.setupEventListeners();
      this.renderMarkers();
      this.drawInitialRoutes();
    } catch (err) {
      console.error("Failed to load map locations", err);
    }
  }

  // ============================================
  // EVENT LISTENERS
  // ============================================

  setupEventListeners() {
    // Popup close
    this.popupClose.addEventListener('click', () => this.closePopup());
    this.locationPopup.addEventListener('click', (e) => {
      if (e.target === this.locationPopup) this.closePopup();
    });

    // Search functionality
    this.locationSearch.addEventListener('input', (e) => this.filterLocations(e.target.value));

    // Reset button
    this.resetMapBtn.addEventListener('click', () => this.resetView());

    // Map click to close popup
    this.mapCanvas.addEventListener('click', (e) => {
      if (e.target === this.mapCanvas) this.closePopup();
    });

    // Keyboard
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') this.closePopup();
    });
  }

  // ============================================
  // MARKER RENDERING
  // ============================================

  renderMarkers() {
    this.markersContainer.innerHTML = '';

    this.filteredLocations.forEach(location => {
      const marker = document.createElement('button');
      marker.className = 'location-marker';
      marker.type = 'button';
      marker.id = `marker-${location.id}`;
      marker.style.left = `${location.position.x}%`;
      marker.style.top = `${location.position.y}%`;
      marker.setAttribute('aria-label', `${location.name} - ${location.type}`);

      const markerIcon = document.createElement('img');
      markerIcon.className = 'marker-icon';
      markerIcon.src = location.icon;
      markerIcon.alt = location.name;
      markerIcon.loading = 'lazy';

      const markerLabel = document.createElement('span');
      markerLabel.className = 'marker-label';
      markerLabel.textContent = `${location.iconLabel} • ${location.name}`;

      marker.appendChild(markerIcon);
      marker.appendChild(markerLabel);

      // Events
      marker.addEventListener('mouseenter', () => this.showTooltip(location, marker));
      marker.addEventListener('mouseleave', () => this.hideTooltip());
      marker.addEventListener('click', (e) => {
        e.stopPropagation();
        this.openPopup(location);
      });

      this.markersContainer.appendChild(marker);
    });
  }

  // ============================================
  // TOOLTIP SYSTEM
  // ============================================

  showTooltip(location, marker) {
    const rect = marker.getBoundingClientRect();
    this.locationTooltip.innerHTML = `
      <p><strong>${location.name}</strong><br>${location.type}<br>Click to explore</p>
    `;
    this.locationTooltip.classList.add('visible');
    this.locationTooltip.style.left = `${rect.left + rect.width / 2}px`;
    this.locationTooltip.style.top = `${rect.top - 10}px`;
  }

  hideTooltip() {
    this.locationTooltip.classList.remove('visible');
  }

  // ============================================
  // POPUP PANEL
  // ============================================

  async openPopup(location) {
    this.activeLocation = location;

    // Show loading state initially
    document.getElementById('popup-image').src = location.image || 'assets/images/placeholder.jpg';
    document.getElementById('popup-title').textContent = location.name;
    document.getElementById('popup-description').textContent = "Loading location details...";
    document.getElementById('popup-type').textContent = location.type;
    document.getElementById('popup-danger').textContent = location.dangerLevel;
    
    document.getElementById('popup-missions').innerHTML = '<p style="color: var(--burnt-brown);">Loading...</p>';
    document.getElementById('popup-characters').innerHTML = '<p style="color: var(--burnt-brown);">Loading...</p>';

    // Highlight marker
    const marker = document.getElementById(`marker-${location.id}`);
    if (marker) marker.classList.add('active');

    // Draw routes from this location
    this.drawRoutesFromLocation(location);

    // Open popup
    this.locationPopup.classList.add('open');

    try {
      const response = await fetch(`${APP_BASE}/api/locations/${location.id}`);
      const detailedLocation = await response.json();

      document.getElementById('popup-description').textContent = detailedLocation.description;
      
      // Missions
      const missionsContainer = document.getElementById('popup-missions');
      missionsContainer.innerHTML = '';
      if (detailedLocation.missions && detailedLocation.missions.length > 0) {
        detailedLocation.missions.forEach(mission => {
          const missionEl = document.createElement('a');
          missionEl.href = '/missions?missionName=' + encodeURIComponent(mission.name);
          missionEl.className = 'mission-item';
          missionEl.style.display = 'block';
          missionEl.style.textDecoration = 'none';
          missionEl.innerHTML = `
            <div class="mission-name">🗺️ ${mission.name}</div>
            <div class="mission-description">${mission.description}</div>
          `;
          missionsContainer.appendChild(missionEl);
        });
      } else {
        missionsContainer.innerHTML = '<p style="color: var(--burnt-brown);">No missions available</p>';
      }

      // Characters
      const charactersContainer = document.getElementById('popup-characters');
      charactersContainer.innerHTML = '';
      if (detailedLocation.characters && detailedLocation.characters.length > 0) {
        detailedLocation.characters.forEach(character => {
          const charEl = document.createElement('span');
          charEl.className = 'character-tag';
          charEl.textContent = character;
          charactersContainer.appendChild(charEl);
        });
      } else {
        charactersContainer.innerHTML = '<p style="color: var(--burnt-brown);">No notable characters</p>';
      }
    } catch (err) {
      console.error("Failed to load detailed location data", err);
      document.getElementById('popup-description').textContent = location.description || "Information unavailable.";
    }

    // Travel button
    const travelBtn = document.getElementById('travel-button');
    travelBtn.onclick = () => this.sailToLocation(location);
  }

  closePopup() {
    this.locationPopup.classList.remove('open');
    
    // Remove marker highlighting
    if (this.activeLocation) {
      const marker = document.getElementById(`marker-${this.activeLocation.id}`);
      if (marker) marker.classList.remove('active');
    }
    
    // Clear routes
    this.clearRoutes();
    this.drawInitialRoutes();
    
    this.activeLocation = null;
  }

  // ============================================
  // SEARCH FUNCTIONALITY
  // ============================================

  filterLocations(searchTerm) {
    const term = searchTerm.toLowerCase().trim();
    
    if (!term) {
      this.filteredLocations = this.locations;
    } else {
      this.filteredLocations = this.locations.filter(location =>
        location.name.toLowerCase().includes(term) ||
        location.type.toLowerCase().includes(term) ||
        location.description.toLowerCase().includes(term)
      );
    }

    this.renderMarkers();
    
    if (this.filteredLocations.length === 0) {
      this.locationSearch.style.borderColor = '#5A3825';
    } else {
      this.locationSearch.style.borderColor = '#C9A44C';
    }
  }

  // ============================================
  // ROUTE DRAWING
  // ============================================

  drawInitialRoutes() {
    const routePairs = [];

    for (let index = 0; index < this.locations.length; index += 1) {
      for (let nextIndex = index + 1; nextIndex < this.locations.length; nextIndex += 1) {
        routePairs.push([this.locations[index].id, this.locations[nextIndex].id]);
      }
    }

    routePairs.forEach(([from, to]) => {
      this.drawRoute(from, to);
    });
  }

  drawRoute(fromId, toId) {
    const fromLoc = this.locations.find(l => l.id === fromId);
    const toLoc = this.locations.find(l => l.id === toId);

    if (!fromLoc || !toLoc) return;

    const routeKey = [fromId, toId].sort().join('-');
    if (this.drawnRoutes.has(routeKey)) return;

    this.drawnRoutes.add(routeKey);

    // Convert percentages to SVG coordinates
    const x1 = (fromLoc.position.x / 100) * 1200;
    const y1 = (fromLoc.position.y / 100) * 800;
    const x2 = (toLoc.position.x / 100) * 1200;
    const y2 = (toLoc.position.y / 100) * 800;

    const dx = x2 - x1;
    const dy = y2 - y1;
    const distance = Math.sqrt(dx * dx + dy * dy) || 1;
    const curveOffset = Math.min(140, Math.max(60, distance * 0.18));
    const curveDirection = ((fromId.charCodeAt(0) + toId.charCodeAt(0)) % 2 === 0) ? 1 : -1;
    const controlX = (x1 + x2) / 2 + (dy / distance) * curveOffset * curveDirection;
    const controlY = (y1 + y2) / 2 - (dx / distance) * curveOffset * curveDirection;

    const pathData = `M ${x1} ${y1} Q ${controlX} ${controlY} ${x2} ${y2}`;

    const glowPath = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    glowPath.setAttribute('d', pathData);
    glowPath.setAttribute('class', 'route-line route-line-glow');

    const mainPath = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    mainPath.setAttribute('d', pathData);
    mainPath.setAttribute('class', 'route-line route-line-main');

    mainPath.setAttribute('id', `route-${fromId}-${toId}`);

    this.routeOverlay.appendChild(glowPath);
    this.routeOverlay.appendChild(mainPath);
  }

  drawRoutesFromLocation(location) {
    this.clearRoutes();

    if (location.connectedLocations) {
      location.connectedLocations.forEach(connectedId => {
        this.drawRoute(location.id, connectedId);
      });
    }
  }

  clearRoutes() {
    this.routeOverlay.innerHTML = '';
    this.drawnRoutes.clear();
  }

  // ============================================
  // SHIP ANIMATION
  // ============================================

  sailToLocation(toLocation) {
    if (!this.activeLocation) return;

    const fromLoc = this.activeLocation;
    const toLoc = toLocation;

    // Convert percentages to pixels
    const startX = (fromLoc.position.x / 100) * this.mapCanvas.offsetWidth;
    const startY = (fromLoc.position.y / 100) * this.mapCanvas.offsetHeight;
    const endX = (toLoc.position.x / 100) * this.mapCanvas.offsetWidth;
    const endY = (toLoc.position.y / 100) * this.mapCanvas.offsetHeight;

    this.animateShip(startX, startY, endX, endY);
  }

  animateShip(startX, startY, endX, endY) {
    const ship = this.animatedShip;
    const distance = Math.sqrt(Math.pow(endX - startX, 2) + Math.pow(endY - startY, 2));
    const duration = Math.max(2000, distance / 0.3); // Adjust speed

    ship.style.left = `${startX}px`;
    ship.style.top = `${startY}px`;

    // Calculate angle
    const angle = Math.atan2(endY - startY, endX - startX) * (180 / Math.PI);
    ship.style.transform = `rotate(${angle}deg)`;

    ship.classList.add('sailing');

    let startTime = Date.now();
    const animate = () => {
      const elapsed = Date.now() - startTime;
      const progress = Math.min(elapsed / duration, 1);

      const currentX = startX + (endX - startX) * progress;
      const currentY = startY + (endY - startY) * progress;

      ship.style.left = `${currentX}px`;
      ship.style.top = `${currentY}px`;

      if (progress < 1) {
        requestAnimationFrame(animate);
      } else {
        ship.classList.remove('sailing');
        // Optional: show arrival message
        this.showArrivalMessage(this.activeLocation);
      }
    };

    animate();
  }

  showArrivalMessage(location) {
    // Create a simple toast message
    const message = document.createElement('div');
    message.style.cssText = `
      position: fixed;
      bottom: 2rem;
      left: 50%;
      transform: translateX(-50%);
      background: rgba(30, 27, 24, 0.95);
      color: #C9A44C;
      padding: 1rem 2rem;
      border: 2px solid #C9A44C;
      border-radius: 4px;
      font-family: 'Playfair Display', serif;
      z-index: 300;
      animation: slideUp 0.3s ease-out, slideDown 0.3s ease-out 3s forwards;
    `;
    message.textContent = `⚓ Arrived at ${location.name}! Preparing missions...`;
    document.body.appendChild(message);

    setTimeout(() => {
        message.remove();
        window.location.href = '/missions?location=' + location.id;
    }, 1500);
  }

  // ============================================
  // RESET VIEW
  // ============================================

  resetView() {
    this.closePopup();
    this.locationSearch.value = '';
    this.filteredLocations = this.locations;
    this.renderMarkers();
    this.clearRoutes();
    this.drawInitialRoutes();
  }
}

// ============================================
// INITIALIZATION
// ============================================

document.addEventListener('DOMContentLoaded', () => {
  const mapManager = new MapManager();

  const loader = document.getElementById('page-loader');
  if (loader) {
    const hideLoader = () => {
      document.body.classList.add('page-loaded');
      loader.classList.add('hide');
      window.setTimeout(() => loader.remove(), 520);
    };

    if (document.readyState === 'complete') {
      hideLoader();
    } else {
      window.addEventListener('load', hideLoader, { once: true });
    }
  }
});

// ============================================
// SHARED ANIMATIONS (if not in main.js)
// ============================================

const mapAnimationStyle = document.createElement('style');
mapAnimationStyle.textContent = `
  @keyframes slideUp {
    from {
      opacity: 0;
      transform: translateX(-50%) translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateX(-50%) translateY(0);
    }
  }

  @keyframes slideDown {
    from {
      opacity: 1;
      transform: translateX(-50%) translateY(0);
    }
    to {
      opacity: 0;
      transform: translateX(-50%) translateY(20px);
    }
  }
`;
document.head.appendChild(mapAnimationStyle);
