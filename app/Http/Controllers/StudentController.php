<?php

namespace App\Http\Controllers;

use App\Exports\StudentReportExport;
use App\Models\Module;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::latest()->paginate(10);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'intake_no' => 'required',
            'intake_year' => 'required',
        ]);

        // Get latest student number for that intake/year
        $lastStudent = Student::where('intake_no', $request->intake_no)
            ->where('intake_year', $request->intake_year)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastStudent ? ((int)substr($lastStudent->student_id, -6) + 1) : 1;
        $formattedNumber = str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

        // Generate student ID like ATC/IGAK/01/24/000001
        $student_id = "ATC/IGAK/{$request->intake_no}/{$request->intake_year}/{$formattedNumber}";

        Student::create(array_merge($request->all(), [
            'student_id' => $student_id,
        ]));

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }


    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        $student->update($request->all());

        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return back()->with('success', 'Student deleted successfully!');
    }

    public function viewMarks($id)
    {
        $student = Student::with('marks.module')->findOrFail($id);
        return view('students.marks', compact('student'));
    }

    // Show the report page with student selection
    public function reportPage(Request $request)
    {
        $students = Student::all();
        $selectedStudent = null;
        $modules = [];

        if ($request->has('student_id')) {
            $selectedStudent = Student::find($request->student_id);

            // Get all modules for courses the student is enrolled in
            $modules = Module::with(['lessons' => function($query) use ($selectedStudent) {
                $query->with(['marks' => function($q) use ($selectedStudent) {
                    $q->where('student_id', $selectedStudent->id);
                }]);
            }])->get();
        }

        return view('students.report', compact('students', 'selectedStudent', 'modules'));
    }

    // Generate report (PDF/Excel)
    public function generateReport(Request $request)
    {
        $student = Student::findOrFail($request->student_id);

        $modules = Module::with(['lessons' => function($query) use ($student) {
            $query->with(['marks' => function($q) use ($student) {
                $q->where('student_id', $student->id);
            }]);
        }])->get();

        // Here you can use Laravel Excel or DomPDF to generate report
        // Example: return view('students.report_pdf', compact('student', 'modules'));
    }

    // Generate PDF
    public function generatePdf(Request $request)
    {
        $student = Student::findOrFail($request->student_id);
        $modules = Module::with(['lessons' => function($q) use ($student) {
            $q->with(['marks' => function($m) use ($student) {
                $m->where('student_id', $student->id);
            }]);
        }])->get();

        $pdf = PDF::loadView('students.report_pdf', compact('student', 'modules'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download($student->first_name . '_report.pdf');
    }

    // Generate Excel
    public function generateExcel(Request $request)
    {
        $student = Student::findOrFail($request->student_id);
        return Excel::download(new StudentReportExport($student), $student->first_name . '_report.xlsx');
    }

    // Final report page
    public function finalReportPage()
    {
        return view('students.final_report');
    }
}