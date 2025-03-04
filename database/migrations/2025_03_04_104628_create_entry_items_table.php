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
        Schema::create('entry_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entry_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('entry_id')->constrained('entries')->cascadeOnDelete();
            $table->foreignId('ledger_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('entry_items')->nullOnDelete();
            $table->string('parent_type', 50)->nullable();
            $table->date('voucher_date');
            $table->decimal('amount', 11, 2);
            $table->enum('dc', ['d', 'c']);
            $table->text('narration')->nullable();
            $table->string('instrument_number', 191)->nullable();
            $table->smallInteger('status')->unsigned()->default(1);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entry_items');
    }
};
