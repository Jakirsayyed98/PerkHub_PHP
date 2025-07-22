<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('logo')->nullable();      // main logo
            $table->string('icon')->nullable();      // small icon
            $table->string('banner')->nullable();    // large banner

            $table->foreignId('category_id')->constrained('store_categories')->onDelete('cascade');
            $table->foreignId('affiliate_source_id')->nullable()->constrained('affiliate_sources')->onDelete('set null');

            $table->text('url')->nullable();             // affiliate tracking link
            $table->string('cashback_percentage')->nullable(); // UI cashback info (e.g., Flat 5%)
            $table->string('label')->nullable();         // badge/label (e.g., "Hot Deal")
            $table->text('terms')->nullable();           // cashback terms and conditions
            $table->string('description')->nullable();   // short intro about the store

            $table->boolean('cashback_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('trending')->default(false);
            $table->boolean('popular')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('stores');
    }
};
