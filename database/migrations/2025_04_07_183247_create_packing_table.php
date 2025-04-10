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
        Schema::create('packings', function (Blueprint $table) {
            $table->id();
            $table->string('packing_type'); // bottle, box, tablet, etc.
            $table->decimal('quantity', 10, 2); // 50, 500, 1, etc.
            $table->string('unit'); // ml, liter, kg, etc.
            $table->string('display_name')->nullable(); // Optional display name (e.g., "Small Bottle")
            $table->string('image_path')->nullable(); // Optional image path
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();

            // Index for faster lookups
            $table->index(['packing_type', 'quantity', 'unit']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packings');
    }
};
