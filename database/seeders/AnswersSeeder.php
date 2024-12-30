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
                'question_id' => 1, // 'q1' sorusuyla ilişkili
                'answer_text' => 'Decentralized record-keeping',
                'is_correct' => true,
                'explanation' => 'Blockchain primarily serves as a decentralized ledger system',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_id' => 1, // 'q1' sorusuyla ilişkili
                'answer_text' => 'Social media networking',
                'is_correct' => false,
                'explanation' => 'This is not the main purpose of blockchain',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_id' => 2, // 'q2' sorusuyla ilişkili
                'answer_text' => 'Self-executing contract with terms directly written into code',
                'is_correct' => true,
                'explanation' => 'Smart contracts automatically execute when conditions are met',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
