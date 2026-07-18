<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Ship;
use App\Models\Captain;
use App\Models\Mission;

class MovieShipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing to avoid duplicate conflicts and ensure no user ships remain
        DB::table('missions')->delete();
        DB::table('ships')->delete();
        DB::table('captains')->delete();

        // ==========================
        // CAPTAINS
        // ==========================
        $jack = Captain::create(['name' => 'Captain Jack Sparrow', 'image' => 'assets/images/characters/jack-sparrow.jpg']);
        $barbossa = Captain::create(['name' => 'Hector Barbossa', 'image' => 'assets/images/characters/barbossa.jpg']);
        $davy = Captain::create(['name' => 'Davy Jones', 'image' => 'assets/images/characters/davy-jones.jpg']);
        $blackbeard = Captain::create(['name' => 'Blackbeard', 'image' => 'assets/images/characters/blackbeard.jpg']);
        $beckett = Captain::create(['name' => 'Lord Cutler Beckett', 'image' => 'assets/images/characters/beckett.jpg']);
        $salazar = Captain::create(['name' => 'Captain Armando Salazar', 'image' => 'assets/images/characters/salazar.jpg']);
        $norrington = Captain::create(['name' => 'James Norrington', 'image' => '']); // Missing image
        $sao_feng = Captain::create(['name' => 'Sao Feng', 'image' => '']); // Missing image
        $gibbs = Captain::create(['name' => 'Joshamee Gibbs', 'image' => '']); // Missing image

        // ==========================
        // 6 EXISTING SHIPS (With Assets)
        // ==========================
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
            'captain_id' => $jack->id, 
            'type' => 'Merchant Vessel Turned Pirate Legend',
            'tags' => 'all,legendary,cursed',
            'image' => 'assets/images/ships/Wicked_Wench.jpg',
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
            'image' => 'assets/images/ships/Silent_Mary.jpg',
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
            'image' => 'assets/images/ships/hms_endeavor.jpg',
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

        // ==========================
        // NEW REMARKABLE MOVIE SHIPS (Pending Assets)
        // ==========================
        Ship::create([
            'name' => 'HMS Interceptor',
            'captain_id' => $norrington->id, // Formerly
            'type' => 'Fast Navy Brig',
            'tags' => 'all,navy',
            'image' => 'assets/images/ships/The_Intercepter.jpg',
            'short_power' => 'Fastest ship in the Royal Navy',
            'history' => 'Commanded by Commodore Norrington, it was famously stolen by Captain Jack Sparrow and Will Turner. It was later destroyed in a battle against the Black Pearl.',
            'weapons' => 'Cannons, speed-based maneuvering',
            'curse' => 'None',
            'fate' => 'Sunk by the Black Pearl',
            'speed' => 9,
            'attack_power' => 6,
            'defense' => 5,
            'curse_level' => 0,
            'legend_rank' => 7
        ]);

        Ship::create([
            'name' => 'HMS Dauntless',
            'captain_id' => $norrington->id,
            'type' => 'Navy Ship of the Line',
            'tags' => 'all,navy',
            'image' => 'assets/images/ships/hms_dauntless.jpeg',
            'short_power' => 'The pride of the Royal Navy',
            'history' => 'A massive, heavily armed first-rate ship of the line serving as the flagship for the British Royal Navy in the Caribbean. Overpowered by the cursed crew of the Black Pearl.',
            'weapons' => '100+ heavy cannons',
            'curse' => 'None',
            'fate' => 'Destroyed during a hurricane',
            'speed' => 4,
            'attack_power' => 10,
            'defense' => 10,
            'curse_level' => 0,
            'legend_rank' => 8
        ]);

        Ship::create([
            'name' => 'The Empress',
            'captain_id' => $sao_feng->id,
            'type' => 'Chinese Pirate Junk',
            'tags' => 'all,legendary',
            'image' => 'assets/images/ships/the_impress.jpg',
            'short_power' => 'Flagship of the Pirate Lord of the South China Sea',
            'history' => 'An elegant and heavily armed Chinese Junk commanded by Sao Feng and later Elizabeth Swann. It led the brethren fleet during the battle of the Maelstrom.',
            'weapons' => 'Cannons, rockets, elite crew',
            'curse' => 'None',
            'fate' => 'Survived the War Against Piracy',
            'speed' => 7,
            'attack_power' => 8,
            'defense' => 7,
            'curse_level' => 0,
            'legend_rank' => 8
        ]);

        Ship::create([
            'name' => 'The Edinburgh Trader',
            'captain_id' => null,
            'type' => 'Merchant Vessel',
            'tags' => 'all',
            'image' => 'assets/images/ships/Edinburgh_Trader.jpg',
            'short_power' => 'Sturdy merchant ship',
            'history' => 'A peaceful merchant vessel that unwittingly rescued Will Turner, only to be entirely pulverized by the Kraken at the behest of Davy Jones.',
            'weapons' => 'Minimal merchant defenses',
            'curse' => 'None',
            'fate' => 'Snapped in half and dragged to the depths by the Kraken',
            'speed' => 5,
            'attack_power' => 2,
            'defense' => 4,
            'curse_level' => 0,
            'legend_rank' => 5
        ]);

        Ship::create([
            'name' => 'Dying Gull',
            'captain_id' => $jack->id,
            'type' => 'Dilapidated Sloop',
            'tags' => 'all',
            'image' => 'assets/images/ships/Dying_Gull.jpg',
            'short_power' => 'Barely floats',
            'history' => 'A remarkably pathetic ship commanded briefly by Jack Sparrow. It miraculously avoided destruction mostly by being ignored.',
            'weapons' => 'A few rusty cannons',
            'curse' => 'None',
            'fate' => 'Abandoned',
            'speed' => 3,
            'attack_power' => 2,
            'defense' => 2,
            'curse_level' => 0,
            'legend_rank' => 3
        ]);

        Ship::create([
            'name' => 'Hai Peng',
            'captain_id' => $barbossa->id,
            'type' => 'Chinese Junk',
            'tags' => 'all',
            'image' => 'assets/images/ships/The_Hai_Peng.png',
            'short_power' => 'Navigated over the edge of the world',
            'history' => 'Provided by Sao Feng to Hector Barbossa, this ship survived freezing waters and ultimately plummeted off the edge of the world to reach Davy Jones\' Locker.',
            'weapons' => 'Standard cannons',
            'curse' => 'None',
            'fate' => 'Destroyed passing into the Locker',
            'speed' => 6,
            'attack_power' => 5,
            'defense' => 5,
            'curse_level' => 0,
            'legend_rank' => 6
        ]);
    }
}
