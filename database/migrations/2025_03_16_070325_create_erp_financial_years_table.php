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
        Schema::create('erp_financial_years', function (Blueprint $table) {

            $table->id();
            $table->string('name', 255)->collation('utf8mb4_unicode_ci');
            $table->date('start_date');
            $table->date('end_date');
            $table->smallInteger('status')->unsigned()->default(1);

            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
            $table->unsignedInteger('deleted_by')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('erp_financial_years', function (Blueprint $table) {
            //
        });
    }
};
