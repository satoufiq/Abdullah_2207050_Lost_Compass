<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ship;
use App\Models\Captain;
use App\Models\Mission;

class ShipEncyclopediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Captains
        $jack = Captain::create(['name' => 'Captain Jack Sparrow', 'image' => 'assets/images/characters/jack-sparrow.jpg']);
        $barbossa = Captain::create(['name' => 'Hector Barbossa', 'image' => 'assets/images/characters/barbossa.jpg']);
        $davy = Captain::create(['name' => 'Davy Jones', 'image' => 'assets/images/characters/davy-jones.jpg']);
        $blackbeard = Captain::create(['name' => 'Blackbeard', 'image' => 'assets/images/characters/blackbeard.jpg']);
        $beckett = Captain::create(['name' => 'Lord Cutler Beckett', 'image' => 'assets/images/characters/beckett.jpg']);
        $salazar = Captain::create(['name' => 'Captain Armando Salazar', 'image' => 'assets/images/characters/salazar.jpg']);

        // 2. Create Ships
        $pearl = Ship::create([
            'name' => 'Black Pearl',
            'captain_id' => $jack->id,
            'type' => 'Legendary Pirate Ship',
            'tags' => 'all,legendary,cursed',
            'image' => 'assets/images/ships/black pearl.jpg',
            'short_power' => 'Fastest ship on the seas',
            'history' => 'The Black Pearl is feared for speed and sudden strikes. Reclaimed and lost repeatedly, it remains a symbol of pirate freedom and impossible escapes.',
            'weapons' => 'Broadside cannons, boarding crew tactics',
            'curse' => 'Aztec curse (former)',
            'fate' => 'Sails again under Sparrow',
            'speed' => 10,
            'attack_power' => 8,
            'defense' => 7,
            'curse_level' => 6,
            'legend_rank' => 10
        ]);

        $wench = Ship::create([
            'name' => 'Wicked Wench',
            'captain_id' => $jack->id, // Former
            'type' => 'Merchant Vessel Turned Pirate Legend',
            'tags' => 'all,legendary,cursed',
            'image' => 'assets/images/ships/Wicked Wench.jpeg',
            'short_power' => 'The ship before the Black Pearl legend',
            'history' => 'Before becoming the Black Pearl, the Wicked Wench served in trade and then fell into conflict with Beckett. Its destruction and rebirth forged one of the greatest legends at sea.',
            'weapons' => 'Merchant guns refitted for pirate warfare',
            'curse' => 'Reborn through dark bargain',
            'fate' => 'Reforged as the Black Pearl',
            'speed' => 8,
            'attack_power' => 6,
            'defense' => 6,
            'curse_level' => 7,
            'legend_rank' => 8
        ]);

        $dutchman = Ship::create([
            'name' => 'Flying Dutchman',
            'captain_id' => $davy->id,
            'type' => 'Cursed Ghost Ship',
            'tags' => 'all,ghost,cursed,legendary',
            'image' => 'assets/images/ships/Flying Dutchman.jpg',
            'short_power' => 'Master of abyssal terror',
            'history' => 'A supernatural vessel bound to ferry souls lost at sea. The Dutchman commands fear through dark pacts, sea monsters, and eternal servitude.',
            'weapons' => 'Cursed crew, heavy cannons, Kraken command',
            'curse' => 'Eternal servitude to the sea',
            'fate' => 'Bound to the Dutchman cycle',
            'speed' => 8,
            'attack_power' => 10,
            'defense' => 9,
            'curse_level' => 10,
            'legend_rank' => 10
        ]);

        $mary = Ship::create([
            'name' => 'Silent Mary',
            'captain_id' => $salazar->id,
            'type' => 'Ghost Hunter Warship',
            'tags' => 'all,ghost,cursed,legendary',
            'image' => 'assets/images/ships/Silent Mary.jpg',
            'short_power' => "Undead pursuit vessel of the Devil's Triangle",
            'history' => "Once a Spanish hunter ship, the Silent Mary returned from the Devil's Triangle as a spectral predator, shattering hulls and haunting pirate routes.",
            'weapons' => 'Spectral crew, crushing ram, heavy cannons',
            'curse' => 'Undead curse of the Triangle',
            'fate' => 'Collapsed with the breaking of sea curses',
            'speed' => 8,
            'attack_power' => 9,
            'defense' => 8,
            'curse_level' => 9,
            'legend_rank' => 9
        ]);

        $revenge = Ship::create([
            'name' => "Queen Anne's Revenge",
            'captain_id' => $blackbeard->id,
            'type' => 'Dark Pirate Warship',
            'tags' => 'all,cursed,legendary',
            'image' => "assets/images/ships/Queen Anne's Revenge.jpg",
            'short_power' => 'Fire and fear under black magic',
            'history' => "Blackbeard's flagship is infamous for brutality and sorcery. It carries dread across shipping lanes and leaves no peaceful horizon behind.",
            'weapons' => 'Greek fire, heavy guns, enchanted rigging',
            'curse' => 'Dark sorcery influence',
            'fate' => 'Taken and repurposed by Barbossa',
            'speed' => 7,
            'attack_power' => 9,
            'defense' => 8,
            'curse_level' => 8,
            'legend_rank' => 9
        ]);

        $endeavour = Ship::create([
            'name' => 'HMS Endeavour',
            'captain_id' => $beckett->id,
            'type' => 'East India Flagship',
            'tags' => 'all,navy,legendary',
            'image' => 'assets/images/ships/HMS Endeavour.jpg',
            'short_power' => 'Command ship of naval domination',
            'history' => "The Endeavour functions as Beckett's floating throne, coordinating fleets and trade empire warfare to strangle piracy across the Caribbean.",
            'weapons' => 'Flagship artillery and fleet command lines',
            'curse' => 'None',
            'fate' => 'Destroyed in the maelstrom battle',
            'speed' => 6,
            'attack_power' => 10,
            'defense' => 9,
            'curse_level' => 1,
            'legend_rank' => 9
        ]);

        // 3. Missions (Relate to Ships)
        Mission::create([
            'title' => 'Escape the Kraken',
            'description' => 'Outrun the monstrous beast summoned from the abyss.',
            'ship_id' => $pearl->id,
            'difficulty' => 'extreme',
            'featured' => true,
        ]);

        Mission::create([
            'title' => 'Reclaim the Aztec Gold',
            'description' => 'Break the curse by returning the scattered coins.',
            'ship_id' => $pearl->id,
            'difficulty' => 'hard',
            'featured' => true,
        ]);

        Mission::create([
            'title' => 'Ferry the Lost Souls',
            'description' => 'Guide the dying to the next world across the sea.',
            'ship_id' => $dutchman->id,
            'difficulty' => 'medium',
            'featured' => false,
        ]);

        Mission::create([
            'title' => 'Break the Trident',
            'description' => 'Shatter Poseidon\'s Trident to lift all curses of the sea.',
            'ship_id' => $mary->id,
            'difficulty' => 'extreme',
            'featured' => true,
        ]);

        Mission::create([
            'title' => 'Quest for the Fountain',
            'description' => 'Navigate perilous waters and overcome traps to reach eternal youth.',
            'ship_id' => $revenge->id,
            'difficulty' => 'hard',
            'featured' => true,
        ]);

        Mission::create([
            'title' => 'Crush the Pirate Brethren',
            'description' => 'Assemble the armada and bombard Shipwreck Cove.',
            'ship_id' => $endeavour->id,
            'difficulty' => 'hard',
            'featured' => false,
        ]);
    }
}
