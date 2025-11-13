<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VerificationExport implements FromCollection, WithHeadings, WithStyles
{
    protected $schoolDetails;
    protected $modules;
    protected $trainees;
    protected $internalVerifier;
    protected $externalVerifiers;

    public function __construct($schoolDetails, $modules, $trainees, $internalVerifier, $externalVerifiers)
    {
        $this->schoolDetails = $schoolDetails;
        $this->modules = $modules;
        $this->trainees = $trainees;
        $this->internalVerifier = $internalVerifier;
        $this->externalVerifiers = $externalVerifiers;
    }

    public function collection()
    {
        // Flatten trainees into rows
        return collect($this->trainees)->map(function ($t, $i) {
            return [
                $i + 1,
                $t['name'],
                $t['portfolio'],
                $t['scores'][0] ?? null,
                $t['scores'][1] ?? null,
                $t['scores'][2] ?? null,
                $t['scores'][3] ?? null,
                $t['scores'][4] ?? null, // Industrial Attachment
                $t['scores'][5] ?? null, // Final Integrated Assessment
                $t['decision'] ?? null,
            ];
        });
    }

    public function headings(): array
    {
        return [
            "No",
            "Trainee's Name",
            "Portfolio",
            "Score1",
            "Score2",
            "Score3",
            "Score4",
            "Industrial Attachment",
            "Final Integrated Assessment",
            "Decision (C/NYC)"
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
