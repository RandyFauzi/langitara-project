<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;
use App\Models\Template;
use App\Models\Admin;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@langitara.com',
            'password' => bcrypt('password'),
            'role' => 'super_admin',
        ]);

        // Packages
        Package::create([
            'name' => 'Free',
            'price' => 0,
            'duration_days' => 3,
            'max_invitations' => 1,
            'max_guests' => 50,
            'status' => 'active',
        ]);
        Package::create([
            'name' => 'Premium',
            'price' => 99000,
            'duration_days' => 180,
            'max_invitations' => 1,
            'max_guests' => 9999,
            'status' => 'active',
        ]);
        Package::create([
            'name' => 'Exclusive',
            'price' => 249000,
            'duration_days' => 36500,
            'max_invitations' => 1,
            'max_guests' => 9999,
            'status' => 'active',
        ]);

        // Templates
        Template::create([
            'name' => 'Gardenia Love',
            'category' => 'Floral',
            'folder_name' => 'gardenia',
            'is_premium' => true,
            'status' => 'active',
        ]);

        Template::create([
            'name' => 'Modern Ivory',
            'category' => 'Minimalist',
            'folder_name' => 'ivory',
            'is_premium' => true,
            'status' => 'active',
        ]);

        Template::create([
            'name' => 'Ocean Blue',
            'category' => 'Nature',
            'folder_name' => 'ocean',
            'is_premium' => true,
            'status' => 'active',
        ]);

        // --- DASHBOARD FAKE DATA ---

        // 1. Create Users
        $users = User::factory(5)->create();

        // 2. Create Invitations & Orders
        foreach ($users as $index => $user) {
            $invitation = \App\Models\Invitation::create([
                'user_id' => $user->id,
                'template_id' => 1, // Gardenia
                'package_id' => 2, // Premium
                'slug' => 'wedding-' . $user->id . '-' . rand(100, 999),
                'title' => 'The Wedding of ' . $user->name,
                'event_date' => now()->addDays(rand(10, 60)),
                'location' => 'Grand Ballroom',
                'status' => $index < 3 ? 'published' : 'draft', // 3 published, 2 draft
            ]);

            // Create Order
            \App\Models\Order::create([
                'user_id' => $user->id,
                'invitation_id' => $invitation->id,
                'package_id' => 2,
                'amount' => 99000,
                'payment_status' => $index < 3 ? 'paid' : 'pending',
            ]);

            // Create Guests & RSVPs
            if ($invitation->status === 'published') {
                for ($i = 0; $i < 5; $i++) {
                    $guest = \App\Models\Guest::create([
                        'invitation_id' => $invitation->id,
                        'name' => 'Guest ' . $i . ' for ' . $user->name,
                    ]);

                    \App\Models\Rsvp::create([
                        'guest_id' => $guest->id,
                        'attendance' => ['hadir', 'tidak', 'ragu'][rand(0, 2)],
                        'pax' => rand(1, 2),
                    ]);
                }
            }
        }

        // 3. Activity Logs
        \App\Models\ActivityLog::create(['actor_type' => 'user', 'actor_id' => 1, 'action' => 'Registered new account']);
        \App\Models\ActivityLog::create(['actor_type' => 'user', 'actor_id' => 1, 'action' => 'Created invitation Draft']);
        \App\Models\ActivityLog::create(['actor_type' => 'admin', 'actor_id' => 1, 'action' => 'Approved payment #ORD-001']);
        \App\Models\ActivityLog::create(['actor_type' => 'user', 'actor_id' => 2, 'action' => 'Submitted RSVP']);
    }
}
