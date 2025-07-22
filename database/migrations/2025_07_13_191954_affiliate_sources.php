<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('affiliate_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., Cuelinks, EarnKaro
            $table->string('base_url')->nullable(); // optional, for display
            $table->string('callback_url')->nullable(); // your callback endpoint
            $table->string('tracking_param')->default('subid'); // subid, subid1, etc.
            $table->boolean('status')->default(true); // is this affiliate active
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('affiliate_sources');
    }
};
