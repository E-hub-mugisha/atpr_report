<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'first_name',
        'last_name',
        'gender',
        'dob',
        'email',
        'phone',
        'class',
        'academic_year',
        'qualification_title',
        'intake_no',
        'intake_year',
    ];

    // Example relationship (optional)
    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
