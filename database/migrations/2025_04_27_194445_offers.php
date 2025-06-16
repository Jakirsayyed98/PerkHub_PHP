<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('image')->nullable();
            $table->string('end_date')->nullable();
            $table->string('url')->nullable();
            $table->string('coupon_code')->nullable();
            $table->string('type')->default('0'); // 0 = offer, 1 = coupon
            $table->string('terms')->nullable();
            $table->string('miniapp_id')->nullable();
            $table->string('status')->default('1'); // 1 = active, 0 = inactive
            $table->timestamps(); // adds created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('offers');
    }
};
