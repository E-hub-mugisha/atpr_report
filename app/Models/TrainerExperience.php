<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'type',
        'position',
        'institution',
        'place',
        'status',
        'sector',
        'trade',
        'core_responsibility',
        'from_date',
        'to_date',
        'days',
        'times_assessed',
        'sessions_competent',
        'master_trainer',
        'evidence'
    ];

    protected $casts = [
        'evidence' => 'boolean'
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }
}
