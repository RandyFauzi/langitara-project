<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Package;
use App\Models\Invitation;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have users and packages
        if (User::count() == 0) {
            User::factory(10)->create();
        }

        // Ensure invitations exist/create some dummy relations is complicated without logic, 
        // so we will just link to random users and packages, and nullable invitations if none exist.

        $users = User::all();
        $packages = Package::all();

        if ($packages->isEmpty()) {
            $this->call(PackageSeeder::class);
            $packages = Package::all();
        }

        // Create 50 dummy orders
        for ($i = 0; $i < 50; $i++) {
            $user = $users->random();
            $package = $packages->random();
            $status = fake()->randomElement(['pending', 'paid', 'failed', 'paid', 'paid']); // higher chance for paid

            // Try to find an invitation for this user, or null
            // For seeding purposes, we won't strictly enforce invitation ownership if it's too complex, 
            // but let's try to be consistent if possible.
            // Since we don't have invitation factory here easily accessible or verified, we assume null for now 
            // OR create one if we want valid data.
            // Let's keep it null for simplicity unless we want to seed invitations too.

            Order::create([
                'user_id' => $user->id,
                'invitation_id' => null, // Simplified for this seeder to avoid constraint errors
                'package_id' => $package->id,
                'amount' => $package->price,
                'payment_status' => $status,
                'created_at' => fake()->dateTimeBetween('-3 months', 'now'),
            ]);
        }
    }
}
