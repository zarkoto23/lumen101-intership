<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assignment_submissions', function (Blueprint $table) {

            $table->id();


            $table->foreignId('assignment_id')
                ->constrained()
                ->cascadeOnDelete();


            $table->foreignId('student_id')
                ->constrained('users')
                ->cascadeOnDelete();


            $table->string('file_path')
                ->nullable();


            $table->text('comment')
                ->nullable();


            $table->timestamp('submitted_at')
                ->nullable();


            $table->enum('status', [
                'submitted',
                'late',
                'reviewed',
                'returned'
            ])
            ->default('submitted');


            $table->unsignedInteger('points')
                ->nullable();


            $table->text('instructor_feedback')
                ->nullable();


            $table->timestamp('graded_at')
                ->nullable();


            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');
    }
};