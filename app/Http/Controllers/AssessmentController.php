<?php

namespace App\Http\Controllers;

use App\Models\TraineeReport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AssessmentController extends Controller
{
    public function index()
    {
        $reports = TraineeReport::all();
        return view('reports.index', compact('reports'));
    }

    public function showForm()
    {
        return view('upload');
    }

    public function uploadExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls'
        ]);

        $file = $request->file('excel_file');

        // Read directly from the uploaded file
        $data = Excel::toArray([], $file);

        $sheet = $data[0];

        $traineeName = $sheet[3][1] ?? null;
        $qualification = $sheet[4][1] ?? null;
        $courseDuration = $sheet[5][1] ?? null;
        $intakeYear = $sheet[6][1] ?? null;
        $traineeCode = $sheet[7][1] ?? null;

        $modules = [];
        foreach ($sheet as $row) {
            if (isset($row[0]) && preg_match('/^[A-Z]{4}\d{3}$/', $row[0])) {
                $modules[] = [
                    'code' => $row[0],
                    'title' => $row[1],
                    'score' => $row[2],
                    'remark' => $row[3],
                ];
            }
        }

        return view('results', compact('traineeName', 'qualification', 'courseDuration', 'intakeYear', 'traineeCode', 'modules'));
    }

    public function uploadForm()
    {
        return view('reports.upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();

        // 🎯 Extract data from specific cells
        $data = [
            'trainee_name' => $sheet->getCell('I7')->getValue(),        // Example: Trainee Name
            'reg_no' => $sheet->getCell('G9')->getValue(),             // Reg No
            'academic_year' => $sheet->getCell('F4')->getValue(),      // Academic Year
            'class' => $sheet->getCell('G5')->getValue(),              // Class
            'course_duration' => $sheet->getCell('G6')->getValue(),    // Course Duration
            'qualification_title' => $sheet->getCell('C3')->getValue(),// Qualification Title
            'english' => $sheet->getCell('F20')->getValue(),
            'francais' => $sheet->getCell('F21')->getValue(),
            'swahili' => $sheet->getCell('F22')->getValue(),
            'total_marks' => $sheet->getCell('F45')->getValue(),
            'percentage' => $sheet->getCell('G46')->getValue(),
            'decision' => $sheet->getCell('G47')->getValue(),
        ];

        // 💾 Save extracted data
        TraineeReport::create($data);

        return redirect()->route('reports.index')->with('success', 'Data extracted and saved successfully!');
    }
}
