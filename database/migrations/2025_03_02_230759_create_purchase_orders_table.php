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
        Schema::create('purchase_orders', function (Blueprint $table) {

                $table->id();
                $table->string('po_number')->unique(); // Purchase Order Number
                $table->unsignedBigInteger('supplier_id'); // Supplier Reference
                $table->date('order_date');
                $table->date('delivery_date')->nullable();
                $table->enum('status', ['pending', 'approved', 'delivered', 'cancelled'])->default('pending');
                $table->decimal('total_amount', 10, 2)->default(0);
                $table->text('notes')->nullable();
                $table->timestamps();

                // Foreign Key Constraint
                $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
