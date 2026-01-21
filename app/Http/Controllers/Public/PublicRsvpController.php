<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Rsvp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Invitation;

class PublicRsvpController extends Controller
{
    /**
     * Handle the incoming RSVP submission.
     * This endpoint is PUBLIC - no login required.
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'invitation_id' => 'required|exists:invitations,id',
            'name' => 'required|string|max:255',
            'status' => 'required|in:hadir,tidak_hadir,ragu',
            'amount' => 'nullable|integer|min:1|max:10',
            'message' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();

        try {
            // Create RSVP directly - no login required
            $rsvp = Rsvp::create([
                'invitation_id' => $validated['invitation_id'],
                'name' => $validated['name'],
                'status' => $validated['status'],
                'amount' => $validated['amount'] ?? 1,
                'message' => $validated['message'] ?? null,
                'is_visible' => true,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Terima kasih! Konfirmasi kehadiran Anda telah disimpan.',
                'data' => [
                    'name' => $rsvp->name,
                    'status' => $rsvp->status,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
