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
        Schema::create('companies', function (Blueprint $table) {

                $table->id();
                $table->string('name', 191);
                $table->string('description', 191)->nullable();
                $table->string('ntn', 191)->nullable();
                $table->string('gst', 191)->nullable();
                $table->enum('gst_type', ['fixed', 'percentage'])->nullable();
                $table->string('vat', 191)->nullable();
                $table->string('phone', 191)->nullable();
                $table->string('fax', 191)->nullable();
                $table->string('address', 191)->nullable();
                $table->string('logo', 191)->nullable();
                $table->unsignedSmallInteger('status')->default(1);
                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();
                $table->timestamp('deleted_at')->nullable();
                $table->timestamps();

                $table->index('created_by');
                $table->index('updated_by');
                $table->index('deleted_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
