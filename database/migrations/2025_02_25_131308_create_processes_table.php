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
        Schema::create('processes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Process name (e.g., Mixing, Packaging)
            $table->text('description')->nullable(); // Details about the process
            $table->integer('sequence_order')->default(0); // Order in which the process should be performed
            $table->string('image')->nullable(); // Order in which the process should be performed
//            $table->foreignId('formulation_id')->constrained('formulations')->onDelete('cascade'); // Link to the formulation
//            $table->enum('status', ['pending', 'in_progress', 'completed', 'failed'])->default('pending'); // Status of the process
//            $table->string('assigned_operator')->nullable(); // Person responsible for the process
//            $table->timestamp('scheduled_start')->nullable(); // Scheduled start time
//            $table->timestamp('actual_start')->nullable(); // Actual start time
//            $table->timestamp('completed_at')->nullable(); // Completion time
            $table->integer('duration_minutes')->nullable(); // Duration of the process in minutes
            $table->text('remarks')->nullable(); // Additional notes or remarks
            $table->boolean('requires_quality_check')->default(false);
            $table->timestamps();
            $table->SoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processes');
    }
};
