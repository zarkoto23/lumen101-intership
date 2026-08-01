<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Enrollment extends Model
{

    use HasFactory;



    protected $fillable = [

        'course_id',

        'student_id',

        'status',

        'enrolled_at',

        'completed_at',

        'final_grade',

    ];





    protected $casts = [

        'enrolled_at'=>'datetime',

        'completed_at'=>'datetime',

    ];





    public function course()
    {
        return $this->belongsTo(
            Course::class
        );
    }





    public function student()
    {
        return $this->belongsTo(
            User::class,
            'student_id'
        );
    }





    public function lessonProgress()
    {
        return $this->hasMany(
            LessonProgress::class
        );
    }





    public function payment()
    {
        return $this->hasOne(
            Payment::class
        );
    }





    public function certificate()
    {
        return $this->hasOne(
            Certificate::class
        );
    }


}