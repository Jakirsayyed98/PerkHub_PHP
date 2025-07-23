<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClickLogsTable extends Migration
{
    public function up()
    {
        Schema::create('click_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('subid');
            $table->string('subid2');
            $table->timestamp('clicked_at');
            $table->index(['store_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('click_logs');
    }
}