<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('package_id')->constrained()->onDelete('cascade');
            $table->string('order_id')->unique(); // Midtrans order ID
            $table->string('transaction_id')->nullable(); // Midtrans transaction ID
            $table->enum('status', ['pending', 'active', 'expired', 'cancelled'])->default('pending');
            $table->decimal('amount', 12, 2);
            $table->string('payment_type')->nullable(); // e.g., gopay, bank_transfer
            $table->timestamp('paid_at')->nullable();
            $table->date('expiry_date')->nullable();
            $table->json('midtrans_response')->nullable(); // Store full response for reference
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_packages');
    }
};
