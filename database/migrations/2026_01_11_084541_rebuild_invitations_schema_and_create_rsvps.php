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
        // 0. Disable Constraints
        Schema::disableForeignKeyConstraints();

        // 1. Safely Drop Old Tables (and potential legacies)
        Schema::dropIfExists('invitation_love_stories');
        Schema::dropIfExists('invitation_galleries');
        Schema::dropIfExists('invitation_events');
        Schema::dropIfExists('invitation_details');
        
        Schema::dropIfExists('rsvps');
        Schema::dropIfExists('invitations');

        // 2. Create New Invitations Table
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('template_id')->nullable(); 
            $table->unsignedBigInteger('package_id')->nullable();  
            $table->string('slug')->unique();
            $table->string('title');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->json('active_sections')->nullable();
            
            // Bride & Groom
            $table->string('groom_name')->nullable();
            $table->string('groom_nickname')->nullable();
            $table->string('groom_father')->nullable();
            $table->string('groom_mother')->nullable();
            $table->string('groom_photo')->nullable();
            
            $table->string('bride_name')->nullable();
            $table->string('bride_nickname')->nullable();
            $table->string('bride_father')->nullable();
            $table->string('bride_mother')->nullable();
            $table->string('bride_photo')->nullable();

            // Assets
            $table->string('cover_image')->nullable();
            $table->string('music_path')->nullable();

            // Quote
            $table->text('quote_text')->nullable();
            $table->string('quote_author')->nullable();

            // Event Akad
            $table->dateTime('akad_date')->nullable();
            $table->text('akad_location')->nullable();
            $table->text('akad_address')->nullable();
            $table->text('akad_map_link')->nullable();

            // Event Resepsi
            $table->dateTime('resepsi_date')->nullable();
            $table->text('resepsi_location')->nullable();
            $table->text('resepsi_address')->nullable();
            $table->text('resepsi_map_link')->nullable();

            // JSON Lists
            $table->json('love_stories')->nullable();
            $table->json('gallery_photos')->nullable();
            $table->json('bank_accounts')->nullable();

            // Gift
            $table->text('gift_address')->nullable();

            $table->timestamps();
        });

        // 3. Create RSVPs Table
        Schema::create('rsvps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained('invitations')->onDelete('cascade');
            $table->string('name');
            $table->integer('amount')->default(1);
            $table->enum('status', ['hadir', 'tidak_hadir', 'ragu'])->default('hadir');
            $table->text('message')->nullable();
            $table->timestamps();
        });

        // 4. Re-enable Constraints
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rsvps');
        Schema::dropIfExists('invitations');
    }
};
