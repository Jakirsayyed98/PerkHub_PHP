<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->foreignId('affiliate_provider_id')->constrained()->onDelete('restrict');
            $table->string('reference_id');
            $table->string('order_id')->nullable();
            $table->timestamp('transaction_date');
            $table->text('order_amount');
            $table->text('affiliate_commission');
            $table->text('user_commission');
            $table->decimal('user_commission_percent', 5, 2);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('subid')->nullable();
            $table->string('subid1')->nullable();
            $table->string('subid2')->nullable();
            $table->string('subid3')->nullable();
            $table->timestamps();
            $table->unique(['affiliate_provider_id', 'reference_id']);
            $table->index(['user_id', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}