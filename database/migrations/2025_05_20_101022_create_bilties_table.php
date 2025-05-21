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
        Schema::create('bilties', function (Blueprint $table) {
            $table->id();
            $table->string('goods_name')->nullable();
            $table->string('place')->nullable();
            $table->string('bilty_no')->nullable();
            $table->date('bilty_date')->nullable();
            $table->date('courier_date')->nullable();
            $table->string('receipt_no')->nullable();
            $table->integer('cartons')->default(0);
            $table->decimal('fare', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bilties');
    }
};
