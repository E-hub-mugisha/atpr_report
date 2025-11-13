<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'qualification',
        'bio',
        'sex',
        'civil_status',
        'dob',
        'id_or_passport',
        'school_name',
        'province',
        'district',
        'sector',
        'school_level',
        'school_status',
    ];

    // Relation: Trainer teaches many modules
    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    protected $casts = [
        'dob' => 'date',
    ];

    // ✅ Relationships
    public function academicQualifications()
    {
        return $this->hasMany(AcademicQualification::class);
    }

    public function trainings()
    {
        return $this->hasMany(TrainerTraining::class);
    }

    public function experiences()
    {
        return $this->hasMany(TrainerExperience::class);
    }

    public function skillRatings()
    {
        return $this->hasMany(TrainerSkillRating::class);
    }
}
