<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id')->index();

            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedInteger('working_hours')->nullable();
            $table->string('reg_no')->nullable();
            $table->enum('relation', ['father', 'husband'])->nullable();
            $table->string('pemail', 1000)->nullable();
            $table->enum('marital_status', ['married', 'unmarried'])->nullable();
            $table->date('expiry_date')->nullable();
            $table->integer('training')->nullable();
            $table->string('staff_type');
            $table->date('join_date')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('ntn')->nullable();
            $table->string('conveyance')->nullable();
            $table->string('house_rent')->nullable();
            $table->string('provident_fund')->nullable();
            $table->string('provident_amount')->nullable();
            $table->string('medical_allowances')->nullable();
            $table->string('filer_type')->nullable();
            $table->string('gender')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('nationality')->nullable();
            $table->string('mother_tongue')->nullable();
            $table->string('address')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('temp_address')->nullable();
            $table->string('home_phone')->nullable();
            $table->string('mobile_1')->nullable();
            $table->string('mobile_2')->nullable();
            $table->string('email')->nullable();
            $table->string('qualification')->nullable();
            $table->string('experience')->nullable();
            $table->string('other_info')->nullable();
            $table->string('staff_image')->nullable();
            $table->string('skill')->nullable();
            $table->string('salary')->nullable();
            $table->string('salary_per_hour')->nullable();
            $table->string('password');
            $table->string('cnic')->index();
            $table->enum('status', ['Active', 'InActive', 'Pending'])->default('Active');
            $table->date('sos_date')->nullable();
            $table->string('sos_reason', 1000)->nullable();
            $table->enum('job_status', ['Full Time', 'Part Time', 'Visiting', 'Lecture'])->nullable();
            $table->string('start_day_contract')->nullable();
            $table->string('end_day_contract')->nullable();
            $table->string('probation')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('is_iban', 1)->nullable();
            $table->text('bank_account')->nullable();
            $table->text('bank_branch')->nullable();
            $table->text('account_title')->nullable();
            $table->string('account_number')->nullable();
            $table->integer('basic_salary')->nullable();
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->unsignedBigInteger('updated_by')->index()->nullable();
            $table->unsignedBigInteger('deleted_by')->index()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
