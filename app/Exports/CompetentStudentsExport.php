<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CompetentStudentsExport implements FromCollection, WithHeadings
{
    protected $intake;

    public function __construct($intake)
    {
        $this->intake = $intake;
    }

    public function collection()
    {
        return Student::where('academic_year', $this->intake)
            ->where('status', 'active')
            ->get([
                'id_number',
                'first_name',
                'last_name',
                'gender',
                'dob',
                'email',
                'phone',
                'academic_year',
                'qualification_title',
                'status'
            ]);
    }

    public function headings(): array
    {
        return [
            'ID Number',
            'First Name',
            'Last Name',
            'Gender',
            'Date of Birth',
            'Email',
            'Phone',
            'Academic Year',
            'Qualification Title',
            'Status'
        ];
    }
}
