<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Stores extends Migration
{
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('affiliate_provider_id')->constrained()->onDelete('restrict');
            $table->string('store_category_id')->nullable();
            $table->string('icon')->nullable(); 
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->string('url')->nullable();
            $table->text('about_store')->nullable();
            $table->text('description')->nullable();
            $table->text('terms_and_conditions')->nullable();
            $table->text('how_its_work')->nullable();
            $table->string('label')->nullable();
            $table->string('cashback')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('status')->default(true);
            $table->boolean('cd_active')->default(true);
            $table->boolean('top_cashback')->default(false);
            $table->boolean('trending')->default(false);
            $table->boolean('popular')->default(false);
            $table->boolean('url_type')->default('1');// 1 for internam, 2 for external
            $table->foreignId('added_by_admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('deleted_by_admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stores');
    }
}