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
        // 1. Add content column to invitations
        Schema::table('invitations', function (Blueprint $table) {
            if (!Schema::hasColumn('invitations', 'content')) {
                $table->json('content')->nullable()->after('status');
            }
            // Drop payload if exists as it is redundant
            if (Schema::hasColumn('invitations', 'payload')) {
                 $table->dropColumn('payload');
            }
        });

        // 2. Drop legacy child tables
        // We drop them in reverse order of dependency if needed, but here simple drop is fine.
        Schema::dropIfExists('invitation_love_stories');
        Schema::dropIfExists('invitation_galleries');
        Schema::dropIfExists('invitation_events');
        Schema::dropIfExists('invitation_details');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We cannot easily restore data, but we can recreate tables
        // For development environment, this is acceptable.
        
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn('content');
        });

        // Recreate tables (simplified)
        // ... (Omitting full recreation as it's a consolidation migration)
    }
};
