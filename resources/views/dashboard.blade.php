<x-app-layout>
    @section('body_class', 'home-page')
    @section('use_base_css', true)

    <div class="dashboard-wrapper" style="min-height: 100vh; background: radial-gradient(ellipse at center, hsl(25, 28%, 10%), hsl(22, 35%, 4%)); padding: 4rem 2rem;">
        <div style="max-width: 1000px; margin: 0 auto;">
            
            <header style="border-bottom: 2px solid rgba(240,180,73,0.3); padding-bottom: 1rem; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: flex-end;">
                <div>
                    <h2 style="font-family: 'Cinzel', serif; font-size: 2.5rem; color: #d4af37; margin: 0; text-shadow: 0 0 15px rgba(212,175,55,0.4);">
                        Captain's Quarters
                    </h2>
                    <p style="color: #a89f91; font-family: 'Lora', serif; margin-top: 0.5rem; font-style: italic;">
                        Welcome aboard, {{ Auth::user()->name }}
                    </p>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="background: transparent; color: #d4af37; border: 1px solid #d4af37; padding: 0.5rem 1rem; border-radius: 4px; font-family: 'Cinzel', serif; cursor: pointer; transition: all 0.3s ease;">
                        Abandon Ship (Logout)
                    </button>
                </form>
            </header>

            <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                
                <!-- Static Card -->
                <div class="pirate-card" style="background: linear-gradient(145deg, hsl(25, 22%, 10%) 0%, hsl(220, 28%, 9%) 100%); border: 1px solid rgba(240,180,73,0.2); border-radius: 12px; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
                    <h3 style="color: #d9c9a8; font-family: 'Cinzel', serif; font-size: 1.5rem; border-bottom: 1px solid rgba(201,164,76,0.3); padding-bottom: 0.5rem; margin-bottom: 1.5rem;">Ship Manifest</h3>
                    <ul style="color: #a89f91; font-family: 'Lora', serif; list-style: none; padding: 0; line-height: 2;">
                        <li><strong>Email:</strong> {{ Auth::user()->email }}</li>
                        <li><strong>Joined:</strong> {{ Auth::user()->created_at->format('M d, Y') }}</li>
                        <li><strong>Status:</strong> <span style="color: #28a745;">Active</span></li>
                    </ul>
                </div>

                <!-- Async Data Card -->
                <div class="pirate-card" style="background: linear-gradient(145deg, hsl(25, 22%, 10%) 0%, hsl(220, 28%, 9%) 100%); border: 1px solid rgba(240,180,73,0.2); border-radius: 12px; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.5); position: relative;">
                    <h3 style="color: #d9c9a8; font-family: 'Cinzel', serif; font-size: 1.5rem; border-bottom: 1px solid rgba(201,164,76,0.3); padding-bottom: 0.5rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                        Live Pirate Stats
                        <button id="refresh-stats" style="background: none; border: none; color: #d4af37; cursor: pointer; font-size: 0.9rem; text-decoration: underline; font-family: 'Lora', serif;">Refresh</button>
                    </h3>
                    
                    <div id="stats-loading" style="color: #a89f91; font-family: 'Lora', serif; font-style: italic; text-align: center; padding: 2rem 0;">
                        Consulting the compass...
                    </div>
                    
                    <ul id="stats-content" style="color: #a89f91; font-family: 'Lora', serif; list-style: none; padding: 0; line-height: 2; display: none;">
                        <li><strong>Current Bounty:</strong> <span id="stat-bounty" style="color: #d4af37;"></span></li>
                        <li><strong>Title:</strong> <span id="stat-title"></span></li>
                        <li><strong>Ship:</strong> <span id="stat-ship"></span></li>
                        <li><strong>Missions Completed:</strong> <span id="stat-missions"></span></li>
                        <li><strong>Infamy Level:</strong> <span id="stat-infamy" style="color: #ff6b6b;"></span></li>
                        <li><strong>Last Seen:</strong> <span id="stat-lastseen"></span></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <!-- Asynchronous JavaScript to fetch API data -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loadingIndicator = document.getElementById('stats-loading');
            const contentArea = document.getElementById('stats-content');
            const refreshBtn = document.getElementById('refresh-stats');
            
            function fetchPirateStats() {
                // Show loading
                contentArea.style.display = 'none';
                loadingIndicator.style.display = 'block';
                
                // Fetch from our new API endpoint protected by Sanctum
                fetch('/api/pirate-stats', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Update DOM elements dynamically
                    document.getElementById('stat-bounty').textContent = data.bounty;
                    document.getElementById('stat-title').textContent = data.title;
                    document.getElementById('stat-ship').textContent = data.ship;
                    document.getElementById('stat-missions').textContent = data.missions_completed;
                    document.getElementById('stat-infamy').textContent = data.infamy_level;
                    document.getElementById('stat-lastseen').textContent = data.last_seen;
                    
                    // Hide loading, show content
                    loadingIndicator.style.display = 'none';
                    contentArea.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error fetching pirate stats:', error);
                    loadingIndicator.textContent = 'Failed to read the compass. The sea is turbulent.';
                    loadingIndicator.style.color = '#ff6b6b';
                });
            }

            // Fetch immediately on load
            fetchPirateStats();
            
            // Allow manual refresh
            refreshBtn.addEventListener('click', fetchPirateStats);
        });
    </script>
</x-app-layout>
