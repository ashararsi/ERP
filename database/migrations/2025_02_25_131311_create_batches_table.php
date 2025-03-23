<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formulation_id')->constrained('formulations')->onDelete('cascade');
            $table->string('batch_code');
            $table->string('batch_name');
            $table->string('batch_date');
            $table->string('product_name');
            $table->string('mfg_date');
            $table->string('total_qty');
            $table->date('production_date')->nullable();
            $table->date('expiry_date');
            $table->enum('status', ['in_process', 'packaging', 'completed', 'dispatched_for_warehouse'])->default('in_process');
            $table->timestamps();
            $table->SoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
