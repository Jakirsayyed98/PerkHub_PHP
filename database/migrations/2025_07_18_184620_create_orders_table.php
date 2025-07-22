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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('store_id')->nullable();
        $table->string('affiliate_source')->nullable();
        $table->string('reference_id')->nullable();
        $table->string('order_id')->nullable();
        $table->timestamp('transaction_date')->nullable();
        $table->decimal('order_amount', 10, 2)->nullable();
        $table->decimal('affiliate_commission', 10, 2)->nullable();
        $table->decimal('user_commission', 10, 2)->nullable();
        $table->decimal('user_commission_percent', 5, 2)->nullable();
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->string('subid')->nullable();
        $table->string('subid1')->nullable();
        $table->string('subid2')->nullable();
        $table->string('subid3')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
