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

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('group_id')->constrained()->onDelete('cascade');

            $table->date('period'); // Represents the month this contribution is for (e.g. 2025-09-01)

            $table->decimal('amount', 12, 2); // Allow partial amounts (e.g. 130.00)

            $table->string('transaction_code')->nullable(); // M-Pesa or bank transaction code

            $table->timestamps();

            // Ensure no duplicate full contributions for the same user/month in a group
            // This does NOT block partials unless you enforce amount = 300
            $table->unique(['user_id', 'group_id', 'period', 'transaction_code'], 'unique_user_period_transaction');
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
