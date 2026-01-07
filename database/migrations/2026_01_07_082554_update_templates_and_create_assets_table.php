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
        Schema::table('templates', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name'); // Make nullable initially to avoid errors with existing data, then can be filled
            $table->string('style')->nullable()->after('category'); // classic, modern, elegant
            $table->string('preview_image_path')->nullable()->after('style');
            $table->string('package_access')->default('free')->after('is_premium')->comment('free, premium, exclusive, wo');
            $table->json('supported_features')->nullable()->after('package_access');
            $table->string('base_path')->nullable()->after('folder_name'); // To store actual resources view path
        });

        Schema::create('template_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type'); // image, audio, icon, etc.
            $table->string('path');
            $table->string('source')->default('internal'); // internal, upload
            $table->string('license_type')->nullable();
            $table->text('license_notes')->nullable();
            $table->string('allowed_usage')->default('template-only');
            $table->unsignedBigInteger('uploader_id')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_assets');

        Schema::table('templates', function (Blueprint $table) {
            $table->dropColumn(['slug', 'style', 'preview_image_path', 'package_access', 'supported_features', 'base_path']);
        });
    }
};
