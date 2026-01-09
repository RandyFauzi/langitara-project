<?php

namespace App\Services\Invitation;

use App\Models\Invitation;

class InvitationDataBuilderService
{
    /**
     * Build the TemplateDataContract array from the Invitation model.
     *
     * @param Invitation $invitation
     * @return array
     */
    public function build(Invitation $invitation): array
    {
        // 1. Resolve Data Sources
        // Ensure relations are loaded
        $invitation->loadMissing(['detail', 'events', 'loveStories', 'galleries', 'song']);

        // 2. Build Meta
        $meta = [
            'title' => $invitation->title,
            'slug' => $invitation->slug,
            'event_date' => $invitation->event_date ? $invitation->event_date->format('Y-m-d') : null,
            'event_timestamp' => $invitation->event_date ? $invitation->event_date->timestamp : null,
            'location' => $invitation->location,
            'song_url' => $invitation->song ? $invitation->song->file_path : null, // Assumed file_path
        ];

        // 3. Build Couple (from Detail)
        $couple = [];
        if ($invitation->detail) {
            $couple = [
                'groom' => $invitation->detail->groom_name,
                'bride' => $invitation->detail->bride_name,
                // Add extended fields if/when they exist
            ];
        }

        // 4. Build Components from Relations & Payload
        $events = $invitation->events->map(function ($event) {
            return [
                'title' => $event->title,
                'date' => $event->date ? $event->date->format('Y-m-d') : null,
                'time_start' => $event->time_start,
                'time_end' => $event->time_end,
                'location_name' => $event->location_name,
                'address' => $event->address,
                'map_url' => $event->map_url
            ];
        })->toArray();

        $love_story = $invitation->loveStories->map(function ($story) {
            return [
                'year' => $story->year,
                'title' => $story->title,
                'story' => $story->story,
                'image' => $story->image
            ];
        })->toArray();

        $gallery = $invitation->galleries->map(function ($item) {
            // Contract usually expects array of strings, or logic to handle object.
            // For now, let's map to object if contract supports it or simplify.
            // Assumption: Template handles object structure or simple url.
            // Let's standardise to object for future proofing if allowed, OR simple array if strict.
            // If template strict array of strings: return $item->url;
            return [
                'url' => $item->url,
                'caption' => $item->caption
            ];
        })->toArray();

        // Payload Handling
        $payload = $invitation->payload ?? [];
        $quotes = $payload['quote'] ?? [];
        $gift = $payload['gift'] ?? [];
        $rsvp = $payload['rsvp'] ?? [];
        $wishes = []; // Usually fetched from a different relation or API

        // 5. Feature Flags (Logic-based resolution)
        // Templates must NEVER guess. We tell them what is active.
        $features = [
            'cover' => true,
            'quote' => ($quotes['enabled'] ?? false) && !empty($quotes['text']),
            'gallery' => !empty($gallery),
            'events' => !empty($events),
            'love_story' => !empty($love_story),
            'wishes' => true,
            'rsvp' => ($rsvp['enabled'] ?? false),
            'gift' => ($gift['enabled'] ?? false),
            'music' => !is_null($invitation->song_id) || !empty($meta['song_url']),
        ];

        // 6. Construct Final Contract
        return [
            'meta' => $meta,
            'features' => $features,
            'couple' => $couple,
            'quote' => $quotes,
            'events' => $events,
            'love_story' => $love_story,
            'gallery' => $gallery,
            'location' => [
                'address' => $invitation->location,
                // map_embed could be stored in meta or inferred
                'map_url' => null,
            ],
            'gift' => $gift,
            'rsvp' => $rsvp,
            'wishes' => $wishes,
        ];
    }
}
