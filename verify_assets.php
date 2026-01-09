<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$renderer = app(App\Services\Template\TemplateRendererService::class);

$slug = 'gardenia-love';
$data = [
    'features' => [
        'cover' => true,
        'quote' => false,
        'couple' => true,
        'events' => true,
        'location' => false
    ],
    'meta' => [
        'title' => 'Test Wedding',
        'song_url' => 'http://example.com/song.mp3',
        'event_date' => '01 . 01 . 2026',
        'event_timestamp' => time(),
    ],
    'couple' => [
        'bride_name' => 'Juliet',
        'bride_photo' => 'https://via.placeholder.com/150',
        'groom_name' => 'Romeo',
        'groom_photo' => 'https://via.placeholder.com/150',
        'bride_parents' => 'Parents',
        'groom_parents' => 'Parents'
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
    ]
];

echo "Rendering $slug...\n";

try {
    $view = $renderer->render($slug, $data);
    $html = $view->render();

    // Checks
    if (strpos($html, '/templates/gardenia-love/assets/css/style.css') !== false) {
        echo "[PASS] CSS Link found.\n";
    } else {
        echo "[FAIL] CSS Link NOT found.\n";
        echo "Dump: " . substr($html, 0, 1000) . "\n";
    }

    if (strpos($html, '/templates/gardenia-love/assets/js/template.js') !== false) {
        echo "[PASS] JS Link found.\n";
    } else {
        echo "[FAIL] JS Link NOT found.\n";
    }

    // Check Music
    if (strpos($html, 'assets/music/') !== false && strpos($html, 'example.com') === false) {
        echo "[FAIL] Found local music path! Music should be decoupled.\n";
    } else {
        echo "[PASS] No local music path found (good).\n";
    }

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
