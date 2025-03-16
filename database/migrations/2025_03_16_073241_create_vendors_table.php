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
        Schema::table('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_name', 191)->nullable()->collation('latin1_swedish_ci'); // Vendor Name
            $table->string('cnic', 191)->nullable()->collation('latin1_swedish_ci'); // CNIC
            $table->string('ntn', 191)->nullable()->collation('latin1_swedish_ci'); // NTN
            $table->string('salestaxno', 191)->nullable()->collation('latin1_swedish_ci'); // Sales Tax No
            $table->string('email', 191)->nullable()->collation('latin1_swedish_ci'); // Email
            $table->string('contact', 191)->nullable()->collation('latin1_swedish_ci'); // Contact Number
            $table->string('addresss', 191)->nullable()->collation('latin1_swedish_ci'); // Address
            $table->string('type', 255)->nullable()->collation('latin1_swedish_ci'); // Type
            $table->string('category', 255)->nullable()->collation('latin1_swedish_ci'); // Category
            $table->string('service_type', 255)->nullable()->collation('latin1_swedish_ci'); // Service Type
            $table->string('remarks', 191)->nullable()->collation('latin1_swedish_ci'); // Remarks
            $table->string('acc_no', 191)->nullable()->collation('latin1_swedish_ci'); // Account Number
            $table->string('pra_no', 191)->nullable()->collation('latin1_swedish_ci'); // PRA Number
            $table->string('pra_type', 255)->nullable()->collation('latin1_swedish_ci'); // PRA Type
            $table->string('sales_tax', 255)->nullable()->collation('latin1_swedish_ci'); // Sales Tax
            $table->string('bank_branch_code', 255)->nullable()->collation('latin1_swedish_ci'); // Bank Branch Code
            $table->string('bank_branch_name', 255)->nullable()->collation('latin1_swedish_ci'); // Bank Branch Name
            $table->string('updated_by', 255)->nullable()->collation('latin1_swedish_ci'); // Updated By
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            //
        });
    }
};
