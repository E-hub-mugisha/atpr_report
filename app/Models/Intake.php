<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intake extends Model
{
    //
    protected $fillable = [
        'month',
        'year',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
