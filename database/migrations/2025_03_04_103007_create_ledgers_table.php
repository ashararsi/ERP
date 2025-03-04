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
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('number', 255)->nullable();
            $table->string('code', 255)->nullable();
            $table->unsignedBigInteger('group_id')->default(0);
            $table->string('group_number', 255)->nullable();
            $table->unsignedInteger('opening_balance')->nullable()->default(0);
            $table->unsignedInteger('closing_balance')->nullable()->default(0);
            $table->enum('balance_type', ['c', 'd'])->default('c');
            $table->unsignedBigInteger('account_type_id')->nullable()->index();
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedBigInteger('branch_id')->nullable()->index();
            $table->unsignedInteger('company_id')->nullable();
            $table->unsignedInteger('city_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->unsignedBigInteger('updated_by')->nullable()->index();
            $table->unsignedBigInteger('deleted_by')->nullable()->index();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->string('parent_type', 191)->nullable();
            $table->unsignedTinyInteger('is_common')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledgers');
    }
};
