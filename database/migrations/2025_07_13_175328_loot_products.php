<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('loot_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image_url');
            $table->decimal('price', 10, 2);
            $table->text('deal_link');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('loot_products');
    }
};
