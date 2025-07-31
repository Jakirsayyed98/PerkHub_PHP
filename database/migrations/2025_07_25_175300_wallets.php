<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Wallets extends Migration
{
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->primary();
            $table->text('balance')->default(encrypt(0));
            $table->text('pending')->default(encrypt(0));
            $table->text('withdrawn')->default(encrypt(0));
            $table->text('rejected')->default(encrypt(0));
            $table->text('lifetime_earnings')->default(encrypt(0));
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wallets');
    }
}