<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    /**
     * Display a listing of invitations.
     */
    public function index(Request $request)
    {
        $query = Invitation::with(['user', 'template', 'package', 'guests', 'rsvps']);

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filters
        if ($request->has('status') && $request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('template_id') && $request->template_id) {
            $query->where('template_id', $request->template_id);
        }

        // Eager load counts and aggregated RSVP stats if possible, or calculate in view
        // To allow sorting by RSVP count, we would need subqueries, but for now we just show it.
        $invitations = $query->latest()
            ->withCount(['guests'])
            ->paginate(10)
            ->withQueryString();

        $templates = \App\Models\Template::all();
        $packages = \App\Models\Package::all();

        return view('admin.invitations.index', compact('invitations', 'templates', 'packages'));
    }

    /**
     * Show detailed stats for an invitation (Full Page).
     */
    public function show($id, Request $request)
    {
        // 1. Fetch Invitation with eager loading
        $invitation = Invitation::with(['user', 'template', 'package'])->findOrFail($id);

        // 2. RSVP Stats Aggregation
        $rsvpStats = [
            'total' => $invitation->rsvps()->count(),
            'hadir' => $invitation->rsvps()->where('attendance', 'hadir')->sum('pax'), // Pax count for hadir
            'tidak' => $invitation->rsvps()->where('attendance', 'tidak')->count(),
            'ragu' => $invitation->rsvps()->where('attendance', 'ragu')->count(),
        ];

        // 3. Guest List with RSVP data (Paginated)
        $query = $invitation->rsvps()->with('guest'); // Accessing RSVPs directly which has guest relation

        // Optional: Filter within the detail page 
        if ($request->has('rsvp_status') && $request->rsvp_status) {
            $query->where('attendance', $request->rsvp_status);
        }

        $rsvps = $query->latest()->paginate(10)->withQueryString();

        return view('admin.invitations.show', compact('invitation', 'rsvpStats', 'rsvps'));
    }

    /**
     * Impersonate User (Login as User).
     */
    public function impersonate($id)
    {
        $invitation = Invitation::findOrFail($id);
        $user = $invitation->user;

        if (!$user) {
            return back()->with('error', 'User not found for this invitation.');
        }

        // Log the action
        ActivityLog::log('impersonate', "Impersonated user {$user->email} from invitation {$invitation->slug}", $invitation);

        // Login as the user
        Auth::login($user);

        return redirect()->route('public.home')->with('success', "You are now logged in as {$user->name}");
    }
}
