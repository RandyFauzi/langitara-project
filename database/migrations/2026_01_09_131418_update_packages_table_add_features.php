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
        Schema::table('packages', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
            $table->text('description')->nullable()->after('slug');
            $table->decimal('original_price', 12, 2)->nullable()->after('price');
            $table->json('features')->nullable()->after('max_guests');
            $table->boolean('can_publish')->default(true)->after('features');
            $table->boolean('is_featured')->default(false)->after('can_publish');
            $table->integer('sort_order')->default(0)->after('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn(['slug', 'description', 'original_price', 'features', 'can_publish', 'is_featured', 'sort_order']);
        });
    }
};
