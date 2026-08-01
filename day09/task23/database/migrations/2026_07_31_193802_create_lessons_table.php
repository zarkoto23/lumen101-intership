<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {

            $table->id();

            $table->foreignId('course_section_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');

            $table->text('description')
                ->nullable();

            $table->string('video_url')
                ->nullable();

            $table->string('file_path')
                ->nullable();

            $table->unsignedInteger('duration_minutes')
                ->default(0);

            $table->unsignedInteger('position')
                ->default(1);

            $table->boolean('is_preview')
                ->default(false);

            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};