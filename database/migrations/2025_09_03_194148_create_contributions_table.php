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

            $table->date('period'); // e.g. 2025-01-01, 2025-02-01
            $table->decimal('amount', 12, 2);

            $table->string('transaction_code'); // M-Pesa or bank transaction code

            // Optional: track which month(s) this payment covers, but better in ContributionPeriod
            $table->date('starting_period')->nullable();

            $table->timestamps();

            $table->unique(['user_id', 'group_id', 'period']); // prevent double entry for the same month
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
