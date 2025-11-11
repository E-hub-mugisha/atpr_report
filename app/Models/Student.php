<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'id_number',
        'first_name',
        'last_name',
        'gender',
        'dob',
        'email',
        'phone',
        'phone_next_of_kin',
        'address',
        'academic_year',
        'qualification_title',
        'status',
        'disability',
        'marital_status',
        'education_level',
        'intake_id',

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

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function intake()
    {
        return $this->belongsTo(Intake::class);
    }

    public function getIntakeNameAttribute()
    {
        return $this->intake ? $this->intake->month . ' ' . $this->intake->year : 'N/A';
    }

    public function getStatusAttribute()
    {
        return $this->attributes['status'] === 'active' ? 'Active' : 'Inactive';
    }

    protected $casts = [
        'dob' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
