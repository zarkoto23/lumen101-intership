<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'teacher_id',
        'name',
        'description',
        'duration',
        'price',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
