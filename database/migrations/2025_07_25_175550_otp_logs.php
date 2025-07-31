<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OtpLogs extends Migration
{
    public function up()
    {
        Schema::create('otp_logs', function (Blueprint $table) {
            $table->id();
            $table->string('mobile', 15);
            $table->string('otp', 6);
            $table->enum('status', ['pending', 'verified'])->default('pending');
            $table->string('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('expires_at');
            $table->timestamps();
            $table->index('mobile');
        });
    }

    public function down()
    {
        Schema::dropIfExists('otp_logs');
    }
}