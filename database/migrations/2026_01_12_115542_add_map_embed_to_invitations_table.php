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
        Schema::table('invitations', function (Blueprint $table) {
            $table->text('akad_map_embed')->nullable()->after('akad_map_link');
            $table->text('resepsi_map_embed')->nullable()->after('resepsi_map_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn(['akad_map_embed', 'resepsi_map_embed']);
        });
    }
};
