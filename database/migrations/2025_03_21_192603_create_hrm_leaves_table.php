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
        Schema::table('hrm_leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('leave_request_id');
            $table->unsignedInteger('employee_id');
            $table->unsignedInteger('leave_type_id');
            $table->unsignedInteger('work_shift_id');
            $table->unsignedInteger('leave_status_id');
            $table->date('leave_date');
            $table->string('start_time', 5);
            $table->string('end_time', 5);
            $table->string('shift', 10);
            $table->double('hours');
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
        Schema::table('hrm_leaves', function (Blueprint $table) {
            //
        });
    }
};
