<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class MapController extends Controller
{
    /**
     * Display a listing of locations.
     */
    public function index()
    {
        $locations = Location::all()->map(function($loc) {
            return [
                'id' => $loc->id,
                'name' => $loc->name,
                'type' => $loc->type,
                'position' => ['x' => $loc->x_position, 'y' => $loc->y_position],
                'iconLabel' => $loc->icon_label,
                'icon' => asset($loc->icon),
                'description' => $loc->description,
                'dangerLevel' => $loc->danger_level,
                'image' => asset($loc->image),
                // Return basic info, connectedLocations can be hardcoded mapping or logic later
            ];
        });

        // Connected Locations logic to keep the Javascript working:
        // We will just inject the same static connected locations based on ID
        $connectedLocationsMap = [
            'port-royal' => ['tortuga', 'isla-muerta', 'shipwreck-cove', 'devils-triangle', 'kraken-depths'],
            'tortuga' => ['port-royal', 'isla-muerta', 'shipwreck-cove', 'devils-triangle', 'kraken-depths'],
            'isla-muerta' => ['port-royal', 'tortuga', 'shipwreck-cove', 'devils-triangle', 'kraken-depths'],
            'shipwreck-cove' => ['port-royal', 'tortuga', 'isla-muerta', 'devils-triangle', 'kraken-depths'],
            'devils-triangle' => ['port-royal', 'tortuga', 'isla-muerta', 'shipwreck-cove', 'kraken-depths'],
            'kraken-depths' => ['port-royal', 'tortuga', 'isla-muerta', 'shipwreck-cove', 'devils-triangle'],
        ];

        foreach ($locations as $key => $loc) {
            $loc['connectedLocations'] = $connectedLocationsMap[$loc['id']] ?? [];
            $locations[$key] = $loc;
        }

        return response()->json($locations);
    }

    /**
     * Display detailed information for a single location.
     */
    public function show($id)
    {
        $location = Location::with(['missions', 'characters'])->find($id);

        if (!$location) {
            return response()->json(['error' => 'Location not found'], 404);
        }

        return response()->json([
            'id' => $location->id,
            'name' => $location->name,
            'type' => $location->type,
            'description' => $location->description,
            'dangerLevel' => $location->danger_level,
            'image' => asset($location->image),
            'missions' => $location->missions->map(function($mission) {
                return [
                    'id' => $mission->id,
                    'name' => $mission->title,
                    'description' => $mission->description
                ];
            }),
            'characters' => $location->characters->pluck('name')
        ]);
    }
}
