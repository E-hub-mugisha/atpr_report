<?php

namespace App\Exports;

use App\Models\Intake;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class FinalReportExport implements FromView, WithStyles, WithColumnWidths, ShouldAutoSize
{
    public $intake;

    public function __construct($intake)
    {
        $this->intake = $intake;
    }

    public function view(): View
    {
        return view('reports.final_report', [
            'students' => Student::where('intake_id', $this->intake)->get(),
            'competences' => Lesson::all(),
            'intake' => Intake::find($this->intake),
            'trainerName' => "SHEMA Olivier",
        ]);
    }

    /** COLUMN WIDTHS */
    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 30,
            'C' => 35,
            'D' => 28,
            'E' => 10,
            'F' => 28,
            'G' => 12,
            'H' => 12,
            'I' => 12,
        ];
    }

    /** BASIC STYLES */
    public function styles(Worksheet $sheet)
    {
        return [
            // Header row styling
            2 => [
                'font' => ['bold' => true, 'size' => 12],
                'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                // 1) Strong border for header info (A1:A5 or more depending on rows)
                $event->sheet->getStyle('A1:A5')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // 2) Strong border for main table (adjust rows as needed)
                $event->sheet->getStyle('A7:I200')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // 3) Competences table
                $event->sheet->getStyle('A202:C300')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // 4) Footer signatures
                $event->sheet->getStyle('A305:C305')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            }
        ];
    }
}
