<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Basic',
                'price' => 49000,
                'duration_days' => 30,
                'max_invitations' => 1,
                'max_guests' => 300,
                'status' => 'active',
            ],
            [
                'name' => 'Premium',
                'price' => 99000,
                'duration_days' => 90,
                'max_invitations' => 5,
                'max_guests' => 1000,
                'status' => 'active',
            ],
            [
                'name' => 'Exclusive',
                'price' => 199000,
                'duration_days' => 365,
                'max_invitations' => 20,
                'max_guests' => 3000,
                'status' => 'active',
            ],
            [
                'name' => 'White Label', // Khusus WO
                'price' => 999000,
                'duration_days' => 365,
                'max_invitations' => 100,
                'max_guests' => 10000,
                'status' => 'active', // Admin can toggle this or assign manually
            ],
        ];

        foreach ($packages as $pkg) {
            Package::updateOrCreate(['name' => $pkg['name']], $pkg);
        }
    }
}
