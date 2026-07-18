<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PirateProfile;
use App\Models\UserReward;
use App\Models\TavernPost;
use App\Models\TavernComment;
use App\Models\TavernLike;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TavernSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed some dummy pirate users
        $pirates = [
            ['name' => 'Blackbeard Teach', 'email' => 'teach@pirates.test', 'pirate_name' => 'Edward "Blackbeard" Teach', 'rank' => 'Captain', 'allegiance' => 'Brethren Court', 'avatar' => 'avatar-captain-fearless.png', 'reputation' => 950, 'missions' => 42, 'relics' => 5],
            ['name' => 'Anne Bonny', 'email' => 'anne@pirates.test', 'pirate_name' => 'Anne "The Fierce" Bonny', 'rank' => 'Swordmaster', 'allegiance' => 'Pirate Republic', 'avatar' => 'avatar-hunter-cunning.png', 'reputation' => 840, 'missions' => 38, 'relics' => 3],
            ['name' => 'Jack Rackham', 'email' => 'calico@pirates.test', 'pirate_name' => 'Calico Jack', 'rank' => 'Navigator', 'allegiance' => 'Pirate Republic', 'avatar' => 'avatar-navigator-cunning.png', 'reputation' => 720, 'missions' => 25, 'relics' => 2],
            ['name' => 'Mary Read', 'email' => 'mary@pirates.test', 'pirate_name' => 'Mary "Steel" Read', 'rank' => 'Swordmaster', 'allegiance' => 'Pirate Republic', 'avatar' => 'avatar-hunter-loyal.png', 'reputation' => 780, 'missions' => 30, 'relics' => 4],
            ['name' => 'Bartholomew Roberts', 'email' => 'bart@pirates.test', 'pirate_name' => 'Black Bart', 'rank' => 'Captain', 'allegiance' => 'Brethren Court', 'avatar' => 'avatar-captain-mysterious.png', 'reputation' => 920, 'missions' => 40, 'relics' => 6],
        ];

        $userIds = [];

        foreach ($pirates as $p) {
            $user = User::firstOrCreate(
                ['email' => $p['email']],
                [
                    'name' => $p['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'pirate_name' => $p['pirate_name'],
                    'rank' => $p['rank'],
                    'allegiance' => $p['allegiance'],
                    'avatar' => $p['avatar']
                ]
            );

            PirateProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'pirate_name' => $p['pirate_name'],
                    'rank' => $p['rank'],
                    'allegiance' => $p['allegiance'],
                    'avatar' => $p['avatar']
                ]
            );

            UserReward::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'reputation' => $p['reputation'],
                    'gold' => $p['missions'] * 100, // dummy gold
                    'relics' => $p['relics']
                ]
            );

            $userIds[] = $user->id;
        }

        // 2. Seed Tavern Posts (Discussions)
        $postsData = [
            [
                'user_id' => $userIds[0], 
                'title' => 'The Kraken is Awake!', 
                'content' => 'I saw it with me own two eyes off the coast of Tortuga. A beast the size of a galleon! Who else has seen the ripples in the dark waters?'
            ],
            [
                'user_id' => $userIds[1], 
                'title' => 'Best blade for close quarters?', 
                'content' => 'Cutlass or rapier? I find a good cutlass handles the rough and tumble of a boarding action much better.'
            ],
            [
                'user_id' => $userIds[2], 
                'title' => 'Looking for a skilled navigator', 
                'content' => 'Our last navigator had a disagreement with a cannonball. The ship pays well. Need someone who can read the stars.'
            ],
            [
                'user_id' => $userIds[3], 
                'title' => 'Rum prices in Nassau are outrageous!', 
                'content' => 'Ten gold pieces for a watered-down pint? It is a travesty! We should boycott the local taverns until they lower the price.'
            ],
            [
                'user_id' => $userIds[4], 
                'title' => 'Cursed Treasure in the Cove', 
                'content' => 'Do not touch the Aztec gold in the eastern cove. Three of my men turned into skeletons under the moonlight.'
            ]
        ];

        $postIds = [];
        foreach ($postsData as $pd) {
            $post = TavernPost::firstOrCreate(
                ['title' => $pd['title']],
                ['user_id' => $pd['user_id'], 'content' => $pd['content'], 'likes_count' => rand(1, 10)]
            );
            $postIds[] = $post->id;
        }

        // 3. Seed Tavern Comments
        $commentsData = [
            ['tavern_post_id' => $postIds[0], 'user_id' => $userIds[1], 'content' => 'Aye, I saw the beast too. Took down a merchant vessel in seconds.'],
            ['tavern_post_id' => $postIds[0], 'user_id' => $userIds[4], 'content' => 'You fools. The Kraken is just a myth invented by the Royal Navy to scare us.'],
            ['tavern_post_id' => $postIds[1], 'user_id' => $userIds[3], 'content' => 'A cutlass, always. A rapier is too fragile for real combat.'],
            ['tavern_post_id' => $postIds[2], 'user_id' => $userIds[0], 'content' => 'I know a guy in Port Royal. I\'ll send word.'],
            ['tavern_post_id' => $postIds[4], 'user_id' => $userIds[2], 'content' => 'I warned you about that gold, Bart. Next time listen to the legends.']
        ];

        foreach ($commentsData as $cd) {
            TavernComment::firstOrCreate($cd);
        }

        // 4. Seed Tavern Likes
        foreach ($postIds as $postId) {
            // Randomly like posts
            $likers = (array) array_rand(array_flip($userIds), rand(1, 3));
            foreach ($likers as $likerId) {
                TavernLike::firstOrCreate(['tavern_post_id' => $postId, 'user_id' => $likerId]);
            }
        }
    }
}
