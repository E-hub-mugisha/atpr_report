<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningOutcome extends Model
{
    protected $fillable = [
        'module_evaluation_id','order_number','description'
    ];

    public function performanceCriteria() {
        return $this->hasMany(PerformanceCriteria::class);
    }
}
