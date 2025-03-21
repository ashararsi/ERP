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
        Schema::create('hrm_work_weeks', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('mon');
            $table->unsignedSmallInteger('tue');
            $table->unsignedSmallInteger('wed');
            $table->unsignedSmallInteger('thu');
            $table->unsignedSmallInteger('fri');
            $table->unsignedSmallInteger('sat');
            $table->unsignedSmallInteger('sun');
            $table->unsignedSmallInteger('working_days');
            $table->unsignedSmallInteger('status')->default(1);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hrm_work_weeks');
    }
};
