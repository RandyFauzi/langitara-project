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
        // Drop if exists to avoid conflicts with legacy data
        Schema::dropIfExists('guests');

        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained('invitations')->onDelete('cascade');
            $table->string('name');
            $table->enum('category', ['family', 'friend', 'colleague', 'vip'])->default('friend');
            $table->string('phone_number')->nullable();
            $table->string('slug')->unique(); // Unique token for tracking
            $table->enum('status', ['pending', 'sent', 'opened'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
