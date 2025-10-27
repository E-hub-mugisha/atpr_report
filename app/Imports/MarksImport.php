<?php

namespace App\Imports;

use App\Models\Mark;
use App\Models\Module;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MarksImport implements ToModel, WithHeadingRow
{
    protected $module;

    public function __construct(Module $module)
    {
        $this->module = $module;
    }

    public function model(array $row)
    {
        return new Mark([
            'trainee' => $row['trainee'],
            'module_id' => $this->module->id,
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
