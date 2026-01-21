<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicInvitationController extends Controller
{
    /**
     * Handle the incoming request for an invitation.
     */
    public function show(Request $request, $slug)
    {
        // 1. Find Invitation
        $invitation = Invitation::with(['template', 'music'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Check Status (allow author to preview)
        if ($invitation->status !== 'published') {
            if (!Auth::check() || Auth::id() !== $invitation->user_id) {
                abort(404);
            }
        }

        // 2. Guest Name Logic
        $guestName = null;

        // Priority: Code (ID) -> Name Param
        if ($request->has('code')) {
            $guest = $invitation->guests()->where('id', $request->query('code'))->first();
            if ($guest)
                $guestName = $guest->name;
        }

        if (!$guestName) {
            $paramName = $request->query('to') ?? $request->query('guest');
            if ($paramName) {
                // Sanitize and use directly
                $guestName = strip_tags(urldecode($paramName));
            }
        }

        // Default
        if (empty($guestName)) {
            $guestName = 'Tamu Undangan';
        }

        // 3. RSVP Data (Wishes) - Only "Hadir" or "Ragu", or all except "Tidak Hadir"?
        // Prompt: "where('status', '!=', 'tidak_hadir')"
        $rsvps = $invitation->rsvps()
            ->where('status', '!=', 'tidak_hadir')
            ->whereNotNull('message')
            ->latest()
            ->get();

        // 4. View Determination
        $theme = $invitation->template->folder_name ?? 'basic';
        $viewPath = "templates.{$theme}.index";

        if (!view()->exists($viewPath)) {
            // Fallback
            $viewPath = 'templates.basic.index';
        }

        // 5. Pass Data
        return view($viewPath, [
            'invitation' => $invitation,
            'guest_name' => $guestName, // Note: Prompt asked for snake_case $guest_name so I'll use that key
            'rsvps' => $rsvps,
        ]);
    }

    /**
     * Map JSON content to legacy variables.
     * This acts as an adapter layer.
     */
    private function mapContentToLegacy(array $content, Invitation $invitation): array
    {
        $defaults = $this->getDefaultPlaceholders();

        // Reconstruct Events List from Columns
        $eventsList = [];
        if ($invitation->akad_date || $invitation->akad_location) {
            $eventsList[] = [
                'name' => 'Akad Nikah',
                'date' => $invitation->akad_date ? $invitation->akad_date->translatedFormat('d F Y') : null,
                'time_start' => $invitation->akad_date ? $invitation->akad_date->format('H:i') : null,
                'location' => $invitation->akad_location,
                'address' => $invitation->akad_address,
                'maps_link' => $invitation->akad_map_link,
            ];
        }
        if ($invitation->resepsi_date || $invitation->resepsi_location) {
            $eventsList[] = [
                'name' => 'Resepsi',
                'date' => $invitation->resepsi_date ? $invitation->resepsi_date->translatedFormat('d F Y') : null,
                'time_start' => $invitation->resepsi_date ? $invitation->resepsi_date->format('H:i') : null,
                'location' => $invitation->resepsi_location,
                'address' => $invitation->resepsi_address,
                'maps_link' => $invitation->resepsi_map_link,
            ];
        }

        return [
            // Cover
            'cover_title' => $invitation->title ?? $defaults['cover_title'],

            // Smart Date Logic: Priority 1: Akad Date, Priority 2: Resepsi Date
            'cover_date' => $invitation->akad_date
                ? $invitation->akad_date->translatedFormat('d F Y')
                : ($invitation->resepsi_date ? $invitation->resepsi_date->translatedFormat('d F Y') : $defaults['cover_date']),

            'cover_image' => $invitation->cover_image ?? asset('images/default-cover.jpg'),

            // Couple - Groom
            'groom_name' => $invitation->groom_name ?? $defaults['groom_name'],
            'groom_father' => $invitation->groom_father ?? $defaults['groom_father'],
            'groom_mother' => $invitation->groom_mother ?? $defaults['groom_mother'],
            'groom_photo' => $invitation->groom_photo ?? null,
            'groom_nickname' => $invitation->groom_nickname ?? '',
            'groom_show_photo' => true,

            // Couple - Bride
            'bride_name' => $invitation->bride_name ?? $defaults['bride_name'],
            'bride_father' => $invitation->bride_father ?? $defaults['bride_father'],
            'bride_mother' => $invitation->bride_mother ?? $defaults['bride_mother'],
            'bride_photo' => $invitation->bride_photo ?? null,
            'bride_nickname' => $invitation->bride_nickname ?? '',
            'bride_show_photo' => true,

            // Quote
            'quote_text' => $invitation->quote_text ?? $defaults['quote_text'],
            'quote_author' => $invitation->quote_author ?? $defaults['quote_author'],

            // Elements from JSON Lists
            'events_list' => $eventsList,
            'gallery_images' => $invitation->gallery_photos ?? [],
            'love_stories' => $invitation->love_stories ?? [],
            'bank_accounts' => $invitation->bank_accounts ?? [],
        ];
    }

    /**
     * Default placeholder data for empty/new invitations.
     */
    private function getDefaultPlaceholders(): array
    {
        return [
            'cover_title' => 'The Wedding Of',
            'cover_date' => 'Tanggal Acara',
            'groom_name' => 'Nama Mempelai Pria',
            'groom_father' => 'Nama Ayah',
            'groom_mother' => 'Nama Ibu',
            'bride_name' => 'Nama Mempelai Wanita',
            'bride_father' => 'Nama Ayah',
            'bride_mother' => 'Nama Ibu',
            'quote_text' => '"Dan di antara tanda-tanda-Nya ialah Dia menciptakan untukmu pasangan hidup dari jenismu sendiri."',
            'quote_author' => 'QS. Ar-Rum: 21',
        ];
    }
}
