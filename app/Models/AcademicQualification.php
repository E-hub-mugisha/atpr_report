<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicQualification extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'qualification_name',
        'institution',
        'date_awarded',
        'level',
        'verification'
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }
}
