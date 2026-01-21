<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Template;
use Illuminate\Support\Str;

class RoseGoldTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $slug = 'rose-gold';

        // Cleanup old slug if exists
        if (Template::where('slug', 'rosegold')->exists()) {
            Template::where('slug', 'rosegold')->delete();
            $this->command->info("Deleted old 'rosegold' template record.");
        }


        // Check if template already exists to avoid duplicates
        if (Template::where('slug', 'rose-gold')->exists()) {
            $this->command->info("Template 'Rose Gold' already exists. Updating path info.");
            $t = Template::where('slug', 'rose-gold')->first();
            $t->update([
                'folder_name' => 'rose-gold',
                'base_path' => 'templates/rose-gold',
            ]);
            return;
        }

        Template::create([
            'name' => 'Rose Gold',
            'slug' => 'rose-gold',
            'category' => 'Wedding',
            'folder_name' => 'rose-gold',
            'base_path' => 'templates/rose-gold',
            'package_access' => 'premium',
            'preview_image_path' => null, // Placeholder
            'status' => 'active',
            'is_premium' => true,
        ]);

        $this->command->info("Template 'Rose Gold' registered successfully.");
    }
}
