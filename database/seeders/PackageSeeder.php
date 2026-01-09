<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear existing packages
        Package::truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $packages = [
            [
                'name' => 'Free',
                'slug' => 'free',
                'description' => 'Coba gratis tanpa biaya',
                'price' => 0,
                'original_price' => null,
                'duration_days' => 0,
                'max_invitations' => 1,
                'max_guests' => 50,
                'features' => json_encode([
                    '1 Undangan',
                    'Akses Template Basic',
                    'Tidak Bisa Publish',
                ]),
                'can_publish' => false,
                'is_featured' => false,
                'sort_order' => 1,
                'status' => 'active',
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium',
                'description' => 'Paket terlaris untuk acara spesial',
                'price' => 49500,
                'original_price' => 80000,
                'duration_days' => 14,
                'max_invitations' => 1,
                'max_guests' => 999999,
                'features' => json_encode([
                    '1 Undangan',
                    'Unlimited Tamu',
                    'Music Digital',
                    'Amplop Digital',
                    'Template Premium',
                    'Durasi Aktivasi: 14 hari',
                ]),
                'can_publish' => true,
                'is_featured' => true,
                'sort_order' => 2,
                'status' => 'active',
            ],
            [
                'name' => 'Exclusive',
                'slug' => 'exclusive',
                'description' => 'Fitur lengkap untuk acara istimewa',
                'price' => 89000,
                'original_price' => 100000,
                'duration_days' => 30,
                'max_invitations' => 1,
                'max_guests' => 999999,
                'features' => json_encode([
                    '1 Undangan',
                    'Unlimited Tamu',
                    'Music Digital',
                    'Amplop Digital',
                    'Template Premium + Exclusive',
                    'Durasi Aktivasi: 30 hari',
                ]),
                'can_publish' => true,
                'is_featured' => false,
                'sort_order' => 3,
                'status' => 'active',
            ],
            [
                'name' => 'Super Exclusive',
                'slug' => 'super-exclusive',
                'description' => 'Paket super lengkap untuk multiple event',
                'price' => 199000,
                'original_price' => 220000,
                'duration_days' => 60,
                'max_invitations' => 3,
                'max_guests' => 999999,
                'features' => json_encode([
                    '3 Undangan',
                    'Unlimited Tamu',
                    'Music Digital',
                    'Amplop Digital',
                    'Template Premium + Exclusive',
                    'Durasi Aktivasi: 60 hari',
                    'Selfie Check-in (coming soon)',
                ]),
                'can_publish' => true,
                'is_featured' => false,
                'sort_order' => 4,
                'status' => 'active',
            ],
            [
                'name' => 'Partnership',
                'slug' => 'partnership',
                'description' => 'Solusi untuk vendor & bisnis wedding',
                'price' => 5000000,
                'original_price' => null,
                'duration_days' => 365,
                'max_invitations' => 999999,
                'max_guests' => 999999,
                'features' => json_encode([
                    'White Label: Branding Anda sendiri',
                    'Undangan Digital Custom',
                    'Unlimited Undangan',
                    'Multiple Guests (500+ per event)',
                    'Integrasi Tambahan (CRM)',
                    'Selfie Check-in (coming soon)',
                    'Pelaporan & Analitik',
                    'Dedicated Support',
                ]),
                'can_publish' => true,
                'is_featured' => false,
                'sort_order' => 5,
                'status' => 'active',
            ],
        ];

        foreach ($packages as $package) {
            DB::table('packages')->insert(array_merge($package, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
