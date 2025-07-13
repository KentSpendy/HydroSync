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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('order_details')->nullable(); // e.g., 5 Gallons, 3 Liters, etc.
            $table->enum('payment_status', ['paid', 'debt'])->default('paid');
            $table->decimal('amount', 10, 2);
            $table->string('delivery_group')->nullable(); // e.g., Morning Trip, Van 1
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
