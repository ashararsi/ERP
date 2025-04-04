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
        Schema::create('batch_checkpoints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_process_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->foreignId('unit_id')->constrained('units');
            $table->decimal('standard_value', 10, 2);
            $table->decimal('actual_value', 10, 2)->nullable();
            $table->boolean('is_approved')->default(false);
            $table->text('notes')->nullable();
            $table->foreignId('checked_by')->nullable()->constrained('users');
            $table->timestamp('checked_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_checkpoints');
    }
};
