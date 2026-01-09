<?php

namespace App\Services\Invitation;

use App\Models\Invitation;
use App\Models\InvitationEvent;
use App\Models\InvitationLoveStory;
use App\Models\InvitationGallery;
use App\Models\InvitationDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InvitationEditorService
{
    protected $dataBuilder;

    public function __construct(InvitationDataBuilderService $dataBuilder)
    {
        $this->dataBuilder = $dataBuilder;
    }

    /**
     * LOAD Editor State (Schema v1) from Database
     */
    public function load(Invitation $invitation): array
    {
        $invitation->load(['detail', 'events', 'loveStories', 'galleries', 'song', 'guests']);

        $payload = $invitation->payload ?? [];

        return [
            'meta' => [
                'title' => $invitation->title,
                'description' => $payload['meta']['description'] ?? null, // Stored in payload
                'event_date' => $invitation->event_date ? $invitation->event_date->format('Y-m-d') : null,
                'event_time' => $payload['meta']['event_time'] ?? '00:00:00', // Stored in payload
                'timezone' => $payload['meta']['timezone'] ?? 'UTC',
                'theme_slug' => $invitation->template->slug, // Read-only for editor context mainly
            ],
            'couple' => [
                'bride' => [
                    'name' => $invitation->detail->bride_name ?? '',
                    'full_name' => $payload['couple']['bride']['full_name'] ?? null,
                    'parents' => $payload['couple']['bride']['parents'] ?? null,
                    'photo' => $payload['couple']['bride']['photo'] ?? null,
                    'instagram' => $payload['couple']['bride']['instagram'] ?? null,
                ],
                'groom' => [
                    'name' => $invitation->detail->groom_name ?? '',
                    'full_name' => $payload['couple']['groom']['full_name'] ?? null,
                    'parents' => $payload['couple']['groom']['parents'] ?? null,
                    'photo' => $payload['couple']['groom']['photo'] ?? null,
                    'instagram' => $payload['couple']['groom']['instagram'] ?? null,
                ],
            ],
            'quote' => $payload['quote'] ?? ['enabled' => false, 'text' => '', 'source' => ''],
            'events' => $invitation->events->map(function ($e) {
                return [
                    'id' => $e->id,
                    'title' => $e->title,
                    'date' => $e->date ? $e->date->format('Y-m-d') : null,
                    'time_start' => $e->time_start ? Carbon::parse($e->time_start)->format('H:i') : null,
                    'time_end' => $e->time_end ? Carbon::parse($e->time_end)->format('H:i') : null,
                    'location_name' => $e->location_name,
                    'address' => $e->address,
                    'map_url' => $e->map_url,
                ];
            })->toArray(),
            'love_story' => $invitation->loveStories->map(function ($l) {
                return [
                    'id' => $l->id,
                    'year' => $l->year,
                    'title' => $l->title,
                    'story' => $l->story,
                    'image' => $l->image,
                ];
            })->toArray(),
            'gallery' => $invitation->galleries->map(function ($g) {
                return [
                    'id' => $g->id,
                    'url' => $g->url,
                    'caption' => $g->caption,
                ];
            })->toArray(),
            'location' => [
                'name' => $payload['location']['name'] ?? $invitation->location, // Prefer payload for extended, fallback to simple column
                'address' => $payload['location']['address'] ?? $invitation->location,
                'map_embed' => $payload['location']['map_embed'] ?? null,
            ],
            'music' => [
                'song_id' => $invitation->song_id
            ],
            'gift' => $payload['gift'] ?? ['enabled' => false],
            'rsvp' => $payload['rsvp'] ?? ['enabled' => true, 'max_guests' => 1],
            'guests' => $invitation->guests->map(function ($g) {
                return [
                    'id' => $g->id,
                    'name' => $g->name,
                    'phone' => $g->phone,
                    'pax' => $g->pax,
                    'category' => $g->category,
                    // QR Code or Slug usually computed, not stored directly for edit
                ];
            })->toArray(),
            'wishes' => [], // Read-only, fetched separately usually
        ];
    }

    /**
     * SAVE Editor State (Schema v1) to Database
     */
    public function save(Invitation $invitation, array $state): void
    {
        DB::transaction(function () use ($invitation, $state) {
            // 1. Prepare Payload (Strict Mapping)
            $payload = $this->preparePayload($invitation, $state);

            // 2. Update Main Invitation Model
            $invitation->update([
                'title' => $state['meta']['title'],
                'event_date' => $state['meta']['event_date'],
                'location' => $state['location']['name'], // Simple fallback column
                'song_id' => $state['music']['song_id'] ?? null,
                'payload' => $payload,
            ]);

            // 3. Update Detail (Basic Names)
            $invitation->detail()->updateOrCreate(
                ['invitation_id' => $invitation->id],
                [
                    'groom_name' => $state['couple']['groom']['name'],
                    'bride_name' => $state['couple']['bride']['name'],
                ]
            );

            // 4. Sync Events (HasMany)
            $this->syncEvents($invitation, $state['events']);

            // 5. Sync Love Stories (HasMany)
            $this->syncLoveStories($invitation, $state['love_story'] ?? []);

            // 6. Sync Galleries (HasMany)
            $this->syncGalleries($invitation, $state['gallery'] ?? []);

            // 7. Sync Guests (HasMany)
            $this->syncGuests($invitation, $state['guests'] ?? []);
        });
    }

    /**
     * PREVIEW: Build TemplateDataContract from Editor State without Saving
     * @param Invitation $invitation
     * @param array $state
     * @return array
     */
    public function buildPreviewData(Invitation $invitation, array $state): array
    {
        // 1. Mock the Invitation Model with incoming data
        $dummy = clone $invitation;

        $dummy->title = $state['meta']['title'];
        $dummy->event_date = $state['meta']['event_date'] ? Carbon::parse($state['meta']['event_date']) : null;
        $dummy->location = $state['location']['name'];
        $dummy->song_id = $state['music']['song_id'] ?? null;

        // Use EXACT same strict payload mapping as save()
        $dummy->payload = $this->preparePayload($invitation, $state);

        // 2. Mock Relations
        // Detail
        $detail = new InvitationDetail([
            'groom_name' => $state['couple']['groom']['name'],
            'bride_name' => $state['couple']['bride']['name'],
        ]);
        $dummy->setRelation('detail', $detail);

        // Events
        $eventsCollection = collect($state['events'])->map(function ($e, $index) {
            return new InvitationEvent([
                'title' => $e['title'],
                'date' => Carbon::parse($e['date']),
                'time_start' => isset($e['time_start']) ? $e['time_start'] : null,
                'time_end' => $e['time_end'] ?? null,
                'location_name' => $e['location_name'],
                'address' => $e['address'],
                'map_url' => $e['map_url'] ?? null,
                'sort_order' => $index
            ]);
        });
        $dummy->setRelation('events', $eventsCollection);

        // Love Stories
        $loveStoriesCollection = collect($state['love_story'] ?? [])->map(function ($l, $index) {
            return new InvitationLoveStory([
                'year' => $l['year'],
                'title' => $l['title'],
                'story' => $l['story'],
                'image' => $l['image'] ?? null,
                'sort_order' => $index
            ]);
        });
        $dummy->setRelation('loveStories', $loveStoriesCollection);

        // Galleries
        $galleriesCollection = collect($state['gallery'] ?? [])->map(function ($g, $index) {
            return new InvitationGallery([
                'url' => $g['url'],
                'caption' => $g['caption'] ?? null,
                'sort_order' => $index
            ]);
        });
        $dummy->setRelation('galleries', $galleriesCollection);

        // Guests (Mock)
        $guestsCollection = collect($state['guests'] ?? [])->map(function ($g) {
            return new \App\Models\Guest([
                'name' => $g['name'],
                'phone' => $g['phone'] ?? null,
                'pax' => $g['pax'] ?? 1,
                'category' => $g['category'] ?? 'General',
                // 'status' is usually managed by system, but acceptable here
            ]);
        });
        $dummy->setRelation('guests', $guestsCollection);

        // Pre-resolve Song if ID changed
        if ($dummy->song_id && $dummy->song_id != $invitation->song_id) {
            $song = \App\Models\Song::find($dummy->song_id);
            $dummy->setRelation('song', $song);
        }

        // 3. Use the existing Builder
        return $this->dataBuilder->build($dummy);
    }

    /**
     * Helper: Prepare strict payload from state.
     * Ensures consistency between save and preview.
     */
    private function preparePayload(Invitation $invitation, array $state): array
    {
        $payload = $invitation->payload ?? [];

        // Meta
        $payload['meta'] = [
            'description' => $state['meta']['description'] ?? null,
            'event_time' => $state['meta']['event_time'] ?? '00:00:00',
            'timezone' => $state['meta']['timezone'] ?? 'UTC',
        ];

        // Couple Extended - Strict Mapping
        $payload['couple'] = [
            'bride' => [
                'full_name' => $state['couple']['bride']['full_name'] ?? null,
                'parents' => $state['couple']['bride']['parents'] ?? null,
                'photo' => $state['couple']['bride']['photo'] ?? null,
                'instagram' => $state['couple']['bride']['instagram'] ?? null,
            ],
            'groom' => [
                'full_name' => $state['couple']['groom']['full_name'] ?? null,
                'parents' => $state['couple']['groom']['parents'] ?? null,
                'photo' => $state['couple']['groom']['photo'] ?? null,
                'instagram' => $state['couple']['groom']['instagram'] ?? null,
            ]
        ];

        // Location Extended
        $payload['location'] = [
            'name' => $state['location']['name'] ?? null,
            'address' => $state['location']['address'] ?? null,
            'map_embed' => $state['location']['map_embed'] ?? null,
        ];

        // Config Blocks
        $payload['quote'] = $state['quote'] ?? null;
        $payload['gift'] = $state['gift'] ?? null;
        $payload['rsvp'] = $state['rsvp'] ?? null;

        return $payload;
    }

    // --- Helpers for Syncing ---

    protected function syncEvents(Invitation $invitation, array $items)
    {
        $existingIds = $invitation->events()->pluck('id')->toArray();
        $keptIds = [];

        foreach ($items as $index => $item) {
            if (isset($item['id']) && in_array($item['id'], $existingIds)) {
                // Update
                $invitation->events()->where('id', $item['id'])->update([
                    'title' => $item['title'],
                    'date' => $item['date'],
                    'time_start' => $item['time_start'],
                    'time_end' => $item['time_end'],
                    'location_name' => $item['location_name'],
                    'address' => $item['address'],
                    'map_url' => $item['map_url'],
                    'sort_order' => $index
                ]);
                $keptIds[] = $item['id'];
            } else {
                // Create
                $newEvent = $invitation->events()->create([
                    'title' => $item['title'],
                    'date' => $item['date'],
                    'time_start' => $item['time_start'],
                    'time_end' => $item['time_end'],
                    'location_name' => $item['location_name'],
                    'address' => $item['address'],
                    'map_url' => $item['map_url'],
                    'sort_order' => $index
                ]);
                $keptIds[] = $newEvent->id;
            }
        }

        // Delete removed
        $invitation->events()->whereNotIn('id', $keptIds)->delete();
    }

    protected function syncLoveStories(Invitation $invitation, array $items)
    {
        $existingIds = $invitation->loveStories()->pluck('id')->toArray();
        $keptIds = [];

        foreach ($items as $index => $item) {
            if (isset($item['id']) && in_array($item['id'], $existingIds)) {
                $invitation->loveStories()->where('id', $item['id'])->update([
                    'year' => $item['year'],
                    'title' => $item['title'],
                    'story' => $item['story'],
                    'image' => $item['image'],
                    'sort_order' => $index
                ]);
                $keptIds[] = $item['id'];
            } else {
                $new = $invitation->loveStories()->create([
                    'year' => $item['year'],
                    'title' => $item['title'],
                    'story' => $item['story'],
                    'image' => $item['image'],
                    'sort_order' => $index
                ]);
                $keptIds[] = $new->id;
            }
        }

        $invitation->loveStories()->whereNotIn('id', $keptIds)->delete();
    }

    protected function syncGalleries(Invitation $invitation, array $items)
    {
        $existingIds = $invitation->galleries()->pluck('id')->toArray();
        $keptIds = [];

        foreach ($items as $index => $item) {
            if (isset($item['id']) && in_array($item['id'], $existingIds)) {
                $invitation->galleries()->where('id', $item['id'])->update([
                    'url' => $item['url'],
                    'caption' => $item['caption'] ?? null,
                    'sort_order' => $index
                ]);
                $keptIds[] = $item['id'];
            } else {
                $new = $invitation->galleries()->create([
                    'url' => $item['url'],
                    'caption' => $item['caption'] ?? null,
                    'sort_order' => $index
                ]);
                $keptIds[] = $new->id;
            }
        }

        $invitation->galleries()->whereNotIn('id', $keptIds)->delete();
    }

    protected function syncGuests(Invitation $invitation, array $items)
    {
        $existingIds = $invitation->guests()->pluck('id')->toArray();
        $keptIds = [];

        foreach ($items as $item) {
            if (isset($item['id']) && in_array($item['id'], $existingIds)) {
                $invitation->guests()->where('id', $item['id'])->update([
                    'name' => $item['name'],
                    'phone' => $item['phone'] ?? null,
                    'pax' => $item['pax'] ?? 1,
                    // 'category' => $item['category'] ?? 'General', // Ensure Guest model has 'category'
                ]);
                $keptIds[] = $item['id'];
            } else {
                $new = $invitation->guests()->create([
                    'name' => $item['name'],
                    'phone' => $item['phone'] ?? null,
                    'pax' => $item['pax'] ?? 1,
                    // 'category' => $item['category'] ?? 'General',
                ]);
                $keptIds[] = $new->id;
            }
        }

        $invitation->guests()->whereNotIn('id', $keptIds)->delete();
    }
}
