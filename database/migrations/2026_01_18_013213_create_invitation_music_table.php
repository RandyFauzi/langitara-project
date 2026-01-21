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
        Schema::create('invitation_music', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->enum('provider', ['youtube', 'spotify', 'soundcloud']);
            $table->text('url'); // Original user provided URL
            $table->text('embed_url'); // Processed embed URL
            $table->string('title')->nullable();
            $table->boolean('is_valid')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitation_music');
    }
};
