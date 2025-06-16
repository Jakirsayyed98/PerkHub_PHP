<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; 


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('miniapp_transaction', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('campaign_id')->nullable();
            $table->string('miniapp_id')->nullable();
            $table->string('commission')->nullable();
            $table->string('user_commission')->nullable();
            $table->string('subid1')->nullable();
            $table->string('subid2')->nullable();
            $table->string('subid3')->nullable();
            $table->string('sale_amount')->nullable();
            $table->string('commission_percentage')->nullable();
            $table->string('transaction_amt')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('transaction_date')->nullable();
            $table->string('transaction_status')->nullable();
            $table->string('reference_id')->nullable();
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
        //
        Schema::dropIfExists('miniapp_transaction');
    }
};




