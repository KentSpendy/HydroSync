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
        Schema::table('expenses', function (Blueprint $table) {
            $table->string('description')->nullable();
            $table->enum('category', ['fuel', 'maintenance', 'others'])->default('others');
            $table->decimal('amount', 10, 2)->default(0);
            $table->date('date')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn(['description', 'category', 'amount', 'date']);
        });
    }

};
