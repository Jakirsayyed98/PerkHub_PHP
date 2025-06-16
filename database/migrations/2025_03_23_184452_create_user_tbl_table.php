<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateUserTblTable extends Migration
{
    public function up()
    {
        Schema::create('user_tbl', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->string('user_id')->nullable();   // User's Id
            $table->string('name')->nullable();   // User's name
            $table->string('email')->nullable()->unique();  // Unique email
            $table->string('number')->nullable();  // Phone number
            $table->string('address')->nullable();  // Address
            $table->date('dob')->nullable();  // Date of Birth
            $table->string('status')->default(false);  // Account status (e.g. active, inactive)
            $table->string('FCMtoken')->nullable();  // Firebase Cloud Messaging token
            $table->string('otp')->nullable();  // One-time password
            $table->timestamps();  // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_tbl');
    }
};
