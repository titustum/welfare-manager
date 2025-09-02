<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_benefit_requests_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBenefitRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('benefit_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('benefit_type_id')->constrained()->onDelete('cascade');
            $table->date('event_date');
            $table->string('relationship')->nullable();
            $table->string('supporting_documents')->nullable();
            $table->decimal('amount_requested', 10, 2);
            $table->enum('status', ['pending', 'approved', 'rejected', 'paid'])->default('pending');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('benefit_requests');
    }
}