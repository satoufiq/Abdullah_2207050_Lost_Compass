<x-app-layout>
    @section('body_class', 'home-page auth-page')
    @section('use_base_css', true)

    @include('partials.nav')

    <div class="auth-wrapper" style="min-height: calc(100vh - 86px); display:flex; justify-content:center; align-items:center; background: radial-gradient(ellipse at center, hsl(25, 28%, 10%), hsl(22, 35%, 4%)); padding: 2rem;">
        <div class="auth-card" style="background: linear-gradient(145deg, hsl(25, 22%, 10%) 0%, hsl(220, 28%, 9%) 100%); border: 1px solid rgba(240,180,73,0.2); border-radius: 16px; padding: 2.5rem; max-width: 450px; width: 100%; box-shadow: 0 10px 40px rgba(0,0,0,0.8); position: relative; overflow: hidden;">
            
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2 style="font-family: 'Cinzel', serif; font-size: 2rem; color: #d4af37; text-shadow: 0 0 15px rgba(212,175,55,0.4); margin: 0; letter-spacing: 2px;">THE LOST COMPASS</h2>
                <p style="color: #a89f91; font-size: 0.9rem; font-style: italic; margin-top: 0.5rem;">Identify yourself, Captain</p>
            </div>

            <style>
                .auth-card, .auth-card label, .auth-card span, .auth-card h2 { color: #d9c9a8; font-family: 'Lora', serif; }
                .auth-card a { color: #d4af37; text-decoration: none; transition: all 0.3s ease; }
                .auth-card a:hover { color: #fff; text-shadow: 0 0 8px rgba(212,175,55,0.6); }
                .auth-card input { background: rgba(0,0,0,0.5); border: 1px solid rgba(201,164,76,0.3); color: #fff; border-radius: 6px; padding: 0.75rem; width: 100%; margin-top: 0.25rem; font-family: 'Lora', serif; transition: all 0.3s ease; }
                .auth-card button { background: linear-gradient(to bottom, #d4af37, #8b6b22); color: #111; padding: 0.75rem 1.5rem; border-radius: 6px; border: 1px solid #ffd700; font-weight: bold; cursor: pointer; font-family: 'Cinzel', serif; letter-spacing: 1px; transition: all 0.3s ease; }
                .auth-card button:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(212,175,55,0.4); }
                .auth-card input:focus { outline: none; border-color: #d4af37; box-shadow: 0 0 10px rgba(212,175,55,0.3); }
                .auth-card [type="checkbox"] { width: auto; margin-right: 0.5rem; accent-color: #d4af37; }
                .auth-card .mt-4 { margin-top: 1.5rem; }
                .auth-card .mt-1 { margin-top: 0.5rem; }
                .auth-card .mt-2 { margin-top: 0.5rem; }
                .auth-card .mb-4 { margin-bottom: 1.5rem; }
                .auth-card .block { display: block; }
                .auth-card .w-full { width: 100%; box-sizing: border-box; }
                .auth-card .flex { display: flex; }
                .auth-card .items-center { align-items: center; }
                .auth-card .justify-end { justify-content: flex-end; }
                .auth-card .justify-between { justify-content: space-between; }
                .auth-card .ms-3 { margin-left: 1rem; }
                .auth-card .text-sm { font-size: 0.9rem; }
                .auth-card .text-red-600 { color: #ff6b6b; }
            </style>
            {{ $slot }}
        </div>
    </div>
    
    @include('partials.footer-main')
</x-app-layout>
