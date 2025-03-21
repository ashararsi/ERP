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
        Schema::create('hrm_leave_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('employee_id');
            $table->unsignedInteger('leave_type_id');
            $table->unsignedInteger('work_shift_id');
            $table->unsignedInteger('leave_status')->default(3);
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedSmallInteger('total_days');
            $table->date('applied_date');
            $table->text('comments')->nullable();
            $table->text('leave_type_data')->nullable();
            $table->text('work_shift_data')->nullable();
            $table->string('single_duration', 20)->nullable();
            $table->string('single_shift', 20)->nullable();
            $table->string('single_hours_start', 5)->nullable();
            $table->string('single_hours_end', 5)->nullable();
            $table->unsignedSmallInteger('single_hours_duration')->nullable();
            $table->string('partial_days', 20)->nullable();
            $table->string('all_days_duration', 20)->nullable();
            $table->string('all_days_shift', 20)->nullable();
            $table->string('all_days_hours_start', 5)->nullable();
            $table->string('all_days_hours_end', 5)->nullable();
            $table->unsignedSmallInteger('all_days_hours_duration')->nullable();
            $table->string('starting_duration', 20)->nullable();
            $table->string('starting_shift', 20)->nullable();
            $table->string('starting_hours_start', 5)->nullable();
            $table->string('starting_hours_end', 5)->nullable();
            $table->unsignedSmallInteger('starting_hours_duration')->nullable();
            $table->string('ending_duration', 20)->nullable();
            $table->string('ending_shift', 20)->nullable();
            $table->string('ending_hours_start', 5)->nullable();
            $table->string('ending_hours_end', 5)->nullable();
            $table->unsignedSmallInteger('ending_hours_duration')->nullable();
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
        Schema::dropIfExists('hrm_leave_requests');
    }
};
