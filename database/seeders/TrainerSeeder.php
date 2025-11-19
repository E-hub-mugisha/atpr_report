<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Trainer;
use App\Models\AcademicQualification;
use App\Models\TrainerTraining;
use App\Models\TrainerExperience;
use App\Models\TrainerSkillRating;

class TrainerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();

        try {
            // 1️⃣ Create Trainer
            $trainer = Trainer::create([
                'first_name'     => 'John',
                'last_name'      => 'Doe',
                'email'          => 'john.doe@example.com',
                'phone'          => '+250780000000',
                'qualification'  => 'Bachelor in Education',
                'bio'            => 'Experienced trainer in transportation management',
                'sex'            => 'Male',
                'civil_status'   => 'Single',
                'dob'            => '1990-01-01',
                'id_or_passport' => 'ID12345678',
                'school_name'    => 'National Transport Institute',
                'province'       => 'Kigali',
                'district'       => 'Nyarugenge',
                'sector'         => 'Muhima',
                'school_level'   => 'polytechnic',
                'school_status'  => 'public',
            ]);

            // 2️⃣ Academic Qualifications
            AcademicQualification::create([
                'trainer_id'         => $trainer->id,
                'qualification_name' => 'Bachelor in Education',
                'institution'        => 'University of Rwanda',
                'date_awarded'       => Carbon::parse('2012-06-15'),
                'level'              => 'Bachelor',
                'verification'       => 1,
            ]);

            // 3️⃣ Trainings
            TrainerTraining::create([
                'trainer_id'  => $trainer->id,
                'type'        => 'Professional',
                'title'       => 'Advanced Transport Safety',
                'provider'    => 'Transport Academy',
                'hours'       => 40,
                'institution' => 'Transport Academy',
                'company'     => 'National Transport Institute',
                'status'      => 'Completed',
                'details'     => 'Training on vehicle safety and passenger management',
                'from_date'   => '2024-01-10',
                'to_date'     => '2024-01-20',
                'evidence'    => true,
            ]);

            // 4️⃣ Experiences
            TrainerExperience::create([
                'trainer_id'         => $trainer->id,
                'type'               => 'work_experience',
                'position'           => 'Transport Trainer',
                'institution'        => 'National Transport Institute',
                'place'              => 'Kigali',
                'status'             => 'Active',
                'sector'             => 'Transport',
                'trade'              => 'Passenger Transport',
                'core_responsibility' => 'Train drivers on safe driving practices',
                'from_date'          => '2015-02-01',
                'to_date'            => '2025-01-01',
                'days'               => 3650,
                'times_assessed'     => 200,
                'sessions_competent' => 150,
                'master_trainer'     => true,
                'evidence'           => true,
            ]);

            // 5️⃣ Language Skills
            TrainerSkillRating::create([
                'trainer_id' => $trainer->id,
                'skill_type' => 'language',
                'skill_name' => 'English',
                'reading'    => 'Advanced',
                'speaking'   => 'Advanced',
                'writing'    => 'Advanced',
                'computer_level' => null,
            ]);

            // 6️⃣ Computer Skills
            TrainerSkillRating::create([
                'trainer_id' => $trainer->id,
                'skill_type' => 'computer',
                'skill_name' => 'Microsoft Office',
                'reading'    => null,
                'speaking'   => null,
                'writing'    => null,
                'computer_level' => 'Intermediate',
            ]);

            DB::commit();
            $this->command->info('Trainer created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Failed to create trainer: '.$e->getMessage());
        }
    }
}
