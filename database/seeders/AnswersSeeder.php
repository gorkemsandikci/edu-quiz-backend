<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnswersSeeder extends Seeder
{
    public function run()
    {
        DB::table('answers')->insert([
            [
                'question_id' => 1,
                'answer_text' => 'Decentralized record-keeping',
                'is_correct' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_id' => 1,
                'answer_text' => 'Social media networking',
                'is_correct' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_id' => 2,
                'answer_text' => 'Self-executing contract with terms directly written into code',
                'is_correct' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
