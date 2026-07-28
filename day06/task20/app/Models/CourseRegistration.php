<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseRegistration extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'age',
        'specialty',
        'course',
        'study_form'
    ];
}
