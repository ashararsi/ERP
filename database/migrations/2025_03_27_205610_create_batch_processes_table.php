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
        Schema::create('batch_processes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->constrained()->onDelete('cascade');
            $table->foreignId('process_id')->constrained('processes');
            $table->integer('order')->default(0);
            $table->string('remarks')->nullable();
            $table->integer('duration_minutes'); // Planned duration
            $table->integer('actual_duration_minutes')->nullable(); // Actual duration
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->string('status')->default('pending'); // pending, in_progress, completed, skipped
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_processes');
    }
};
