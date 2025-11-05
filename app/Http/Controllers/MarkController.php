<?php

namespace App\Http\Controllers;

use App\Imports\MarksImport;
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
    public function index(Module $module)
    {
        $marks = Mark::where('module_id', $module->id)->get();
        $students = Student::all();
        return view('marks.index', compact('module', 'marks', 'students'));
    }

    public function store(Request $request, Module $module)
    {
        $request->validate([
            'student_id' => 'required',
            'i_a' => 'nullable|integer',
            'f_a' => 'nullable|integer',
            'c_a' => 'nullable|integer',
            'total' => 'nullable|integer',
            'reass' => 'nullable|integer',
            'obs' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        Mark::create([
            'student_id' => $request->student_id,
            'module_id' => $module->id,
            'i_a' => $request->i_a,
            'f_a' => $request->f_a,
            'c_a' => $request->c_a,
            'total' => $request->total,
            'reass' => $request->reass,
            'obs' => $request->obs,
            'remarks' => $request->remarks,
        ]);

        return back()->with('success', 'Mark recorded successfully.');
    }

    public function import(Request $request, Module $module)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls'
        ]);

        Excel::import(new MarksImport($module), $request->file('excel_file'));

        return back()->with('success', 'Marks imported successfully.');
    }

    public function export($moduleId)
    {
        $module = Module::with('marks')->findOrFail($moduleId);
        $marks = $module->marks ?? collect();

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
        $fileName = 'Marks_' . $module->title . '.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName);
    }

    // Add update and destroy methods here
    public function update(Request $request, Module $module, Mark $mark)
    {
        $request->validate([
            'trainee' => 'required|string|max:255',
            'i_a' => 'nullable|integer',
            'f_a' => 'nullable|integer',
            'c_a' => 'nullable|integer',
            'total' => 'nullable|integer',
            'reass' => 'nullable|integer',
            'obs' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $mark->update([
            'trainee' => $request->trainee,
            'i_a' => $request->i_a,
            'f_a' => $request->f_a,
            'c_a' => $request->c_a,
            'total' => $request->total,
            'reass' => $request->reass,
            'obs' => $request->obs,
            'remarks' => $request->remarks,
        ]);

        return back()->with('success', 'Mark updated successfully.');
    }

    public function destroy(Module $module, Mark $mark)
    {
        $mark->delete();
        return back()->with('success', 'Mark deleted successfully.');
    }
}
