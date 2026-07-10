<?php

namespace Database\Seeders;

use App\Models\Mission;
use Illuminate\Database\Seeder;

class MissionSeeder extends Seeder
{
    /**
     * Seed the missions table with featured and standard missions.
     */
    public function run(): void
    {
        $missions = [
            // Featured missions
            [
                'title' => 'Recover the Aztec Coin',
                'description' => 'The compass points toward a cursed cave where one coin can make or break your fate.',
                'image' => 'assets/images/missions/Aztec_Gold for mission card.jpg',
                'location' => 'Isla de Muerta',
                'difficulty' => 4,
                'featured' => true,
            ],
            [
                'title' => 'Escape the Kraken',
                'description' => 'A storm tears the horizon apart while the Kraken rises beneath your hull.',
                'image' => 'assets/images/missions/kraken-01-stormfront.jpg',
                'location' => 'Kraken Depths',
                'difficulty' => 4,
                'featured' => true,
            ],
            [
                'title' => 'Duel at Tortuga',
                'description' => 'Inside a smoky tavern, a rival captain challenges your right to command the harbor.',
                'image' => 'assets/images/missions/duel mission card.jpg',
                'location' => 'Tortuga',
                'difficulty' => 3,
                'featured' => true,
            ],
            // Standard missions
            [
                'title' => 'Port Royal: The Smuggler Ledger',
                'description' => 'The docks are under inspection, and a hidden ledger could expose the whole smuggling ring.',
                'image' => 'assets/images/missions/portroyal-card.jpg',
                'location' => 'Port Royal',
                'difficulty' => 3,
                'featured' => false,
            ],
            [
                'title' => 'Shipwreck Cove: The Hidden Charter',
                'description' => 'The Brethren Court keeps an old charter locked inside the wrecks of the cove.',
                'image' => 'assets/images/missions/shipwreck-card.jpg',
                'location' => 'Shipwreck Cove',
                'difficulty' => 4,
                'featured' => false,
            ],
            [
                'title' => 'Devil\'s Triangle: Black Tide Crossing',
                'description' => 'Ghost lights and violent currents twist every route through the cursed waters.',
                'image' => 'assets/images/missions/devils-triangle-card.png',
                'location' => 'Devil\'s Triangle',
                'difficulty' => 4,
                'featured' => false,
            ],
        ];

        foreach ($missions as $mission) {
            Mission::create($mission);
        }
    }
}
