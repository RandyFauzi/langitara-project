<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\InvitationDetail;
use App\Models\InvitationMusic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Str;
use Illuminate\Support\Facades\Validator;

class EditorController extends Controller
{
    /**
     * Show the editor page (3-Column Layout).
     */
    /**
     * Show the editor page (3-Column Layout).
     */
    public function edit($slug)
    {
        $invitation = Invitation::where('slug', $slug)
            ->with(['template'])
            ->firstOrFail();

        // Security: Ensure owner or admin
        if (Auth::id() !== $invitation->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Initialize defaults if critical JSON arrays are null
        if (is_null($invitation->active_sections)) {
            $invitation->active_sections = $this->getDefaultActiveSections();
        }
        // Initialize other defaults loosely in frontend or here if strictly needed

        $songs = \App\Models\Song::where('status', 'active')->get();

        // Resolve current song for display
        $currentSong = $invitation->music_path ? \App\Models\Song::where('file_path', $invitation->music_path)->first() : null;
        $customMusic = $invitation->music;

        // Fetch Guests for "Daftar Tamu" section
        $guests = $invitation->guests()->orderBy('created_at', 'desc')->get();

        // Fetch RSVP Stats for "Konfirmasi Kehadiran" section
        $totalGuests = $invitation->guests()->count();
        $rsvps = $invitation->rsvps()->orderBy('created_at', 'desc')->get();

        $stats = [
            'total_guests' => $totalGuests,
            'total_responses' => $rsvps->count(),
            'hadir' => $rsvps->where('status', 'hadir')->count(),
            'tidak_hadir' => $rsvps->where('status', 'tidak_hadir')->count(),
            'ragu' => $rsvps->where('status', 'ragu')->count(),
            'total_attendees' => $rsvps->where('status', 'hadir')->sum('amount'), // Sum of pax
        ];

        // Prepare Chart Data
        $chartData = [
            'labels' => ['Hadir', 'Tidak Hadir', 'Ragu-ragu'],
            'data' => [$stats['hadir'], $stats['tidak_hadir'], $stats['ragu']],
            'colors' => ['#22c55e', '#ef4444', '#f59e0b'],
        ];

        // Fetch Wishes (RSVPs with messages)
        $wishes = $invitation->rsvps()
            ->whereNotNull('message')
            ->where('message', '!=', '')
            ->orderBy('created_at', 'desc')
            ->get();

        // Fetch active templates for the "Change Template" feature
        $templates = \App\Models\Template::where('status', 'active')->get();

        return view('editor.index', [
            'invitation' => $invitation,
            'templates' => $templates,
            'songs' => $songs,
            'currentSong' => $currentSong,
            'customMusic' => $customMusic,
            'guests' => $guests,
            'stats' => $stats,
            'recentRsvps' => $rsvps->take(10), // Limit recent list
            'chartData' => $chartData,
            'wishes' => $wishes,
        ]);
    }

    /**
     * Update the invitation data via AJAX.
     * Expects strict column naming in request payload.
     */
    public function update(Request $request, $slug)
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();

        if (Auth::id() !== $invitation->user_id && Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Allow all fillable fields. Validation can be stricter if needed.
        // We trust the fillable array to protect sensitive columns.
        $data = $request->only($invitation->getFillable());

        // Ensure arrays are arrays (Laravel casts handle this, but input must be array)
        // If frontend sends null for methods, ensure we handle it.

        try {
            DB::beginTransaction();

            // Handle music specifically if needing to resolve ID -> Path?
            // User requirement: "Handle standard inputs directly".
            // If frontend sends `music_path` string, we save it.
            // Conflict resolution is handled by specific endpoints:
            // - updateMusic() sets music_path = null when custom music is saved
            // - destroyMusic() deletes custom music when library song is selected

            // DEBUG: Log what's being saved
            \Illuminate\Support\Facades\Log::info('EditorController@update - music_path received: ' . ($data['music_path'] ?? 'NULL'));
            \Illuminate\Support\Facades\Log::info('EditorController@update - form data keys: ' . implode(', ', array_keys($data)));

            $invitation->update($data);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Perubahan berhasil disimpan.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function publish(Request $request, $slug)
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();

        if (Auth::id() !== $invitation->user_id && Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $status = $request->input('status'); // 'published' or 'draft'

        // Validate status
        if (!in_array($status, ['published', 'draft'])) {
            return response()->json([
                'success' => false,
                'message' => 'Status tidak valid.',
            ], 400);
        }

        $invitation->update(['status' => $status]);

        $message = $status === 'published' ? 'Undangan berhasil dipublikasikan.' : 'Undangan berhasil diubah ke draft.';

        return response()->json([
            'success' => true,
            'message' => $message,
            'status' => $status
        ]);
    }

    /**
     * Upload image via AJAX (Smart File Manager).
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120', // Max 5MB
            'invitation_slug' => 'required|exists:invitations,slug',
            'key' => 'required|string', // e.g., 'cover.image' or 'gallery'
        ]);

        $invitation = Invitation::where('slug', $request->invitation_slug)->with('user')->firstOrFail();

        // Security Check
        if (Auth::id() !== $invitation->user_id && Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // 1. Folder Structure: public/uploads/invitations/{id}_{username}/
            $username = Str::slug($invitation->user->name);
            $folderName = "{$invitation->id}_{$username}";
            $destinationPath = public_path("uploads/invitations/{$folderName}");

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // 2. Filename: {timestamp}_{section}_{username}.ext
            // Extract section from key (e.g., 'cover' from 'cover.image')
            $section = explode('.', $request->key)[0];
            $filename = time() . "_{$section}_{$username}." . $file->getClientOriginalExtension();

            // 3. Auto-Cleanup (Delete Old File)
            // Use columns to find old image
            if ($request->key !== 'gallery') {
                $columnMap = [
                    'cover.image' => 'cover_image',
                    'couple.groom.photo' => 'groom_photo',
                    'couple.bride.photo' => 'bride_photo',
                    // Add other single-image fields if any
                ];

                $col = $columnMap[$request->key] ?? null;
                $oldUrl = $col ? $invitation->$col : null;

                if ($oldUrl) {
                    // Convert URL to absolute path
                    $relativePath = str_replace(asset(''), '', $oldUrl);
                    $absolutePath = public_path($relativePath);

                    // Check if it's a file in our uploads directory (don't delete defaults/assets)
                    if (file_exists($absolutePath) && is_file($absolutePath) && strpos($absolutePath, 'uploads/invitations') !== false) {
                        @unlink($absolutePath);
                    }
                }
            }

            // 4. Save New File
            $file->move($destinationPath, $filename);

            // Return accessible public URL
            return response()->json([
                'success' => true,
                'url' => asset("uploads/invitations/{$folderName}/{$filename}"),
            ]);
        }

        return response()->json(['success' => false, 'message' => 'No file uploaded'], 400);
    }

    /**
     * Update custom music (Premium Feature).
     */
    public function updateMusic(Request $request, $slug)
    {
        $invitation = Invitation::where('slug', $slug)->with('package')->firstOrFail();

        if (Auth::id() !== $invitation->user_id && Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // 1. Check Premium Status (Account Level OR Invitation Level)
        $user = Auth::user();
        $accountPackage = $user->active_package; // Uses the accessor we just added

        $hasPremiumAccount = $accountPackage && $accountPackage->price > 0;
        $hasPremiumInvitation = $invitation->package && $invitation->package->price > 0;

        $isPremium = $hasPremiumAccount || $hasPremiumInvitation;

        if (!$isPremium) {
            return response()->json(['success' => false, 'message' => 'Fitur ini hanya untuk pengguna Premium.'], 403);
        }

        $request->validate([
            'url' => 'required|url',
            // 'is_valid' agreement is checked on frontend, implicit here by action
        ]);

        $url = $request->input('url');
        $parsingResult = $this->parseMusicUrl($url);

        if (!$parsingResult['success']) {
            return response()->json(['success' => false, 'message' => $parsingResult['message']], 400);
        }

        // Save to DB with Transaction
        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $music = InvitationMusic::updateOrCreate(
                ['invitation_id' => $invitation->id],
                [
                    'provider' => $parsingResult['provider'],
                    'url' => $url,
                    'embed_url' => $parsingResult['embed_url'],
                    'title' => $parsingResult['title'] ?? null,
                    'is_valid' => true,
                ]
            );

            // Force clear music_path using direct DB update to bypass mutators/casts
            \Illuminate\Support\Facades\DB::table('invitations')
                ->where('id', $invitation->id)
                ->update(['music_path' => null]);

            \Illuminate\Support\Facades\DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Musik berhasil disimpan.',
                'music' => $music
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan musik: ' . $e->getMessage()], 500);
        }
    }

    private function parseMusicUrl($url)
    {
        $domain = parse_url($url, PHP_URL_HOST);
        $domain = str_replace('www.', '', $domain);

        // YOUTUBE
        if (in_array($domain, ['youtube.com', 'youtu.be', 'm.youtube.com'])) {
            $videoId = null;
            if ($domain === 'youtu.be') {
                $path = parse_url($url, PHP_URL_PATH);
                $videoId = ltrim($path, '/');
            } else {
                parse_str(parse_url($url, PHP_URL_QUERY), $query);
                $videoId = $query['v'] ?? null;
                // Handle shorts?
                if (!$videoId) {
                    $path = parse_url($url, PHP_URL_PATH);
                    if (strpos($path, '/shorts/') === 0) {
                        $videoId = str_replace('/shorts/', '', $path);
                    }
                }
            }

            if ($videoId) {
                return [
                    'success' => true,
                    'provider' => 'youtube',
                    'embed_url' => "https://www.youtube.com/embed/{$videoId}?autoplay=1&loop=1&playlist={$videoId}"
                ];
            }
        }

        // SPOTIFY
        if ($domain === 'open.spotify.com') {
            // Path: /track/ID, /playlist/ID, /album/ID
            $path = parse_url($url, PHP_URL_PATH);
            // Check if track/playlist/album/artist
            if (preg_match('/^\/(track|playlist|album|artist)\/([a-zA-Z0-9]+)/', $path)) {
                // Official embed: https://open.spotify.com/embed/track/ID
                return [
                    'success' => true,
                    'provider' => 'spotify',
                    'embed_url' => "https://open.spotify.com/embed{$path}"
                ];
            }
        }

        // SOUNDCLOUD
        if ($domain === 'soundcloud.com' || $domain === 'm.soundcloud.com') {
            // Need to encode URL
            $encoded = urlencode($url);
            return [
                'success' => true,
                'provider' => 'soundcloud',
                'embed_url' => "https://w.soundcloud.com/player/?url={$encoded}&color=%23ff5500&auto_play=true&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true"
            ];
        }

        return ['success' => false, 'message' => 'Link tidak didukung. Gunakan YouTube, Spotify, atau SoundCloud.'];
    }

    // =========================================================================
    // DEFAULT DATA STRUCTURES (Seed Data for Empty Invitations)
    // =========================================================================

    private function getDefaultContent(): array
    {
        return [
            'cover' => [
                'title' => 'The Wedding Of',
                'date_display' => 'Tanggal Acara',
                'image' => null,
            ],
            'couple' => [
                'groom' => [
                    'name' => 'Nama Mempelai Pria',
                    'nickname' => 'Panggilan',
                    'father' => 'Nama Ayah',
                    'mother' => 'Nama Ibu',
                    'photo' => null,
                ],
                'bride' => [
                    'name' => 'Nama Mempelai Wanita',
                    'nickname' => 'Panggilan',
                    'father' => 'Nama Ayah',
                    'mother' => 'Nama Ibu',
                    'photo' => null,
                ],
            ],
            'quote' => [
                'text' => '"Dan di antara tanda-tanda-Nya ialah Dia menciptakan untukmu pasangan hidup dari jenismu sendiri."',
                'author' => 'QS. Ar-Rum: 21',
            ],
            'events' => [
                [
                    'name' => 'Akad Nikah',
                    'date' => null,
                    'time_start' => '08:00',
                    'time_end' => '10:00',
                    'location' => 'Nama Tempat',
                    'maps_link' => '',
                ],
                [
                    'name' => 'Resepsi',
                    'date' => null,
                    'time_start' => '11:00',
                    'time_end' => '14:00',
                    'location' => 'Nama Tempat',
                    'maps_link' => '',
                ],
            ],
            'gallery' => [],
            'story' => [],
            'bank_accounts' => [],
            'wishes' => [],
        ];
    }

    private function getDefaultActiveSections(): array
    {
        return ['cover', 'couple', 'quote', 'events', 'gallery', 'wishes', 'gift'];
    }

    private function getDefaultMetaSettings(): array
    {
        return [
            'font' => 'Inter',
            'primary_color' => '#8B4513',
            'secondary_color' => '#D2691E',
        ];
    }
    /**
     * Delete custom music (Revert to default/library).
     */
    public function destroyMusic($slug)
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();

        if (Auth::id() !== $invitation->user_id && Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if ($invitation->music) {
            $invitation->music->delete();
        }

        return response()->json(['success' => true, 'message' => 'Musik custom dihapus.']);
    }
}
