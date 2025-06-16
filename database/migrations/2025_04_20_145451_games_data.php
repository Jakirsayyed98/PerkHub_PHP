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
        //
        Schema::create('games',function (Blueprint $table){
            $table->id();
            $table->string('code')->nullable();
            $table->string('url')->nullable();
            $table->string('name')->nullable();
            $table->boolean('isPortrait')->default(false);
            $table->string('description')->nullable();
            $table->string('gamePreviews')->nullable();
            $table->longText('assets')->nullable();
            $table->string('categoryId')->nullable();
            $table->string('width')->nullable();
            $table->string('height')->nullable();
            $table->string('colorMuted')->nullable();
            $table->string('colorVibrant')->nullable();
            $table->boolean('privateAllowed')->default(false);
            $table->string('rating')->nullable();
            $table->string('numberOfRatings')->nullable();
            $table->string('gamePlays')->nullable();
            $table->boolean('hasIntegratedAds')->default(false);
            $table->boolean('status')->default(false);
            $table->boolean('popular')->default(false);
            $table->boolean('trending')->default(false);
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
        //
        Schema::dropIfExists('games');
    }
};
