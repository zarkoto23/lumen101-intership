<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;

use Filament\Models\Contracts\FilamentUser;

use Filament\Panel;

use Illuminate\Database\Eloquent\Relations\HasMany;



class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;



    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_image',
        'phone',
        'is_active',
    ];



    protected $hidden = [
        'password',
        'remember_token',
    ];



    protected function casts(): array
    {
        return [

            'email_verified_at' => 'datetime',

            'password' => 'hashed',

            'is_active' => 'boolean',

        ];
    }




public function canAccessPanel(Panel $panel): bool
{
    return in_array(
        $this->role,
        [
            'admin',
            'instructor',
        ]
    );
}




    public function courses(): HasMany
    {
        return $this->hasMany(
            Course::class,
            'instructor_id'
        );
    }





    public function enrollments(): HasMany
    {
        return $this->hasMany(
            Enrollment::class,
            'student_id'
        );
    }





    public function assignmentSubmissions(): HasMany
    {
        return $this->hasMany(
            AssignmentSubmission::class,
            'student_id'
        );
    }





    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }





    public function isInstructor(): bool
    {
        return $this->role === 'instructor';
    }





    public function isStudent(): bool
    {
        return $this->role === 'student';
    }
}