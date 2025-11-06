<?php

namespace App\Imports;

use App\Models\Lesson;
use App\Models\Mark;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MarksImport implements ToModel, WithHeadingRow
{
    protected $lesson;

    public function __construct(Lesson $lesson)
    {
        $this->lesson = $lesson;
    }

    public function model(array $row)
    {
        return new Mark([
            'trainee' => $row['trainee'],
            'lesson_id' => $this->lesson->id,
            'i_a' => $row['i_a'] ?? null,
            'f_a' => $row['f_a'] ?? null,
            'c_a' => $row['c_a'] ?? null,
            'total' => $row['total'] ?? null,
            'reass' => $row['reass'] ?? null,
            'obs' => $row['obs'] ?? null,
            'remarks' => $row['remarks'] ?? null,
        ]);
    }
}
