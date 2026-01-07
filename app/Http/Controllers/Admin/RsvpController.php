<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rsvp;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class RsvpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Stats Summary
        $stats = [
            'total' => Rsvp::count(),
            'hadir' => Rsvp::where('attendance', 'hadir')->count(),
            'tidak' => Rsvp::where('attendance', 'tidak')->count(),
            'ragu' => Rsvp::where('attendance', 'ragu')->count(),
        ];

        // 2. Query Builder for List
        $query = Rsvp::with([
            'guest.invitation.user',
            'guest.invitation.template'
        ]);

        // 3. Filters
        // Search Global
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('guest', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhereHas('invitation', function ($q2) use ($search) {
                        $q2->where('title', 'like', "%{$search}%")
                            ->orWhere('slug', 'like', "%{$search}%")
                            ->orWhereHas('user', function ($q3) use ($search) {
                                $q3->where('name', 'like', "%{$search}%")
                                    ->orWhere('email', 'like', "%{$search}%");
                            });
                    });
            });
        }

        // Filter Status
        if ($request->has('attendance') && $request->attendance && $request->attendance !== 'all') {
            $query->where('attendance', $request->attendance);
        }

        // Get Data
        $rsvps = $query->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.rsvps.index', compact('rsvps', 'stats'));
    }

    /**
     * Show detailed RSVP (for Modal).
     */
    public function show($id)
    {
        $rsvp = Rsvp::with(['guest.invitation.user'])->findOrFail($id);

        // Log View Action
        ActivityLog::log('view', "Viewed details of RSVP #{$id}", $rsvp);

        return response()->json([
            'rsvp' => $rsvp,
            'guest_name' => $rsvp->guest->name,
            'guest_contact' => $rsvp->guest->phone ?? $rsvp->guest->email ?? '-', // Adjust field based on schema
            'invitation_title' => $rsvp->guest->invitation->title,
            'invitation_slug' => $rsvp->guest->invitation->slug,
            'owner_name' => $rsvp->guest->invitation->user->name ?? 'Deleted User',
            'created_formatted' => $rsvp->created_at->format('d M Y, H:i'),
        ]);
    }
}
