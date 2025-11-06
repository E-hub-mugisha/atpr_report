<?php

namespace App\Http\Controllers;

use App\Imports\MarksImport;
use App\Models\Lesson;
use App\Models\Mark;
use App\Models\Module;
use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MarkController extends Controller
{
    public function index(Lesson $lesson)
    {
        $marks = Mark::where('lesson_id', $lesson->id)->get();
        $students = Student::all();
        return view('marks.index', compact('lesson', 'marks', 'students'));
    }

    public function store(Request $request, $moduleId, $lessonId)
    {
        $lesson = Lesson::where('id', $lessonId)
            ->where('module_id', $moduleId)
            ->firstOrFail();

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'i_a' => 'nullable|numeric',
            'f_a' => 'nullable|numeric',
            'c_a' => 'nullable|numeric',
            'total' => 'nullable|numeric',
            'reass' => 'nullable|numeric',
            'obs' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        Mark::create([
            'lesson_id' => $lesson->id,  // Must be included
            'student_id' => $request->student_id,
            'i_a' => $request->i_a,
            'f_a' => $request->f_a,
            'c_a' => $request->c_a,
            'total' => $request->total,
            'reass' => $request->reass,
            'obs' => $request->obs,
            'remarks' => $request->remarks,
        ]);

        return redirect()->back()
            ->with('success', 'Mark added successfully.');
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


    public function destroy(Mark $mark)
    {
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
        $lessons = $module->lessons()->with(['marks' => function($q) use ($student) {
            $q->where('student_id', $student->id);
        }])->get();

        return view('marks.student-marks', compact('module', 'student', 'lessons'));
    }
}
