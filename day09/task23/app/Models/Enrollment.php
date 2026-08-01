<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


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
        'enrolled_at' => 'datetime',
        'completed_at' => 'datetime',
        'final_grade' => 'decimal:2',
    ];


    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }


    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }


    public function progress(): HasMany
    {
        return $this->hasMany(LessonProgress::class);
    }

    public function payment(): HasOne
{
    return $this->hasOne(Payment::class);
}


public function certificate(): HasOne
{
    return $this->hasOne(Certificate::class);
}
}