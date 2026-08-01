<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {

            $table->id();


            $table->foreignId('course_id')
                ->constrained()
                ->cascadeOnDelete();


            $table->foreignId('student_id')
                ->constrained('users')
                ->cascadeOnDelete();


            $table->enum('status', [
                'pending',
                'active',
                'completed',
                'cancelled'
            ])
            ->default('pending');


            $table->timestamp('enrolled_at')
                ->nullable();


            $table->timestamp('completed_at')
                ->nullable();


            $table->decimal('final_grade', 5, 2)
                ->nullable();


            $table->timestamps();


            $table->unique([
                'course_id',
                'student_id'
            ]);

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};