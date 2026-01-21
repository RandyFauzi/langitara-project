<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Template;

class BetawiHeritageTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Slug must match the folder name in resources/views/templates/
        $slug = 'betawi-heritage';

        // Check if template already exists to avoid duplicates
        if (Template::where('slug', $slug)->exists()) {
            $this->command->info("Template 'Betawi Heritage' already exists. Updating path info.");
            $t = Template::where('slug', $slug)->first();
            $t->update([
                'folder_name' => 'betawi-heritage',
                'base_path' => 'templates/betawi-heritage',
                'package_access' => 'free',
                'status' => 'active',
                'is_premium' => false,
            ]);
            return;
        }

        Template::create([
            'name' => 'Betawi Heritage v1.1',
            'slug' => $slug,
            'category' => 'Wedding',
            'folder_name' => 'betawi-heritage',
            'base_path' => 'templates/betawi-heritage',
            'package_access' => 'free',
            'preview_image_path' => null, // Placeholder or add later
            'status' => 'active',
            'is_premium' => false,
        ]);

        $this->command->info("Template 'Betawi Heritage' registered successfully.");
    }
}
