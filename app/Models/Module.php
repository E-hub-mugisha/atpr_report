<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'order',
        'course_id',
        'module_code',
        'type'
    ];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
