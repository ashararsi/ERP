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
            $table->foreignId('formulation_id');
            $table->foreignId('raw_material_id');
            $table->float('standard_quantity');
            $table->text('remarks')->nullable();
            $table->integer('unit_id')->nullable();
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
