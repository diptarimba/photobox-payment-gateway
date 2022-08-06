<?php

namespace Database\Seeders;

use App\Models\Quote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['text' => 'Your first 10,000 photographs are your worst.', 'author' => 'Henri Cartier-Bresson'],
            ['text' => 'Photography is an austere and blazing poetry of the real.', 'author' => 'Ansel Adams'],
            ['text' => 'Photography is the story I fail to put into words.', 'author' => 'Destin Sparks'],
            ['text' => 'When words become unclear, I shall focus with photographs. When images become inadequate, I shall be content with silence.', 'author' => 'Ansel Adams'],
            ['text' => 'When I photograph I make love.', 'author' => 'Alfred Stieglitz'],
            ['text' => 'The negative is the equivalent of the composer’s score and the print the performance.', 'author' => 'Ansel Adams'],
            ['text' => 'There is one thing the photo must contain – the humanity of the moment.', 'author' => 'Robert Frank'],
            ['text' => 'Photography is a way of feeling, of touching, of loving. What you have caught on film is captured forever… It remembers little things, long after you have forgotten everything.', 'author' => 'Aaron Siskind'],
            ['text' => 'If you are out there shooting, things will happen for you. If you’re not out there, you’ll only hear about it.', 'author' => 'Jay Maisel'],
            ['text' => 'Photography is the art of making memories tangible.', 'author' => 'Destin Sparks'],
            ['text' => 'When you photograph people in color, you photograph their clothes. But when you photograph people in Black and white, you photograph their souls!', 'author' => 'Ted Grant'],
            ['text' => 'A good snapshot keeps a moment that s gone from running away.', 'author' => 'Eudora Welty']
        ];

        Quote::insert($data);
    }
}
