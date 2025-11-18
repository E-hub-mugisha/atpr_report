<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition()
    {
        // Rwandan first and last names
        $rwandanFirstNames = [
            'Eric', 'Jean', 'Alice', 'Claude', 'Marie', 'Patrick', 'Sandrine', 'Emmanuel', 'Jeanne', 'Fabrice',
        ];

        $rwandanLastNames = [
            'Uwimana', 'Niyonzima', 'Munyaneza', 'Mukamana', 'Habimana', 'Ishimwe', 'Uwase', 'Bizimana', 'Uwitonze', 'Ndikumana',
        ];

        $firstName = $this->faker->randomElement($rwandanFirstNames);
        $lastName  = $this->faker->randomElement($rwandanLastNames);

        return [
            'id_number'          => $this->faker->unique()->numerify('########'),
            'first_name'         => $firstName,
            'last_name'          => $lastName,
            'gender'             => $this->faker->randomElement(['Male', 'Female']),
            'dob'                => $this->faker->date('Y-m-d', '2005-01-01'),
            'email'              => strtolower($firstName.'.'.$lastName.'@example.com'),
            'phone'              => $this->faker->phoneNumber,
            'phone_next_of_kin'  => '0782390929',
            'address'            => $this->faker->address,
            'academic_year'      => $this->faker->year,
            'qualification_title'=> $this->faker->randomElement(['Diploma', 'Certificate', 'Degree']),
            'status'             => $this->faker->randomElement(['active', 'inactive']),
            'disability'         => $this->faker->boolean,
            'marital_status'     => $this->faker->randomElement(['Single', 'Married']),
            'education_level'    => $this->faker->randomElement(['Secondary', 'A-Level', 'Undergraduate']),
            // 'student_id' and 'intake_id' will be provided by the seeder
        ];
    }
}
