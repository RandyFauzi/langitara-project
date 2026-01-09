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
        // 1. Update invitations table
        Schema::table('invitations', function (Blueprint $table) {
            if (!Schema::hasColumn('invitations', 'payload')) {
                $table->json('payload')->nullable()->after('status');
            }
        });

        // 2. Create invitation_events
        Schema::create('invitation_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained('invitations')->onDelete('cascade');
            $table->string('title');
            $table->date('date');
            $table->time('time_start')->nullable();
            $table->time('time_end')->nullable();
            $table->string('location_name');
            $table->text('address');
            $table->text('map_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['invitation_id', 'sort_order']);
        });

        // 3. Create invitation_love_stories
        Schema::create('invitation_love_stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained('invitations')->onDelete('cascade');
            $table->string('year', 4); // "2020"
            $table->string('title');
            $table->text('story');
            $table->string('image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['invitation_id', 'sort_order']);
        });

        // 4. Create invitation_galleries
        Schema::create('invitation_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained('invitations')->onDelete('cascade');
            $table->string('url');
            $table->string('caption')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['invitation_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitation_galleries');
        Schema::dropIfExists('invitation_love_stories');
        Schema::dropIfExists('invitation_events');

        Schema::table('invitations', function (Blueprint $table) {
            if (Schema::hasColumn('invitations', 'payload')) {
                $table->dropColumn('payload');
            }
        });
    }
};
