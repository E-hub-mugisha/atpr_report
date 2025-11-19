<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use function Symfony\Component\Clock\now;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lessons')->insert([
            [
                'id' => 1,
                'module_id' => 1,
                'title' => 'English',
                'content' => 'English',
                'lesson_code' => 'CCMEN302',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'module_id' => 1,
                'title' => 'Français',
                'content' => 'Français',
                'lesson_code' => 'CCMFT302',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'module_id' => 1,
                'title' => 'Swahili',
                'content' => 'Swahili',
                'lesson_code' => 'CCMKK302',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'module_id' => 2,
                'title' => 'Kubasha kwizigamira no kwiteza imbere',
                'content' => 'Kubasha kwizigamira no kwiteza imbere',
                'lesson_code' => 'CCMBE001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'module_id' => 2,
                'title' => 'Kubungabunga ibidukikije, ibimenyetso by’amateka n’ahantu nyaburanga',
                'content' => 'Kubungabunga ibidukikije, ibimenyetso by’amateka n’ahantu nyaburanga',
                'lesson_code' => 'CCMHE001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'module_id' => 2,
                'title' => 'Kugira indangaciro, uburere mboneragihugu mu mwuga wo gutwara abantu',
                'content' => 'Kugira indangaciro, uburere mboneragihugu mu mwuga wo gutwara abantu',
                'lesson_code' => 'CCMCE001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'module_id' => 3,
                'title' => 'Kubungabunga ubuzima n’umutekano by’abagenzi',
                'content' => 'Kubungabunga ubuzima n’umutekano by’abagenzi',
                'lesson_code' => 'DRVHS001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'module_id' => 3,
                'title' => 'Kwita ku burenganzira n’inshingano bya shoferi n’abagenzi',
                'content' => 'Kwita ku burenganzira n’inshingano bya shoferi n’abagenzi',
                'lesson_code' => 'DRVPD001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'module_id' => 3,
                'title' => 'Gukora ibikenewe by’ibanze ku modoka zitwara abantu',
                'content' => 'Gukora ibikenewe by’ibanze ku modoka zitwara abantu',
                'lesson_code' => 'DRVVM001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
