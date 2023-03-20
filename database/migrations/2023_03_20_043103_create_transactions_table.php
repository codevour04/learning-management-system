<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->string('amount', 100);
            $table->text('transaction_number');
            $table->unsignedInteger('status');
            $table->foreignId('customers_id')->constrained();
            $table->foreignId('sales_agent')->constrained('users');
            $table->foreignId('pre_approver')->constrained('users');
            $table->dateTime('pre_approved_at')->nullable();
            $table->foreignId('final_approver')->constrained('users');
            $table->dateTime('final_approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
