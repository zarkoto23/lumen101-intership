<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Lesson extends Model
{
    use HasFactory;



    protected $fillable = [
        'course_section_id',
        'title',
        'description',
        'video_url',
        'file_path',
        'duration_minutes',
        'position',
        'is_preview',
    ];



    protected $casts = [

        'is_preview' => 'boolean',

    ];



    public function section(): BelongsTo
    {
        return $this->belongsTo(
            CourseSection::class,
            'course_section_id'
        );
    }



    public function progress(): HasMany
    {
        return $this->hasMany(
            LessonProgress::class
        );
    }
}