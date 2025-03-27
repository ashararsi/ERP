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
        Schema::create('inventory_raw_materials', function (Blueprint $table) {

            $table->id();
            $table->integer('product_id');
            $table->integer('quantity');
            $table->integer('quantity_available')->default(0);
            $table->decimal('unit_price', 10, 2); // Price per unit
            $table->string('unit_of_measurement')->nullable(); // e.g., kg, liter, meter
            $table->decimal('total_cost', 15, 2)->storedAs('quantity_available * unit_price'); // Auto-calculated total cost
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_raw_materials');
    }
};
