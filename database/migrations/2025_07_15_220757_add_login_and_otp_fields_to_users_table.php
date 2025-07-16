<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('login_attempts')->default(0);
            $table->timestamp('last_failed_login_at')->nullable();
            $table->unsignedTinyInteger('otp_attempts')->default(0);
            $table->boolean('is_locked')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['login_attempts', 'last_failed_login_at', 'otp_attempts', 'is_locked']);
        });
    }
};

