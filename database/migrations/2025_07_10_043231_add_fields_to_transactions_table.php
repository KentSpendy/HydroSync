<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('customer_name')->after('id');
            $table->string('order_details')->nullable()->after('customer_name');
            $table->enum('payment_status', ['paid', 'debt'])->default('paid')->after('order_details');
            $table->decimal('amount', 10, 2)->after('payment_status');
            $table->string('delivery_group')->nullable()->after('amount');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'customer_name',
                'order_details',
                'payment_status',
                'amount',
                'delivery_group',
            ]);
        });
    }
};
