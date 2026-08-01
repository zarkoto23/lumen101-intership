<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Certificate extends Model
{
    use HasFactory;


    protected $fillable = [
        'enrollment_id',
        'certificate_number',
        'issued_at',
        'file_path',
    ];


    protected $casts = [
        'issued_at' => 'datetime',
    ];


    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }
}