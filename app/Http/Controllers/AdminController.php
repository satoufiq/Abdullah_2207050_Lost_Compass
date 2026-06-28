<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        $characterCount = Character::count();
        $missionCount = \App\Models\Mission::count();
        $rumorCount = \App\Models\TavernRumor::count();
        $noticeCount = \App\Models\TavernNotice::count();
        $shipCount = \App\Models\Ship::count();
        $locationCount = \App\Models\Location::count();
        return view('admin.dashboard', compact('characterCount', 'missionCount', 'rumorCount', 'noticeCount', 'shipCount', 'locationCount'));
    }

    /**
     * List all characters.
     */
    public function charactersIndex()
    {
        $characters = Character::all();
        return view('admin.characters.index', compact('characters'));
    }

    /**
     * Show the form for creating a new character.
     */
    public function charactersCreate()
    {
        return view('admin.characters.create');
    }

    /**
     * Store a newly created character.
     */
    public function charactersStore(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|string|unique:characters,id',
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'short_line' => 'required|string|max:255',
            'quote' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'tags' => 'nullable|string', // Will be converted to array
            'image' => 'nullable|string|max:255',
            'biography' => 'required|string',
            'ship_name' => 'nullable|string|max:255',
            'weapon' => 'nullable|string|max:255',
            'first_appearance' => 'nullable|string|max:255',
        ]);

        if (empty($validated['id'])) {
            $validated['id'] = Str::slug($validated['name']);
        }

        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        } else {
            $validated['tags'] = [];
        }

        Character::create($validated);

        return redirect()->route('admin.characters.index')->with('success', 'Character added successfully.');
    }

    /**
     * Show the form for editing the specified character.
     */
    public function charactersEdit($id)
    {
        $character = Character::findOrFail($id);
        return view('admin.characters.edit', compact('character'));
    }

    /**
     * Update the specified character.
     */
    public function charactersUpdate(Request $request, $id)
    {
        $character = Character::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'short_line' => 'required|string|max:255',
            'quote' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'tags' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'biography' => 'required|string',
            'ship_name' => 'nullable|string|max:255',
            'weapon' => 'nullable|string|max:255',
            'first_appearance' => 'nullable|string|max:255',
        ]);

        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        } else {
            $validated['tags'] = [];
        }

        $character->update($validated);

        return redirect()->route('admin.characters.index')->with('success', 'Character updated successfully.');
    }

    /**
     * Remove the specified character.
     */
    public function charactersDestroy($id)
    {
        $character = Character::findOrFail($id);
        $character->delete();

        return redirect()->route('admin.characters.index')->with('success', 'Character deleted successfully.');
    }

    // ==========================================
    // SHIPS CRUD
    // ==========================================

    public function shipsIndex()
    {
        $ships = \App\Models\Ship::with('captain')->get();
        return view('admin.ships.index', compact('ships'));
    }

    public function shipsCreate()
    {
        $captains = \App\Models\Captain::all();
        return view('admin.ships.create', compact('captains'));
    }

    public function shipsStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'captain_id' => 'nullable|exists:captains,id',
            'type' => 'nullable|string|max:255',
            'speed' => 'required|integer|min:0|max:10',
            'attack_power' => 'required|integer|min:0|max:10',
            'defense' => 'required|integer|min:0|max:10',
            'curse_level' => 'required|integer|min:0|max:10',
            'legend_rank' => 'required|integer|min:0|max:10',
            'tags' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'history' => 'nullable|string',
            'weapons' => 'nullable|string',
            'curse' => 'nullable|string',
            'fate' => 'nullable|string',
            'short_power' => 'nullable|string|max:255',
        ]);

        \App\Models\Ship::create($validated);

        return redirect()->route('admin.ships.index')->with('success', 'Ship added successfully.');
    }

    public function shipsEdit($id)
    {
        $ship = \App\Models\Ship::findOrFail($id);
        $captains = \App\Models\Captain::all();
        return view('admin.ships.edit', compact('ship', 'captains'));
    }

    public function shipsUpdate(Request $request, $id)
    {
        $ship = \App\Models\Ship::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'captain_id' => 'nullable|exists:captains,id',
            'type' => 'nullable|string|max:255',
            'speed' => 'required|integer|min:0|max:10',
            'attack_power' => 'required|integer|min:0|max:10',
            'defense' => 'required|integer|min:0|max:10',
            'curse_level' => 'required|integer|min:0|max:10',
            'legend_rank' => 'required|integer|min:0|max:10',
            'tags' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'history' => 'nullable|string',
            'weapons' => 'nullable|string',
            'curse' => 'nullable|string',
            'fate' => 'nullable|string',
            'short_power' => 'nullable|string|max:255',
        ]);

        $ship->update($validated);

        return redirect()->route('admin.ships.index')->with('success', 'Ship updated successfully.');
    }

    public function shipsDestroy($id)
    {
        $ship = \App\Models\Ship::findOrFail($id);
        $ship->delete();

        return redirect()->route('admin.ships.index')->with('success', 'Ship deleted successfully.');
    }

    // ==========================================
    // TAVERN RUMORS CRUD
    // ==========================================

    public function rumorsIndex()
    {
        $rumors = \App\Models\TavernRumor::all();
        return view('admin.rumors.index', compact('rumors'));
    }

    public function rumorsCreate()
    {
        return view('admin.rumors.create');
    }

    public function rumorsStore(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:500',
            'source' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        \App\Models\TavernRumor::create($validated);

        return redirect()->route('admin.rumors.index')->with('success', 'Rumor added successfully.');
    }

    public function rumorsEdit($id)
    {
        $rumor = \App\Models\TavernRumor::findOrFail($id);
        return view('admin.rumors.edit', compact('rumor'));
    }

    public function rumorsUpdate(Request $request, $id)
    {
        $rumor = \App\Models\TavernRumor::findOrFail($id);

        $validated = $request->validate([
            'content' => 'required|string|max:500',
            'source' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $rumor->update($validated);

        return redirect()->route('admin.rumors.index')->with('success', 'Rumor updated successfully.');
    }

    public function rumorsDestroy($id)
    {
        $rumor = \App\Models\TavernRumor::findOrFail($id);
        $rumor->delete();

        return redirect()->route('admin.rumors.index')->with('success', 'Rumor deleted successfully.');
    }

    // ==========================================
    // TAVERN NOTICES CRUD
    // ==========================================

    public function noticesIndex()
    {
        $notices = \App\Models\TavernNotice::all();
        return view('admin.notices.index', compact('notices'));
    }

    public function noticesCreate()
    {
        return view('admin.notices.create');
    }

    public function noticesStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'reward' => 'required|string|max:255',
            'desc' => 'required|string',
            'image' => 'nullable|string|max:255',
        ]);

        if (empty($validated['image'])) {
            $validated['image'] = 'wanted-default.jpg';
        }

        \App\Models\TavernNotice::create($validated);

        return redirect()->route('admin.notices.index')->with('success', 'Wanted Notice added successfully.');
    }

    public function noticesEdit($id)
    {
        $notice = \App\Models\TavernNotice::findOrFail($id);
        return view('admin.notices.edit', compact('notice'));
    }

    public function noticesUpdate(Request $request, $id)
    {
        $notice = \App\Models\TavernNotice::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'reward' => 'required|string|max:255',
            'desc' => 'required|string',
            'image' => 'nullable|string|max:255',
        ]);

        if (empty($validated['image'])) {
            $validated['image'] = 'wanted-default.jpg';
        }

        $notice->update($validated);

        return redirect()->route('admin.notices.index')->with('success', 'Wanted Notice updated successfully.');
    }

    public function noticesDestroy($id)
    {
        $notice = \App\Models\TavernNotice::findOrFail($id);
        $notice->delete();

        return redirect()->route('admin.notices.index')->with('success', 'Wanted Notice deleted successfully.');
    }

    // ==========================================
    // MAP LOCATIONS CRUD
    // ==========================================

    public function locationsIndex()
    {
        $locations = \App\Models\Location::all();
        return view('admin.locations.index', compact('locations'));
    }

    public function locationsCreate()
    {
        return view('admin.locations.create');
    }

    public function locationsStore(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|string|unique:locations,id|max:255',
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'required|string',
            'danger_level' => 'required|integer|min:1|max:5',
            'image' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'icon_label' => 'nullable|string|max:255',
            'x_position' => 'required|integer|min:0|max:100',
            'y_position' => 'required|integer|min:0|max:100',
        ]);

        \App\Models\Location::create($validated);

        return redirect()->route('admin.locations.index')->with('success', 'Location added successfully.');
    }

    public function locationsEdit($id)
    {
        $location = \App\Models\Location::findOrFail($id);
        return view('admin.locations.edit', compact('location'));
    }

    public function locationsUpdate(Request $request, $id)
    {
        $location = \App\Models\Location::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'required|string',
            'danger_level' => 'required|integer|min:1|max:5',
            'image' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'icon_label' => 'nullable|string|max:255',
            'x_position' => 'required|integer|min:0|max:100',
            'y_position' => 'required|integer|min:0|max:100',
        ]);

        $location->update($validated);

        return redirect()->route('admin.locations.index')->with('success', 'Location updated successfully.');
    }

    public function locationsDestroy($id)
    {
        $location = \App\Models\Location::findOrFail($id);
        $location->delete();

        return redirect()->route('admin.locations.index')->with('success', 'Location deleted successfully.');
    }

    // ==========================================
    // MISSIONS CRUD
    // ==========================================

    public function missionsIndex()
    {
        $missions = \App\Models\Mission::with('location_model')->get();
        return view('admin.missions.index', compact('missions'));
    }

    public function missionsCreate()
    {
        $locations = \App\Models\Location::all();
        $ships = \App\Models\Ship::all();
        return view('admin.missions.create', compact('locations', 'ships'));
    }

    public function missionsStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'location_id' => 'nullable|string|exists:locations,id',
            'difficulty' => 'required|integer|min:1|max:5',
            'featured' => 'boolean',
            'ship_id' => 'nullable|exists:ships,id',
        ]);

        $validated['featured'] = $request->has('featured');

        // Automatically set the legacy `location` field based on `location_id`
        if (!empty($validated['location_id'])) {
            $loc = \App\Models\Location::find($validated['location_id']);
            if ($loc) {
                $validated['location'] = $loc->name;
            }
        }

        \App\Models\Mission::create($validated);

        return redirect()->route('admin.missions.index')->with('success', 'Mission added successfully.');
    }

    public function missionsEdit($id)
    {
        $mission = \App\Models\Mission::findOrFail($id);
        $locations = \App\Models\Location::all();
        $ships = \App\Models\Ship::all();
        return view('admin.missions.edit', compact('mission', 'locations', 'ships'));
    }

    public function missionsUpdate(Request $request, $id)
    {
        $mission = \App\Models\Mission::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'location_id' => 'nullable|string|exists:locations,id',
            'difficulty' => 'required|integer|min:1|max:5',
            'featured' => 'boolean',
            'ship_id' => 'nullable|exists:ships,id',
        ]);

        $validated['featured'] = $request->has('featured');

        // Automatically set the legacy `location` field based on `location_id`
        if (!empty($validated['location_id'])) {
            $loc = \App\Models\Location::find($validated['location_id']);
            if ($loc) {
                $validated['location'] = $loc->name;
            }
        }

        $mission->update($validated);

        return redirect()->route('admin.missions.index')->with('success', 'Mission updated successfully.');
    }

    public function missionsDestroy($id)
    {
        $mission = \App\Models\Mission::findOrFail($id);
        $mission->delete();

        return redirect()->route('admin.missions.index')->with('success', 'Mission deleted successfully.');
    }
}
