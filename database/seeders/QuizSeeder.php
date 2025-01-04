<?php

namespace Database\Seeders;

use App\Models\Quiz;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        Quiz::create([
            'creator' => 'gorkem123',
            'title' => 'Blockchain Basics',
            'duration' => 60,
            'slug' => Str::slug('Blockchain Basics'),
            'winner_count' => 200,
            'liquidity' => 145,
            'description' => 'A quiz about the basics of blockchain technology.',
        ]);

        Quiz::create([
            'creator' => 'gorkem123',
            'title' => 'Smart Contracts',
            'duration' => 120,
            'slug' => Str::slug('Smart Contracts'),
            'winner_count' => 20,
            'liquidity' => 960,
            'description' => 'A quiz focused on smart contracts and their use cases.',
        ]);
    }
}
