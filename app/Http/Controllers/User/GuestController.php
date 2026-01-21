<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\Invitation;
use App\Models\Rsvp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GuestsImport;
use App\Exports\GuestTemplateExport;

class GuestController extends Controller
{
    /**
     * Get the invitation by slug, ensuring it belongs to the authenticated user.
     */
    private function getInvitation(string $slug): Invitation
    {
        return Invitation::where('slug', $slug)
            ->where('user_id', Auth::id())
            ->firstOrFail();
    }

    /**
     * Display the guest list for an invitation.
     */
    public function index(string $slug)
    {
        $invitation = $this->getInvitation($slug);
        $guests = $invitation->guests()->orderBy('created_at', 'desc')->get();

        return view('editor.guests.index', [
            'invitation' => $invitation,
            'guests' => $guests,
        ]);
    }

    /**
     * Store a new guest.
     */
    public function store(Request $request, string $slug)
    {
        $invitation = $this->getInvitation($slug);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:family,friend,colleague,vip',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $guest = $invitation->guests()->create([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'phone_number' => $validated['phone_number'] ?? null,
            'slug' => Str::random(10),
            'status' => 'pending',
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'guest' => $guest,
                'invitation_link' => $guest->getInvitationLink(),
            ]);
        }

        return redirect()->route('editor.guests.index', $slug)
            ->with('success', 'Tamu berhasil ditambahkan!');
    }

    /**
     * Update an existing guest.
     */
    public function update(Request $request, string $slug, Guest $guest)
    {
        $invitation = $this->getInvitation($slug);

        // Ensure guest belongs to this invitation
        if ($guest->invitation_id !== $invitation->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:family,friend,colleague,vip',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $guest->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'guest' => $guest->fresh(),
            ]);
        }

        return redirect()->route('editor.guests.index', $slug)
            ->with('success', 'Tamu berhasil diperbarui!');
    }

    /**
     * Delete a guest.
     */
    public function destroy(Request $request, string $slug, Guest $guest)
    {
        $invitation = $this->getInvitation($slug);

        // Ensure guest belongs to this invitation
        if ($guest->invitation_id !== $invitation->id) {
            abort(403);
        }

        $guest->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('editor.guests.index', $slug)
            ->with('success', 'Tamu berhasil dihapus!');
    }

    /**
     * Get invitation link for a guest.
     */
    public function getLink(string $slug, Guest $guest)
    {
        $invitation = $this->getInvitation($slug);

        if ($guest->invitation_id !== $invitation->id) {
            abort(403);
        }

        return response()->json([
            'success' => true,
            'link' => $guest->getInvitationLink(),
        ]);
    }

    /**
     * Display RSVP statistics dashboard.
     */
    public function stats(string $slug)
    {
        $invitation = $this->getInvitation($slug);
        $rsvps = $invitation->rsvps;

        $stats = [
            'total' => $rsvps->count(),
            'hadir' => $rsvps->where('status', 'hadir')->count(),
            'tidak_hadir' => $rsvps->where('status', 'tidak_hadir')->count(),
            'ragu' => $rsvps->where('status', 'ragu')->count(),
            'total_guests' => $invitation->guests()->count(),
        ];

        // Calculate total attendees (sum of amount for hadir status)
        $stats['total_attendees'] = $rsvps->where('status', 'hadir')->sum('amount');

        // Recent RSVPs
        $recentRsvps = $invitation->rsvps()
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Chart data for pie/donut chart
        $chartData = [
            'labels' => ['Hadir', 'Tidak Hadir', 'Ragu-ragu'],
            'data' => [$stats['hadir'], $stats['tidak_hadir'], $stats['ragu']],
            'colors' => ['#10B981', '#EF4444', '#F59E0B'],
        ];

        return view('editor.guests.stats', [
            'invitation' => $invitation,
            'stats' => $stats,
            'recentRsvps' => $recentRsvps,
            'chartData' => $chartData,
        ]);
    }

    /**
     * Display wishes/messages from RSVPs.
     */
    public function wishes(string $slug)
    {
        $invitation = $this->getInvitation($slug);

        $wishes = $invitation->rsvps()
            ->withMessage()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('editor.guests.wishes', [
            'invitation' => $invitation,
            'wishes' => $wishes,
        ]);
    }

    /**
     * Toggle wish visibility.
     */
    public function toggleWishVisibility(Request $request, string $slug, Rsvp $rsvp)
    {
        $invitation = $this->getInvitation($slug);

        if ($rsvp->invitation_id !== $invitation->id) {
            abort(403);
        }

        $rsvp->update([
            'is_visible' => !$rsvp->is_visible,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_visible' => $rsvp->is_visible,
            ]);
        }

        return redirect()->route('editor.wishes.index', $slug)
            ->with('success', 'Visibilitas ucapan berhasil diubah!');
    }

    /**
     * Delete a wish/RSVP.
     */
    public function destroyWish(Request $request, string $slug, Rsvp $rsvp)
    {
        $invitation = $this->getInvitation($slug);

        if ($rsvp->invitation_id !== $invitation->id) {
            abort(403);
        }

        $rsvp->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('editor.wishes.index', $slug)
            ->with('success', 'Ucapan berhasil dihapus!');
    }

    /**
     * Download the Excel template for guests.
     */
    public function downloadTemplate(string $slug)
    {
        return Excel::download(new GuestTemplateExport, 'template_tamu_langitara.xlsx');
    }

    /**
     * Import guests from Excel file.
     */
    public function import(Request $request, string $slug)
    {
        $invitation = $this->getInvitation($slug);

        $request->validate([
            'file' => 'required|mimes:xlsx,csv|max:2048',
        ]);

        try {
            Excel::import(new GuestsImport($invitation->id), $request->file('file'));

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data tamu berhasil diimport!',
                ]);
            }

            return redirect()->back()->with('success', 'Data tamu berhasil diimport!');

        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengimport: ' . $e->getMessage(),
                ], 500);
            }
            return redirect()->back()->with('error', 'Gagal mengimport: ' . $e->getMessage());
        }
    }
}
