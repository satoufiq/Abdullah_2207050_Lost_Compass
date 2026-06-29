<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ship;
use Illuminate\Http\Request;

class ShipController extends Controller
{
    /**
     * Display a listing of ships with optional filtering and sorting.
     */
    public function index(Request $request)
    {
        $query = Ship::query()->with('captain');

        // Filter by ship category
        if ($request->has('type') && $request->type !== 'all') {
            if ($request->type === 'legendary') {
                // Return all legendary (or we can just sort by legend_rank later, but let's assume 'all' basically)
                // but the JS filter specifies "cursed", "navy", "ghost". Legendary means all in the JS.
            } else {
                // E.g., type=Ghost Ship -> $query->where('type', 'Ghost Ship')
                // To support comma separated or simple matching:
                $query->where('tags', 'LIKE', '%' . $request->type . '%');
            }
        }

        // Apply Search
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $ships = $query->get();

        // Sort if requested
        if ($request->has('sort')) {
            $sort = $request->sort;
            if ($sort === 'legend') {
                $ships = $ships->sortByDesc('legend_rank');
            } else {
                $ships = $ships->sortByDesc($sort); // speed, attack, defense, curse
            }
        } else {
            $ships = $ships->sortByDesc('legend_rank');
        }

        // Format for frontend JSON
        $formatted = $ships->values()->map(function($ship) {
            return [
                'id' => $ship->id,
                'name' => $ship->name,
                'captain' => $ship->captain ? $ship->captain->name : 'Unknown',
                'type' => $ship->type,
                'category' => explode(',', $ship->tags), // e.g., ['all', 'ghost', 'cursed']
                'image' => asset($ship->image),
                'shortPower' => $ship->short_power,
                'history' => $ship->history,
                'weapons' => $ship->weapons,
                'curse' => $ship->curse,
                'fate' => $ship->fate,
                'stats' => [
                    'speed' => $ship->speed,
                    'attack' => $ship->attack_power,
                    'defense' => $ship->defense,
                    'curse' => $ship->curse_level
                ],
                'legendRank' => $ship->legend_rank
            ];
        });

        return response()->json($formatted);
    }

    /**
     * Display detailed information for a single ship
     */
    public function show($id)
    {
        $ship = Ship::with(['captain', 'missions'])->find($id);

        if (!$ship) {
            return response()->json(['error' => 'Ship not found'], 404);
        }

        return response()->json([
            'id' => $ship->id,
            'name' => $ship->name,
            'captain' => $ship->captain ? $ship->captain->name : 'Unknown',
            'type' => $ship->type,
            'image' => asset($ship->image),
            'history' => $ship->history,
            'weapons' => $ship->weapons,
            'curse' => $ship->curse,
            'fate' => $ship->fate,
            'stats' => [
                'speed' => $ship->speed,
                'attack' => $ship->attack_power,
                'defense' => $ship->defense,
                'curse' => $ship->curse_level
            ],
            'missions' => $ship->missions->map(function($mission) {
                return [
                    'id' => $mission->id,
                    'title' => $mission->title,
                    'description' => $mission->description
                ];
            })
        ]);
    }
}
