<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerTraining extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'type',
        'title',
        'provider',
        'hours',
        'institution',
        'company',
        'status',
        'details',
        'from_date',
        'to_date',
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
