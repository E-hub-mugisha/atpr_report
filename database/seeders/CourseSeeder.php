<?php

namespace Database\Seeders;

use App\Models\Trainer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trainer = Trainer::first(); // safer than all()->first()
        if (!$trainer) {
            $this->command->error('No trainer found! Seed trainers first.');
            return;
        }

        DB::table('courses')->insert([
            'id' => 1,
            'name' => 'INOZAMWUGA MU GUTWARA ABANTU KINYAMWUGA',
            'description' => 'INOZAMWUGA MU GUTWARA ABANTU KINYAMWUGA',
            'duration' => 14,
            'trainer_id' => $trainer->id, // use the real trainer id
            'course_code' => 'C00001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
