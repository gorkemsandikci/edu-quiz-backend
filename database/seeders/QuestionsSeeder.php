<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionsSeeder extends Seeder
{
    public function run()
    {
        DB::table('questions')->insert([
            [
                'quiz_id' => '1',
                'question_text' => 'What is the primary purpose of blockchain technology?',
                'question_type' => 'multiple_choice',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'quiz_id' => '1',
                'question_text' => 'What is the primary purpose of blockchain technology?',
                'question_type' => 'multiple_choice',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'quiz_id' => '2',
                'question_text' => 'What is the primary purpose of blockchain technology?',
                'question_type' => 'multiple_choice',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'quiz_id' => '2',
                'question_text' => 'What is a smart contract?',
                'question_type' => 'multiple_choice',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
