<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    protected $fillable = [
        'trainee',
        'module_id',
        'i_a',
        'f_a',
        'c_a',
        'total',
        'reass',
        'obs',
        'remarks',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
