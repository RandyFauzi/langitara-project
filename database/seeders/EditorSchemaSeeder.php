<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Template;
use App\Models\Package;
use App\Models\Invitation;
use App\Models\InvitationDetail;
use App\Models\InvitationEvent;
use App\Models\InvitationLoveStory;
use App\Models\InvitationGallery;
use Carbon\Carbon;

class EditorSchemaSeeder extends Seeder
{
    public function run()
    {
        // Ensure dependencies exist
        $user = User::first() ?? User::factory()->create();
        $template = Template::firstOrCreate(
            ['folder_name' => 'gardenia-love'],
            ['name' => 'Gardenia Love', 'category' => 'Wedding', 'status' => 'active']
        );
        $package = Package::firstOrCreate(
            ['name' => 'Premium'],
            ['price' => 100000, 'duration_days' => 30, 'max_invitations' => 1, 'max_guests' => 100]
        );

        // Create Invitation
        $invitation = Invitation::create([
            'user_id' => $user->id,
            'template_id' => $template->id,
            'package_id' => $package->id,
            'slug' => 'romeo-juliet-preview-' . time(),
            'title' => 'The Wedding of Romeo & Juliet',
            'event_date' => '2026-10-25',
            'location' => 'Hotel Mulia',
            'status' => 'published',
            'payload' => [
                'quote' => [
                    'enabled' => true,
                    'text' => 'Love is composed of a single soul inhabiting two bodies.',
                    'source' => 'Aristotle'
                ],
                'gift' => [
                    'enabled' => true,
                    'bank_name' => 'BCA',
                    'account_number' => '1234567890',
                    'account_holder' => 'Romeo Montague'
                ],
                'rsvp' => [
                    'enabled' => true,
                    'max_guests' => 2,
                    'note' => 'Please confirm before Oct 1st'
                ]
            ]
        ]);

        // Create Detail
        InvitationDetail::create([
            'invitation_id' => $invitation->id,
            'groom_name' => 'Romeo Montague',
            'bride_name' => 'Juliet Capulet',
        ]);

        // Create Events
        InvitationEvent::create([
            'invitation_id' => $invitation->id,
            'title' => 'Akad Nikah',
            'date' => '2026-10-25',
            'time_start' => '08:00',
            'time_end' => '10:00',
            'location_name' => 'Grand Mosque',
            'address' => 'Jl. Sudirman No. 1',
            'sort_order' => 1
        ]);

        InvitationEvent::create([
            'invitation_id' => $invitation->id,
            'title' => 'Resepsi',
            'date' => '2026-10-25',
            'time_start' => '11:00',
            'time_end' => '13:00',
            'location_name' => 'Hotel Mulia',
            'address' => 'Jl. Asia Afrika',
            'sort_order' => 2
        ]);

        // Create Love Stories
        InvitationLoveStory::create([
            'invitation_id' => $invitation->id,
            'year' => '2020',
            'title' => 'First Met',
            'story' => 'We met at a coffee shop.',
            'sort_order' => 1
        ]);
        InvitationLoveStory::create([
            'invitation_id' => $invitation->id,
            'year' => '2022',
            'title' => 'Engagement',
            'story' => 'He proposed under the stars.',
            'sort_order' => 2
        ]);

        // Create Galleries
        InvitationGallery::create([
            'invitation_id' => $invitation->id,
            'url' => 'https://placehold.co/600x400',
            'caption' => 'Prewedding 1',
            'sort_order' => 1
        ]);
        InvitationGallery::create([
            'invitation_id' => $invitation->id,
            'url' => 'https://placehold.co/600x400/orange/white',
            'caption' => 'Prewedding 2',
            'sort_order' => 2
        ]);
        InvitationGallery::create([
            'invitation_id' => $invitation->id,
            'url' => 'https://placehold.co/600x400/black/white',
            'caption' => 'Prewedding 3',
            'sort_order' => 3
        ]);

        $this->command->info('Editor Schema Seeder run successfully. Slug: ' . $invitation->slug);
    }
}
