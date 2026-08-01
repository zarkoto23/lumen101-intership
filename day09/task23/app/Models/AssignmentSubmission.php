<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsTo;


class AssignmentSubmission extends Model
{
    use HasFactory;



    protected $fillable = [
        'assignment_id',
        'student_id',
        'file_path',
        'comment',
        'status',
        'points',
        'instructor_feedback',
        'submitted_at',
        'graded_at',
    ];



    protected $casts = [

        'submitted_at' => 'datetime',

        'graded_at' => 'datetime',

        'points' => 'decimal:2',

    ];



    public function assignment(): BelongsTo
    {
        return $this->belongsTo(
            Assignment::class
        );
    }



    public function student(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'student_id'
        );
    }
}