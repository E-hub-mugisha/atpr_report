<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\ModuleEvaluation;
use App\Models\Student;
use App\Models\Trainer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ModuleEvaluationController extends Controller
{
    public function index()
    {
        $students = Student::all();
        $modules = Module::all();
        $trainers = Trainer::all();

        return view('evaluations.index', compact('students', 'modules', 'trainers'));
    }

    public function showStudent($studentId)
    {
        $student = Student::findOrFail($studentId);

        // Get all evaluations for this student
        $evaluations = ModuleEvaluation::with('module', 'trainer')
            ->where('student_id', $studentId)
            ->get();

        return view('evaluations.show', compact('trainee', 'evaluations'));
    }


    public function create($studentId)
    {
        return view('evaluations.create', [
            'modules' => Module::all(),
            'trainers' => Trainer::all(),
            'student' => Student::findOrFail($studentId)
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'module_id' => 'required',
            'trainer_id' => 'required',
            'student_id' => 'required',
            'competence' => 'nullable|string',

            'learning_outcomes' => 'array',
            'learning_outcomes.*.description' => 'required|string',
            'learning_outcomes.*.criteria.*.description' => 'required|string',
        ]);

        // Create main evaluation
        $evaluation = ModuleEvaluation::create([
            'module_id' => $request->module_id,
            'trainer_id' => $request->trainer_id,
            'student_id' => $request->student_id,
            'competence' => $request->competence,
            'comments' => $request->comments,
        ]);

        // Save learning outcomes + criteria
        foreach ($request->learning_outcomes as $i => $lo) {

            $outcome = $evaluation->learningOutcomes()->create([
                'order_number' => $i + 1,
                'description' => $lo['description']
            ]);

            foreach ($lo['criteria'] as $j => $crit) {
                $outcome->performanceCriteria()->create([
                    'order_number' => $j + 1,
                    'description' => $crit['description'],
                    'score' => $crit['score'] ?? null,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Evaluation recorded successfully.');
    }

    public function show($id)
    {
        $evaluation = ModuleEvaluation::with([
            'module',
            'student',
            'trainer',
            'learningOutcomes.performanceCriteria'  // eager load nested
        ])->findOrFail($id);

        return view('evaluations.show', compact('evaluation'));
    }

    public function exportPdf($id)
    {
        $evaluation = ModuleEvaluation::with(['module', 'student', 'trainer', 'learningOutcomes'])->findOrFail($id);

        $pdf = Pdf::loadView('evaluations.pdf', compact('evaluation'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('Evaluation_' . $evaluation->id . '.pdf');
    }
}
