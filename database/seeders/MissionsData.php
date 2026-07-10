<?php

return [
  [
    'id' => 'aztec-coin',
    'title' => 'Recover the Aztec Coin',
    'category' => 'treasure',
    'mood' => 'treasure',
    'difficulty' => 2,
    'rewardText' => '50 Gold + 1 Relic',
    'summary' => 'The compass points toward a cursed cave where one coin can make or break your fate.',
    'image' => 'assets/images/missions/Aztec_Gold for mission card.jpg',
    'bgm' => 'assets/audio/missions/treasure-ambient.mp3',
    'maxSteps' => 5,
    'nodes' => [
      'start' => [
        'title' => 'At the Mouth of the Cave',
        'text' => 'Torchlight trembles across ancient stone. A chest etched with cursed runes waits in the dark.',
        'image' => 'assets/images/missions/aztec-coin-01-cave-mouth.jpg',
        'choices' => [
          [ 'label' => 'Enter quietly and inspect the symbols', 'next' => 'inspect', 'consequence' => 'You move carefully. The cave remains silent, but not empty.', 'sfx' => 'assets/audio/missions/footsteps.mp3' ],
          [ 'label' => 'Rush to the chest and grab it', 'next' => 'rush', 'consequence' => 'Your haste triggers a hidden mechanism. Stone grinds above you.', 'sfx' => 'assets/audio/missions/trap-click.mp3' ]
        ]
      ],
      'inspect' => [
        'title' => 'Runes of Warning',
        'text' => 'The symbols reveal two paths: an altar route for a true rite, or a lock route for clever thieves.',
        'image' => 'assets/images/missions/aztec-coin-02-runes.jpg',
        'choices' => [
          [ 'label' => 'Follow the altar markings', 'next' => 'altar', 'consequence' => 'You trace the symbols deeper into the cave toward a moonlit chamber.', 'sfx' => 'assets/audio/missions/footsteps.mp3' ],
          [ 'label' => 'Work directly on the blood-lock', 'next' => 'lock', 'consequence' => 'You kneel by the chest and begin testing the lock mechanism.', 'sfx' => 'assets/audio/missions/metal-strain.mp3' ]
        ]
      ],
      'rush' => [
        'title' => 'Ambush in the Dark',
        'text' => 'A skeletal pirate lunges from the shadows as stones begin to collapse behind you.',
        'image' => 'assets/images/missions/aztec-coin-03-ambush.jpg',
        'choices' => [
          [ 'label' => 'Dive through the collapsing side tunnel', 'next' => 'collapse', 'consequence' => 'You slide into a narrow tunnel as rocks crash behind you.', 'sfx' => 'assets/audio/missions/rockfall.mp3' ],
          [ 'label' => 'Stand and duel the guardian', 'next' => 'ambush', 'consequence' => 'Steel meets bone as the guardian blocks your way to the coin.', 'sfx' => 'assets/audio/missions/sword-clang.mp3' ]
        ]
      ],
      'altar' => [
        'title' => 'Moon Altar Chamber',
        'text' => 'A stone altar glows under a shaft of pale light. Offerings lie untouched for centuries.',
        'image' => 'assets/images/missions/aztec-coin-04-altar.jpg',
        'choices' => [
          [ 'label' => 'Perform the old rite before touching treasure', 'next' => 'ritual', 'consequence' => 'You place your blade and whisper the names carved in the stone.', 'sfx' => 'assets/audio/missions/chest-open.mp3' ],
          [ 'label' => 'Search the side map-room first', 'next' => 'maproom', 'consequence' => 'You slip behind the altar and uncover hidden map drawers.', 'sfx' => 'assets/audio/missions/footsteps.mp3' ]
        ]
      ],
      'lock' => [
        'title' => 'Blood-Lock Sequence',
        'text' => 'Five engraved rings rotate around the lock. The final ring is cracked and unstable.',
        'image' => 'assets/images/missions/aztec-coin-05-lock.jpg',
        'choices' => [
          [ 'label' => 'Use your blood to complete the sequence', 'next' => 'ritual', 'consequence' => 'The rings align and the chamber hums with cursed energy.', 'sfx' => 'assets/audio/missions/chest-open.mp3' ],
          [ 'label' => 'Force the final ring open', 'next' => 'breakseal', 'consequence' => 'Metal screams as the ring snaps and dark smoke pours out.', 'sfx' => 'assets/audio/missions/metal-strain.mp3' ]
        ]
      ],
      'collapse' => [
        'title' => 'Tunnel of Falling Stone',
        'text' => 'Dust blinds your eyes. Ahead, a rope bridge hangs over a flooded pit.',
        'image' => 'assets/images/missions/aztec-coin-06-collapse.jpg',
        'choices' => [
          [ 'label' => 'Climb the bridge and cross high', 'next' => 'climb', 'consequence' => 'You climb fast while rocks burst from the tunnel wall.', 'sfx' => 'assets/audio/missions/rockfall.mp3' ],
          [ 'label' => 'Wade through the flooded pit', 'next' => 'flood', 'consequence' => 'Cold water rises to your waist as something moves below.', 'sfx' => 'assets/audio/missions/waves-heavy.mp3' ]
        ]
      ],
      'ambush' => [
        'title' => 'Guardian Duel',
        'text' => 'The skeletal guardian fights with impossible speed, guarding the final chamber door.',
        'image' => 'assets/images/missions/aztec-coin-07-duel.jpg',
        'choices' => [
          [ 'label' => 'Disarm and pin the guardian', 'next' => 'duelguard', 'consequence' => 'You twist the guardian blade aside and gain the doorway.', 'sfx' => 'assets/audio/missions/sword-clang.mp3' ],
          [ 'label' => 'Throw smoke powder and flank', 'next' => 'smokebomb', 'consequence' => 'The chamber fills with smoke while you circle to the lock.', 'sfx' => 'assets/audio/missions/trap-click.mp3' ]
        ]
      ],
      'ritual' => [
        'title' => 'Oath to the Coin',
        'text' => 'The coin rises from the chest as if listening to your heartbeat. One final vow remains.',
        'image' => 'assets/images/missions/aztec-coin-08-ritual.jpg',
        'choices' => [
          [ 'label' => 'Swear to return the coin to the sea', 'next' => 'success-end', 'consequence' => 'The curse settles. The coin accepts your hand.', 'sfx' => 'assets/audio/missions/chest-open.mp3' ],
          [ 'label' => 'Keep the coin for personal power', 'next' => 'partial-end', 'consequence' => 'The coin obeys, but a dark sigil brands your wrist.', 'sfx' => 'assets/audio/missions/metal-strain.mp3' ]
        ]
      ],
      'maproom' => [
        'title' => 'Hidden Cartographer Room',
        'text' => 'You find maps of every cursed port. One chart marks a safe route out, another marks a hoard.',
        'image' => 'assets/images/missions/aztec-coin-09-maproom.jpg',
        'choices' => [
          [ 'label' => 'Take the safe route with the coin', 'next' => 'success-end', 'consequence' => 'You escape cleanly with coin and chart in hand.', 'sfx' => 'assets/audio/missions/footsteps.mp3' ],
          [ 'label' => 'Chase the hidden hoard too', 'next' => 'failure-end', 'consequence' => 'Greed delays you. The cave shutters lock behind you.', 'sfx' => 'assets/audio/missions/rockfall.mp3' ]
        ]
      ],
      'breakseal' => [
        'title' => 'Seal Break',
        'text' => 'With the lock broken, cursed wind races through the chamber and spirits wake.',
        'image' => 'assets/images/missions/aztec-coin-10-seal.jpg',
        'choices' => [
          [ 'label' => 'Grab coin and run for daylight', 'next' => 'partial-end', 'consequence' => 'You escape with the coin, but the curse follows.', 'sfx' => 'assets/audio/missions/footsteps.mp3' ],
          [ 'label' => 'Stand and fight the spirits', 'next' => 'failure-end', 'consequence' => 'You are overwhelmed and forced to abandon the treasure.', 'sfx' => 'assets/audio/missions/sword-clang.mp3' ]
        ]
      ],
      'climb' => [
        'title' => 'Bridge Over the Pit',
        'text' => 'The bridge strains and the final chamber is in sight.',
        'image' => 'assets/images/missions/aztec-coin-11-bridge.jpg',
        'choices' => [
          [ 'label' => 'Leap for the chamber ledge', 'next' => 'partial-end', 'consequence' => 'You make it through with injuries and a single relic.', 'sfx' => 'assets/audio/missions/rockfall.mp3' ],
          [ 'label' => 'Retreat and save the crew', 'next' => 'failure-end', 'consequence' => 'You survive, but the coin remains lost in darkness.', 'sfx' => 'assets/audio/missions/footsteps.mp3' ]
        ]
      ],
      'flood' => [
        'title' => 'Flooded Vault',
        'text' => 'Underwater glyphs reveal a submerged chest compartment.',
        'image' => 'assets/images/missions/aztec-coin-12-flood.jpg',
        'choices' => [
          [ 'label' => 'Dive for the submerged compartment', 'next' => 'success-end', 'consequence' => 'You surface with the coin and a relic clasped tight.', 'sfx' => 'assets/audio/missions/chest-open.mp3' ],
          [ 'label' => 'Surface and abandon the vault', 'next' => 'partial-end', 'consequence' => 'You keep your life, but only salvage scattered gold.', 'sfx' => 'assets/audio/missions/waves-heavy.mp3' ]
        ]
      ],
      'duelguard' => [
        'title' => 'Final Guard Falls',
        'text' => 'With the guardian defeated, the chest stands unprotected at last.',
        'image' => 'assets/images/missions/aztec-coin-13-final-guard.jpg',
        'choices' => [
          [ 'label' => 'Open chest with care', 'next' => 'success-end', 'consequence' => 'The coin accepts your claim and the cave calms.', 'sfx' => 'assets/audio/missions/chest-open.mp3' ],
          [ 'label' => 'Kick chest open quickly', 'next' => 'partial-end', 'consequence' => 'You grab the coin, but traps trigger on your way out.', 'sfx' => 'assets/audio/missions/trap-click.mp3' ]
        ]
      ],
      'smokebomb' => [
        'title' => 'Smoke and Misstep',
        'text' => 'The smoke blinds everyone, including you. You are one mistake from disaster.',
        'image' => 'assets/images/missions/aztec-coin-14-smoke.jpg',
        'choices' => [
          [ 'label' => 'Trust instinct and reach for the chest', 'next' => 'partial-end', 'consequence' => 'You recover part of the treasure before escaping.', 'sfx' => 'assets/audio/missions/footsteps.mp3' ],
          [ 'label' => 'Wait for visibility to return', 'next' => 'failure-end', 'consequence' => 'By the time you move, the chamber seals shut.', 'sfx' => 'assets/audio/missions/rockfall.mp3' ]
        ]
      ],
      'success-end' => [
        'ending' => true,
        'outcome' => 'success',
        'title' => 'Curse Broken, Treasure Claimed',
        'text' => 'You leave Isla de Muerta with the Aztec Coin and your name whispered across every port.',
        'image' => 'assets/images/missions/aztec-coin-ending-success.jpg',
        'rewards' => ['+50 Gold', '+1 Relic', '+10 Reputation']
      ],
      'partial-end' => [
        'ending' => true,
        'outcome' => 'partial',
        'title' => 'Treasure at a Cost',
        'text' => 'You claim part of the loot, but the curse follows your shadow.',
        'image' => 'assets/images/missions/aztec-coin-ending-partial.jpg',
        'rewards' => ['+25 Gold', '+3 Reputation']
      ],
      'failure-end' => [
        'ending' => true,
        'outcome' => 'failure',
        'title' => 'The Cave Keeps Its Secrets',
        'text' => 'You survive, but the coin remains lost. The crew doubts your luck.',
        'image' => 'assets/images/missions/aztec-coin-ending-failure.jpg',
        'rewards' => ['+1 Survival', '-3 Reputation']
      ]
    ]
  ],
  [
    'id' => 'escape-kraken',
    'title' => 'Escape the Kraken',
    'category' => 'battle',
    'mood' => 'battle',
    'difficulty' => 3,
    'rewardText' => '80 Gold + Kraken Fang',
    'summary' => 'A storm tears the horizon apart while the Kraken rises beneath your hull.',
    'image' => 'assets/images/missions/kraken-01-stormfront.jpg',
    'bgm' => 'assets/audio/missions/battle-drums.mp3',
    'maxSteps' => 5,
    'nodes' => [
      'start' => [
        'title' => 'Stormfront',
        'text' => 'Lightning cracks the sky. Tentacles coil around your ship as waves swallow the deck.',
        'image' => 'assets/images/missions/kraken-01-stormfront.jpg',
        'choices' => [
          [ 'label' => 'Fire the broadside cannons', 'next' => 'cannons', 'consequence' => 'The sea erupts as cannon fire thunders into the storm.', 'sfx' => 'assets/audio/missions/cannon-shot.mp3' ],
          [ 'label' => 'Cut the ropes and ride the wind', 'next' => 'maneuver', 'consequence' => 'You gamble on speed, steering into violent waters.', 'sfx' => 'assets/audio/missions/waves-heavy.mp3' ]
        ]
      ],
      'cannons' => [
        'title' => 'The Beast Roars',
        'text' => 'One tentacle recoils. Another smashes the mast and throws crew across the deck.',
        'image' => 'assets/images/missions/kraken-02-cannons.jpg',
        'choices' => [
          [ 'label' => 'Stand and command the crew', 'next' => 'command', 'consequence' => 'Your voice cuts through thunder and steadies the deck.', 'sfx' => 'assets/audio/missions/crew-shout.mp3' ],
          [ 'label' => 'Retreat to coordinate below deck', 'next' => 'belowdeck', 'consequence' => 'You rush below while water floods the lower hold.', 'sfx' => 'assets/audio/missions/ship-creak.mp3' ]
        ]
      ],
      'maneuver' => [
        'title' => 'Knife-Edge Turn',
        'text' => 'You steer between jagged reefs while tentacles strike where you once stood.',
        'image' => 'assets/images/missions/kraken-03-maneuver.jpg',
        'choices' => [
          [ 'label' => 'Drop decoy cargo and flee', 'next' => 'decoy', 'consequence' => 'Barrels smash into the sea and draw the Kraken aside.', 'sfx' => 'assets/audio/missions/crate-drop.mp3' ],
          [ 'label' => 'Ram through the whirlpool', 'next' => 'whirlpool', 'consequence' => 'The helm shakes as you commit to the deadliest path.', 'sfx' => 'assets/audio/missions/thunder.mp3' ]
        ]
      ],
      'command' => [
        'title' => 'Deck Formation',
        'text' => 'Crew forms two lines: one for sails, one for harpoons. You must prioritize.',
        'image' => 'assets/images/missions/kraken-04-command.jpg',
        'choices' => [
          [ 'label' => 'Secure sails first', 'next' => 'sails', 'consequence' => 'Wind control returns, but the Kraken closes in.', 'sfx' => 'assets/audio/missions/waves-heavy.mp3' ],
          [ 'label' => 'Harpoon the nearest tentacle', 'next' => 'harpoon', 'consequence' => 'A direct hit slows the beast for a heartbeat.', 'sfx' => 'assets/audio/missions/cannon-shot.mp3' ]
        ]
      ],
      'belowdeck' => [
        'title' => 'Flooded Gun Deck',
        'text' => 'Water and splintered wood surge through the cannon bay. Powder barrels drift free.',
        'image' => 'assets/images/missions/kraken-05-belowdeck.jpg',
        'choices' => [
          [ 'label' => 'Seal the powder room', 'next' => 'powder', 'consequence' => 'You stop an explosion, but lose precious time.', 'sfx' => 'assets/audio/missions/ship-creak.mp3' ],
          [ 'label' => 'Abandon cannons and pump water out', 'next' => 'pump', 'consequence' => 'You stabilize the hull while the deck fights alone.', 'sfx' => 'assets/audio/missions/waves-heavy.mp3' ]
        ]
      ],
      'decoy' => [
        'title' => 'Bait in the Storm',
        'text' => 'The Kraken follows floating cargo, but reefs now crowd your route.',
        'image' => 'assets/images/missions/kraken-06-decoy.jpg',
        'choices' => [
          [ 'label' => 'Thread through reef gap', 'next' => 'reef', 'consequence' => 'You angle for a narrow cut through jagged stone.', 'sfx' => 'assets/audio/missions/thunder.mp3' ],
          [ 'label' => 'Turn broadside for one last volley', 'next' => 'lastvolley', 'consequence' => 'You risk speed for a finishing shot.', 'sfx' => 'assets/audio/missions/cannon-shot.mp3' ]
        ]
      ],
      'whirlpool' => [
        'title' => 'Eye of the Whirlpool',
        'text' => 'The ship spins toward the center while tentacles thrash at the outer edge.',
        'image' => 'assets/images/missions/kraken-07-whirlpool.jpg',
        'choices' => [
          [ 'label' => 'Cut the anchor and ride the spiral', 'next' => 'spiral', 'consequence' => 'You surrender control to gain momentum.', 'sfx' => 'assets/audio/missions/ship-creak.mp3' ],
          [ 'label' => 'Counter-steer and break left', 'next' => 'counter', 'consequence' => 'The helm strains as you force a dangerous angle.', 'sfx' => 'assets/audio/missions/waves-heavy.mp3' ]
        ]
      ],
      'sails' => [
        'title' => 'Full Wind',
        'text' => 'Sails catch hard wind. You have one opening to outrun the beast.',
        'image' => 'assets/images/missions/kraken-08-sails.jpg',
        'choices' => [
          [ 'label' => 'Burn all speed and escape', 'next' => 'success-end', 'consequence' => 'The ship surges past the storm wall and breaks free.', 'sfx' => 'assets/audio/missions/thunder.mp3' ],
          [ 'label' => 'Turn back for straggling crew', 'next' => 'partial-end', 'consequence' => 'You save lives but lose cargo and ground.', 'sfx' => 'assets/audio/missions/crew-shout.mp3' ]
        ]
      ],
      'harpoon' => [
        'title' => 'Harpoon Line Locked',
        'text' => 'The line is taut and the beast drags your ship sideways.',
        'image' => 'assets/images/missions/kraken-09-harpoon.jpg',
        'choices' => [
          [ 'label' => 'Cut line at the perfect moment', 'next' => 'success-end', 'consequence' => 'The recoil slings your ship clear of the tentacles.', 'sfx' => 'assets/audio/missions/metal-strain.mp3' ],
          [ 'label' => 'Hold line and keep firing', 'next' => 'partial-end', 'consequence' => 'You wound the Kraken but your mast cracks apart.', 'sfx' => 'assets/audio/missions/cannon-shot.mp3' ]
        ]
      ],
      'powder' => [
        'title' => 'Powder Room Secured',
        'text' => 'You prevent disaster, but the Kraken has wrapped the stern.',
        'image' => 'assets/images/missions/kraken-10-powder.jpg',
        'choices' => [
          [ 'label' => 'Signal emergency sail cut', 'next' => 'partial-end', 'consequence' => 'You escape with a crippled rig and battered crew.', 'sfx' => 'assets/audio/missions/ship-creak.mp3' ],
          [ 'label' => 'Wait for a cleaner opening', 'next' => 'failure-end', 'consequence' => 'Delay gives the beast time to overturn your stern.', 'sfx' => 'assets/audio/missions/waves-heavy.mp3' ]
        ]
      ],
      'pump' => [
        'title' => 'Hull Stabilized',
        'text' => 'The bilge clears enough to maneuver, but morale is collapsing.',
        'image' => 'assets/images/missions/kraken-11-pump.jpg',
        'choices' => [
          [ 'label' => 'Rally crew for one final push', 'next' => 'partial-end', 'consequence' => 'You limp away alive, scarred by the storm.', 'sfx' => 'assets/audio/missions/crew-shout.mp3' ],
          [ 'label' => 'Abandon ship in lifeboats', 'next' => 'failure-end', 'consequence' => 'The Kraken claims your vessel and your legend dims.', 'sfx' => 'assets/audio/missions/waves-heavy.mp3' ]
        ]
      ],
      'reef' => [
        'title' => 'Reef Needle',
        'text' => 'Rocks scrape both sides of the hull. One misstep ends the voyage.',
        'image' => 'assets/images/missions/kraken-12-reef.jpg',
        'choices' => [
          [ 'label' => 'Trust the compass line', 'next' => 'success-end', 'consequence' => 'You clear the reef and leave the Kraken trapped behind.', 'sfx' => 'assets/audio/missions/thunder.mp3' ],
          [ 'label' => 'Turn wider for safety', 'next' => 'partial-end', 'consequence' => 'You avoid wrecking, but the Kraken tears your aft deck.', 'sfx' => 'assets/audio/missions/ship-creak.mp3' ]
        ]
      ],
      'lastvolley' => [
        'title' => 'Last Broadside',
        'text' => 'Cannons fire point-blank while the storm closes around you.',
        'image' => 'assets/images/missions/kraken-13-lastvolley.jpg',
        'choices' => [
          [ 'label' => 'Aim for the eye', 'next' => 'success-end', 'consequence' => 'A direct hit stuns the beast and opens an escape route.', 'sfx' => 'assets/audio/missions/cannon-shot.mp3' ],
          [ 'label' => 'Fire chain shot at tentacles', 'next' => 'partial-end', 'consequence' => 'You break its grip but lose speed in the blast.', 'sfx' => 'assets/audio/missions/cannon-shot.mp3' ]
        ]
      ],
      'spiral' => [
        'title' => 'Spiral Run',
        'text' => 'The ship rides the whirlpool wall like a blade on glass.',
        'image' => 'assets/images/missions/kraken-14-spiral.jpg',
        'choices' => [
          [ 'label' => 'Ride until breakout point', 'next' => 'success-end', 'consequence' => 'You launch from the spiral and leave the beast behind.', 'sfx' => 'assets/audio/missions/thunder.mp3' ],
          [ 'label' => 'Jump off course early', 'next' => 'failure-end', 'consequence' => 'You slam broadside into the surge and lose command.', 'sfx' => 'assets/audio/missions/ship-creak.mp3' ]
        ]
      ],
      'counter' => [
        'title' => 'Counter Current',
        'text' => 'The helm resists with brutal force as the hull shudders.',
        'image' => 'assets/images/missions/kraken-15-counter.jpg',
        'choices' => [
          [ 'label' => 'Hold course and bleed speed', 'next' => 'partial-end', 'consequence' => 'You crawl out of the maelstrom with heavy damage.', 'sfx' => 'assets/audio/missions/waves-heavy.mp3' ],
          [ 'label' => 'Release helm and pray', 'next' => 'failure-end', 'consequence' => 'The ship spins uncontrolled into the Kraken reach.', 'sfx' => 'assets/audio/missions/thunder.mp3' ]
        ]
      ],
      'success-end' => [
        'ending' => true,
        'outcome' => 'success',
        'title' => 'Kraken Outsailed',
        'text' => 'Against impossible odds, you outmaneuver the Kraken and claim a severed fang as proof.',
        'image' => 'assets/images/missions/kraken-ending-success.jpg',
        'rewards' => ['+80 Gold', '+1 Kraken Fang', '+15 Reputation']
      ],
      'partial-end' => [
        'ending' => true,
        'outcome' => 'partial',
        'title' => 'Barely Survived',
        'text' => 'You escape the storm with a damaged hull and shaken crew.',
        'image' => 'assets/images/missions/kraken-ending-partial.jpg',
        'rewards' => ['+35 Gold', '+5 Reputation']
      ],
      'failure-end' => [
        'ending' => true,
        'outcome' => 'failure',
        'title' => 'Shipwrecked in the Tempest',
        'text' => 'The sea takes your cargo, and your crew drifts toward hostile waters.',
        'image' => 'assets/images/missions/kraken-ending-failure.jpg',
        'rewards' => ['-10 Reputation', '+1 Hard Lesson']
      ]
    ]
  ],
  [
    'id' => 'duel-tortuga',
    'title' => 'Duel at Tortuga',
    'location' => 'Tortuga',
    'category' => 'duel',
    'mood' => 'duel',
    'difficulty' => 2,
    'rewardText' => '40 Gold + Infamy',
    'summary' => 'Inside a smoky tavern, a rival captain challenges your right to command the harbor.',
    'image' => 'assets/images/missions/duel mission card.jpg',
    'bgm' => 'assets/audio/missions/tavern-tension.mp3',
    'maxSteps' => 5,
    'nodes' => [
      'start' => [
        'title' => 'Tavern Challenge',
        'text' => 'Rum spills, dice stop rolling, and steel glints in lantern light. Everyone is watching.',
        'image' => 'assets/images/missions/tortuga-01-challenge.jpg',
        'choices' => [
          [ 'label' => 'Accept a formal duel', 'next' => 'formal', 'consequence' => 'The room clears. A ring of pirates gives you space.', 'sfx' => 'assets/audio/missions/sword-draw.mp3' ],
          [ 'label' => 'Try to outwit with a bluff', 'next' => 'bluff', 'consequence' => 'You smile and play for time, measuring your rival.', 'sfx' => 'assets/audio/missions/tavern-murmur.mp3' ]
        ]
      ],
      'formal' => [
        'title' => 'Steel on Steel',
        'text' => 'Every strike echoes across the tavern floorboards as wagers rise with each clash.',
        'image' => 'assets/images/missions/tortuga-02-formal.jpg',
        'choices' => [
          [ 'label' => 'Disarm with precision', 'next' => 'precision', 'consequence' => 'You target wrists and timing instead of brute strength.', 'sfx' => 'assets/audio/missions/sword-clang.mp3' ],
          [ 'label' => 'Overpower with brute force', 'next' => 'bruteforce', 'consequence' => 'You drive forward with relentless attacks.', 'sfx' => 'assets/audio/missions/table-crash.mp3' ]
        ]
      ],
      'bluff' => [
        'title' => 'A Dangerous Lie',
        'text' => 'Your rival narrows their eyes. One wrong word and the room will turn on you.',
        'image' => 'assets/images/missions/tortuga-03-bluff.jpg',
        'choices' => [
          [ 'label' => 'Reveal hidden evidence', 'next' => 'evidence', 'consequence' => 'You slam a sealed letter on the table and silence the room.', 'sfx' => 'assets/audio/missions/crowd-gasp.mp3' ],
          [ 'label' => 'Double down on the bluff', 'next' => 'doublebluff', 'consequence' => 'You spin a deeper lie as suspicion spreads.', 'sfx' => 'assets/audio/missions/boo-crowd.mp3' ]
        ]
      ],
      'precision' => [
        'title' => 'Measured Duel',
        'text' => 'Your rival adapts quickly. One clean maneuver will decide the room.',
        'image' => 'assets/images/missions/tortuga-04-precision.jpg',
        'choices' => [
          [ 'label' => 'Feint high, sweep low', 'next' => 'crowdpressure', 'consequence' => 'Your rival stumbles and the crowd surges around the ring.', 'sfx' => 'assets/audio/missions/sword-clang.mp3' ],
          [ 'label' => 'Kick table to break rhythm', 'next' => 'chaosring', 'consequence' => 'Tankards shatter as the duel turns chaotic.', 'sfx' => 'assets/audio/missions/table-crash.mp3' ]
        ]
      ],
      'bruteforce' => [
        'title' => 'Heavy Blades',
        'text' => 'You overpower your rival, but fatigue creeps in and your guard opens.',
        'image' => 'assets/images/missions/tortuga-05-bruteforce.jpg',
        'choices' => [
          [ 'label' => 'Keep pressure and force surrender', 'next' => 'chaosring', 'consequence' => 'You push hard while the tavern chants your name.', 'sfx' => 'assets/audio/missions/crew-shout.mp3' ],
          [ 'label' => 'Step back and recover breath', 'next' => 'crowdpressure', 'consequence' => 'The pause gives your rival one dangerous chance.', 'sfx' => 'assets/audio/missions/tavern-murmur.mp3' ]
        ]
      ],
      'evidence' => [
        'title' => 'Letter of Betrayal',
        'text' => 'The letter names your rival as a traitor to the pirate code. The room demands proof.',
        'image' => 'assets/images/missions/tortuga-06-evidence.jpg',
        'choices' => [
          [ 'label' => 'Call witness from the bar', 'next' => 'witness', 'consequence' => 'A scarred sailor steps forward under every eye in the tavern.', 'sfx' => 'assets/audio/missions/crowd-gasp.mp3' ],
          [ 'label' => 'Challenge rival to trial by steel', 'next' => 'trialsteel', 'consequence' => 'The room roars as swords return to center stage.', 'sfx' => 'assets/audio/missions/sword-draw.mp3' ]
        ]
      ],
      'doublebluff' => [
        'title' => 'Web of Lies',
        'text' => 'Your rival calls your bluff and demands immediate proof or blood.',
        'image' => 'assets/images/missions/tortuga-07-doublebluff.jpg',
        'choices' => [
          [ 'label' => 'Redirect blame to rival first mate', 'next' => 'witness', 'consequence' => 'The first mate hesitates, and the crowd leans in.', 'sfx' => 'assets/audio/missions/tavern-murmur.mp3' ],
          [ 'label' => 'Draw blade before being cornered', 'next' => 'trialsteel', 'consequence' => 'You force the room into steel and speed.', 'sfx' => 'assets/audio/missions/sword-draw.mp3' ]
        ]
      ],
      'crowdpressure' => [
        'title' => 'Ring of Wagers',
        'text' => 'Coins fly, voices rise, and one final action will define your legend tonight.',
        'image' => 'assets/images/missions/tortuga-08-crowd.jpg',
        'choices' => [
          [ 'label' => 'Finish with honorable salute', 'next' => 'success-end', 'consequence' => 'You win with style and earn both fear and respect.', 'sfx' => 'assets/audio/missions/crew-shout.mp3' ],
          [ 'label' => 'Win dirty with hidden dagger', 'next' => 'partial-end', 'consequence' => 'You win, but half the room calls it dishonorable.', 'sfx' => 'assets/audio/missions/sword-clang.mp3' ]
        ]
      ],
      'chaosring' => [
        'title' => 'Broken Glass and Steel',
        'text' => 'The duel spills through tables and lanterns. Guards are moments away.',
        'image' => 'assets/images/missions/tortuga-09-chaos.jpg',
        'choices' => [
          [ 'label' => 'End duel before guards arrive', 'next' => 'partial-end', 'consequence' => 'You force a quick finish and claim a rough victory.', 'sfx' => 'assets/audio/missions/table-crash.mp3' ],
          [ 'label' => 'Keep fighting through the brawl', 'next' => 'failure-end', 'consequence' => 'Guards overwhelm both sides and drag you out.', 'sfx' => 'assets/audio/missions/boo-crowd.mp3' ]
        ]
      ],
      'witness' => [
        'title' => 'Witness Statement',
        'text' => 'The witness trembles. One final push can either seal your claim or expose your bluff.',
        'image' => 'assets/images/missions/tortuga-10-witness.jpg',
        'choices' => [
          [ 'label' => 'Offer safe passage for truth', 'next' => 'success-end', 'consequence' => 'Truth breaks free and the crowd turns in your favor.', 'sfx' => 'assets/audio/missions/crowd-gasp.mp3' ],
          [ 'label' => 'Threaten witness to speak now', 'next' => 'failure-end', 'consequence' => 'The room sees through your desperation and turns hostile.', 'sfx' => 'assets/audio/missions/boo-crowd.mp3' ]
        ]
      ],
      'trialsteel' => [
        'title' => 'Trial by Steel',
        'text' => 'Only one clean exchange remains before the tavern declares a victor.',
        'image' => 'assets/images/missions/tortuga-11-trial.jpg',
        'choices' => [
          [ 'label' => 'Parry and disarm decisively', 'next' => 'success-end', 'consequence' => 'Your rival blade hits the floor and silence fills the room.', 'sfx' => 'assets/audio/missions/sword-clang.mp3' ],
          [ 'label' => 'Go all-in with reckless lunge', 'next' => 'partial-end', 'consequence' => 'You win narrowly but take a deep cut.', 'sfx' => 'assets/audio/missions/sword-clang.mp3' ]
        ]
      ],
      'success-end' => [
        'ending' => true,
        'outcome' => 'success',
        'title' => 'Tortuga Respects Your Name',
        'text' => 'You leave the tavern as the new legend of the docks.',
        'image' => 'assets/images/missions/tortuga-ending-success.jpg',
        'rewards' => ['+40 Gold', '+1 Infamy Mark', '+12 Reputation']
      ],
      'partial-end' => [
        'ending' => true,
        'outcome' => 'partial',
        'title' => 'Victory with Scars',
        'text' => 'You win the duel, but whispers question how long your luck will hold.',
        'image' => 'assets/images/missions/tortuga-ending-partial.jpg',
        'rewards' => ['+20 Gold', '+5 Reputation']
      ],
      'failure-end' => [
        'ending' => true,
        'outcome' => 'failure',
        'title' => 'Outplayed in Public',
        'text' => 'You retreat into the night, planning your return.',
        'image' => 'assets/images/missions/tortuga-ending-failure.jpg',
        'rewards' => ['-5 Reputation', '+1 Resolve']
      ]
    ]
  ],
  [
    'id' => 'port-royal-ledger',
    'title' => 'Port Royal: The Smuggler Ledger',
    'location' => 'Port Royal',
    'category' => 'mystery',
    'mood' => 'treasure',
    'difficulty' => 2,
    'rewardText' => '45 Gold + Royal Seal',
    'summary' => 'The docks are under inspection, and a hidden ledger could expose the whole smuggling ring.',
    'image' => 'assets/images/missions/portroyal-card.jpg',
    'bgm' => 'assets/audio/missions/port-royal-ambient.mp3',
    'maxSteps' => 5,
    'nodes' => [
      'start' => [
        'title' => 'Harbor Watch',
        'text' => 'Port Royal is alive with soldiers, merchants, and cargo wagons. The ledger is rumored to be hidden somewhere along the piers.',
        'image' => 'assets/images/missions/portroyal-01-harbor.jpg',
        'choices' => [
          [ 'label' => 'Blend in with the dockworkers', 'next' => 'dockworkers', 'consequence' => 'You vanish into the crowd and follow the cargo line.', 'sfx' => 'assets/audio/missions/footsteps.mp3' ],
          [ 'label' => 'Bribe the customs clerk', 'next' => 'bribe', 'consequence' => 'The clerk pockets the coin and points you toward the warehouse.', 'sfx' => 'assets/audio/missions/coin-drop.mp3' ]
        ]
      ],
      'dockworkers' => [
        'title' => 'The Warehouse Row',
        'text' => 'A dockmaster counts crates while a naval patrol circles the street.',
        'image' => 'assets/images/missions/portroyal-03-bribe.jpg',
        'choices' => [
          [ 'label' => 'Search the marked crates', 'next' => 'crates', 'consequence' => 'You find false bottoms and a coded shipping manifest.', 'sfx' => 'assets/audio/missions/crate-drop.mp3' ],
          [ 'label' => 'Follow the patrol instead', 'next' => 'patrol', 'consequence' => 'You shadow the soldiers toward a sealed office block.', 'sfx' => 'assets/audio/missions/footsteps.mp3' ]
        ]
      ],
      'bribe' => [
        'title' => 'Customs Office',
        'text' => 'The clerk reveals the ledger changed hands twice already. One buyer is still in town.',
        'image' => 'assets/images/missions/portroyal-03-bribe.jpg',
        'choices' => [
          [ 'label' => 'Trail the buyer to the counting house', 'next' => 'counting-house', 'consequence' => 'You sprint through back streets before the trail goes cold.', 'sfx' => 'assets/audio/missions/footsteps.mp3' ],
          [ 'label' => 'Take the ledger copy and leave', 'next' => 'partial-end', 'consequence' => 'You gain proof, but not the full ledger.', 'sfx' => 'assets/audio/missions/paper-rustle.mp3' ]
        ]
      ],
      'crates' => [
        'title' => 'False Bottom Cargo',
        'text' => 'One crate hides the ledger, another hides a pistol pointed at the floor.',
        'image' => 'assets/images/missions/portroyal-04-crates.jpg',
        'choices' => [
          [ 'label' => 'Use the coded manifest to locate the ledger', 'next' => 'success-end', 'consequence' => 'You recover the ledger and expose the smugglers.', 'sfx' => 'assets/audio/missions/paper-rustle.mp3' ],
          [ 'label' => 'Take the cargo money instead', 'next' => 'failure-end', 'consequence' => 'The ledger stays hidden while the patrol closes in.', 'sfx' => 'assets/audio/missions/coin-drop.mp3' ]
        ]
      ],
      'patrol' => [
        'title' => 'Naval Patrol',
        'text' => 'The soldiers stop near a sealed office. Someone inside is waiting for the ledger.',
        'image' => 'assets/images/missions/portroyal-05-patrol.jpg',
        'choices' => [
          [ 'label' => 'Follow the officer inside', 'next' => 'counting-house', 'consequence' => 'You enter through the side door unnoticed.', 'sfx' => 'assets/audio/missions/footsteps.mp3' ],
          [ 'label' => 'Cause a dock distraction', 'next' => 'chase', 'consequence' => 'The patrol breaks formation and the harbor erupts.', 'sfx' => 'assets/audio/missions/crowd-gasp.mp3' ]
        ]
      ],
      'counting-house' => [
        'title' => 'Counting House Vault',
        'text' => 'The final copy of the ledger rests in an iron drawer behind a sea chart.',
        'image' => 'assets/images/missions/portroyal-06-counting-house.jpg',
        'choices' => [
          [ 'label' => 'Swap the ledger with a forged page', 'next' => 'success-end', 'consequence' => 'The smugglers never know what you took.', 'sfx' => 'assets/audio/missions/paper-rustle.mp3' ],
          [ 'label' => 'Snatch the ledger and run', 'next' => 'partial-end', 'consequence' => 'You escape with proof, but the alarm rings.', 'sfx' => 'assets/audio/missions/footsteps.mp3' ]
        ]
      ],
      'chase' => [
        'title' => 'Harbor Chase',
        'text' => 'Sailors and soldiers scatter. A single decision now decides whether the ledger survives.',
        'image' => 'assets/images/missions/portroyal-07-chase.jpg',
        'choices' => [
          [ 'label' => 'Jump a crate stack and lose the patrol', 'next' => 'partial-end', 'consequence' => 'You get away, but lose the original seal.', 'sfx' => 'assets/audio/missions/rockfall.mp3' ],
          [ 'label' => 'Hold your ground and fight', 'next' => 'failure-end', 'consequence' => 'You are overrun before you can secure the ledger.', 'sfx' => 'assets/audio/missions/sword-clang.mp3' ]
        ]
      ],
      'success-end' => [
        'ending' => true,
        'outcome' => 'success',
        'title' => 'Port Royal Exposed',
        'text' => 'The ledger is in your hands and the harbor’s secrets are yours to command.',
        'image' => 'assets/images/missions/portroyal-ending-success.jpg',
        'rewards' => ['+45 Gold', '+1 Royal Seal', '+8 Reputation']
      ],
      'partial-end' => [
        'ending' => true,
        'outcome' => 'partial',
        'title' => 'Evidence, Not Triumph',
        'text' => 'You recover part of the truth, but the dockmaster escapes with the rest.',
        'image' => 'assets/images/missions/portroyal-ending-partial.jpg',
        'rewards' => ['+20 Gold', '+4 Reputation']
      ],
      'failure-end' => [
        'ending' => true,
        'outcome' => 'failure',
        'title' => 'The Ledger Vanishes',
        'text' => 'The harbor seals shut behind you and the smugglers vanish into the night.',
        'image' => 'assets/images/missions/portroyal-ending-failure.jpg',
        'rewards' => ['-2 Reputation', '+1 Lesson']
      ]
    ]
  ],
  [
    'id' => 'shipwreck-cove-court',
    'title' => 'Shipwreck Cove: The Hidden Charter',
    'location' => 'Shipwreck Cove',
    'category' => 'mystery',
    'mood' => 'treasure',
    'difficulty' => 3,
    'rewardText' => '60 Gold + Pirate Charter',
    'summary' => 'The Brethren Court keeps an old charter locked inside the wrecks of the cove.',
    'image' => 'assets/images/missions/shipwreck-card.jpg',
    'bgm' => 'assets/audio/missions/shipwreck-ambient.mp3',
    'maxSteps' => 5,
    'nodes' => [
      'start' => [
        'title' => 'Broken Harbors',
        'text' => 'Old hulls lean over the water like skeletons. The charter is said to be hidden in the Court archives.',
        'image' => 'assets/images/missions/shipwreck-01-harbors.jpg',
        'choices' => [
          [ 'label' => 'Sneak through the wreck channel', 'next' => 'channel', 'consequence' => 'You slide between broken hulls toward the hidden court.', 'sfx' => 'assets/audio/missions/waves-heavy.mp3' ],
          [ 'label' => 'Call on an old pirate contact', 'next' => 'contact', 'consequence' => 'A wary look from the docks suggests someone remembers you.', 'sfx' => 'assets/audio/missions/tavern-murmur.mp3' ]
        ]
      ],
      'channel' => [
        'title' => 'Wreck Channel',
        'text' => 'The path narrows between splintered ships and rusting chains.',
        'image' => 'assets/images/missions/shipwreck-02-channel.jpg',
        'choices' => [
          [ 'label' => 'Dive under the chain boom', 'next' => 'vault', 'consequence' => 'You pass beneath the boom and reach the archives side door.', 'sfx' => 'assets/audio/missions/waves-heavy.mp3' ],
          [ 'label' => 'Climb the wreck mast for a better view', 'next' => 'mast', 'consequence' => 'You spot the courtyard, but someone spots you too.', 'sfx' => 'assets/audio/missions/footsteps.mp3' ]
        ]
      ],
      'contact' => [
        'title' => 'Old Crew Contact',
        'text' => 'Your contact offers directions, but wants a favor paid in advance.',
        'image' => 'assets/images/missions/shipwreck-03-contact.jpg',
        'choices' => [
          [ 'label' => 'Promise a share of the charter', 'next' => 'vault', 'consequence' => 'The contact opens a route into the archive tunnels.', 'sfx' => 'assets/audio/missions/coin-drop.mp3' ],
          [ 'label' => 'Refuse the favor and push on alone', 'next' => 'patrol', 'consequence' => 'You lose the route and enter under heavier watch.', 'sfx' => 'assets/audio/missions/footsteps.mp3' ]
        ]
      ],
      'vault' => [
        'title' => 'Archive Vault',
        'text' => 'The charter lies inside a sealed chest, guarded by old pirate codes.',
        'image' => 'assets/images/missions/shipwreck-04-vault.jpg',
        'choices' => [
          [ 'label' => 'Solve the code with the court seal', 'next' => 'success-end', 'consequence' => 'The vault opens and the charter is yours.', 'sfx' => 'assets/audio/missions/chest-open.mp3' ],
          [ 'label' => 'Force the chest before the court returns', 'next' => 'partial-end', 'consequence' => 'You get the charter, but trigger a silent alarm.', 'sfx' => 'assets/audio/missions/metal-strain.mp3' ]
        ]
      ],
      'mast' => [
        'title' => 'Mast Top Warning',
        'text' => 'A lookout demands your identity. The cove will not stay quiet for long.',
        'image' => 'assets/images/missions/shipwreck-05-mast.jpg',
        'choices' => [
          [ 'label' => 'Pretend to be court cargo', 'next' => 'patrol', 'consequence' => 'You are waved through toward the archives.', 'sfx' => 'assets/audio/missions/tavern-murmur.mp3' ],
          [ 'label' => 'Jump into the courtyard below', 'next' => 'failure-end', 'consequence' => 'You land hard and lose the trail to the charter.', 'sfx' => 'assets/audio/missions/rockfall.mp3' ]
        ]
      ],
      'patrol' => [
        'title' => 'Court Patrol',
        'text' => 'The Brethren Court guards the archive corridor with sharpened suspicion.',
        'image' => 'assets/images/missions/shipwreck-06-patrol.jpg',
        'choices' => [
          [ 'label' => 'Talk your way through', 'next' => 'vault', 'consequence' => 'You buy just enough time to reach the chest.', 'sfx' => 'assets/audio/missions/tavern-murmur.mp3' ],
          [ 'label' => 'Draw steel and push through', 'next' => 'failure-end', 'consequence' => 'The court overpowers you before you can escape.', 'sfx' => 'assets/audio/missions/sword-clang.mp3' ]
        ]
      ],
      'success-end' => [
        'ending' => true,
        'outcome' => 'success',
        'title' => 'Shipwreck Cove Unsealed',
        'text' => 'The hidden charter is yours, and the Brethren Court owes you a debt.',
        'image' => 'assets/images/missions/shipwreck-ending-success.jpg',
        'rewards' => ['+60 Gold', '+1 Pirate Charter', '+10 Reputation']
      ],
      'partial-end' => [
        'ending' => true,
        'outcome' => 'partial',
        'title' => 'The Charter Is Partial',
        'text' => 'You escape with proof of the charter, but the court marks your face.',
        'image' => 'assets/images/missions/shipwreck-ending-partial.jpg',
        'rewards' => ['+28 Gold', '+5 Reputation']
      ],
      'failure-end' => [
        'ending' => true,
        'outcome' => 'failure',
        'title' => 'The Court Claims the Trail',
        'text' => 'The archives are locked and every pirate in the cove now knows your name.',
        'image' => 'assets/images/missions/shipwreck-ending-failure.jpg',
        'rewards' => ['-3 Reputation', '+1 Escape']
      ]
    ]
  ],
  [
    'id' => 'devils-triangle-crossing',
    'title' => 'Devil\'s Triangle: Black Tide Crossing',
    'location' => 'Devil\'s Triangle',
    'category' => 'escape',
    'mood' => 'mystery',
    'difficulty' => 3,
    'rewardText' => '70 Gold + Storm Compass',
    'summary' => 'Ghost lights and violent currents twist every route through the cursed waters.',
    'image' => 'assets/images/missions/devils-triangle-card.png',
    'bgm' => 'assets/audio/missions/storm-ambient.mp3',
    'maxSteps' => 5,
    'nodes' => [
      'start' => [
        'title' => 'Black Water Horizon',
        'text' => 'The sea turns dark, and the compass spins without settling. Something watches from the fog.',
        'image' => 'assets/images/missions/devils-triangle-01-horizon.jpg',
        'choices' => [
          [ 'label' => 'Follow the ghost lights', 'next' => 'ghostlights', 'consequence' => 'The lantern-like lights drift deeper into the triangle.', 'sfx' => 'assets/audio/missions/waves-heavy.mp3' ],
          [ 'label' => 'Trust your map and steer hard east', 'next' => 'eastturn', 'consequence' => 'You commit to a brutal turn through the cursed current.', 'sfx' => 'assets/audio/missions/thunder.mp3' ]
        ]
      ],
      'ghostlights' => [
        'title' => 'Ghost Light Trail',
        'text' => 'The lights lead toward a wrecked ship that should not be floating.',
        'image' => 'assets/images/missions/devils-triangle-02-ghostlights.jpg',
        'choices' => [
          [ 'label' => 'Board the wreck', 'next' => 'wreckboard', 'consequence' => 'You leap aboard the ghost ship and hear voices below.', 'sfx' => 'assets/audio/missions/footsteps.mp3' ],
          [ 'label' => 'Fire a flare and mark the route', 'next' => 'flarestart', 'consequence' => 'The lights react, revealing hidden current lines.', 'sfx' => 'assets/audio/missions/cannon-shot.mp3' ]
        ]
      ],
      'flarestart' => [
        'title' => 'Reading the Lights',
        'text' => 'The flare illuminates a path through the currents, but the triangle twists in response.',
        'image' => 'assets/images/missions/devils-triangle-03-flarestart.jpg',
        'choices' => [
          [ 'label' => 'Follow the revealed channel', 'next' => 'flare', 'consequence' => 'You commit your course to the glowing waters.', 'sfx' => 'assets/audio/missions/waves-heavy.mp3' ],
          [ 'label' => 'Wait and observe the pattern', 'next' => 'observe', 'consequence' => 'The currents shift, revealing a second safer route.', 'sfx' => 'assets/audio/missions/thunder.mp3' ]
        ]
      ],
      'observe' => [
        'title' => 'The Pattern Shifts',
        'text' => 'The second route glows brighter. The fog parts for a moment, showing two possible passages.',
        'image' => 'assets/images/missions/devils-triangle-04-observe.jpg',
        'choices' => [
          [ 'label' => 'Steer through the marked channel', 'next' => 'success-end', 'consequence' => 'You navigate perfectly through the safe passage.', 'sfx' => 'assets/audio/missions/waves-heavy.mp3' ],
          [ 'label' => 'Cut the flare line and bolt', 'next' => 'partial-end', 'consequence' => 'You escape, but the compass cracks in the surge.', 'sfx' => 'assets/audio/missions/thunder.mp3' ]
        ]
      ],
      'eastturn' => [
        'title' => 'Current Break',
        'text' => 'The sea slams against the hull. A narrow gap opens between two lightning strikes.',
        'image' => 'assets/images/missions/devils-triangle-05-eastturn.jpg',
        'choices' => [
          [ 'label' => 'Ride the gap at full speed', 'next' => 'gaprun', 'consequence' => 'You thread the storm wall and gain precious distance.', 'sfx' => 'assets/audio/missions/thunder.mp3' ],
          [ 'label' => 'Drop anchor to stabilize', 'next' => 'failure-end', 'consequence' => 'The anchor drags you deeper into the triangle.', 'sfx' => 'assets/audio/missions/ship-creak.mp3' ]
        ]
      ],
      'wreckboard' => [
        'title' => 'Ghost Ship Boarding',
        'text' => 'The wreck is empty except for wet footprints and a sealed compass case.',
        'image' => 'assets/images/missions/devils-triangle-06-wreckboard.jpg',
        'choices' => [
          [ 'label' => 'Open the compass case', 'next' => 'wreckexamine', 'consequence' => 'You pry open the case with your cutlass.', 'sfx' => 'assets/audio/missions/chest-open.mp3' ],
          [ 'label' => 'Take the ship log instead', 'next' => 'readlog', 'consequence' => 'You grab the water-logged logbook and run.', 'sfx' => 'assets/audio/missions/paper-rustle.mp3' ]
        ]
      ],
      'wreckexamine' => [
        'title' => 'Storm Compass Revealed',
        'text' => 'Inside is an ancient compass pointing to safety. But the wreck begins to creak.',
        'image' => 'assets/images/missions/devils-triangle-07-wreckexamine.jpg',
        'choices' => [
          [ 'label' => 'Flee with the compass', 'next' => 'success-end', 'consequence' => 'You race back to the ship with the storm compass.', 'sfx' => 'assets/audio/missions/footsteps.mp3' ],
          [ 'label' => 'Also grab the helm wheel', 'next' => 'partial-end', 'consequence' => 'You grab too much and the wreck collapses behind you.', 'sfx' => 'assets/audio/missions/rockfall.mp3' ]
        ]
      ],
      'readlog' => [
        'title' => 'Deciphering the Log',
        'text' => 'The log contains route markers, but they fade in the ghostly light.',
        'image' => 'assets/images/missions/devils-triangle-08-readlog.jpg',
        'choices' => [
          [ 'label' => 'Trust the faded marks', 'next' => 'partial-end', 'consequence' => 'The marks lead you safely, but not to the compass.', 'sfx' => 'assets/audio/missions/waves-heavy.mp3' ],
          [ 'label' => 'Go back for the compass', 'next' => 'success-end', 'consequence' => 'You race back and grab both the compass and escape.', 'sfx' => 'assets/audio/missions/thunder.mp3' ]
        ]
      ],
      'flare' => [
        'title' => 'Current Lines Revealed',
        'text' => 'The flare lights a pattern of safe channels in the water.',
        'image' => 'assets/images/missions/devils-triangle-09-flare.jpg',
        'choices' => [
          [ 'label' => 'Steer through the marked channel', 'next' => 'success-end', 'consequence' => 'You exit the triangle with the storm compass intact.', 'sfx' => 'assets/audio/missions/waves-heavy.mp3' ],
          [ 'label' => 'Wait for the best current window', 'next' => 'partial-end', 'consequence' => 'You wait too long and the compass signal fades.', 'sfx' => 'assets/audio/missions/thunder.mp3' ]
        ]
      ],
      'gaprun' => [
        'title' => 'Lightning Gap',
        'text' => 'The ship tears across open water while lightning flashes close enough to burn the rigging.',
        'image' => 'assets/images/missions/devils-triangle-10-gaprun.jpg',
        'choices' => [
          [ 'label' => 'Hold speed through the gap', 'next' => 'gapfinal', 'consequence' => 'You thread the storm wall with precision.', 'sfx' => 'assets/audio/missions/thunder.mp3' ],
          [ 'label' => 'Slow down to stabilize', 'next' => 'gapstall', 'consequence' => 'The storm pulls at your hull as you lose momentum.', 'sfx' => 'assets/audio/missions/waves-heavy.mp3' ]
        ]
      ],
      'gapfinal' => [
        'title' => 'Storm Compass Found',
        'text' => 'Beyond the gap lies clear water and a floating compass on the surface.',
        'image' => 'assets/images/missions/devils-triangle-11-gapfinal.jpg',
        'choices' => [
          [ 'label' => 'Retrieve the compass', 'next' => 'success-end', 'consequence' => 'You collect the storm compass and chart the route home.', 'sfx' => 'assets/audio/missions/chest-open.mp3' ],
          [ 'label' => 'Document the route and sail on', 'next' => 'partial-end', 'consequence' => 'You escape, but leave the compass behind.', 'sfx' => 'assets/audio/missions/waves-heavy.mp3' ]
        ]
      ],
      'gapstall' => [
        'title' => 'Caught in the Spiral',
        'text' => 'The storm pulls harder. The waters spiral around your slowing ship.',
        'image' => 'assets/images/missions/devils-triangle-12-gapstall.jpg',
        'choices' => [
          [ 'label' => 'Full power - break through', 'next' => 'failure-end', 'consequence' => 'The triangle swallows your course and spits you into wreckage.', 'sfx' => 'assets/audio/missions/rockfall.mp3' ],
          [ 'label' => 'Anchor and wait out the storm', 'next' => 'partial-end', 'consequence' => 'You survive by drifting on the currents.', 'sfx' => 'assets/audio/missions/thunder.mp3' ]
        ]
      ],
      'success-end' => [
        'ending' => true,
        'outcome' => 'success',
        'title' => 'The Triangle Releases You',
        'text' => 'You cross the cursed waters and chart a way through the black tide.',
        'image' => 'assets/images/missions/devils-triangle-ending-success.jpg',
        'rewards' => ['+70 Gold', '+1 Storm Compass', '+12 Reputation']
      ],
      'partial-end' => [
        'ending' => true,
        'outcome' => 'partial',
        'title' => 'Escaped, But Marked',
        'text' => 'You survive the triangle, but the sea remembers your route.',
        'image' => 'assets/images/missions/devils-triangle-ending-partial.jpg',
        'rewards' => ['+30 Gold', '+4 Reputation']
      ],
      'failure-end' => [
        'ending' => true,
        'outcome' => 'failure',
        'title' => 'Lost in the Triangle',
        'text' => 'The waters claim the ship’s course and your crew vanishes in the fog.',
        'image' => 'assets/images/missions/devils-triangle-ending-failure.jpg',
        'rewards' => ['-6 Reputation', '+1 Survival']
      ]
    ]
  ]
];
