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
        Schema::create('affiliatecommision_setting', function (Blueprint $table) {
            $table->id();
            $table->string('Affiliate_name')->nullable();
            $table->string('user_commision')->nullable();
            $table->string('API_KEY')->nullable();
            $table->string('channel_name')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('affiliatecommision_setting');
    }
};
