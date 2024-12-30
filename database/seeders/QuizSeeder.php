<?php

namespace Database\Seeders;

use App\Models\Quiz;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        Quiz::create([
            'title' => 'Blockchain Basics',
            'description' => 'A quiz about the basics of blockchain technology.',
        ]);

        Quiz::create([
            'title' => 'Smart Contracts',
            'description' => 'A quiz focused on smart contracts and their use cases.',
        ]);
    }
}
