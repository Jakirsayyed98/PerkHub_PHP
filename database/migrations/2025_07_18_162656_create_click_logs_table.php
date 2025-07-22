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
        Schema::create('click_logs', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('store_id');
    $table->string('user_id')->nullable();
    $table->string('subid')->nullable();
    $table->string('subid2')->nullable();
    $table->timestamp('clicked_at');
    $table->timestamps();

    $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('click_logs');
    }
};
