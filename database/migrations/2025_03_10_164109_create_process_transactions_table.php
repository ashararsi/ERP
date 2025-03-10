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
        Schema::create('process_transactions', function (Blueprint $table) {
            $table->id();

            $table->integer('raw_material_id')->nullable();
            $table->integer('process_stage_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->enum('status', ['issued', 'returned', 'finalized'])->default('issued');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('process_transactions');
    }
};
