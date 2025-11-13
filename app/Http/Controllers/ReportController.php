<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Exports\CompetentStudentsExport;
use App\Exports\VerificationExport;
use Maatwebsite\Excel\Facades\Excel;

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
        $intake = $request->intake;

        return Excel::download(new CompetentStudentsExport($intake), 'competent_students.xlsx');
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

    public function export()
    {
        $schoolDetails = [
            "School Name" => "ATPR TC",
            "Sector" => "Transport",
            "Class Teacher" => "SHEMA OLIVIER",
            "District" => "Nyarugenge",
            "No of learners" => 153,
            "Head teacher" => "ACP (Rtd) AHIMANA Anselme",
            "Period" => "21 Oct 2024 - 26 Jan 2025",
            "Duration" => "3 Months"
        ];

        $modules = [
            ["title" => "English for passenger transport", "code" => "CCMEN 302"],
            ["title" => "French for passenger transport", "code" => "CCMFT 302"],
        ];

        $trainees = [
            ["name" => "AKINGENEYE Jean Paul", "portfolio" => "Yes", "scores" => [79.5, 81.5, 70, 85], "decision" => "C"],
            ["name" => "AMERIKA Aphrodis", "portfolio" => "Yes", "scores" => [95, 88, 65.5, 95], "decision" => "C"],
        ];

        $internalVerifier = [
            "name" => "ACP (Rtd) AHIMANA Anselme",
            "position" => "Head ATPR TC",
            "phone" => "0788456099"
        ];

        $externalVerifiers = [
            ["name" => "Verifier A", "institution" => "Institution A", "position" => "Position A", "phone" => "0700000000"],
            ["name" => "Verifier B", "institution" => "Institution B", "position" => "Position B", "phone" => "0700000001"],
        ];

        return Excel::download(
            new VerificationExport($schoolDetails, $modules, $trainees, $internalVerifier, $externalVerifiers),
            'ATPR_verification.xlsx'
        );
    }
}
