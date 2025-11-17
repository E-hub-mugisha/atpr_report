<?php

namespace App\Http\Controllers;

use App\Exports\AtprReportExport;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Exports\CompetentStudentsExport;
use App\Exports\FinalReportExport;
use App\Exports\StudentInfoReport;
use App\Exports\VerificationReport;
use App\Models\Intake;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ReportController extends Controller
{
    //
    public function index()
    {
        $intakes = Intake::all();
        return view('reports.rtb', compact('intakes'));
    }

    // public function competent(Request $request)
    // {
    //     $intake = $request->intake;

    //     return Excel::download(new CompetentStudentsExport($intake), 'competent_students.xlsx');
    // }

    public function competent()
    {
        $intakeId = request('intake_id');

        return Excel::download(
            new FinalReportExport($intakeId),
            'Competent_Students_' . $intakeId . '.xlsx'
        );
    }


    public function studentsInfo()
    {
        $intakeId = request('intake_id');

        return Excel::download(new StudentInfoReport($intakeId), 'Students_info_' . $intakeId . '.xlsx');
    }

    public function verification()
    {
        $intakeId = request('intake_id');

        return Excel::download(
            new VerificationReport($intakeId),
            'verification_' . $intakeId . '.xlsx'
        );
    }


    public function export()
    {
        // --------- Replace with your own data sources / Eloquent queries ----------
        $school = [
            'school_name'   => 'ASSOCIATION DES TRANSPORTEURS DES PERSONNES AU RWANDA (ATPR TC)',
            'address'       => 'District: Nyarugenge, Sector: Muhima',
            'head_teacher'  => 'ACP (Rtd) AHIMANA Anselme',
            'status'        => 'PRIVATE',
            'tel'           => '0788456099',
            'email'         => 'aahimana@yahoo.fr',
            'accredited'    => 'Yes',
        ];
        $program = [
            'sector'        => 'TRANSPORT&LOGISTICS',
            'sub_sector'    => 'INOZAMWUGA MU GUTWARA ABANTU MU BURYO BWA RUSANGE',
            'title'         => 'IBT',
            'modules'       => '9.0',
            'duration'      => 'Three Months',
            'period'        => 'From 21 October 2024 to 26 January 2025',
            'teacher_count' => '6',
            'learners'      => '153',
            'class_teacher' => 'SHEMA OLIVIER',
        ];
        $modules = [
            ["Gukoresha indimi z’ibanze mu gutwara abantu - English",  "CCMEN 302"],
            ["Gukoresha indimi z’ibanze mu gutwara abantu - Français", "CCMFT 302"],
            ["Gukoresha indimi z’ibanze mu gutwara abantu - Swahili",  "CCMKK 302"],
            ["Kubasha kwizigamira no kwiteza imbere",                  "CCMBE 001"],
            ["Kubungabunga ibidukikije, ibimenyetso by'amateka n'ahantu nyaburanga", "CCMHE 001"],
            ["Kugira indangagaciro, uburere mboneragihugu n'ikinyabupfura mu mwuga wo gutwara abantu", "CCMCE 001"],
            ["Kubungabunga ubuzima n'umutekano by'abagenzi",           "DRVHS 001"],
            ["Kwita ku burenganzira n'inshingano bya shoferi n'abagenzi", "DRVPD 001"],
            ["Gukora ibikenewe by'ibanze ku modoka zitwara abantu",    "DRVVM 001"],
        ];
        $trainees = [
            ['AKINGENEYE Jean Paul', 'Yes', 79.5, 81.5, 70.0, 85, 68, 52.5, 72.9, 75.0, 88.9, 'N/A', 'N/A', '', 'C'],
            ['AMERIKA Aphrodis',     'Yes', 95.0, 88.0, 65.5, 95, 55, 80.0, 73.0, 75.0, 90.0, 'N/A', 'N/A', '', 'C'],
        ];
        // --------------------------------------------------------------------------

        $wb = new Spreadsheet();
        $ws = $wb->getActiveSheet();
        $ws->setTitle('Report');

        // Colors & styles
        $blue      = '4472C4';
        $white     = 'FFFFFF';
        $yellow    = 'FFD966';
        $lightBlue = 'BDD7EE';

        $borderAll = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];
        $center = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrapText'   => true
            ]
        ];
        $left = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical'   => Alignment::VERTICAL_TOP,
                'wrapText'   => true
            ]
        ];
        $headFill = [
            'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => $blue]],
            'font' => ['bold' => true, 'color' => ['rgb' => $white]],
        ];

        // ---------------- Table 1: School / Program / Class ----------------
        $r = 1;
        $ws->setCellValue("A{$r}", 'SCHOOL DETAILS');
        $ws->setCellValue("B{$r}", 'SHORT COURSE PROGRAM DETAILS');
        $ws->setCellValue("C{$r}", 'CLASS DETAILS');
        foreach (['A', 'B', 'C'] as $col) {
            $ws->getStyle("{$col}{$r}")->applyFromArray($headFill)
                ->applyFromArray($borderAll)
                ->applyFromArray($center);
        }

        $rowsT1 = [
            ["School Name :", $school['school_name'], "Class Teacher (in charge): {$program['class_teacher']}"],
            ["Address (District, Sector) :", $school['address'], "No of learners: {$program['learners']}"],
            ["Head teacher :", $school['head_teacher'], "Total Number of Teachers Teaching all modules : {$program['teacher_count']}"],
            ["School status:", $school['status'], "Period : {$program['period']}"],
            ["Tel Number :", $school['tel'], "Duration : {$program['duration']}"],
            ["E-mail :", $school['email'], ""],
            ["School & trade(s) accredited:", $school['accredited'], ""],
        ];

        foreach ($rowsT1 as $rowT1) {
            $r++;
            $ws->setCellValue("A{$r}", "{$rowT1[0]} {$rowT1[1]}");
            $ws->setCellValue("B{$r}", ""); // will fill below
            $ws->setCellValue("C{$r}", $rowT1[2]);
            foreach (['A', 'B', 'C'] as $col) {
                $ws->getStyle("{$col}{$r}")->applyFromArray($left)->applyFromArray($borderAll);
            }
        }

        // Fill B2..B5 details
        $ws->setCellValue('B2', 'Sector: ' . $program['sector']);
        $ws->setCellValue('B3', 'Sub-Sector/Trade: ' . $program['sub_sector']);
        $ws->setCellValue('B4', 'Short course program title: ' . $program['title']);
        $ws->setCellValue('B5', 'No of Modules: ' . $program['modules']);
        foreach ([2, 3, 4, 5] as $rx) {
            $ws->getStyle("B{$rx}")->applyFromArray($left)->applyFromArray($borderAll);
        }

        // Column widths
        $ws->getColumnDimension('A')->setWidth(45);
        $ws->getColumnDimension('B')->setWidth(45);
        $ws->getColumnDimension('C')->setWidth(40);

        // Blank row then Table 2
        $r += 2;
        $top  = $r;        // top header
        $sub  = $r + 1;    // sub header
        $mods = $r + 2;    // module titles row

        // ---------------- Table 2: Competences & Assessment ----------------
        // Top header with merges
        $ws->setCellValue("A{$top}", "Trainee's names");
        $ws->mergeCells("A{$top}:A" . ($top + 1));

        $ws->setCellValue("B{$top}", "Availability of portfolio (Yes or No)");
        $ws->mergeCells("B{$top}:B" . ($top + 1));

        $ws->setCellValue("C{$top}", "COMPETENCES TITLE");
        $ws->mergeCells("C{$top}:K{$top}");

        $ws->setCellValue("L{$top}", "ASSESSMENT");
        $ws->mergeCells("L{$top}:N{$top}");

        $ws->setCellValue("O{$top}", "DECISION (C or NYC)");
        $ws->mergeCells("O{$top}:O" . ($top + 1));

        foreach (range('A', 'O') as $col) {
            $ws->getStyle("{$col}{$top}")->applyFromArray($headFill)
                ->applyFromArray($borderAll)
                ->applyFromArray($center);
        }

        // Sub headers
        $ws->setCellValue("C{$sub}", "Complementary Modules (CCMs)");
        $ws->mergeCells("C{$sub}:E{$sub}");

        $ws->setCellValue("F{$sub}", "GENERAL MODULES");
        $ws->mergeCells("F{$sub}:H{$sub}");

        $ws->setCellValue("I{$sub}", "SPECIFIC MODULES");
        $ws->mergeCells("I{$sub}:K{$sub}");

        $ws->setCellValue("L{$sub}", "Industrial attachment (%)");
        $ws->setCellValue("M{$sub}", "FINAL INTEGRATED ASSESSMENT (%)");
        $ws->setCellValue("N{$sub}", "RESULTS");

        $ws->getStyle("C{$sub}:N{$sub}")->applyFromArray($headFill)
            ->applyFromArray($borderAll)
            ->applyFromArray($center);

        // Module titles (C..K), first 3 yellow, others light blue
        foreach (['A', 'B'] as $col) {
            $ws->setCellValue("{$col}{$mods}", '');
            $ws->getStyle("{$col}{$mods}")->applyFromArray($borderAll);
        }
        $cols = ['C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'];
        foreach ($modules as $i => [$title, $code]) {
            $col = $cols[$i];
            $ws->setCellValue("{$col}{$mods}", "{$title}\n{$code}");
            $ws->getStyle("{$col}{$mods}")
                ->applyFromArray(['font' => ['bold' => true]])
                ->applyFromArray($borderAll);
            $ws->getStyle("{$col}{$mods}")
                ->getAlignment()->setWrapText(true)->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $fillColor = $i <= 2 ? $yellow : $lightBlue;
            $ws->getStyle("{$col}{$mods}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($fillColor);
        }
        foreach (['L', 'M', 'N', 'O'] as $col) {
            $ws->setCellValue("{$col}{$mods}", '');
            $ws->getStyle("{$col}{$mods}")->applyFromArray($borderAll);
        }

        // Data rows
        $rData = $mods + 1;
        foreach ($trainees as $rowVals) {
            $col = 'A';
            foreach ($rowVals as $val) {
                $ws->setCellValue("{$col}{$rData}", $val);
                $ws->getStyle("{$col}{$rData}")->applyFromArray($borderAll);
                if ($col === 'A') {
                    $ws->getStyle("{$col}{$rData}")
                        ->applyFromArray(['font' => ['bold' => true]])
                        ->applyFromArray($left);
                } elseif (in_array($col, ['A', 'B'])) {
                    $ws->getStyle("{$col}{$rData}")->applyFromArray($left);
                } else {
                    $ws->getStyle("{$col}{$rData}")->applyFromArray($center);
                }
                $col = chr(ord($col) + 1);
            }
            $rData++;
        }

        // Column widths + module row height
        $ws->getColumnDimension('A')->setWidth(28);
        $ws->getColumnDimension('B')->setWidth(18);
        foreach (['C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'] as $c) {
            $ws->getColumnDimension($c)->setWidth(18);
        }
        foreach (['L', 'M', 'N'] as $c) {
            $ws->getColumnDimension($c)->setWidth(16);
        }
        $ws->getColumnDimension('O')->setWidth(14);
        $ws->getRowDimension($mods)->setRowHeight(66);

        // ---------------- Observations + Verifiers ----------------
        $endCol = 'O';

        // 1) Observation
        $row = $ws->getHighestRow() + 2;
        $ws->mergeCells("A{$row}:{$endCol}{$row}");
        $ws->setCellValue("A{$row}", 'Observation from external verifiers:');
        $ws->getStyle("A{$row}")->applyFromArray([
            'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'D9D9D9']],
            'font' => ['bold' => true],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);

        $row++;
        $ws->mergeCells("A{$row}:{$endCol}{$row}");
        $ws->setCellValue("A{$row}", 'The total number of trainees is 153. Out of these, 148 are competent and eligible for certification');
        $ws->getStyle("A{$row}")->applyFromArray([
            'alignment' => ['wrapText' => true, 'vertical' => Alignment::VERTICAL_TOP],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);

        // 2) Internal verifier
        $row += 2;
        $ws->mergeCells("A{$row}:E{$row}");
        $ws->setCellValue("A{$row}", 'Internal verifier');
        $ws->getStyle("A{$row}:E{$row}")->applyFromArray([
            'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => $blue]],
            'font' => ['bold' => true, 'color' => ['rgb' => $white]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        $row++;
        $headers = ['No', 'Names', 'Position', 'Phone', 'Signature'];
        foreach ($headers as $i => $h) {
            $col = chr(ord('A') + $i);
            $ws->setCellValue($col . $row, $h);
            $ws->getStyle($col . $row)->applyFromArray([
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'D9D9D9']],
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ]);
        }

        $row++;
        $data = ['*', 'ACP (Rtd) AHIMANA Anselme', 'Head ATPR TC', '0788456099', ''];
        foreach ($data as $i => $v) {
            $col = chr(ord('A') + $i);
            $ws->setCellValue($col . $row, $v);
            $ws->getStyle($col . $row)->applyFromArray([
                'alignment' => ['wrapText' => true],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ]);
        }

        // 3) External verifiers
        $row += 2;
        $ws->mergeCells("A{$row}:F{$row}");
        $ws->setCellValue("A{$row}", 'EXTERNAL VERIFIERS:');
        $ws->getStyle("A{$row}:F{$row}")->applyFromArray([
            'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => $blue]],
            'font' => ['bold' => true, 'color' => ['rgb' => $white]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        $row++;
        $headers2 = ['No', 'Verifier’s name', 'Institution', 'Position', 'Phone', 'Signature'];
        foreach ($headers2 as $i => $h) {
            $col = chr(ord('A') + $i);
            $ws->setCellValue($col . $row, $h);
            $ws->getStyle($col . $row)->applyFromArray([
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'D9D9D9']],
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ]);
        }

        $extRows = [
            [1, 'MINANI Callixte', 'RTB', 'Transport and Logistics Sector Specialist', '0788265200', ''],
            [2, 'RENZAHO Jean Damascene', 'RTB', 'Youth Empowerment and Employment Promotion Specialist', '0788619071', ''],
            [3, 'UWAMBAYE Rose', 'RTB', 'Administrative assistant to SPIU coordinator', '0788402090', ''],
        ];
        foreach ($extRows as $vals) {
            $row++;
            foreach ($vals as $i => $v) {
                $col = chr(ord('A') + $i);
                $ws->setCellValue($col . $row, $v);
                $ws->getStyle($col . $row)->applyFromArray([
                    'alignment' => ['wrapText' => true],
                    'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ]);
            }
        }

        // ---- Stream to browser (no temp files)
        $writer = new Xlsx($wb);
        $fileName = 'ATPR_Training_Report.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
