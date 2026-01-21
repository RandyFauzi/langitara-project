<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->string('groom_name')->nullable()->after('title');
            $table->string('bride_name')->nullable()->after('groom_name');
            $table->string('groom_nickname')->nullable()->after('bride_name');
            $table->string('bride_nickname')->nullable()->after('groom_nickname');
            $table->string('cover_image')->nullable()->after('bride_nickname');
            $table->string('music_path')->nullable()->after('cover_image');
            $table->string('theme_category')->default('basic')->after('music_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn([
                'groom_name', 
                'bride_name', 
                'groom_nickname', 
                'bride_nickname', 
                'cover_image', 
                'music_path', 
                'theme_category'
            ]);
        });
    }
};
