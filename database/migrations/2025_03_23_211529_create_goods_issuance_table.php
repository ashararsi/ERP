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
        Schema::create('goods_issuance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('batch_id');
            $table->unsignedBigInteger('raw_material_id')->nullable();
            $table->decimal('issued_quantity', 10, 2);
            $table->decimal('wastage_quantity_allow', 10, 2)->default(0);
            $table->string('issued_by')->nullable();
            $table->integer('process_id')->nullable();
            $table->string('operator_id')->nullable();
            $table->date('issued_date')->nullable();

            $table->text('remarks')->nullable();
//            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
//            $table->foreign('raw_material_id')->references('id')->on('raw_materials')->onDelete('cascade');
            $table->timestamps();
            $table->SoftDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_issuance');
    }
};
