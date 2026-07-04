<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        $quizData = [
            [
                'question' => 'When danger approaches, what do you trust most?',
                'answers' => [
                    ['text' => 'My instincts', 'role' => 'captain', 'trait' => 'fearless', 'allegiance' => 'free'],
                    ['text' => 'My sword', 'role' => 'hunter', 'trait' => 'loyal', 'allegiance' => 'navy'],
                    ['text' => 'My crew', 'role' => 'strategist', 'trait' => 'loyal', 'allegiance' => 'free'],
                    ['text' => 'My luck', 'role' => 'cursed', 'trait' => 'mysterious', 'allegiance' => 'mythic'],
                ],
            ],
            [
                'question' => 'Which sea path calls to you at midnight?',
                'answers' => [
                    ['text' => 'The storm route', 'role' => 'captain', 'trait' => 'fearless', 'allegiance' => 'free'],
                    ['text' => 'The hidden currents', 'role' => 'navigator', 'trait' => 'cunning', 'allegiance' => 'free'],
                    ['text' => 'The haunted channel', 'role' => 'cursed', 'trait' => 'mysterious', 'allegiance' => 'mythic'],
                    ['text' => 'The trade lane', 'role' => 'strategist', 'trait' => 'cunning', 'allegiance' => 'merchant'],
                ],
            ],
            [
                'question' => 'Your rival offers a truce. You respond by...',
                'answers' => [
                    ['text' => 'Accepting, then outsmarting later', 'role' => 'strategist', 'trait' => 'cunning', 'allegiance' => 'merchant'],
                    ['text' => 'Reading their intent first', 'role' => 'navigator', 'trait' => 'mysterious', 'allegiance' => 'free'],
                    ['text' => 'Demanding a duel at dawn', 'role' => 'hunter', 'trait' => 'fearless', 'allegiance' => 'navy'],
                    ['text' => 'Listening to the whispers in the wind', 'role' => 'cursed', 'trait' => 'mysterious', 'allegiance' => 'mythic'],
                ],
            ],
            [
                'question' => 'What treasure is worth risking everything for?',
                'answers' => [
                    ['text' => 'A legendary map', 'role' => 'navigator', 'trait' => 'cunning', 'allegiance' => 'free'],
                    ['text' => 'A cursed relic', 'role' => 'cursed', 'trait' => 'mysterious', 'allegiance' => 'mythic'],
                    ['text' => 'A throne and fleet', 'role' => 'captain', 'trait' => 'fearless', 'allegiance' => 'navy'],
                    ['text' => 'Gold to feed my people', 'role' => 'strategist', 'trait' => 'loyal', 'allegiance' => 'merchant'],
                ],
            ],
            [
                'question' => 'When your crew doubts the voyage, you...',
                'answers' => [
                    ['text' => 'Lead from the front', 'role' => 'captain', 'trait' => 'fearless', 'allegiance' => 'free'],
                    ['text' => 'Show the stars and route', 'role' => 'navigator', 'trait' => 'loyal', 'allegiance' => 'free'],
                    ['text' => 'Lay a perfect plan', 'role' => 'strategist', 'trait' => 'cunning', 'allegiance' => 'merchant'],
                    ['text' => 'Invoke old sea oaths', 'role' => 'cursed', 'trait' => 'mysterious', 'allegiance' => 'mythic'],
                ],
            ],
            [
                'question' => 'What keeps you moving when the map goes dark?',
                'answers' => [
                    ['text' => 'The thrill of the unknown', 'role' => 'captain', 'trait' => 'fearless', 'allegiance' => 'free'],
                    ['text' => 'A trail of stars', 'role' => 'navigator', 'trait' => 'loyal', 'allegiance' => 'free'],
                    ['text' => 'A clever plan ahead', 'role' => 'strategist', 'trait' => 'cunning', 'allegiance' => 'merchant'],
                    ['text' => 'The pull of old legends', 'role' => 'cursed', 'trait' => 'mysterious', 'allegiance' => 'mythic'],
                ],
            ],
            [
                'question' => 'Which sound belongs to your ideal voyage?',
                'answers' => [
                    ['text' => 'Cannons thundering', 'role' => 'hunter', 'trait' => 'fearless', 'allegiance' => 'navy'],
                    ['text' => 'Rigging creaking in calm wind', 'role' => 'navigator', 'trait' => 'loyal', 'allegiance' => 'free'],
                    ['text' => 'Coins spilling into a chest', 'role' => 'strategist', 'trait' => 'cunning', 'allegiance' => 'merchant'],
                    ['text' => 'Chains rattling below deck', 'role' => 'cursed', 'trait' => 'mysterious', 'allegiance' => 'mythic'],
                ],
            ],
            [
                'question' => 'A stranger hands you a sealed letter. You...',
                'answers' => [
                    ['text' => 'Break the seal at once', 'role' => 'captain', 'trait' => 'fearless', 'allegiance' => 'free'],
                    ['text' => 'Inspect the wax and markings', 'role' => 'navigator', 'trait' => 'cunning', 'allegiance' => 'free'],
                    ['text' => 'Archive it for leverage', 'role' => 'strategist', 'trait' => 'loyal', 'allegiance' => 'merchant'],
                    ['text' => 'Feel for a curse before opening', 'role' => 'cursed', 'trait' => 'mysterious', 'allegiance' => 'mythic'],
                ],
            ],
            [
                'question' => 'What best describes your command style?',
                'answers' => [
                    ['text' => 'Bold and direct', 'role' => 'captain', 'trait' => 'fearless', 'allegiance' => 'free'],
                    ['text' => 'Measured and observant', 'role' => 'navigator', 'trait' => 'cunning', 'allegiance' => 'free'],
                    ['text' => 'Precise and disciplined', 'role' => 'hunter', 'trait' => 'loyal', 'allegiance' => 'navy'],
                    ['text' => 'Quietly unnerving', 'role' => 'cursed', 'trait' => 'mysterious', 'allegiance' => 'mythic'],
                ],
            ],
            [
                'question' => 'On the horizon, you spot a ghost ship. You...',
                'answers' => [
                    ['text' => 'Sail straight toward it', 'role' => 'captain', 'trait' => 'fearless', 'allegiance' => 'free'],
                    ['text' => 'Chart a careful approach', 'role' => 'navigator', 'trait' => 'cunning', 'allegiance' => 'free'],
                    ['text' => 'Signal the crew to hold formation', 'role' => 'strategist', 'trait' => 'loyal', 'allegiance' => 'merchant'],
                    ['text' => 'Answer its call', 'role' => 'cursed', 'trait' => 'mysterious', 'allegiance' => 'mythic'],
                ],
            ],
            [
                'question' => 'What kind of victory matters most?',
                'answers' => [
                    ['text' => 'A daring triumph', 'role' => 'captain', 'trait' => 'fearless', 'allegiance' => 'free'],
                    ['text' => 'A victory with no wasted motion', 'role' => 'navigator', 'trait' => 'cunning', 'allegiance' => 'free'],
                    ['text' => 'A win that secures the crew', 'role' => 'strategist', 'trait' => 'loyal', 'allegiance' => 'merchant'],
                    ['text' => 'A victory that changes fate', 'role' => 'cursed', 'trait' => 'mysterious', 'allegiance' => 'mythic'],
                ],
            ],
            [
                'question' => 'When the seas turn violent, you rely on...',
                'answers' => [
                    ['text' => 'Raw nerve', 'role' => 'captain', 'trait' => 'fearless', 'allegiance' => 'free'],
                    ['text' => 'Navigation and timing', 'role' => 'navigator', 'trait' => 'loyal', 'allegiance' => 'free'],
                    ['text' => 'Prepared contingencies', 'role' => 'strategist', 'trait' => 'cunning', 'allegiance' => 'merchant'],
                    ['text' => 'The storm itself', 'role' => 'cursed', 'trait' => 'mysterious', 'allegiance' => 'mythic'],
                ],
            ],
            [
                'question' => 'Which keepsake would you guard with your life?',
                'answers' => [
                    ['text' => 'A cracked captain\'s ring', 'role' => 'captain', 'trait' => 'loyal', 'allegiance' => 'free'],
                    ['text' => 'An ink-stained star chart', 'role' => 'navigator', 'trait' => 'cunning', 'allegiance' => 'free'],
                    ['text' => 'A ledger of debts owed', 'role' => 'strategist', 'trait' => 'loyal', 'allegiance' => 'merchant'],
                    ['text' => 'A relic that hums at night', 'role' => 'cursed', 'trait' => 'mysterious', 'allegiance' => 'mythic'],
                ],
            ],
            [
                'question' => 'A rival boasts about their legend. You...',
                'answers' => [
                    ['text' => 'Laugh and challenge them', 'role' => 'hunter', 'trait' => 'fearless', 'allegiance' => 'navy'],
                    ['text' => 'Let their pride reveal a weakness', 'role' => 'navigator', 'trait' => 'cunning', 'allegiance' => 'free'],
                    ['text' => 'Quietly outmaneuver them', 'role' => 'strategist', 'trait' => 'loyal', 'allegiance' => 'merchant'],
                    ['text' => 'Offer them a prophecy', 'role' => 'cursed', 'trait' => 'mysterious', 'allegiance' => 'mythic'],
                ],
            ],
            [
                'question' => 'Which crew member do you trust most?',
                'answers' => [
                    ['text' => 'The one who never backs down', 'role' => 'captain', 'trait' => 'fearless', 'allegiance' => 'free'],
                    ['text' => 'The one who spots hidden routes', 'role' => 'navigator', 'trait' => 'loyal', 'allegiance' => 'free'],
                    ['text' => 'The one who keeps order', 'role' => 'strategist', 'trait' => 'loyal', 'allegiance' => 'merchant'],
                    ['text' => 'The one who hears the sea speak', 'role' => 'cursed', 'trait' => 'mysterious', 'allegiance' => 'mythic'],
                ],
            ],
            [
                'question' => 'Your ideal treasure room contains...',
                'answers' => [
                    ['text' => 'Weapons won in battle', 'role' => 'hunter', 'trait' => 'fearless', 'allegiance' => 'navy'],
                    ['text' => 'Maps from forgotten coasts', 'role' => 'navigator', 'trait' => 'cunning', 'allegiance' => 'free'],
                    ['text' => 'Contracts, keys, and codes', 'role' => 'strategist', 'trait' => 'loyal', 'allegiance' => 'merchant'],
                    ['text' => 'Artifacts wrapped in salt cloth', 'role' => 'cursed', 'trait' => 'mysterious', 'allegiance' => 'mythic'],
                ],
            ],
            [
                'question' => 'What do you do first after claiming a ship?',
                'answers' => [
                    ['text' => 'Raise the colors and sail', 'role' => 'captain', 'trait' => 'fearless', 'allegiance' => 'free'],
                    ['text' => 'Study the charts and currents', 'role' => 'navigator', 'trait' => 'cunning', 'allegiance' => 'free'],
                    ['text' => 'Assign stations and supplies', 'role' => 'strategist', 'trait' => 'loyal', 'allegiance' => 'merchant'],
                    ['text' => 'Listen for what the hull remembers', 'role' => 'cursed', 'trait' => 'mysterious', 'allegiance' => 'mythic'],
                ],
            ],
            [
                'question' => 'Which oath sounds most like yours?',
                'answers' => [
                    ['text' => 'No wave shall turn me aside', 'role' => 'captain', 'trait' => 'fearless', 'allegiance' => 'free'],
                    ['text' => 'I will never lose the way', 'role' => 'navigator', 'trait' => 'loyal', 'allegiance' => 'free'],
                    ['text' => 'Every deal will favor the crew', 'role' => 'strategist', 'trait' => 'loyal', 'allegiance' => 'merchant'],
                    ['text' => 'The deep remembers my name', 'role' => 'cursed', 'trait' => 'mysterious', 'allegiance' => 'mythic'],
                ],
            ],
            [
                'question' => 'When the night watch grows uneasy, you...',
                'answers' => [
                    ['text' => 'Stand watch beside them', 'role' => 'hunter', 'trait' => 'loyal', 'allegiance' => 'navy'],
                    ['text' => 'Trace safe bearings in the dark', 'role' => 'navigator', 'trait' => 'cunning', 'allegiance' => 'free'],
                    ['text' => 'Reassure them with a plan', 'role' => 'strategist', 'trait' => 'loyal', 'allegiance' => 'merchant'],
                    ['text' => 'Smile like you know a secret', 'role' => 'cursed', 'trait' => 'mysterious', 'allegiance' => 'mythic'],
                ],
            ],
            [
                'question' => 'What makes a legend endure?',
                'answers' => [
                    ['text' => 'Fearless action', 'role' => 'captain', 'trait' => 'fearless', 'allegiance' => 'free'],
                    ['text' => 'Perfect timing', 'role' => 'navigator', 'trait' => 'cunning', 'allegiance' => 'free'],
                    ['text' => 'Unbreakable loyalty', 'role' => 'strategist', 'trait' => 'loyal', 'allegiance' => 'merchant'],
                    ['text' => 'A mystery no one solves', 'role' => 'cursed', 'trait' => 'mysterious', 'allegiance' => 'mythic'],
                ],
            ],
            [
                'question' => 'A storm offers one final choice. You choose...',
                'answers' => [
                    ['text' => 'The straight path through it', 'role' => 'captain', 'trait' => 'fearless', 'allegiance' => 'free'],
                    ['text' => 'The edge where winds shift', 'role' => 'navigator', 'trait' => 'cunning', 'allegiance' => 'free'],
                    ['text' => 'The route with the best odds', 'role' => 'strategist', 'trait' => 'loyal', 'allegiance' => 'merchant'],
                    ['text' => 'The whisper inside the lightning', 'role' => 'cursed', 'trait' => 'mysterious', 'allegiance' => 'mythic'],
                ],
            ],
            [
                'question' => 'What title would your crew whisper behind your back?',
                'answers' => [
                    ['text' => 'The Unbroken Captain', 'role' => 'captain', 'trait' => 'fearless', 'allegiance' => 'free'],
                    ['text' => 'The Star-Sighted Guide', 'role' => 'navigator', 'trait' => 'cunning', 'allegiance' => 'free'],
                    ['text' => 'The Ledger Mind', 'role' => 'strategist', 'trait' => 'loyal', 'allegiance' => 'merchant'],
                    ['text' => 'The Tide-Touched One', 'role' => 'cursed', 'trait' => 'mysterious', 'allegiance' => 'mythic'],
                ],
            ]
        ];

        $shipQuestions = [
            [
                'question' => 'How do you prefer to engage your enemies?',
                'answers' => [
                    ['text' => 'Overwhelm them with sheer firepower', 'ship' => 'The Iron Galleon'],
                    ['text' => 'Outmaneuver them with speed', 'ship' => 'The Swift Sloop'],
                    ['text' => 'Strike from the shadows', 'ship' => 'The Phantom Brig'],
                    ['text' => 'Absorb their attacks and board them', 'ship' => 'The Dreadnought'],
                ]
            ],
            [
                'question' => 'What is the most important quality in a vessel?',
                'answers' => [
                    ['text' => 'Terrifying presence and aura', 'ship' => 'The Crimson Leviathan'],
                    ['text' => 'Ability to glide silently in the night', 'ship' => 'The Silent Marauder'],
                    ['text' => 'Mystical connection to the ocean depths', 'ship' => 'The Abyssal Queen'],
                    ['text' => 'Opulence that demands respect', 'ship' => 'The Gilded Serpent'],
                ]
            ],
            [
                'question' => 'Your crew spots a heavily armed merchant convoy. You...',
                'answers' => [
                    ['text' => 'Read the stars to intercept them perfectly', 'ship' => 'The Star-Catcher'],
                    ['text' => 'Summon a storm to break their formation', 'ship' => 'The Tempest\'s Wrath'],
                    ['text' => 'Broadside them and demand surrender', 'ship' => 'The Iron Galleon'],
                    ['text' => 'Pick off the stragglers quickly', 'ship' => 'The Swift Sloop'],
                ]
            ],
            [
                'question' => 'A storm is brewing on the horizon. Your orders?',
                'answers' => [
                    ['text' => 'Use the storm to cover our approach', 'ship' => 'The Phantom Brig'],
                    ['text' => 'Ride the squall to our destination', 'ship' => 'The Dreadnought'],
                    ['text' => 'Feed the storm our fury', 'ship' => 'The Crimson Leviathan'],
                    ['text' => 'Slip past it unnoticed', 'ship' => 'The Silent Marauder'],
                ]
            ],
            [
                'question' => 'If your ship had a soul, what would it crave?',
                'answers' => [
                    ['text' => 'The secrets of the abyss', 'ship' => 'The Abyssal Queen'],
                    ['text' => 'Infinite wealth and glory', 'ship' => 'The Gilded Serpent'],
                    ['text' => 'Knowledge of the cosmos', 'ship' => 'The Star-Catcher'],
                    ['text' => 'Chaos and roaring thunder', 'ship' => 'The Tempest\'s Wrath'],
                ]
            ],
            [
                'question' => 'You find an uncharted island. You...',
                'answers' => [
                    ['text' => 'Establish a fortified beachhead', 'ship' => 'The Iron Galleon'],
                    ['text' => 'Scout it rapidly before the tide turns', 'ship' => 'The Swift Sloop'],
                    ['text' => 'Claim it in the name of terror', 'ship' => 'The Crimson Leviathan'],
                    ['text' => 'Map its hidden coves in silence', 'ship' => 'The Silent Marauder'],
                ]
            ],
            [
                'question' => 'The royal navy has you cornered. You...',
                'answers' => [
                    ['text' => 'Vanish into the eerie fog', 'ship' => 'The Phantom Brig'],
                    ['text' => 'Ram their blockade to splinters', 'ship' => 'The Dreadnought'],
                    ['text' => 'Drag them to the depths with you', 'ship' => 'The Abyssal Queen'],
                    ['text' => 'Bribe their admiral with unseen riches', 'ship' => 'The Gilded Serpent'],
                ]
            ],
            [
                'question' => 'A mutiny is brewing below deck. You...',
                'answers' => [
                    ['text' => 'Read their fates in the stars to show them the truth', 'ship' => 'The Star-Catcher'],
                    ['text' => 'Unleash your wrath upon the ringleaders', 'ship' => 'The Tempest\'s Wrath'],
                    ['text' => 'Lock them in the iron brig', 'ship' => 'The Iron Galleon'],
                    ['text' => 'Let the ghosts handle them', 'ship' => 'The Phantom Brig'],
                ]
            ],
            [
                'question' => 'You discover a cursed artifact. You...',
                'answers' => [
                    ['text' => 'Outrun the curse it brings', 'ship' => 'The Swift Sloop'],
                    ['text' => 'Store it deep in the indestructible hold', 'ship' => 'The Dreadnought'],
                    ['text' => 'Feed its power to the ship\'s dark heart', 'ship' => 'The Crimson Leviathan'],
                    ['text' => 'Offer it to the ocean\'s embrace', 'ship' => 'The Abyssal Queen'],
                ]
            ],
            [
                'question' => 'The Kraken rises from the deep. You...',
                'answers' => [
                    ['text' => 'Slip away while it attacks another vessel', 'ship' => 'The Silent Marauder'],
                    ['text' => 'Distract it with gleaming gold', 'ship' => 'The Gilded Serpent'],
                    ['text' => 'Navigate through its tentacles flawlessly', 'ship' => 'The Star-Catcher'],
                    ['text' => 'Strike it with lightning and thunder', 'ship' => 'The Tempest\'s Wrath'],
                ]
            ]
        ];

        $weaponQuestions = [
            [
                'question' => 'A duel is inevitable. Your stance is...',
                'answers' => [
                    ['text' => 'Aggressive and close quarters', 'weapon' => 'Cursed Cutlass'],
                    ['text' => 'Measured, at a distance', 'weapon' => 'Gold-Inlaid Flintlock'],
                    ['text' => 'Unpredictable and chaotic', 'weapon' => 'Abyssal Dagger'],
                    ['text' => 'Heavy and overwhelming', 'weapon' => 'Kraken Bone Axe'],
                ]
            ],
            [
                'question' => 'What is a weapon\'s true purpose?',
                'answers' => [
                    ['text' => 'To unleash burning destruction', 'weapon' => 'Volcanic Broadsword'],
                    ['text' => 'To strike with elegant precision', 'weapon' => 'Obsidian Rapier'],
                    ['text' => 'To clear a room in one deafening blast', 'weapon' => 'Blunderbuss of the Deep'],
                    ['text' => 'To paralyze with toxic fear', 'weapon' => 'Venomous Harpoon'],
                ]
            ],
            [
                'question' => 'Your enemy drops their guard for a split second. You...',
                'answers' => [
                    ['text' => 'Blind them with starlight before striking', 'weapon' => 'Starlit Scimitar'],
                    ['text' => 'Meld into the shadows and appear behind them', 'weapon' => 'Shadow-Forged Cutlass'],
                    ['text' => 'Strike true to the heart', 'weapon' => 'Cursed Cutlass'],
                    ['text' => 'Take the shot without hesitation', 'weapon' => 'Gold-Inlaid Flintlock'],
                ]
            ],
            [
                'question' => 'Which of these feels most natural in your hand?',
                'answers' => [
                    ['text' => 'Something easily concealed and deadly', 'weapon' => 'Abyssal Dagger'],
                    ['text' => 'A weight that demands respect', 'weapon' => 'Kraken Bone Axe'],
                    ['text' => 'A blade that radiates heat', 'weapon' => 'Volcanic Broadsword'],
                    ['text' => 'A perfectly balanced duelist blade', 'weapon' => 'Obsidian Rapier'],
                ]
            ],
            [
                'question' => 'You are outnumbered in a tavern brawl. Your move?',
                'answers' => [
                    ['text' => 'Fire blindly into the crowd', 'weapon' => 'Blunderbuss of the Deep'],
                    ['text' => 'Throw a poisoned barb to scatter them', 'weapon' => 'Venomous Harpoon'],
                    ['text' => 'Dance through them with dazzling speed', 'weapon' => 'Starlit Scimitar'],
                    ['text' => 'Extinguish the lanterns and hunt in the dark', 'weapon' => 'Shadow-Forged Cutlass'],
                ]
            ],
            [
                'question' => 'A betrayal leaves you cornered. You grab...',
                'answers' => [
                    ['text' => 'The cursed blade resting on the mantle', 'weapon' => 'Cursed Cutlass'],
                    ['text' => 'A dagger carved from the abyss', 'weapon' => 'Abyssal Dagger'],
                    ['text' => 'A heavy molten sword', 'weapon' => 'Volcanic Broadsword'],
                    ['text' => 'A loaded, rusty blunderbuss', 'weapon' => 'Blunderbuss of the Deep'],
                ]
            ],
            [
                'question' => 'The enemy captain challenges you to single combat. You draw...',
                'answers' => [
                    ['text' => 'Your finest, gold-trimmed pistol', 'weapon' => 'Gold-Inlaid Flintlock'],
                    ['text' => 'An intimidating bone axe', 'weapon' => 'Kraken Bone Axe'],
                    ['text' => 'Your impossibly sharp glass rapier', 'weapon' => 'Obsidian Rapier'],
                    ['text' => 'A harpoon dripping with green venom', 'weapon' => 'Venomous Harpoon'],
                ]
            ],
            [
                'question' => 'You must sever the ropes before the ship sinks. You use...',
                'answers' => [
                    ['text' => 'A shimmering scimitar of light', 'weapon' => 'Starlit Scimitar'],
                    ['text' => 'A blade that cuts without reflecting', 'weapon' => 'Shadow-Forged Cutlass'],
                    ['text' => 'A dependable, rune-etched cutlass', 'weapon' => 'Cursed Cutlass'],
                    ['text' => 'Wait, I just shoot the pulley', 'weapon' => 'Gold-Inlaid Flintlock'],
                ]
            ],
            [
                'question' => 'A sea monster breaches the hull. You strike with...',
                'answers' => [
                    ['text' => 'A blade made from the deep itself', 'weapon' => 'Abyssal Dagger'],
                    ['text' => 'An axe carved from its own kin', 'weapon' => 'Kraken Bone Axe'],
                    ['text' => 'A sword hot enough to boil the sea', 'weapon' => 'Volcanic Broadsword'],
                    ['text' => 'A massive blast of shrapnel', 'weapon' => 'Blunderbuss of the Deep'],
                ]
            ],
            [
                'question' => 'The treasure room is guarded. You enter with...',
                'answers' => [
                    ['text' => 'A silent thrust to the throat', 'weapon' => 'Obsidian Rapier'],
                    ['text' => 'A toxic dart from the shadows', 'weapon' => 'Venomous Harpoon'],
                    ['text' => 'A dazzling flourish of a glowing blade', 'weapon' => 'Starlit Scimitar'],
                    ['text' => 'A sword drawn directly from the dark', 'weapon' => 'Shadow-Forged Cutlass'],
                ]
            ]
        ];

        \App\Models\Question::query()->delete();
        \App\Models\Answer::query()->delete();

        // Seed Identity Questions
        foreach ($quizData as $data) {
            $question = \App\Models\Question::create(['question_text' => $data['question'], 'type' => 'identity']);
            foreach ($data['answers'] as $ans) {
                \App\Models\Answer::create([
                    'question_id' => $question->id,
                    'answer_text' => $ans['text'],
                    'role_impact' => $ans['role'],
                    'trait_impact' => $ans['trait'],
                    'allegiance_impact' => $ans['allegiance'],
                ]);
            }
        }

        // Seed Ship Questions
        foreach ($shipQuestions as $data) {
            $question = \App\Models\Question::create(['question_text' => $data['question'], 'type' => 'ship']);
            foreach ($data['answers'] as $ans) {
                \App\Models\Answer::create([
                    'question_id' => $question->id,
                    'answer_text' => $ans['text'],
                    'ship_impact' => $ans['ship'],
                ]);
            }
        }

        // Seed Weapon Questions
        foreach ($weaponQuestions as $data) {
            $question = \App\Models\Question::create(['question_text' => $data['question'], 'type' => 'weapon']);
            foreach ($data['answers'] as $ans) {
                \App\Models\Answer::create([
                    'question_id' => $question->id,
                    'answer_text' => $ans['text'],
                    'weapon_impact' => $ans['weapon'],
                ]);
            }
        }
    }
}
