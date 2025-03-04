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
        Schema::create('good_receipt_notes', function (Blueprint $table) {
            $table->id();
            $table->string('grn_number')->unique();
            $table->foreignId('purchase_order_id')->constrained()->onDelete('cascade');
            $table->date('receipt_date')->nullable();
            $table->float('total_amount')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('good_receipt_notes');
    }
};
