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
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->date('voucher_date');
            $table->string('cheque_no', 191)->nullable();
            $table->string('financial_year', 191)->nullable();
            $table->date('cheque_date')->nullable();
            $table->string('invoice_no', 191)->nullable();
            $table->date('invoice_date')->nullable();
            $table->string('bank_name', 255)->nullable();
            $table->string('bank_branch', 255)->nullable();
            $table->decimal('dr_total', 11, 2)->default(0.00);
            $table->decimal('cr_total', 11, 2)->default(0.00);
            $table->text('narration')->nullable();
            $table->text('remarks')->nullable();
            $table->integer('entry_type_id')->nullable();
            $table->integer('employee_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('department_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->smallInteger('status')->unsigned()->default(1);
            $table->integer('created_by')->nullable()->nullable();
            $table->integer('updated_by')->nullable()->nullable();
            $table->integer('deleted_by')->nullable()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
