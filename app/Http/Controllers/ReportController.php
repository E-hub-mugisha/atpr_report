<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
    public function index()
    {
        $intakes = Student::distinct()->pluck('academic_year');
        return view('reports.rtb', compact('intakes'));
    }

    public function competent(Request $request)
    {
        $students = Student::where('academic_year', $request->intake)
            ->where('status', 'Competent')
            ->get();

        return view('reports.competent', compact('students'));
    }

    public function students(Request $request)
    {
        $students = Student::where('academic_year', $request->intake)->get();
        return view('reports.students', compact('students'));
    }

    public function final(Request $request)
    {
        $students = Student::with('marks.module')
            ->where('academic_year', $request->intake)
            ->get();

        return view('reports.final', compact('students'));
    }
}
