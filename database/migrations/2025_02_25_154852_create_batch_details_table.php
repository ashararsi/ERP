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
        Schema::create('batch_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('batch_id');  // Ensure correct type
            $table->unsignedBigInteger('raw_material_id'); // Ensure correct type
            $table->float('actual_quantity');
            $table->string('operator_initials')->nullable();
            $table->string('qa_initials')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Correct casing

            // Foreign Keys
//            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
//            $table->foreign('raw_material_id')->references('id')->on('raw_materials')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_details');
    }
};
