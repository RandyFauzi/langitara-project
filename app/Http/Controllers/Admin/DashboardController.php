<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Invitation;
use App\Models\Order;
use App\Models\Template;
use App\Models\Rsvp;
use App\Models\ActivityLog;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the main admin dashboard.
     */
    public function index()
    {
        return view('admin.dashboard.index', [
            'revenueStats' => $this->getRevenueStats(),
            'userStats' => $this->getUserStats(),
            'invitationStats' => $this->getInvitationStats(),
            'orderStats' => $this->getOrderStats(),
            'topPackages' => $this->getTopPackages(),
            'activePromos' => \App\Models\Promo::active()->count(),
            'rsvpStats' => $this->getRsvpSummary(),
            'recentActivities' => $this->getRecentActivities(),
        ]);
    }

    private function getRevenueStats()
    {
        $currentMonth = Carbon::now();

        return [
            'total' => Order::where('payment_status', 'paid')->sum('amount'),
            'this_month' => Order::where('payment_status', 'paid')
                ->whereMonth('created_at', $currentMonth->month)
                ->whereYear('created_at', $currentMonth->year)
                ->sum('amount'),
            'last_month' => Order::where('payment_status', 'paid')
                ->whereMonth('created_at', $currentMonth->subMonth()->month)
                ->whereYear('created_at', $currentMonth->year) // simplistic, better to use subMonth on date
                ->sum('amount'),
        ];
    }

    private function getUserStats()
    {
        return [
            'total' => User::count(),
            'today' => User::whereDate('created_at', Carbon::today())->count(),
            'week' => User::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count(),
            'month' => User::whereMonth('created_at', Carbon::now()->month)->count(),
        ];
    }

    private function getInvitationStats()
    {
        return [
            'total' => Invitation::count(),
            'draft' => Invitation::where('status', 'draft')->count(),
            'published' => Invitation::where('status', 'published')->count(),
            'expired' => Invitation::where('status', 'expired')->count(), // Assuming 'expired' status exists, or check date
        ];
    }

    private function getOrderStats()
    {
        return [
            'total' => Order::count(),
            'pending' => Order::where('payment_status', 'pending')->count(),
            'paid' => Order::where('payment_status', 'paid')->count(),
            'failed' => Order::where('payment_status', 'failed')->count(),
        ];
    }

    private function getTopPackages()
    {
        // Top 3 Best Selling Packages
        return DB::table('orders')
            ->join('packages', 'orders.package_id', '=', 'packages.id')
            ->select('packages.name', DB::raw('count(orders.id) as total_sold'))
            ->where('orders.payment_status', 'paid')
            ->groupBy('packages.id', 'packages.name')
            ->orderByDesc('total_sold')
            ->limit(3)
            ->get();
    }

    private function getRsvpSummary()
    {
        $total = Rsvp::count();
        $stats = [
            'hadir' => Rsvp::where('status', 'hadir')->count(),
            'tidak' => Rsvp::where('status', 'tidak_hadir')->count(),
            'ragu' => Rsvp::where('status', 'ragu')->count(),
        ];

        // Calculate percentages
        $stats['hadir_pct'] = $total > 0 ? round(($stats['hadir'] / $total) * 100) : 0;
        $stats['tidak_pct'] = $total > 0 ? round(($stats['tidak'] / $total) * 100) : 0;
        $stats['ragu_pct'] = $total > 0 ? round(($stats['ragu'] / $total) * 100) : 0;

        return $stats;
    }

    private function getRecentActivities()
    {
        return ActivityLog::latest()
            ->take(10)
            ->get()
            ->map(function ($log) {
                $log->formatted_date = $log->created_at->format('d M Y H:i');
                return $log;
            });
    }

    private function getTrafficEstimate()
    {
        // Using activity logs as a proxy for "views" or interaction if no dedicated tracker
        return ActivityLog::count();
    }
}
