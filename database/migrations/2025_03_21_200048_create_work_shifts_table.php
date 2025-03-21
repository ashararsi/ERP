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
        Schema::create('work_shifts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->double('hours_per_day', 11, 2)->default(0.00);
            $table->string('shift_start_time', 5);
            $table->string('shift_end_time', 5);
            $table->double('working_hours_per_day', 11, 2)->default(0.00);
            $table->string('break_start_time', 5)->nullable();
            $table->string('break_end_time', 5)->nullable();
            $table->double('break_hours_per_day', 11, 2)->default(0.00);
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
        Schema::dropIfExists('work_shifts');
    }
};
