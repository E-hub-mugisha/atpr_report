<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentReportExport implements FromArray, WithHeadings
{
    protected $student;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    public function array(): array
    {
        $data = [];

        // Get all marks for this student with lessons and module
        $marks = $this->student->marks()->with('lesson.module')->get();

        foreach ($marks as $mark) {
            $lesson = $mark->lesson;
            $module = $lesson->module;

            $data[] = [
                'Module' => $module->title ?? '-',
                'Lesson' => $lesson->title ?? '-',
                'IA' => $mark->i_a ?? '',
                'FA' => $mark->f_a ?? '',
                'CA' => $mark->c_a ?? '',
                'Total' => $mark->total ?? '',
                'Re-assessment' => $mark->reass ?? '',
                'Observation' => $mark->obs ?? '',
                'Remarks' => $mark->remarks ?? '',
            ];
        }

        return $data;
    }

    public function headings(): array
    {
        return ['Module', 'Lesson', 'IA', 'FA', 'CA', 'Total', 'Re-assessment', 'Observation', 'Remarks'];
    }
}
