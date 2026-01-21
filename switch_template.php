<?php

use App\Models\Template;
use App\Models\Invitation;

// 1. Create or Find Basic Template
$template = Template::firstOrCreate(
    ['folder_name' => 'basic'],
    [
        'name' => 'Basic Theme',
        'thumbnail_path' => 'images/templates/basic.jpg',
        'is_active' => true,
        'category' => 'Free'
    ]
);

// 2. Assign to Invitation
$invitation = Invitation::where('slug', 'the-wedding-of-sasuke-sakura-s3y3e')->first();

if ($invitation) {
    $invitation->template_id = $template->id;
    $invitation->save();
    echo "SUCCESS: Invitation '{$invitation->title}' switched to '{$template->name}' (ID: {$template->id})";
} else {
    echo "ERROR: Invitation not found.";
}
