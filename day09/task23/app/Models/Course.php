<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


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
        'start_date' => 'date',
        'end_date' => 'date',
        'price' => 'decimal:2',
    ];



    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }



    public function instructor(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'instructor_id'
        );
    }



    public function sections(): HasMany
    {
        return $this->hasMany(
            CourseSection::class
        );
    }



    public function assignments(): HasMany
    {
        return $this->hasMany(
            Assignment::class
        );
    }



    public function enrollments(): HasMany
    {
        return $this->hasMany(
            Enrollment::class
        );
    }
}