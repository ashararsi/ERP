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
//            $table->string('document_no')->unique();
            $table->integer('process_id');
            $table->integer('batch_id');
            $table->text('description');
            $table->string('mixing_time_min'); // Store in minutes
            $table->json('check_points'); // Store multiple check points as JSON
            $table->string('status')->default('pending');
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
