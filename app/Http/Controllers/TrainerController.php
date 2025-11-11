<?php

namespace App\Http\Controllers;

use App\Models\AcademicQualification;
use App\Models\Trainer;
use App\Models\TrainerExperience;
use App\Models\TrainerSkillRating;
use App\Models\TrainerTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainerController extends Controller
{
    public function index()
    {
        $trainers = Trainer::all();
        return view('trainers.index', compact('trainers'));
    }

    public function create()
    {
        return view('trainers.create');
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            // 1. Insert Trainer Personal Info + School + Manager
            $trainer = Trainer::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'sex' => $request->sex,
                'civil_status' => $request->civil_status,
                'dob' => $request->dob,
                'telephone' => $request->telephone,
                'email' => $request->email,
                'id_or_passport' => $request->id_or_passport,
                // School/Office info
                'school_name' => $request->school_name,
                'province' => $request->province,
                'district' => $request->district,
                'sector' => $request->sector,
                'level' => $request->level,
                'status' => $request->status,
                // Manager info
                'manager_name' => $request->manager_name,
                'manager_phone' => $request->manager_phone,
                'manager_mobile' => $request->manager_mobile,
                'manager_email' => $request->manager_email,
            ]);

            // 2. Insert Academic Qualifications
            if($request->has('qualifications')) {
                foreach($request->qualifications as $qual) {
                    AcademicQualification::create([
                        'trainer_id' => $trainer->id,
                        'course' => $qual['course'] ?? null,
                        'institution' => $qual['institution'] ?? null,
                        'date_awarded' => $qual['date_awarded'] ?? null,
                        'evidence' => $qual['evidence'] ?? null,
                    ]);
                }
            }

            // 3. Insert Trainings
            if($request->has('trainings')) {
                foreach($request->trainings as $training) {
                    TrainerTraining::create([
                        'trainer_id' => $trainer->id,
                        'description' => $training['description'] ?? null,
                        'status' => $training['status'] ?? null,
                        'hours' => $training['hours'] ?? null,
                        'evidence' => $training['evidence'] ?? null,
                    ]);
                }
            }

            // 4. Insert Experiences
            if($request->has('experiences')) {
                foreach($request->experiences as $exp) {
                    TrainerExperience::create([
                        'trainer_id' => $trainer->id,
                        'details' => $exp['details'] ?? null,
                        'duration_core' => $exp['duration_core'] ?? null,
                    ]);
                }
            }

            // 5. Insert Skills / Ratings
            $languages = $request->input('languages', []);
            $computerSkills = $request->input('computer_skills', []);

            if(!empty($languages) || !empty($computerSkills)) {
                foreach($languages as $lang => $level) {
                    TrainerSkillRating::create([
                        'trainer_id' => $trainer->id,
                        'type' => 'language',
                        'skill_name' => $lang,
                        'rating' => $level,
                    ]);
                }

                foreach($computerSkills as $skill => $level) {
                    TrainerSkillRating::create([
                        'trainer_id' => $trainer->id,
                        'type' => 'computer',
                        'skill_name' => $skill,
                        'rating' => $level,
                    ]);
                }
            }
        });

        return back()->with('success', 'Trainer added successfully');
    }

    public function update(Request $request, Trainer $trainer)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'     => 'required|email',
            'phone'     => 'required',
            'qualification' => 'nullable',
            'bio'      => 'nullable'
        ]);

        $trainer->update($request->all());

        return back()->with('success', 'Trainer updated successfully');
    }

    public function destroy(Trainer $trainer)
    {
        $trainer->delete();
        return back()->with('success', 'Trainer removed');
    }
}
