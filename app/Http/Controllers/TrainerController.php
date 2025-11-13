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
        // Eager load relationships to reduce queries
        $trainers = Trainer::with([
            'academicQualifications',
            'trainings',
            'experiences',
            'skillRatings'
        ])->orderBy('last_name')->get();

        return view('trainers.index', compact('trainers'));
    }

    public function create()
    {
        return view('trainers.create');
    }
    public function edit($id)
    {
        $trainer = Trainer::findOrFail($id);
        return view('trainers.edit', compact('trainer'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            /**
             * 1️⃣ Create Trainer
             */
            $trainer = Trainer::create([
                'first_name'     => $request->first_name,
                'last_name'      => $request->last_name,
                'email'          => $request->email,
                'phone'          => $request->phone,
                'qualification'  => $request->qualification,
                'bio'            => $request->bio,
                'sex'            => $request->sex,
                'civil_status'   => $request->civil_status,
                'dob'            => $request->dob,
                'id_or_passport' => $request->id_or_passport,
                'school_name'    => $request->school_name,
                'province'       => $request->province,
                'district'       => $request->district,
                'sector'         => $request->sector,
                'school_level'   => $request->school_level,
                'school_status'  => $request->school_status,
            ]);

            /**
             * 2️⃣ Academic Qualifications
             */
            if ($request->has('qualifications')) { // <-- matches Blade input names
                foreach ($request->qualifications as $qual) {

                    // Handle partial dates like "2025-11"
                    $dateAwarded = $qual['date_awarded'] ?? null;
                    if ($dateAwarded && preg_match('/^\d{4}-\d{2}$/', $dateAwarded)) {
                        $dateAwarded .= '-01';
                    }

                    AcademicQualification::create([
                        'trainer_id'         => $trainer->id,
                        'qualification_name' => $qual['qualification_name'] ?? null,
                        'institution'        => $qual['institution'] ?? null,
                        'date_awarded'       => $dateAwarded,
                        'level'              => $qual['level'] ?? null,
                        'verification' => $qual['verification'] ?? 0,
                    ]);
                }
            }


            /**
             * 3️⃣ Trainings
             */
            if ($request->has('trainings')) {
                foreach ($request->trainings as $training) {

                    $fromDate = $training['from_date'] ?? null;
                    $toDate   = $training['to_date'] ?? null;

                    if ($fromDate && preg_match('/^\d{4}-\d{2}$/', $fromDate)) {
                        $fromDate .= '-01';
                    }
                    if ($toDate && preg_match('/^\d{4}-\d{2}$/', $toDate)) {
                        $toDate .= '-01';
                    }

                    TrainerTraining::create([
                        'trainer_id'  => $trainer->id,
                        'type'        => $training['type'] ?? null,
                        'title'       => $training['title'] ?? null,
                        'provider'    => $training['provider'] ?? null,
                        'hours'       => $training['hours'] ?? null,
                        'institution' => $training['institution'] ?? null,
                        'company'     => $training['company'] ?? null,
                        'status'      => $training['status'] ?? null,
                        'details'     => $training['details'] ?? null,
                        'from_date'   => $fromDate,
                        'to_date'     => $toDate,
                        'evidence'    => !empty($training['evidence']),
                    ]);
                }
            }

            /**
             * 4️⃣ Experiences
             */
            if ($request->has('experiences')) {
                foreach ($request->experiences as $exp) {

                    $fromDate = $exp['from_date'] ?? null;
                    $toDate   = $exp['to_date'] ?? null;

                    if ($fromDate && preg_match('/^\d{4}-\d{2}$/', $fromDate)) {
                        $fromDate .= '-01';
                    }
                    if ($toDate && preg_match('/^\d{4}-\d{2}$/', $toDate)) {
                        $toDate .= '-01';
                    }

                    TrainerExperience::create([
                        'trainer_id'         => $trainer->id,
                        'type'               => $exp['type'] ?? 'work_experience',
                        'position'           => $exp['position'] ?? null,
                        'institution'        => $exp['institution'] ?? null,
                        'place'              => $exp['place'] ?? null,
                        'status'             => $exp['status'] ?? null,
                        'sector'             => $exp['sector'] ?? null,
                        'trade'              => $exp['trade'] ?? null,
                        'core_responsibility' => $exp['core_responsibility'] ?? null,
                        'from_date'          => $fromDate,
                        'to_date'            => $toDate,
                        'days'               => $exp['days'] ?? null,
                        'times_assessed'     => $exp['times_assessed'] ?? null,
                        'sessions_competent' => $exp['sessions_competent'] ?? null,
                        'master_trainer'     => $exp['master_trainer'] ?? null,
                        'evidence'           => !empty($exp['evidence']),
                    ]);
                }
            }

            /**
             * 5️⃣ Skill Ratings (Languages + Computer)
             */
            // Save Language Proficiency
            if ($request->filled('languages')) {
                foreach ($request->languages as $lang => $level) {
                    TrainerSkillRating::create([
                        'trainer_id' => $trainer->id,
                        'skill_type' => 'language',
                        'skill_name' => $lang,
                        'reading' => $level,
                        'speaking' => $level,
                        'writing' => $level,
                        'computer_level' => null,
                    ]);
                }
            }

            // Save Computer Skills
            if ($request->filled('computer_skills')) {
                foreach ($request->computer_skills as $skill => $level) {
                    TrainerSkillRating::create([
                        'trainer_id' => $trainer->id,
                        'skill_type' => 'computer',
                        'skill_name' => $skill,
                        'reading' => null,
                        'speaking' => null,
                        'writing' => null,
                        'computer_level' => $level,
                    ]);
                }
            }



            DB::commit();

            return back()->with('success', 'Trainer profile created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
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

    public function show($id)
    {
        $trainer = Trainer::findOrFail($id);
        return view('trainers.show', compact('trainer'));
    }
    public function destroy(Trainer $trainer)
    {
        $trainer->delete();
        return back()->with('success', 'Trainer removed');
    }
}
