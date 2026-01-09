<?php

namespace App\Services\Dashboard;

use App\Models\User;
use App\Models\Package;
use Illuminate\Support\Collection;

class UserDashboardService
{
    /**
     * Get all dashboard overview data for a user.
     */
    public function getOverviewData(User $user): array
    {
        return [
            'user' => $user,
            'invitations' => $this->getInvitations($user),
            'activePackage' => $this->getActivePackage($user),
            'stats' => $this->getStats($user),
        ];
    }

    /**
     * Get user's invitations with template and status.
     */
    public function getInvitations(User $user): Collection
    {
        return $user->invitations()
            ->with(['template:id,name,preview_image_path', 'package:id,name'])
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($invitation) {
                return [
                    'id' => $invitation->id,
                    'title' => $invitation->title,
                    'slug' => $invitation->slug,
                    'status' => $invitation->status ?? 'draft',
                    'event_date' => $invitation->event_date,
                    'template_name' => $invitation->template?->name ?? 'Unknown',
                    'template_thumbnail' => $invitation->template?->preview_image_path,
                    'package_name' => $invitation->package?->name ?? 'Free',
                    'updated_at' => $invitation->updated_at,
                    'public_url' => route('public.templates.show', $invitation->slug),
                ];
            });
    }

    /**
     * Get user's active package from the latest paid order.
     */
    public function getActivePackage(User $user): ?array
    {
        $latestPaidOrder = $user->orders()
            ->where('payment_status', 'paid')
            ->with('package')
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$latestPaidOrder || !$latestPaidOrder->package) {
            return null;
        }

        $package = $latestPaidOrder->package;

        return [
            'id' => $package->id,
            'name' => $package->name,
            'price' => $package->price,
            'duration_days' => $package->duration_days,
            'max_invitations' => $package->max_invitations,
            'max_guests' => $package->max_guests,
            'purchased_at' => $latestPaidOrder->created_at,
            'expires_at' => $latestPaidOrder->created_at->addDays($package->duration_days),
            'is_expired' => $latestPaidOrder->created_at->addDays($package->duration_days)->isPast(),
        ];
    }

    /**
     * Get quick stats for the dashboard.
     */
    public function getStats(User $user): array
    {
        $invitations = $user->invitations;
        $totalGuests = $user->invitations()->withCount('guests')->get()->sum('guests_count');
        $totalRsvps = $user->invitations()->withCount('rsvps')->get()->sum('rsvps_count');

        return [
            'total_invitations' => $invitations->count(),
            'published_invitations' => $invitations->where('status', 'published')->count(),
            'draft_invitations' => $invitations->where('status', '!=', 'published')->count(),
            'total_guests' => $totalGuests,
            'total_rsvps' => $totalRsvps,
        ];
    }
}
