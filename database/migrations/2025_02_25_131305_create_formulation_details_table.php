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
        Schema::create('formulation_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formulation_id')->constrained('formulations')->onDelete('cascade');
            $table->foreignId('raw_material_id')->constrained('raw_materials')->onDelete('cascade');
            $table->float('standard_quantity');
            $table->float('actual')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Fix: Correct casing
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulation_details');
    }
};
