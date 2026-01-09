<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeTemplateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:template {slug : The unique slug of the template (e.g., ocean-blue)} {name : The display name of the template}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new template skeleton with standard structure in Langitara.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $slug = Str::kebab($this->argument('slug'));
        $name = $this->argument('name');

        $basePath = resource_path("views/templates/{$slug}");

        // 1. Validate Uniqueness (Idempotency check / Safety)
        if (File::exists($basePath)) {
            $this->error("Template with slug '{$slug}' already exists at: {$basePath}");
            return 1;
        }

        $this->info("Creating template '{$name}' with slug '{$slug}'...");

        // 2. Create Directory Structure
        $directories = [
            $basePath,
            "$basePath/sections",
            "$basePath/assets/css",
            "$basePath/assets/js",
            "$basePath/assets/images",
            "$basePath/assets/icons",
        ];

        foreach ($directories as $dir) {
            File::makeDirectory($dir, 0755, true);
            $this->line("Created directory: " . str_replace(resource_path('views/'), '', $dir));
        }

        // 3. Generate Files
        $this->generateConfig($basePath, $name);
        $this->generateLayout($basePath, $slug);
        $this->generateAssets($basePath);
        $this->generateIndex($basePath, $slug);
        $this->generateSections($basePath, $slug);

        $this->info("Template skeleton created successfully!");
        $this->info("Location: " . str_replace(resource_path('views/'), '', $basePath));

        return 0;
    }

    protected function generateConfig(string $basePath, string $name)
    {
        $config = [
            "template_name" => $name,
            "category" => "General",
            "style" => "Modern",
            "supported_sections" => [
                "cover",
                "quote",
                "couple",
                "love_story",
                "events",
                "countdown",
                "location",
                "gallery",
                "rsvp",
                "gift",
                "wishes",
                "closing"
            ],
            "supported_features" => [
                "music" => true,
                "countdown" => true,
                "rsvp" => true,
                "gift" => true,
                "gallery" => true
            ]
        ];

        File::put("$basePath/config.json", json_encode($config, JSON_PRETTY_PRINT));
        $this->line("Created config.json");
    }

    protected function generateLayout(string $basePath, string $slug)
    {
        $stub = <<<'blade'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['meta']['title'] ?? 'Invitation' }}</title>
    <meta name="description" content="{{ $data['meta']['description'] ?? '' }}">
    
    {{-- Fonts & Styles --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ $data['__template']['asset_path'] }}/css/style.css">
</head>
<body class="antialiased text-gray-800 bg-white">
    
    {{-- Main Content Injection --}}
    @yield('content')

    <script src="{{ $data['__template']['asset_path'] }}/js/template.js" defer></script>

</body>
</html>
blade;

        File::put("$basePath/layout.blade.php", $stub);
        $this->line("Created layout.blade.php");
    }

    protected function generateIndex(string $basePath, string $slug)
    {
        $stub = <<<blade
@extends('templates.{$slug}.layout')

@section('content')

    {{-- 
      Template: {$slug}
      Philosophy: Template = Blueprint. Logic free.
    --}}

    @if(\$data['features']['cover'] ?? false)
        @include('templates.{$slug}.sections.cover')
    @endif

    @if(\$data['features']['quote'] ?? false)
        @include('templates.{$slug}.sections.quote')
    @endif

    @if(\$data['features']['couple'] ?? false)
        @include('templates.{$slug}.sections.couple')
    @endif

    @if(\$data['features']['love_story'] ?? false)
        @include('templates.{$slug}.sections.love_story')
    @endif

    @if(\$data['features']['events'] ?? false)
        @include('templates.{$slug}.sections.events')
    @endif

    @if(\$data['features']['countdown'] ?? false)
        @include('templates.{$slug}.sections.countdown')
    @endif

    @if(\$data['features']['location'] ?? false)
        @include('templates.{$slug}.sections.location')
    @endif

    @if(\$data['features']['gallery'] ?? false)
        @include('templates.{$slug}.sections.gallery')
    @endif

    @if(\$data['features']['rsvp'] ?? false)
        @include('templates.{$slug}.sections.rsvp')
    @endif

    @if(\$data['features']['gift'] ?? false)
        @include('templates.{$slug}.sections.gift')
    @endif

    @if(\$data['features']['wishes'] ?? false)
        @include('templates.{$slug}.sections.wishes')
    @endif

    @if(\$data['features']['closing'] ?? false)
        @include('templates.{$slug}.sections.closing')
    @endif

@endsection
blade;

        File::put("$basePath/index.blade.php", $stub);
        $this->line("Created index.blade.php");
    }

    protected function generateSections(string $basePath, string $slug)
    {
        $sections = [
            'cover' => 'Section: Cover',
            'quote' => 'Section: Quote',
            'couple' => 'Section: Couple',
            'love_story' => 'Section: Love Story',
            'events' => 'Section: Events',
            'countdown' => 'Section: Countdown',
            'location' => 'Section: Location',
            'gallery' => 'Section: Gallery',
            'rsvp' => 'Section: RSVP',
            'gift' => 'Section: Gift',
            'wishes' => 'Section: Wishes',
            'closing' => 'Section: Closing',
        ];

        foreach ($sections as $key => $title) {
            $stub = <<<blade
<section id="{$key}" class="py-10">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-2xl font-bold mb-4">{$title}</h2>
        <p class="text-gray-600">
            {{-- Access data safely via \$data variable conforming to TemplateDataContract --}}
            {{-- Example: {{ \$data['meta']['title'] ?? '' }} --}}
        </p>
    </div>
</section>
blade;
            File::put("$basePath/sections/{$key}.blade.php", $stub);
        }
        $this->line("Created all section stubs.");
    }

    protected function generateAssets(string $basePath)
    {
        // CSS
        $cssStub = "/* Template Specific Styles */\nbody {\n    /* Add your styles here */\n}";
        File::put("$basePath/assets/css/style.css", $cssStub);

        // JS
        $jsStub = "// Template Specific Scripts\nconsole.log('Template loaded');";
        File::put("$basePath/assets/js/template.js", $jsStub);

        // Gitkeeps
        File::put("$basePath/assets/images/.gitkeep", "");
        File::put("$basePath/assets/icons/.gitkeep", "");

        $this->line("Created asset stubs (css, js, images, icons).");
    }
}
