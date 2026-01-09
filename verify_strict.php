<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;
use App\Services\Template\TemplateRendererService;

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$slug = 'gardenia-love';

// Complete Mock Data to prevent "Undefined index" errors
$data = [
    'features' => [
        'cover' => true,
        'quote' => true,
        'couple' => true,
        'love_story' => true,
        'carousel' => true,
        'events' => true,
        'countdown' => true,
        'location' => true,
        'gallery' => true,
        'rsvp' => true,
        'gift' => true,
        'wishes' => true,
        'closing' => true,
    ],
    'meta' => [
        'title' => 'Test Wedding',
        'song_url' => 'http://example.com/song.mp3',
        'event_date' => '01 . 01 . 2026',
        'event_timestamp' => time() + 86400,
        'cover_image' => 'https://via.placeholder.com/800',
    ],
    'couple' => [
        'bride_name' => 'Juliet',
        'bride_photo' => 'https://via.placeholder.com/150',
        'bride_parents' => 'Mr and Mrs Capulet',
        'bride_instagram' => 'juliet',
        'groom_name' => 'Romeo',
        'groom_photo' => 'https://via.placeholder.com/150',
        'groom_parents' => 'Mr and Mrs Montague',
        'groom_instagram' => 'romeo',
    ],
    'quote' => [
        'text' => 'Love is all you need.',
        'source' => 'The Beatles',
    ],
    'love_story' => [
        ['year' => '2020', 'title' => 'Met', 'story' => 'We met.'],
    ],
    'gallery' => [
        'https://via.placeholder.com/150',
        'https://via.placeholder.com/150',
    ],
    'events' => [
        [
            'title' => 'Akad',
            'date_label' => 'Sat',
            'time_label' => '08:00',
            'location_name' => 'Mosque',
            'address' => 'Street',
            'map_url' => '#'
        ]
    ],
    'location' => [
        'name' => 'Venue Name',
        'address' => 'Venue Address',
        'map_embed' => 'https://google.com',
    ],
    'gift' => [
        'bank_name' => 'BCA',
        'account_number' => '1234567890',
        'account_holder' => 'Romeo',
    ],
    'wishes' => [
        ['name' => 'Friend', 'message' => 'Congrats!', 'initials' => 'F', 'time' => 'Now'],
    ],
    'rsvp' => [
        'action' => '#',
    ]
];

echo "Rendering $slug with STRICT DATA MODE...\n";

try {
    $renderer = app(TemplateRendererService::class);
    $html = $renderer->render($slug, $data);

    // Verify critical legacy artifacts are GONE
    if (strpos($html, '$features') !== false) {
        throw new Exception("FAIL: Found unparsed \$features variable.");
    }

    // Verify content exists
    if (strpos($html, 'Juliet') === false) {
        throw new Exception("FAIL: Data 'Juliet' not found in rendered HTML.");
    }

    // Verify Asset Paths (from previous task)
    if (strpos($html, '/assets/css/style.css') === false) {
        throw new Exception("FAIL: Asset path not found.");
    }

    echo "SUCCESS: Template rendered correctly with strict data.\n";

} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
    exit(1);
}
