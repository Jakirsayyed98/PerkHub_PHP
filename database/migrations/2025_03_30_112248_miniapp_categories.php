<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up()
    {
        Schema::create('miniapp_categories', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->string('name');  // User's name
            $table->string('description')->nullable();  // Profile color
            $table->string('image')->nullable();  // Profile color
            $table->string('status')->default(false);;  // Account status (e.g. active, inactive)
            $table->string('homepage_visible')->default(false);;  // Account status (e.g. active, inactive)
            $table->timestamps();  // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('miniapp_categories');
    }
};
