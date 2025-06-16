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
        Schema::create('miniapp_data',function(Blueprint $table){
            $table->id();
            $table->string('miniapp_category_id');
            $table->string('name');
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->text('cashback_terms')->nullable();
            $table->text('cashback_rates')->nullable();
            $table->boolean('status')->default(false);
            $table->string('url_type', 50)->nullable();
            $table->boolean('cb_active')->default(false);
            $table->string('cb_percentage')->nullable();
            $table->string('url')->nullable();
            $table->string('label')->nullable();
            $table->string('banner')->nullable();
            $table->string('logo')->nullable();
            $table->string('macro_publisher')->nullable();
            $table->boolean('popular')->default(false);
            $table->boolean('trending')->default(false);
            $table->boolean('top_cashback')->default(false);
            $table->text('about')->nullable();
            $table->text('howitswork')->nullable();
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
        Schema::dropIfExists('miniapp_data');
    }
};
