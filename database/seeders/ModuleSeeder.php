<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('modules')->insert([
            [
                'id' => 1,
                'title' => 'COMPLEMENTARY MODULES',
                'description' => 'COMPLEMENTARY MODULES',
                'order' => 1,
                'course_id' => 1,
                'module_code' => 'M00001',
                'type' => 'complementary',
                'created_at' => Carbon::parse('2025-11-06 06:10:38'),
                'updated_at' => Carbon::parse('2025-11-06 06:10:38'),
            ],
            [
                'id' => 2,
                'title' => 'GENERAL MODULES',
                'description' => 'GENERAL MODULES',
                'order' => 2,
                'course_id' => 1,
                'module_code' => 'M00002',
                'type' => 'general',
                'created_at' => Carbon::parse('2025-11-06 06:30:11'),
                'updated_at' => Carbon::parse('2025-11-06 06:30:11'),
            ],
            [
                'id' => 3,
                'title' => 'SPECIFIC MODULES',
                'description' => 'SPECIFIC MODULES',
                'order' => 3,
                'course_id' => 1,
                'module_code' => 'M00003',
                'type' => 'specific',
                'created_at' => Carbon::parse('2025-11-06 06:32:40'),
                'updated_at' => Carbon::parse('2025-11-06 06:32:40'),
            ],
        ]);
    }
}
