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
        Schema::create('quality_checks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('batch_id');  // Ensure correct type
            $table->unsignedBigInteger('process_id'); // Ensure correct type
            $table->string('check_type');
            $table->string('parameter');
            $table->string('standard_value');
            $table->string('actual_value');
            $table->enum('status', ['pass', 'fail']);
            $table->string('operator_initials')->nullable();
            $table->string('qa_initials')->nullable();
            $table->timestamp('checked_at')->useCurrent();
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Correct casing

            // Foreign Keys
//            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
//            $table->foreign('process_id')->references('id')->on('processes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quality_checks');
    }
};
