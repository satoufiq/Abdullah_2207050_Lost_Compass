<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MissionEngineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $missionsData = include database_path('seeders/MissionsData.php');

        // We assume Mission records already exist with title matching the ones in MissionsData.
        foreach ($missionsData as $missionConfig) {
            $missionTitle = $missionConfig['title'];
            $mission = \App\Models\Mission::where('title', $missionTitle)->first();

            if (!$mission) {
                // If it doesn't exist, we skip or create it. But MissionSeeder already seeded them.
                continue;
            }

            // Create Scenes and Choices
            foreach ($missionConfig['nodes'] as $nodeId => $nodeData) {
                // The ID should be unique, so we prefix it with mission id
                $sceneId = $missionConfig['id'] . '-' . $nodeId;
                
                $rewards = null;
                if (isset($nodeData['rewards'])) {
                    $rewards = json_encode($nodeData['rewards']);
                }

                \App\Models\MissionScene::updateOrCreate(
                    ['id' => $sceneId],
                    [
                        'mission_id' => $mission->id,
                        'title' => $nodeData['title'] ?? null,
                        'scene_text' => $nodeData['text'] ?? '',
                        'image' => $nodeData['image'] ?? null,
                        'is_ending' => $nodeData['ending'] ?? false,
                        'outcome_type' => $nodeData['outcome'] ?? null,
                        'rewards' => $rewards,
                    ]
                );

                // Create choices if any
                if (isset($nodeData['choices'])) {
                    foreach ($nodeData['choices'] as $choice) {
                        $nextSceneId = $missionConfig['id'] . '-' . $choice['next'];
                        
                        \App\Models\MissionChoice::create([
                            'scene_id' => $sceneId,
                            'choice_text' => $choice['label'],
                            'consequence_text' => $choice['consequence'] ?? null,
                            'next_scene_id' => $nextSceneId,
                            'sfx' => $choice['sfx'] ?? null,
                        ]);
                    }
                }
            }
        }
    }
}
