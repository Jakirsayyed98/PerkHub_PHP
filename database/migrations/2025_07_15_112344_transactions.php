<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('store_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('set null');

            // Affiliate Info
            $table->string('affiliate_source')->nullable();   // e.g., cuelinks
            $table->string('reference_id')->nullable();       // affiliate transaction ID
            $table->string('order_id')->nullable();           // unique order ID (from client or affiliate)
            $table->timestamp('transaction_date')->nullable();

            // Financial Info
            $table->decimal('order_amount', 10, 2)->nullable();
            $table->decimal('affiliate_commission', 10, 2)->nullable();
            $table->decimal('user_commission', 10, 2)->nullable();
            $table->decimal('user_commission_percent', 5, 2)->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            // SubIDs for tracking
            $table->string('subid')->nullable();
            $table->string('subid1')->nullable();
            $table->string('subid2')->nullable();
            $table->string('subid3')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('transactions');
    }
};
