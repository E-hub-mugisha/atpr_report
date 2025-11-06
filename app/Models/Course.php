<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name',
        'description',
        'duration',
        'trainer_id',
        'course_code',
    ];

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
