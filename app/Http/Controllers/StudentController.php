<?php

namespace App\Http\Controllers;

use App\Exports\StudentReportExport;
use App\Models\Intake;
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
        $intakes = Intake::all();
        return view('students.index', compact('students', 'intakes'));
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('students.student-details', compact('student'));
    }

    /**
     * Store a newly created student.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name'          => 'required|string|max:255',
            'last_name'           => 'required|string|max:255',
            'intake_id'           => 'required',
            'gender'              => 'nullable|string',
            'dob'                 => 'nullable|date',
            'email'               => 'nullable|email',
            'phone'               => 'nullable|string',
            'phone_next_of_kin'   => 'nullable|string',
            'address'             => 'nullable|string',
            'academic_year'       => 'nullable|string',
            'qualification_title' => 'nullable|string',
            'status'              => 'nullable|in:active,inactive',
            'disability'          => 'nullable|boolean',
            'marital_status'      => 'nullable|string',
            'education_level'     => 'nullable|string',
        ]);

        // Load intake to get intake_no + intake_year
        $intake = Intake::findOrFail($request->intake_id);

        // ✅ Get last student for this intake
        $lastStudent = Student::where('intake_id', $request->intake_id)
            ->orderBy('id', 'desc')
            ->first();

        // ✅ Generate Next Number
        $nextNumber = $lastStudent
            ? ((int) substr($lastStudent->student_id, -6) + 1)
            : 1;

        $formattedNumber = str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

        // ✅ Final student number format:
        // ATC/IGAK/01/24/000001
        $student_id = "ATC/IGAK/{$intake->month}/{$intake->year}/{$formattedNumber}";

        // ✅ Create student
        Student::create([
            'student_id'         => $student_id,
            'id_number'          => $request->id_number,
            'first_name'         => $request->first_name,
            'last_name'          => $request->last_name,
            'gender'             => $request->gender,
            'dob'                => $request->dob,
            'email'              => $request->email,
            'phone'              => $request->phone,
            'phone_next_of_kin'  => $request->phone_next_of_kin,
            'address'            => $request->address,
            'academic_year'      => $request->academic_year,
            'qualification_title' => $request->qualification_title,
            'status'             => $request->status,
            'disability'         => $request->disability,
            'marital_status'     => $request->marital_status,
            'education_level'    => $request->education_level,
            'intake_id'          => $request->intake_id,
        ]);

        return redirect()->route('students.index')
            ->with('success', 'Student created successfully.');
    }



    /**
     * Update student details.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'first_name'          => 'required|string|max:255',
            'last_name'           => 'required|string|max:255',
            'intake_id'           => 'required|exists:intakes,id',
        ]);

        // ✅ Student ID should NOT regenerate on update
        $student->update([
            'id_number'          => $request->id_number,
            'first_name'         => $request->first_name,
            'last_name'          => $request->last_name,
            'gender'             => $request->gender,
            'dob'                => $request->dob,
            'email'              => $request->email,
            'phone'              => $request->phone,
            'phone_next_of_kin'  => $request->phone_next_of_kin,
            'address'            => $request->address,
            'academic_year'      => $request->academic_year,
            'qualification_title' => $request->qualification_title,
            'status'             => $request->status,
            'disability'         => $request->disability,
            'marital_status'     => $request->marital_status,
            'education_level'    => $request->education_level,
            'intake_id'          => $request->intake_id,
        ]);

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully!');
    }

    /**
     * Remove the student.
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully!');
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
            $modules = Module::with(['lessons' => function ($query) use ($selectedStudent) {
                $query->with(['marks' => function ($q) use ($selectedStudent) {
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

        $modules = Module::with(['lessons' => function ($query) use ($student) {
            $query->with(['marks' => function ($q) use ($student) {
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
        $modules = Module::with(['lessons' => function ($q) use ($student) {
            $q->with(['marks' => function ($m) use ($student) {
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
