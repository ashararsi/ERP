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
        Schema::table('sales_orders', function (Blueprint $table) {
            $table->decimal('further_sales_tax_rate', 5, 2)->default(0)->after('net_total'); 
            $table->decimal('advance_tax_rate', 5, 2)->default(0)->after('further_sales_tax_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_orders', function (Blueprint $table) {
            $table->dropColumn(['further_sales_tax_rate', 'advance_tax_rate']);

        });
    }
};
