<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
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



    protected $casts = [

        'password' => 'hashed',

        'is_active' => 'boolean',

    ];




    public function enrollments()
    {
        return $this->hasMany(
            Enrollment::class,
            'student_id'
        );
    }




    public function courses()
    {
        return $this->hasMany(
            Course::class,
            'instructor_id'
        );
    }





    public function isAdmin()
    {
        return $this->role === 'admin';
    }





    public function isInstructor()
    {
        return $this->role === 'instructor';
    }





    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function canAccessPanel(\Filament\Panel $panel): bool
    {

        return in_array(
            $this->role,
            [
                'admin',
                'instructor'
            ]
        )
            &&
            $this->is_active;
    }
}
