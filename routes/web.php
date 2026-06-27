<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - The Lost Compass
|--------------------------------------------------------------------------
|
| Routes for the pirate universe. Home page and auth are controller-backed.
| Other pages remain as simple view routes.
|
*/

use App\Http\Controllers\CharacterController;

use App\Http\Controllers\AdminController;

// ─── Home (Dynamic via Controller) ────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// ─── Authentication Routes ────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─── Admin Control Panel ──────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Character CRUD
    Route::get('/characters', [AdminController::class, 'charactersIndex'])->name('characters.index');
    Route::get('/characters/create', [AdminController::class, 'charactersCreate'])->name('characters.create');
    Route::post('/characters', [AdminController::class, 'charactersStore'])->name('characters.store');
    Route::get('/characters/{id}/edit', [AdminController::class, 'charactersEdit'])->name('characters.edit');
    Route::put('/characters/{id}', [AdminController::class, 'charactersUpdate'])->name('characters.update');
    Route::delete('/characters/{id}', [AdminController::class, 'charactersDestroy'])->name('characters.destroy');

    // Ship CRUD
    Route::get('/ships', [AdminController::class, 'shipsIndex'])->name('ships.index');
    Route::get('/ships/create', [AdminController::class, 'shipsCreate'])->name('ships.create');
    Route::post('/ships', [AdminController::class, 'shipsStore'])->name('ships.store');
    Route::get('/ships/{id}/edit', [AdminController::class, 'shipsEdit'])->name('ships.edit');
    Route::put('/ships/{id}', [AdminController::class, 'shipsUpdate'])->name('ships.update');
    Route::delete('/ships/{id}', [AdminController::class, 'shipsDestroy'])->name('ships.destroy');

    // Map Locations CRUD
    Route::get('/locations', [AdminController::class, 'locationsIndex'])->name('locations.index');
    Route::get('/locations/create', [AdminController::class, 'locationsCreate'])->name('locations.create');
    Route::post('/locations', [AdminController::class, 'locationsStore'])->name('locations.store');
    Route::get('/locations/{id}/edit', [AdminController::class, 'locationsEdit'])->name('locations.edit');
    Route::put('/locations/{id}', [AdminController::class, 'locationsUpdate'])->name('locations.update');
    Route::delete('/locations/{id}', [AdminController::class, 'locationsDestroy'])->name('locations.destroy');

    // Missions CRUD
    Route::get('/missions', [AdminController::class, 'missionsIndex'])->name('missions.index');
    Route::get('/missions/create', [AdminController::class, 'missionsCreate'])->name('missions.create');
    Route::post('/missions', [AdminController::class, 'missionsStore'])->name('missions.store');
    Route::get('/missions/{id}/edit', [AdminController::class, 'missionsEdit'])->name('missions.edit');
    Route::put('/missions/{id}', [AdminController::class, 'missionsUpdate'])->name('missions.update');
    Route::delete('/missions/{id}', [AdminController::class, 'missionsDestroy'])->name('missions.destroy');

    // Tavern Rumors CRUD
    Route::get('/rumors', [AdminController::class, 'rumorsIndex'])->name('rumors.index');
    Route::get('/rumors/create', [AdminController::class, 'rumorsCreate'])->name('rumors.create');
    Route::post('/rumors', [AdminController::class, 'rumorsStore'])->name('rumors.store');
    Route::get('/rumors/{id}/edit', [AdminController::class, 'rumorsEdit'])->name('rumors.edit');
    Route::put('/rumors/{id}', [AdminController::class, 'rumorsUpdate'])->name('rumors.update');
    Route::delete('/rumors/{id}', [AdminController::class, 'rumorsDestroy'])->name('rumors.destroy');

    // Tavern Notices CRUD
    Route::get('/notices', [AdminController::class, 'noticesIndex'])->name('notices.index');
    Route::get('/notices/create', [AdminController::class, 'noticesCreate'])->name('notices.create');
    Route::post('/notices', [AdminController::class, 'noticesStore'])->name('notices.store');
    Route::get('/notices/{id}/edit', [AdminController::class, 'noticesEdit'])->name('notices.edit');
    Route::put('/notices/{id}', [AdminController::class, 'noticesUpdate'])->name('notices.update');
    Route::delete('/notices/{id}', [AdminController::class, 'noticesDestroy'])->name('notices.destroy');
});

// ─── Characters (Dynamic via Controller) ─────────────────────
Route::get('/characters', [CharacterController::class, 'index'])->name('characters');
Route::get('/api/characters', [CharacterController::class, 'apiList']);
Route::get('/api/characters/{id}', [CharacterController::class, 'apiShow']);

// ─── Ships API ────────────────────────────────────────────────
use App\Http\Controllers\Api\ShipController;
Route::get('/api/ships', [ShipController::class, 'index']);
Route::get('/api/ships/{id}', [ShipController::class, 'show']);

// ─── Map Locations API ───────────────────────────────────────
use App\Http\Controllers\Api\MapController;
Route::get('/api/locations', [App\Http\Controllers\Api\MapController::class, 'index']);
Route::get('/api/locations/{id}', [App\Http\Controllers\Api\MapController::class, 'show']);

// Mission Engine APIs
Route::get('/api/engine/missions', [App\Http\Controllers\Api\MissionEngineController::class, 'getMissions']);
Route::get('/api/engine/missions/{id}/load', [App\Http\Controllers\Api\MissionEngineController::class, 'loadMission']);
Route::post('/api/engine/missions/{id}/choice', [App\Http\Controllers\Api\MissionEngineController::class, 'makeChoice']);
Route::post('/api/engine/missions/{id}/claim', [App\Http\Controllers\Api\MissionEngineController::class, 'claimReward']);

// ─── Tavern API ──────────────────────────────────────────────
use App\Http\Controllers\Api\TavernController;
Route::get('/api/tavern/posts', [TavernController::class, 'getPosts']);
Route::post('/api/tavern/posts', [TavernController::class, 'createPost']);
Route::post('/api/tavern/posts/{id}/reply', [TavernController::class, 'createComment']);
Route::post('/api/tavern/posts/{id}/like', [TavernController::class, 'toggleLike']);
Route::get('/api/tavern/rumors', [TavernController::class, 'getRumors']);
Route::get('/api/tavern/notices', [TavernController::class, 'getNotices']);
Route::get('/api/tavern/leaderboard', [TavernController::class, 'getLeaderboard']);

// ─── Content Pages (Frontend-only) ───────────────────────────

Route::get('/ships', function () {
    return view('pages.ships');
})->name('ships');

Route::get('/map', function () {
    return view('pages.map');
})->name('map');

Route::get('/missions', function () {
    return view('pages.missions');
})->name('missions');

Route::get('/relics', function () {
    return view('pages.relics');
})->name('relics');

Route::get('/rankings', function () {
    return view('pages.rankings');
})->name('rankings');

Route::get('/tavern', function () {
    return view('pages.tavern');
})->name('tavern');

Route::get('/profile', function () {
    return view('pages.profile');
})->name('profile');

Route::get('/quiz', function () {
    $identityQuestions = \App\Models\Question::with('answers')->where('type', 'identity')->inRandomOrder()->limit(10)->get();
    $shipQuestions = \App\Models\Question::with('answers')->where('type', 'ship')->inRandomOrder()->limit(5)->get();
    $weaponQuestions = \App\Models\Question::with('answers')->where('type', 'weapon')->inRandomOrder()->limit(5)->get();
    
    $mapFn = function($q) {
        return [
            'question' => $q->question_text,
            'answers' => $q->answers->map(function($a) {
                return [
                    'text' => $a->answer_text,
                    'role' => $a->role_impact,
                    'trait' => $a->trait_impact,
                    'allegiance' => $a->allegiance_impact,
                    'ship' => $a->ship_impact,
                    'weapon' => $a->weapon_impact
                ];
            })->toArray()
        ];
    };

    $identityData = $identityQuestions->map($mapFn)->toArray();
    $shipData = $shipQuestions->map($mapFn)->toArray();
    $weaponData = $weaponQuestions->map($mapFn)->toArray();
    
    return view('pages.quiz', compact('identityData', 'shipData', 'weaponData'));
})->name('quiz');

Route::post('/quiz/identity/submit', function (\Illuminate\Http\Request $request) {
    $request->session()->put('quiz_identity_data', [
        'identity_character' => $request->input('identity_character'),
        'pirate_name' => $request->input('pirate_name'),
        'role' => $request->input('role'),
        'relic' => $request->input('relic'),
        'allegiance' => $request->input('allegiance'),
        'trait' => $request->input('trait')
    ]);
    return redirect()->route('signup')->with('quiz_message', 'The Compass has chosen you. Now claim your destiny.');
});

Route::middleware('auth')->group(function () {
    Route::post('/quiz/ship/submit', function (\Illuminate\Http\Request $request) {
        $user = auth()->user();
        if ($user) {
            $user->update(['ship' => $request->input('ship')]);
        }
        return redirect()->route('profile')->with('status', 'Ship claimed successfully!');
    });

    Route::post('/quiz/weapon/submit', function (\Illuminate\Http\Request $request) {
        $user = auth()->user();
        if ($user) {
            $user->update(['weapon' => $request->input('weapon')]);
        }
        return redirect()->route('profile')->with('status', 'Weapon claimed successfully!');
    });
});
