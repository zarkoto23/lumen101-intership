<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;



class Course extends Model
{

    use HasFactory, SoftDeletes;



    protected $fillable = [

        'category_id',

        'instructor_id',

        'title',

        'slug',

        'short_description',

        'description',

        'price',

        'level',

        'image',

        'status',

        'start_date',

        'end_date',

        'maximum_students',

    ];





    protected $casts = [

        'start_date'=>'datetime',

        'end_date'=>'datetime',

    ];





    public function category()
    {
        return $this->belongsTo(
            Category::class
        );
    }





    public function instructor()
    {
        return $this->belongsTo(
            User::class,
            'instructor_id'
        );
    }





    public function sections()
    {
        return $this->hasMany(
            CourseSection::class
        );
    }





    public function enrollments()
    {
        return $this->hasMany(
            Enrollment::class
        );
    }





    public function assignments()
    {
        return $this->hasMany(
            Assignment::class
        );
    }





}