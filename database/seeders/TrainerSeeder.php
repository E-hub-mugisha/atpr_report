<?php

namespace Database\Seeders;

use App\Models\Trainer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Trainer::insert([
            ['name' => 'Alice Uwimana', 'email' => 'alice@example.com'],
            ['name' => 'John Niyonzima', 'email' => 'john@example.com'],
            ['name' => 'Grace Mugabo', 'email' => 'grace@example.com'],
        ]);
    }
}
