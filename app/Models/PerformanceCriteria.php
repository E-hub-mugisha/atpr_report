<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformanceCriteria extends Model
{
    protected $fillable = [
        'learning_outcome_id','order_number','description','score'
    ];
}
