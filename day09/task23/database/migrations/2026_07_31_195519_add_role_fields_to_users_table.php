<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->enum('role', [
                'admin',
                'instructor',
                'student'
            ])
            ->default('student')
            ->after('email');


            $table->string('profile_image')
                ->nullable()
                ->after('role');


            $table->string('phone')
                ->nullable()
                ->after('profile_image');


            $table->boolean('is_active')
                ->default(true)
                ->after('phone');

        });
    }


    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'role',
                'profile_image',
                'phone',
                'is_active'
            ]);

        });
    }
};