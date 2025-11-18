<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Intake;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $intakes = Intake::all();

        if ($intakes->isEmpty()) {
            $this->command->info('No intakes found. Please seed intakes first!');
            return;
        }

        // Rwandan first and last names
        $firstNames = ['Eric', 'Jean', 'Alice', 'Claude', 'Marie', 'Patrick', 'Sandrine', 'Emmanuel', 'Jeanne', 'Fabrice'];
        $lastNames  = ['Uwimana', 'Niyonzima', 'Munyaneza', 'Mukamana', 'Habimana', 'Ishimwe', 'Uwase', 'Bizimana', 'Uwitonze', 'Ndikumana'];

        foreach ($intakes as $intake) {

            // Find last student number for this intake
            $lastStudent = Student::where('intake_id', $intake->id)
                ->orderBy('id', 'desc')
                ->first();
            $startNumber = $lastStudent
                ? ((int) substr($lastStudent->student_id, -6) + 1)
                : 1;

            for ($i = 0; $i < 10; $i++) {
                $number = $startNumber + $i;
                $formattedNumber = str_pad($number, 6, '0', STR_PAD_LEFT);
                $student_id = "ATC/IGAK/{$intake->month}/{$intake->year}/{$formattedNumber}";

                $firstName = $faker->randomElement($firstNames);
                $lastName  = $faker->randomElement($lastNames);

                Student::create([
                    'student_id'         => $student_id,
                    'id_number'          => $faker->unique()->numerify('########'),
                    'first_name'         => $firstName,
                    'last_name'          => $lastName,
                    'gender'             => $faker->randomElement(['Male', 'Female']),
                    'dob'                => $faker->date('Y-m-d', '2005-01-01'),
                    'email'              => strtolower($firstName . '.' . $lastName . '@example.com'),
                    'phone'              => $faker->phoneNumber,
                    'phone_next_of_kin'  => '0782390929',
                    'address'            => $faker->address,
                    'academic_year'      => $faker->year,
                    'qualification_title'=> $faker->randomElement(['Diploma', 'Certificate', 'Degree']),
                    'status'             => $faker->randomElement(['active', 'inactive']),
                    'disability'         => $faker->boolean,
                    'marital_status'     => $faker->randomElement(['Single', 'Married']),
                    'education_level'    => $faker->randomElement(['Secondary', 'A-Level', 'Undergraduate']),
                    'intake_id'          => $intake->id,
                ]);
            }
        }

        $this->command->info('✅ 10 students per intake created successfully!');
    }
}
