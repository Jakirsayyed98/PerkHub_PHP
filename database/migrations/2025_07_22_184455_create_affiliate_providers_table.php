<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateProvidersTable extends Migration
{
    public function up()
    {
        Schema::create('affiliate_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('callback_secret')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('affiliate_providers');
    }
}