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
                'points' => 10,
                'question_type' => 'multiple_choice',
                'time_limit' => 60,
                'order_number' => 1,
                'created_at' => now(),
            ],
            [
                'quiz_id' => '1',
                'question_text' => 'What is the primary purpose of blockchain technology?',
                'points' => 10,
                'question_type' => 'multiple_choice',
                'time_limit' => 60,
                'order_number' => 1,
                'created_at' => now(),
            ],
            [
                'quiz_id' => '2',
                'question_text' => 'What is the primary purpose of blockchain technology?',
                'points' => 10,
                'question_type' => 'multiple_choice',
                'time_limit' => 60,
                'order_number' => 1,
                'created_at' => now(),
            ],
            [
                'quiz_id' => '2',
                'question_text' => 'What is a smart contract?',
                'points' => 15,
                'question_type' => 'multiple_choice',
                'time_limit' => 45,
                'order_number' => 2,
                'created_at' => now(),
            ]
        ]);
    }
}
