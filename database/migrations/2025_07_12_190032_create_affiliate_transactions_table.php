<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('miniapp_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Foreign references (stored as string for flexibility: UUIDs or external IDs)
            $table->string('user_id')->nullable()->comment('Affiliate user ID');
            $table->string('campaign_id')->nullable()->comment('Campaign identifier (can be alphanumeric)');
            $table->string('miniapp_id')->nullable()->comment('MiniApp identifier');

            // Financial values stored as strings for compatibility with external APIs
            $table->string('sale_amount')->nullable()->comment('Total sale amount for the transaction');
            $table->string('commission_percentage')->nullable()->comment('Commission percentage (e.g., 13%)');
            $table->string('commission')->nullable()->comment('Total commission amount earned');
            $table->string('user_commission')->nullable()->comment('Commission amount given to the user');
            $table->string('transaction_amt')->nullable()->comment('Final transaction amount');

            // Transaction metadata
            $table->string('transaction_id')->nullable()->comment('External transaction ID from network or provider');
            $table->string('transaction_date')->nullable()->comment('Date and time of transaction');
            $table->string('transaction_status')->nullable()->comment('Status of the transaction (e.g.,0- pending,1-approved, 2- rejected)');
            $table->string('reference_id')->nullable()->comment('Reference ID or unique token related to the transaction');

            // SubID tracking for affiliate attribution
            $table->string('subid')->nullable()->comment('Original subid used in callback tracking');
            $table->string('subid1')->nullable()->comment('SubID1: internal or campaign-specific');
            $table->string('subid2')->nullable()->comment('SubID2: typically user ID');
            $table->string('subid3')->nullable()->comment('SubID3: additional identifier or campaign keyword');

            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('miniapp_transactions');
    }
};
