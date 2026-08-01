<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Assignment extends Model
{

    use HasFactory;



    protected $fillable = [

        'course_id',

        'title',

        'description',

        'deadline',

        'maximum_points',

        'attachment_path',

        'is_required',

    ];





    protected $casts = [

        'deadline'=>'datetime',

        'is_required'=>'boolean',

    ];





    public function course()
    {
        return $this->belongsTo(
            Course::class
        );
    }





    public function submissions()
    {
        return $this->hasMany(
            AssignmentSubmission::class
        );
    }


}