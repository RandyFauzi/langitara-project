<?php

namespace App\Services\Invitation;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class EditorStateValidator
{
    /**
     * Validate the Editor Schema v1 structure.
     *
     * @param array $data
     * @return array
     * @throws ValidationException
     */
    public function validate(array $data): array
    {
        $validator = Validator::make($data, [
            // Meta
            'meta' => 'required|array',
            'meta.title' => 'required|string|max:255',
            'meta.description' => 'nullable|string',
            'meta.event_date' => 'required|date',
            'meta.event_time' => 'required|date_format:H:i:s', // Strict casting expected
            'meta.timezone' => 'required|string',

            // Couple
            'couple' => 'required|array',
            'couple.bride' => 'required|array',
            'couple.bride.name' => 'required|string',
            'couple.bride.full_name' => 'nullable|string',
            'couple.bride.parents' => 'nullable|string',
            'couple.bride.photo' => 'nullable|string',
            'couple.bride.instagram' => 'nullable|string',

            'couple.groom' => 'required|array',
            'couple.groom.name' => 'required|string',
            'couple.groom.full_name' => 'nullable|string',
            'couple.groom.parents' => 'nullable|string',
            'couple.groom.photo' => 'nullable|string',
            'couple.groom.instagram' => 'nullable|string',

            // Quote (Optional Config)
            'quote' => 'nullable|array',
            'quote.enabled' => 'boolean',
            'quote.text' => 'nullable|string',
            'quote.source' => 'nullable|string',

            // Events (Repeatable)
            'events' => 'required|array|min:1',
            'events.*.id' => 'nullable|integer', // null for new
            'events.*.title' => 'required|string',
            'events.*.date' => 'required|date',
            'events.*.time_start' => 'nullable|date_format:H:i', // HH:MM
            'events.*.time_end' => 'nullable|date_format:H:i',
            'events.*.location_name' => 'required|string',
            'events.*.address' => 'required|string',
            'events.*.map_url' => 'nullable|string',

            // Love Story (Optional)
            'love_story' => 'nullable|array',
            'love_story.*.id' => 'nullable|integer',
            'love_story.*.year' => 'required|string',
            'love_story.*.title' => 'required|string',
            'love_story.*.story' => 'required|string',
            'love_story.*.image' => 'nullable|string',

            // Gallery
            'gallery' => 'nullable|array',
            'gallery.*.url' => 'required|string',
            'gallery.*.caption' => 'nullable|string',

            // Location (Primary)
            'location' => 'required|array',
            'location.name' => 'required|string',
            'location.address' => 'required|string',
            'location.map_embed' => 'nullable|string',

            // Music
            'music' => 'nullable|array',
            'music.song_id' => 'nullable|integer|exists:songs,id',

            // Gift
            'gift' => 'nullable|array',
            'gift.enabled' => 'boolean',
            'gift.bank_name' => 'nullable|string',
            'gift.account_number' => 'nullable|string',
            'gift.account_holder' => 'nullable|string',

            // RSVP
            'rsvp' => 'nullable|array',
            'rsvp.enabled' => 'boolean',
            'rsvp.max_guests' => 'nullable|integer',
            'rsvp.note' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
