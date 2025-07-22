<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('amount', 12, 2);
            $table->string('upi_id');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');    
            $table->string('utr_no')->nullable(); // For UPI transfer ref
            $table->string('method'); // UPI / Bank / Wallet, etc.
            $table->json('account_details'); // Store as JSON for flexibility
            $table->text('rejected_reason')->nullable();
            $table->dateTime('requested_at')->useCurrent();
            $table->dateTime('processed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('withdrawal_requests');
    }
};
