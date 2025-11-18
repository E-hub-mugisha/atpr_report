<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\Mark;

class MarksSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();
        $modules = Module::all();

        if ($students->isEmpty() || $modules->isEmpty()) {
            return;
        }

        foreach ($modules as $module) {

            // Get lessons belonging to this module
            $lessons = Lesson::where('module_id', $module->id)->get();

            if ($lessons->isEmpty()) {
                continue;
            }

            foreach ($lessons as $lesson) {

                foreach ($students as $student) {

                    // Avoid duplicates if marks already exist
                    $alreadyMarked = Mark::where('lesson_id', $lesson->id)
                        ->where('student_id', $student->id)
                        ->exists();

                    if ($alreadyMarked) {
                        continue;
                    }

                    // Generate realistic random marks
                    $i_a = rand(5, 20);
                    $f_a = rand(5, 20);
                    $c_a = rand(5, 60);

                    $total = $i_a + $f_a + $c_a;
                    $reass = $total < 50 ? rand(30, 70) : null;

                    Mark::create([
                        'lesson_id' => $lesson->id,
                        'student_id' => $student->id,
                        'trainer_id' => 1,
                        'i_a' => $i_a,
                        'f_a' => $f_a,
                        'c_a' => $c_a,
                        'total' => $total,
                        'reass' => $reass,
                        'obs' => $total < 50 ? 'Needs improvement' : 'Good performance',
                        'remarks' => $total < 50 ? 'Fail' : 'Pass',
                    ]);
                }
            }
        }
    }
}
