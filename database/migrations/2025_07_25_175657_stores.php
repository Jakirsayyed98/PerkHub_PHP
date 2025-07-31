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
            $table->string('icon')->nullable();
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->text('about_store')->nullable();
            $table->text('terms_and_conditions')->nullable();
            $table->string('label')->nullable();
            $table->decimal('cashback', 5, 2);
            $table->boolean('active')->default(true);
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