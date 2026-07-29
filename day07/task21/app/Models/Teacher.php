<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'specialization',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
