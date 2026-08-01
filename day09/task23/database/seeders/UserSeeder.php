<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@academy.test'
            ],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );


        User::updateOrCreate(
            [
                'email' => 'instructor@academy.test'
            ],
            [
                'name' => 'Instructor',
                'password' => Hash::make('password'),
                'role' => 'instructor',
                'is_active' => true,
            ]
        );


        User::updateOrCreate(
            [
                'email' => 'student@academy.test'
            ],
            [
                'name' => 'Student',
                'password' => Hash::make('password'),
                'role' => 'student',
                'is_active' => true,
            ]
        );
    }
}