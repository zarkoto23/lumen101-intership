<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {

            $table->id();


            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnDelete();


            $table->foreignId('instructor_id')
                ->constrained('users')
                ->cascadeOnDelete();


            $table->string('title');

            $table->string('slug')
                ->unique();


            $table->string('short_description')
                ->nullable();


            $table->text('description')
                ->nullable();


            $table->decimal('price', 10, 2)
                ->default(0);


            $table->enum('level', [
                'beginner',
                'intermediate',
                'advanced'
            ])
            ->default('beginner');


            $table->string('image')
                ->nullable();


            $table->enum('status', [
                'draft',
                'pending',
                'published',
                'completed',
                'rejected'
            ])
            ->default('draft');


            $table->date('start_date')
                ->nullable();


            $table->date('end_date')
                ->nullable();


            $table->unsignedInteger('maximum_students')
                ->default(1);


            $table->timestamps();


            $table->softDeletes();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};