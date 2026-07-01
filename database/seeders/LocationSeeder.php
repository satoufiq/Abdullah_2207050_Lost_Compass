<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Location;
use App\Models\Character;
use App\Models\Mission;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            [
                'id' => 'port-royal',
                'name' => 'Port Royal',
                'type' => 'Colonial Port',
                'position' => ['x' => 12, 'y' => 80],
                'icon_label' => 'Anchor',
                'icon' => 'assets/images/map/Port Royal anchor.png',
                'description' => 'The bustling heart of Caribbean commerce. A colonial stronghold where merchants, naval officers, and pirates converge.',
                'danger_level' => 1,
                'image' => 'assets/images/map/port royal.jpg',
            ],
            [
                'id' => 'tortuga',
                'name' => 'Tortuga',
                'type' => 'Pirate Haven',
                'position' => ['x' => 22, 'y' => 34],
                'icon_label' => 'Pirate Flag',
                'icon' => 'assets/images/map/Tortuga pirate flag.png',
                'description' => 'A lawless island where pirates and rogues gather. Taverns overflow with rum and dangerous conversations.',
                'danger_level' => 4,
                'image' => 'assets/images/map/Tortuga.jpg',
            ],
            [
                'id' => 'isla-muerta',
                'name' => 'Isla de Muerta',
                'type' => 'Cursed Island',
                'position' => ['x' => 43, 'y' => 54],
                'icon_label' => 'Cursed Skull',
                'icon' => 'assets/images/map/Isla de Muerta cursed skull.png',
                'description' => 'An eerie island shrouded in mystery and cursed gold. Legends speak of undead guardians.',
                'danger_level' => 5,
                'image' => 'assets/images/map/Isla Muerta.jpg',
            ],
            [
                'id' => 'shipwreck-cove',
                'name' => 'Shipwreck Cove',
                'type' => 'Hidden Harbor',
                'position' => ['x' => 58, 'y' => 24],
                'icon_label' => 'Shipwreck',
                'icon' => 'assets/images/map/Shipwreck Cove shipwreck.png',
                'description' => 'A concealed inlet littered with the wreckage of a thousand vessels. Home to the Brethren Court.',
                'danger_level' => 4,
                'image' => 'assets/images/map/Shipwreck cove.jpg',
            ],
            [
                'id' => 'devils-triangle',
                'name' => 'Devil\'s Triangle',
                'type' => 'Cursed Waters',
                'position' => ['x' => 78, 'y' => 42],
                'icon_label' => 'Lightning',
                'icon' => 'assets/images/map/Devil’s Triangle lightning .png',
                'description' => 'A treacherous stretch of ocean where ships vanish without trace. Ruled by supernatural forces.',
                'danger_level' => 5,
                'image' => 'assets/images/map/devils triangle.jpg',
            ],
            [
                'id' => 'kraken-depths',
                'name' => 'Kraken Depths',
                'type' => 'Abyssal Realm',
                'position' => ['x' => 90, 'y' => 74],
                'icon_label' => 'Kraken',
                'icon' => 'assets/images/map/Kraken Depths kraken tentacle.png',
                'description' => 'The mysterious underwater realm where the legendary Kraken dwells. An abyss of darkness and forgotten treasures.',
                'danger_level' => 5,
                'image' => 'assets/images/map/kraken depths.jpg',
            ]
        ];

        foreach ($locations as $loc) {
            Location::updateOrCreate(
                ['id' => $loc['id']],
                [
                    'name' => $loc['name'],
                    'type' => $loc['type'],
                    'description' => $loc['description'],
                    'danger_level' => $loc['danger_level'],
                    'image' => $loc['image'],
                    'icon' => $loc['icon'],
                    'icon_label' => $loc['icon_label'],
                    'x_position' => $loc['position']['x'],
                    'y_position' => $loc['position']['y'],
                ]
            );
        }

        // Link Characters
        Character::where('id', 'barbossa')->update(['primary_location_id' => 'isla-muerta']);
        Character::where('id', 'jack-sparrow')->update(['primary_location_id' => 'tortuga']);
        Character::where('id', 'davy-jones')->update(['primary_location_id' => 'devils-triangle']);
        Character::where('id', 'beckett')->update(['primary_location_id' => 'port-royal']);
        Character::where('id', 'blackbeard')->update(['primary_location_id' => 'shipwreck-cove']);
        Character::where('id', 'salazar')->update(['primary_location_id' => 'devils-triangle']);

        // Link Missions
        Mission::where('title', 'Recover the Aztec Coin')->update(['location_id' => 'isla-muerta']);
        Mission::where('title', 'Escape the Kraken')->update(['location_id' => 'kraken-depths']);
        Mission::where('title', 'Duel at Tortuga')->update(['location_id' => 'tortuga']);
        Mission::where('title', 'Port Royal: The Smuggler Ledger')->update(['location_id' => 'port-royal']);
        Mission::where('title', 'Shipwreck Cove: The Hidden Charter')->update(['location_id' => 'shipwreck-cove']);
        Mission::where('title', 'Devil\'s Triangle: Black Tide Crossing')->update(['location_id' => 'devils-triangle']);
    }
}
