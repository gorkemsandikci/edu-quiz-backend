<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'password' => '',
            'ethereum_address' => '0xYourEthereumAddressHere',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $this->call([
            QuizSeeder::class,
            QuestionsSeeder::class,
            AnswersSeeder::class,
        ]);
    }
}