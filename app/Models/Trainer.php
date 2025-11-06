<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'qualification',
        'bio'
    ];

    // Relation: Trainer teaches many modules
    public function modules()
    {
        return $this->hasMany(Module::class);
    }
}
