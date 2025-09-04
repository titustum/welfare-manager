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
        Schema::create('contribution_periods', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            
            $table->date('period'); // e.g. '2025-09-01', always first day of month
            
            $table->decimal('amount_due', 12, 2)->default(300); // expected monthly amount
            $table->decimal('amount_paid', 12, 2)->default(0);  // how much paid for this month
            
            $table->boolean('paid')->default(false); // if fully paid
            
            $table->timestamps();

            $table->unique(['user_id', 'group_id', 'period'], 'unique_user_group_period');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contribution_periods');
    }
};
