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
        Schema::create('recovery_sheet_filters', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedInteger('serial_no')->unique();
            $table->unsignedBigInteger('sales_person_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->json('cities')->nullable();
            $table->json('areas')->nullable();
            $table->timestamps();

            $table->foreign('sales_person_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recovery_sheet_filters');
    }
};
