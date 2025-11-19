<?php

namespace App\Http\Controllers;

use App\Imports\MarksImport;
use App\Models\Lesson;
use App\Models\Mark;
use App\Models\Module;
use App\Models\Student;
use App\Models\Trainer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MarkController extends Controller
{
    public function index()
    {
        // Get all modules with their lessons
        $modules = Module::with('lessons')->orderBy('order')->get();

        // Get all students with their marks
        $students = Student::with('marks')->get();

        // Compute totals, percentage, decision etc
        foreach ($students as $student) {
            $totalMarks = 0;
            $maxMarks = 0;
            foreach ($modules as $module) {
                foreach ($module->lessons as $lesson) {
                    $mark = $student->marks->firstWhere('lesson_id', $lesson->id);
                    $score = $mark->total ?? 0;
                    $totalMarks += $score;
                    $maxMarks += 100; // assuming each lesson total = 100, adjust if different
                }
            }
            $student->total = $totalMarks;
            $student->percentage = $maxMarks > 0 ? round($totalMarks / $maxMarks * 100, 2) : 0;

            // Auto decision
            if ($student->percentage >= 50) {
                $student->decision = 'C'; // Competent
                $student->remarks = 'Passed';
                $student->observation = 'Satisfactory performance';
            } else {
                $student->decision = 'NYC'; // Not yet competent
                $student->remarks = 'Failed';
                $student->observation = 'Needs improvement';
            }
        }

        return view('marks.index', compact('modules', 'students'));
    }


    public function store(Request $request, $moduleId, $lessonId)
    {
        // 1️⃣ Retrieve the lesson and ensure it belongs to the correct module
        $lesson = Lesson::where('id', $lessonId)
            ->where('module_id', $moduleId)
            ->firstOrFail();

        // 2️⃣ Validate input
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'i_a' => 'nullable|numeric|min:0',
            'f_a' => 'nullable|numeric|min:0',
            'c_a' => 'nullable|numeric|min:0',
            'reass' => 'nullable|numeric|min:0',
        ]);

        // 3️⃣ Handle null values and ensure numeric sums
        $i_a = $request->i_a ?? 0;
        $f_a = $request->f_a ?? 0;
        $c_a = $request->c_a ?? 0;
        $reass = $request->reass ?? 0;
        $total = $i_a + $f_a + $c_a;

        // ---------------------------
        //  AUTO-GENERATE OBSERVATION
        // ---------------------------
        if ($total >= 80) {
            $obs = "Excellent Performance";
        } elseif ($total >= 60) {
            $obs = "Good Performance";
        } elseif ($total >= 40) {
            $obs = "Satisfactory";
        } else {
            $obs = "Improvement Needed";
        }

        // ---------------------------
        //  AUTO-GENERATE REMARKS
        // ---------------------------
        if ($total >= 80) {
            $remarks = "Distinction";
        } elseif ($total >= 50) {
            $remarks = "Pass";
        } else {
            $remarks = "Fail";
        }

        // ---------------------------
        //  AUTO DECISION (C / NYC)
        // ---------------------------
        $decision = $total >= 50 ? "C" : "NYC";

        // ---------------------------
        //  AUTO REASSESSMENT FLAG
        // ---------------------------

        if ($total >= 50) {
            $reassessment_needed = 0; // true if not yet competent
        } else {
            $reassessment_needed = 1;
        }

        // 5️⃣ Create mark
        Mark::create([
            'lesson_id' => $lesson->id,
            'student_id' => $request->student_id,
            'i_a' => $i_a,
            'f_a' => $f_a,
            'c_a' => $c_a,
            'total' => $total,
            'reass' => $reass,
            'obs'                 => $obs,
            'remarks'             => $remarks,
            'decision'            => $decision,
            'reassessment_needed' => $reassessment_needed,
        ]);

        return redirect()->back()
            ->with('success', 'Mark added successfully.');
    }


    public function storeComplementary(Request $request, $moduleId, $lessonId)
    {
        $lesson = Lesson::where('id', $lessonId)
            ->where('module_id', $moduleId)
            ->firstOrFail();

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'f_a' => 'nullable|numeric|min:0',
            'c_a' => 'nullable|numeric|min:0',
            'reass' => 'nullable|numeric|min:0',
        ]);

        $trainer = Trainer::first(); // safer than all()->first()
        if (!$trainer) {
            return redirect()->back()->with('error', 'No trainer found! Seed trainers first.');
        }

        $total = ($request->c_a ?? 0) + ($request->f_a ?? 0);

        // ---------------------------
        //  AUTO-GENERATE OBSERVATION
        // ---------------------------
        if ($total >= 80) {
            $obs = "Excellent Performance";
        } elseif ($total >= 60) {
            $obs = "Good Performance";
        } elseif ($total >= 40) {
            $obs = "Satisfactory";
        } else {
            $obs = "Improvement Needed";
        }

        // ---------------------------
        //  AUTO-GENERATE REMARKS
        // ---------------------------
        if ($total >= 80) {
            $remarks = "Distinction";
        } elseif ($total >= 50) {
            $remarks = "Pass";
        } else {
            $remarks = "Fail";
        }

        // ---------------------------
        //  AUTO DECISION (C / NYC)
        // ---------------------------
        $decision = $total >= 50 ? "C" : "NYC";

        // ---------------------------
        //  AUTO REASSESSMENT FLAG
        // ---------------------------
        if ($total >= 50) {
            $reassessment_needed = 0; // true if not yet competent
        } else {
            $reassessment_needed = 1;
        }

        Mark::create([
            'lesson_id'           => $lesson->id,
            'student_id'          => $request->student_id,
            'trainer_id'          => $trainer->id,
            'f_a'                 => $request->f_a,
            'c_a'                 => $request->c_a,
            'total'               => $total,
            'reass'               => $request->reass,
            'obs'                 => $obs,
            'remarks'             => $remarks,
            'decision'            => $decision,
            'reassessment_needed' => $reassessment_needed, // store or display
        ]);

        return back()->with('success', 'Mark added successfully.');
    }


    public function import(Request $request, Lesson $lesson)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls'
        ]);

        Excel::import(new MarksImport($lesson), $request->file('excel_file'));

        return back()->with('success', 'Marks imported successfully.');
    }

    public function export($lessonId)
    {
        $lesson = Lesson::with('marks')->findOrFail($lessonId);
        $marks = $lesson->marks ?? collect();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header row
        $sheet->setCellValue('A1', 'Trainee');
        $sheet->setCellValue('B1', 'IA');
        $sheet->setCellValue('C1', 'FA');
        $sheet->setCellValue('D1', 'CA');
        $sheet->setCellValue('E1', 'Total');
        $sheet->setCellValue('F1', 'Reass');
        $sheet->setCellValue('G1', 'Obs');
        $sheet->setCellValue('H1', 'Remarks');
        $sheet->setCellValue('I1', 'Updated At');

        // Fill data
        $row = 2;
        foreach ($marks as $mark) {
            $sheet->setCellValue('A' . $row, $mark->trainee);
            $sheet->setCellValue('B' . $row, $mark->i_a);
            $sheet->setCellValue('C' . $row, $mark->f_a);
            $sheet->setCellValue('D' . $row, $mark->c_a);
            $sheet->setCellValue('E' . $row, $mark->total);
            $sheet->setCellValue('F' . $row, $mark->reass);
            $sheet->setCellValue('G' . $row, $mark->obs);
            $sheet->setCellValue('H' . $row, $mark->remarks);
            $sheet->setCellValue('I' . $row, optional($mark->updated_at)->format('Y-m-d H:i'));
            $row++;
        }

        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->getStyle('A1:I1')->getFont()->setBold(true);

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Marks_' . $lesson->title . '.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName);
    }

    public function update(Request $request, $moduleId, $lessonId, $markId)
    {
        $lesson = Lesson::where('id', $lessonId)
            ->where('module_id', $moduleId)
            ->firstOrFail();

        $mark = Mark::where('id', $markId)
            ->where('lesson_id', $lesson->id)
            ->firstOrFail();

        $mark->update($request->only(['i_a', 'f_a', 'c_a', 'total', 'reass', 'obs', 'remarks']));

        return back()->with('success', 'Mark updated successfully');
    }


    public function destroy($id)
    {
        $mark = Mark::findOrFail($id);
        $mark->delete();
        return back()->with('success', 'Mark deleted successfully.');
    }

    // Show the form to select student
    public function studentMarksForm(Module $module)
    {
        $students = Student::all(); // or filter by module if needed
        return view('marks.student-marks-form', compact('module', 'students'));
    }

    // Show marks for selected student in all lessons of the module
    public function showStudentMarks(Module $module, Student $student)
    {
        // Load all lessons in this module
        $lessons = $module->lessons()->with(['marks' => function ($q) use ($student) {
            $q->where('student_id', $student->id);
        }])->get();

        return view('marks.student-marks', compact('module', 'student', 'lessons'));
    }

    public function deleteAll($moduleId, $lessonId)
    {
        $lessonMarks = Mark::where('lesson_id', $lessonId)->get();

        if ($lessonMarks->count() > 0) {
            Mark::where('lesson_id', $lessonId)->delete();
            return redirect()->back()->with('success', 'All marks for this lesson have been deleted successfully.');
        }

        return redirect()->back()->with('error', 'No marks found to delete.');
    }
}
