<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Template;

class BanjarHeritageTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Slug must match the folder name in resources/views/templates/
        $slug = 'banjar_heritage';

        // Check if template already exists to avoid duplicates
        if (Template::where('slug', $slug)->exists()) {
            $this->command->info("Template 'Banjar Heritage' already exists. Updating path info.");
            $t = Template::where('slug', $slug)->first();
            $t->update([
                'folder_name' => 'banjar_heritage',
                'base_path' => 'templates/banjar_heritage',
                'package_access' => 'premium',
                'status' => 'active',
                'is_premium' => true,
            ]);
            return;
        }

        Template::create([
            'name' => 'Banjar Heritage v1.1',
            'slug' => $slug,
            'category' => 'Wedding',
            'folder_name' => 'banjar_heritage',
            'base_path' => 'templates/banjar_heritage',
            'package_access' => 'premium',
            'preview_image_path' => null, // Placeholder or add later
            'status' => 'active',
            'is_premium' => true,
        ]);

        $this->command->info("Template 'Banjar Heritage' registered successfully.");
    }
}
