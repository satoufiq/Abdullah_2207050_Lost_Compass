<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    /**
     * Display the Character Gallery page.
     */
    public function index()
    {
        $questions = \App\Models\Question::with('answers')->where('type', 'identity')->inRandomOrder()->limit(10)->get();
        
        $quizDataArray = $questions->map(function($q) {
            return [
                'question' => $q->question_text,
                'answers' => $q->answers->map(function($a) {
                    return [
                        'text' => $a->answer_text,
                        'role' => $a->role_impact,
                        'trait' => $a->trait_impact,
                        'allegiance' => $a->allegiance_impact
                    ];
                })->toArray()
            ];
        })->toArray();
        
        return view('pages.characters', compact('quizDataArray'));
    }

    /**
     * API endpoint: Get a list of characters, optionally filtered and searched.
     */
    public function apiList(Request $request)
    {
        $query = Character::query();

        // Filter by category or tags if provided
        $filter = $request->query('category', 'all');
        if ($filter !== 'all') {
            $query->where(function ($q) use ($filter) {
                $q->where('category', $filter)
                  ->orWhereJsonContains('tags', $filter);
            });
        }

        // Search by name if provided
        $search = $request->query('search');
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Only select the fields needed for the grid to save bandwidth
        $characters = $query->select(['id', 'name', 'role', 'short_line', 'image'])
                            ->get();

        return response()->json($characters);
    }

    /**
     * API endpoint: Get full details for a single character for the modal.
     */
    public function apiShow($id)
    {
        $character = Character::with(['allies', 'enemies'])->find($id);

        if (!$character) {
            return response()->json(['error' => 'Character not found'], 404);
        }

        // Format the response to match what the frontend expects
        return response()->json([
            'id' => $character->id,
            'name' => $character->name,
            'role' => $character->role,
            'short_line' => $character->short_line,
            'quote' => $character->quote,
            'category' => $character->category,
            'tags' => $character->tags,
            'image' => $character->image,
            'biography' => $character->biography,
            'ship' => $character->ship_name, // Using the string field directly
            'weapon' => $character->weapon,
            'firstAppearance' => $character->first_appearance,
            'allies' => $character->allies->pluck('related_name'),
            'enemies' => $character->enemies->pluck('related_name'),
        ]);
    }
}
