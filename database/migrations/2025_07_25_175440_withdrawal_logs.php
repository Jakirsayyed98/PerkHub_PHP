<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WithdrawalLogs extends Migration
{
    public function up()
    {
        Schema::create('withdrawal_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('withdrawal_id')->constrained('withdrawal_requests')->onDelete('cascade');
            $table->string('action');
            $table->text('description');
            $table->timestamps();
            $table->index(['user_id', 'withdrawal_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('withdrawal_logs');
    }
}