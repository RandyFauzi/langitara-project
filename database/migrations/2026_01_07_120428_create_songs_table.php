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
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->string('artist', 150)->nullable();
            $table->string('category', 50)->nullable(); // romantic, classical, modern
            $table->string('file_path'); // path relative to public/assets/music/

            $table->integer('duration')->nullable(); // in seconds

            $table->boolean('is_premium')->default(false);
            $table->enum('min_package_level', ['free', 'basic', 'premium', 'exclusive'])->default('free');
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
