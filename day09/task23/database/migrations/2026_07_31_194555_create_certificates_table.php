<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {

            $table->id();


            $table->foreignId('enrollment_id')
                ->constrained()
                ->cascadeOnDelete();


            $table->string('certificate_number')
                ->unique();


            $table->timestamp('issued_at');


            $table->string('file_path')
                ->nullable();


            $table->timestamps();


            $table->unique('enrollment_id');

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};