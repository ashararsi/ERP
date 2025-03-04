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
        Schema::create('account_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('number', 255)->nullable();
            $table->string('code', 255)->nullable();
            $table->unsignedInteger('level')->default(1);
            $table->unsignedBigInteger('parent_id')->default(0);
            $table->unsignedBigInteger('account_type_id')->nullable()->index();
            $table->unsignedTinyInteger('status')->default(1);
            $table->string('parent_type', 191)->nullable();
            $table->unsignedBigInteger('company_id')->nullable()->default(0);
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->unsignedBigInteger('updated_by')->nullable()->index();
            $table->unsignedBigInteger('deleted_by')->nullable()->index();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_groups');
    }
};
