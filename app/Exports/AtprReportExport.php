<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AtprReportExport implements FromArray, WithStyles, WithEvents
{
    protected array $data;
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        // Build a 2D array for all rows (we’ll merge & style in AfterSheet)
        [$school, $program, $modules, $trainees] = $this->data;

        $rows = [];
        // Table 1 header
        $rows[] = ['SCHOOL DETAILS', 'SHORT COURSE PROGRAM DETAILS', 'CLASS DETAILS'];
        $rows[] = ["School Name : {$school['school_name']}", "Sector: {$program['sector']}", "Class Teacher (in charge): {$program['class_teacher']}"];
        $rows[] = ["Address (District, Sector) : {$school['address']}", "Sub-Sector/Trade: {$program['sub_sector']}", "No of learners: {$program['learners']}"];
        $rows[] = ["Head teacher : {$school['head_teacher']}", "Short course program title: {$program['title']}", "Total Number of Teachers Teaching all modules : {$program['teacher_count']}"];
        $rows[] = ["School status: {$school['status']}", "No of Modules: {$program['modules']}", "Period : {$program['period']}"];
        $rows[] = ["Tel Number : {$school['tel']}", "Duration : {$program['duration']}", ""];
        $rows[] = ["E-mail : {$school['email']}", "", ""];
        $rows[] = ["School & trade(s) accredited: {$school['accredited']}", "", ""];

        $rows[] = ['', '', '']; // blank line

        // Table 2 headers (3 rows)
        $rows[] = ["Trainee's names", 'Availability of portfolio (Yes or No)', 'COMPETENCES TITLE', '', '', '', '', '', '', '', '', 'ASSESSMENT', '', '', 'DECISION (C or NYC)'];
        $rows[] = ['', '', 'Complementary Modules (CCMs)', '', '', 'GENERAL MODULES', '', '', 'SPECIFIC MODULES', '', '', 'Industrial attachment (%)', 'FINAL INTEGRATED ASSESSMENT (%)', 'RESULTS', ''];
        // Module titles row (C..K)
        $row = ['', ''];
        foreach ($modules as [$title, $code]) $row[] = "{$title}\n{$code}";
        // C..K = 9 entries; then L..O empty
        while (count($row) < 11) $row[] = '';
        $row[] = '';
        $row[] = '';
        $row[] = '';
        $row[] = '';
        $rows[] = array_pad($row, 15, '');

        // Data rows
        foreach ($trainees as $t) $rows[] = $t;

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        // basic font/border
        $highest = $sheet->getHighestRow();
        $sheet->getStyle("A1:O{$highest}")->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['wrapText' => true, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        // widths
        $sheet->getColumnDimension('A')->setWidth(28);
        $sheet->getColumnDimension('B')->setWidth(18);
        foreach (range('C', 'K') as $col) $sheet->getColumnDimension($col)->setWidth(18);
        foreach (['L', 'M', 'N'] as $col) $sheet->getColumnDimension($col)->setWidth(16);
        $sheet->getColumnDimension('O')->setWidth(14);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $s = $event->sheet;
                $blue = '4472C4';
                $white = 'FFFFFF';
                $yellow = 'FFD966';
                $lightBlue = 'BDD7EE';

                // Table 1: color header row A1:C1
                $s->getStyle('A1:C1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($blue);
                $s->getStyle('A1:C1')->getFont()->setBold(true)->getColor()->setRGB($white);
                $s->getStyle('A1:C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Table 2 merges
                // Assume table 1 ended at row 8, blank at row 9, table2 starts row 10
                $top = 10;
                $sub = 11;
                $mods = 12;

                // Top header merges
                $s->mergeCells("A{$top}:A" . ($top + 1));
                $s->mergeCells("B{$top}:B" . ($top + 1));
                $s->mergeCells("C{$top}:K{$top}");
                $s->mergeCells("L{$top}:N{$top}");
                $s->mergeCells("O{$top}:O" . ($top + 1));
                // Top header styling
                foreach (['A', 'B', 'C', 'L', 'O'] as $col) {
                    $s->getStyle("{$col}{$top}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($blue);
                    $s->getStyle("{$col}{$top}")->getFont()->setBold(true)->getColor()->setRGB($white);
                    $s->getStyle("{$col}{$top}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }
                $s->getStyle("D{$top}:K{$top}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($blue);
                $s->getStyle("D{$top}:K{$top}")->getFont()->setBold(true)->getColor()->setRGB($white);
                $s->getStyle("D{$top}:K{$top}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $s->getStyle("M{$top}:N{$top}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($blue);
                $s->getStyle("M{$top}:N{$top}")->getFont()->setBold(true)->getColor()->setRGB($white);
                $s->getStyle("M{$top}:N{$top}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Sub headers styling
                $s->mergeCells("C{$sub}:E{$sub}");
                $s->mergeCells("F{$sub}:H{$sub}");
                $s->mergeCells("I{$sub}:K{$sub}");
                $s->getStyle("C{$sub}:N{$sub}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($blue);
                $s->getStyle("C{$sub}:N{$sub}")->getFont()->setBold(true)->getColor()->setRGB($white);
                $s->getStyle("C{$sub}:N{$sub}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Module titles row colors
                // C..E yellow, F..K light blue
                $s->getRowDimension($mods)->setRowHeight(66);
                $s->getStyle("C{$mods}:E{$mods}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($yellow);
                $s->getStyle("F{$mods}:K{$mods}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($lightBlue);
                $s->getStyle("C{$mods}:K{$mods}")->getFont()->setBold(true);
                $s->getStyle("C{$mods}:K{$mods}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
        ];
    }
}
