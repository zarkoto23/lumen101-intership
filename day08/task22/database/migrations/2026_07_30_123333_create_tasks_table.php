<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('tasks', function (Blueprint $table) {
        $table->id();

        $table->foreignId('project_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->foreignId('assigned_to')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();

        $table->string('title');

        $table->text('description')
            ->nullable();

        $table->enum('priority', [
            'low',
            'medium',
            'high'
        ])->default('medium');

        $table->enum('status', [
            'new',
            'in_progress',
            'review',
            'completed'
        ])->default('new');

        $table->date('deadline');

        $table->foreignId('status_changed_by')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();

        $table->timestamp('status_changed_at')
            ->nullable();

        $table->timestamps();

        $table->softDeletes();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
