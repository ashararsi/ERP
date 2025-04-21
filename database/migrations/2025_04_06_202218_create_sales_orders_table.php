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
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();


            $table->string('order_number')->unique();
            $table->date('order_date');
            $table->foreignId('customer_id')->constrained();
            $table->string('customer_po_no')->nullable();
            $table->date('customer_po_date')->nullable();
            $table->string('city');
            $table->string('payment_terms');
            $table->foreignId('sales_rep_id')->nullable();
            $table->date('delivery_date');
            $table->decimal('sub_total', 10, 2);
            $table->decimal('total_discount', 10, 2);
            $table->decimal('total_tax', 10, 2);
            $table->decimal('advance_tax', 10, 2)->default(0);
            $table->decimal('net_total', 10, 2);
            $table->text('notes')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
