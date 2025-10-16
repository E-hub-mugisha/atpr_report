<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraineeReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainee_name',
        'reg_no',
        'academic_year',
        'class',
        'course_duration',
        'qualification_title',
        'english',
        'francais',
        'swahili',
        'total_marks',
        'percentage',
        'decision',
    ];
}
