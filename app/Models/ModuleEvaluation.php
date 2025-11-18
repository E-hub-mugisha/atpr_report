<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleEvaluation extends Model
{
    protected $fillable = [
        'module_id','trainer_id','student_id','competence','comments'
    ];

    // Relationship to Module
    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    // Relationship to Trainer
    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id');
    }

    // Relationship to student
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function learningOutcomes() {
        return $this->hasMany(LearningOutcome::class);
    }
}
