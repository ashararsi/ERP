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
        Schema::create('goods_receipt', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('batch_id');
            $table->unsignedBigInteger('process_id'); // Identifies which process the product is coming from
            $table->decimal('received_quantity', 10, 2);
            $table->decimal('wastage_quantity', 10, 2)->default(0);
            $table->string('received_by');
            $table->date('received_date');
            $table->enum('qa_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
            $table->SoftDeletes();

//            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
//            $table->foreign('process_id')->references('id')->on('manufacturing_processes')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_receipt');
    }
};
