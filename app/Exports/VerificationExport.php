<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class VerificationExport implements FromView, WithTitle, ShouldAutoSize
{
    protected $school, $program, $modules, $students, $total, $competent;

    public function __construct($school, $program, $modules, $students, $total, $competent)
    {
        $this->school   = $school;
        $this->program  = $program;
        $this->modules  = $modules;
        $this->students = $students;
        $this->total = $total;
        $this->competent = $competent;
    }

    public function view(): View
    {
        return view('exports.verification', [
            'school'   => $this->school,
            'program'  => $this->program,
            'modules'  => $this->modules,
            'students' => $this->students,
            'total' => $this->total,
            'competent' => $this->competent,
        ]);
    }

    public function title(): string
    {
        return 'Verification'; // Must be <= 31 chars
    }
}
