<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    //
    protected $fillable = ['title', 'content', 'module_id', 'lesson_code'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
}
