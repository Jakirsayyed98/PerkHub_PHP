<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawal_request', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('1')->comment('1 Cashback Withdrawal')->nullable();
            $table->string('user_id')->nullable();
            $table->string('VPA_Id')->nullable();
            $table->string('txn_id')->nullable();
            $table->string('txn_time')->nullable();
            $table->string('message')->nullable();
            $table->string('requested_withdrawal_amt')->nullable();
            $table->string('status')->comment('0 pending, 1 completed, 2 rejected')->nullable();
            $table->string('title')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdrawal_request');
    }
};
