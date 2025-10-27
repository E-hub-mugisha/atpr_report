<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name',
        'description',
        'duration',
        'trainer',
    ];

    public function modules()
    {
        return $this->hasMany(Module::class);
    }
}
