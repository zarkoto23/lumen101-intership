<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class AssignmentSubmission extends Model
{

    use HasFactory;



    protected $fillable = [

        'assignment_id',

        'student_id',

        'file_path',

        'comment',

        'submitted_at',

        'status',

        'points',

        'instructor_feedback',

        'graded_at',

    ];





    protected $casts = [

        'submitted_at'=>'datetime',

        'graded_at'=>'datetime',

    ];





    public function assignment()
    {
        return $this->belongsTo(
            Assignment::class
        );
    }





    public function student()
    {
        return $this->belongsTo(
            User::class,
            'student_id'
        );
    }


}