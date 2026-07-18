<?php

namespace Database\Seeders;

use App\Models\Quote;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
    /**
     * Seed the quotes table with iconic pirate quotes.
     */
    public function run(): void
    {
        $quotes = [
            [
                'quote' => 'Not all treasure is silver and gold, mate.',
                'speaker' => 'Captain Jack Sparrow',
                'character_image' => 'assets/images/home/new images/jack sparrow.jpg',
            ],
            [
                'quote' => 'Do you fear death? Do you fear that dark abyss?',
                'speaker' => 'Davy Jones',
                'character_image' => 'assets/images/characters/davy-jones.jpg',
            ],
            [
                'quote' => 'The problem is not the problem. The problem is your attitude about the problem.',
                'speaker' => 'Captain Jack Sparrow',
                'character_image' => 'assets/images/home/new images/jack sparrow.jpg',
            ],
            [
                'quote' => 'One day you will find yourself lost. You will have nothing and nowhere to go.',
                'speaker' => 'Will Turner',
                'character_image' => assets/images/home/will turner.jpg',
            ],
            [
                'quote' => 'Gentlemen, milady... you will always remember this as the day you almost caught Captain Jack Sparrow.',
                'speaker' => 'Captain Jack Sparrow',
                'character_image' => 'assets/images/home/new images/jack sparrow.jpg',
            ],
            [
                'quote' => 'Better to not know which moment may be your last. Every morsel of your entire being alive to the infinite mystery of it all.',
                'speaker' => 'Captain Barbossa',
                'character_image' => 'assets/images/home/new images/barbosa.jpg',
            ],
            [
                'quote' => 'The seas may be rough, but I am the Captain! No matter how the wind howls, the mountain cannot bow to it.',
                'speaker' => 'Elizabeth Swann',
                'character_image' => 'assets/images/home/elizabeth swann.jpg',
            ],
            [
                'quote' => 'I got a jar of dirt! I got a jar of dirt! And guess what's inside it!',
                'speaker' => 'Captain Jack Sparrow',
                'character_image' => 'assets/images/home/new images/jack sparrow.jpg',
            ],
            [
                'quote' => 'You best start believing in ghost stories, Miss Turner. You\'re in one.',
                'speaker' => 'Captain Barbossa',
                'character_image' => 'assets/images/home/new images/barbosa.jpg',
            ],
            [
                'quote' => 'The world is still the same. There\'s just less in it.',
                'speaker' => 'Captain Jack Sparrow',
                'character_image' => 'assets/images/home/new images/jack sparrow.jpg',
            ],
            [
                'quote' => 'Life is cruel. Why should the afterlife be any different?',
                'speaker' => 'Davy Jones',
                'character_image' => 'assets/images/home/davy-jones.jpg',
            ],

        ];

        foreach ($quotes as $quote) {
            Quote::create($quote);
        }
    }
}
