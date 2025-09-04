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
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('group_id')->constrained()->onDelete('cascade');

            // Payment info
            $table->decimal('amount', 12, 2);
            $table->date('contribution_date')->nullable(); // when contribution was made
            $table->string('transaction_code')->unique();  // e.g., M-Pesa code

            // Optional: if using multiple payment methods
            $table->string('payment_method')->default('mpesa'); // e.g., 'mpesa', 'bank', 'manual'

            // Optional: extra notes
            $table->text('notes')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
