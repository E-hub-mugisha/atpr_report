<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerSkillRating extends Model
{
   use HasFactory;

    protected $fillable = [
        'trainer_id',
        'skill_type',
        'skill_name',
        'reading',
        'speaking',
        'writing',
        'computer_level'
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }
}
