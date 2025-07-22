<?php

// database/migrations/xxxx_xx_xx_create_otp_logs_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('otp_logs', function (Blueprint $table) {
            $table->id();

            $table->string('mobile', 15);          // Mobile number (international format ready)
            $table->string('otp', 10);             // 6-digit OTP (stored as string for leading 0s)
            $table->enum('status', ['sent', 'verified', 'expired'])->default('sent');

            $table->ipAddress('ip_address')->nullable();   // For logging IP
            $table->string('user_agent')->nullable();      // For logging device/browser

            $table->timestamps();

            $table->index('mobile'); // For faster lookup during login/verification
        });
    }

    public function down(): void {
        Schema::dropIfExists('otp_logs');
    }
};
