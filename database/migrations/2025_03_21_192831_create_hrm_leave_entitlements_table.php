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
        Schema::create('hrm_leave_entitlements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->double('no_of_days', 11, 2)->default(0.00);
            $table->double('days_used', 11, 2)->default(0.00);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('credited_date')->nullable();
            $table->unsignedBigInteger('leave_type_id');
            $table->unsignedSmallInteger('status')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hrm_leave_entitlements');
    }
};
