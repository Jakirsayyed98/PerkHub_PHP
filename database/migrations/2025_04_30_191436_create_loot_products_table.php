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
        Schema::create('loot_products', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('miniapp_id', 100)->nullable();
            $table->string('product_name', 255);
            $table->text('description')->nullable();
            $table->text('image_url')->nullable();
            $table->string('original_price');
            $table->string('discounted_price');
            $table->string('discount_percentage');
            $table->text('product_url');
            $table->string('coupon_code', 100)->nullable(); // New field
            $table->string('offer_type')->default('0')->comment('0 - offer or 1- coupon');
            $table->string('status')->default('0')->comment('1 - active or 0- inactive');
            $table->date('offer_expiry')->nullable()->comment('Last date of offer');
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loot_products');
    }
};
