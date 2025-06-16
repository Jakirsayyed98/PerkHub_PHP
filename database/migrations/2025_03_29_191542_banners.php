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
        //  create table for banner categories
        Schema::create('banners',function(Blueprint $table){
            $table->id();
            $table->string('name')->nullable();
            $table->string('banner_category_id')->nullable();
            $table->string('image')->nullable();
            $table->string('url')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('status')->default(false);
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
        //Drop banner categories table is Exist
        Schema::dropIfExists('banners');
    }
};
