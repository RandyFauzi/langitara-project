<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promo;

class PromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $promos = [
            [
                'title' => 'Opening Sale Special',
                'description' => 'Diskon spesial grand opening Langitara untuk semua paket.',
                'code' => 'OPENING50',
                'discount_type' => 'percentage',
                'discount_value' => 50,
                'target_packages' => ['all'],
                'start_date' => now()->subDays(1),
                'end_date' => now()->addDays(30),
                'status' => 'active',
                'image_path' => null, // Or a path to a real sample image if available
            ],
            [
                'title' => 'Potongan 20 Ribu',
                'description' => 'Potongan langsung untuk pengguna baru.',
                'code' => 'HEMAT20',
                'discount_type' => 'fixed',
                'discount_value' => 20000,
                'target_packages' => ['all'],
                'start_date' => now(),
                'end_date' => now()->addDays(14),
                'status' => 'active',
                'image_path' => null,
            ],
            [
                'title' => 'Exclusive Wedding Season',
                'description' => 'Upgrade ke paket Exclusive lebih hemat.',
                'code' => 'LUXURYWED',
                'discount_type' => 'percentage',
                'discount_value' => 30,
                'target_packages' => ['all'], // Logic could refine this
                'start_date' => now(),
                'end_date' => now()->addMonths(1),
                'status' => 'inactive',
                'image_path' => null,
            ],
        ];

        foreach ($promos as $promo) {
            Promo::updateOrCreate(['code' => $promo['code']], $promo);
        }
    }
}
