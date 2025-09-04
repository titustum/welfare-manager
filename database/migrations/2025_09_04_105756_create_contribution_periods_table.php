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

            $table->foreignId('contribution_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('group_id')->constrained()->onDelete('cascade');

            $table->unsignedTinyInteger('month'); // 1–12
            $table->unsignedSmallInteger('year');
            $table->decimal('amount', 12, 2)->default(300);

            $table->timestamps();

            $table->unique(['user_id', 'group_id', 'month', 'year']);
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
