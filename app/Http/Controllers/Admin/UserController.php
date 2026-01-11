<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by Status
        if ($request->has('status') && $request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $users = $query->withCount(['orders', 'invitations'])
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Display the specified user (for AJAX Modal).
     */
    public function show($id)
    {
        $user = User::with([
            'orders' => function ($q) {
                $q->latest()->take(5);
            },
            'orders.package',
            'invitations' => function ($q) {
                $q->latest()->take(5);
            },
            'userPackages' => function ($q) {
                $q->where('status', 'active')->latest();
            },
            'userPackages.package'
        ])->withCount(['orders', 'invitations'])->findOrFail($id);

        $totalSpent = $user->orders->where('payment_status', 'paid')->sum('amount');

        // Add calculated attributes for JSON
        $user->total_spent = number_format($totalSpent, 0, ',', '.');
        $user->formatted_created_at = $user->created_at->format('d M Y, H:i');

        // Get current active package
        $activePackage = $user->userPackages->first();
        $user->active_package = $activePackage ? [
            'id' => $activePackage->id,
            'package_id' => $activePackage->package_id,
            'package_name' => $activePackage->package->name ?? 'Unknown',
        ] : null;

        // Get all available packages for dropdown
        $user->all_packages = \App\Models\Package::orderBy('sort_order')->get(['id', 'name']);

        return response()->json($user);
    }

    /**
     * Update the specified user status.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Determine action based on input (suspend/activate)
        if ($request->has('status')) {
            $status = $request->status; // 'active' or 'suspended'
            $user->status = $status;
            $user->save();

            // Log Activity
            ActivityLog::log('update', "Changed user status to {$status}", $user);

            return redirect()->back()->with('success', "User status updated to {$status}.");
        }

        return redirect()->back()->with('error', 'No valid action provided.');
    }

    /**
     * Reset password manually.
     */
    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $newPassword = Str::random(8); // Generate random 8 char password

        $user->password = Hash::make($newPassword);
        $user->save();

        ActivityLog::log('reset_password', "Reset password for user {$user->email}", $user);

        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully.',
            'new_password' => $newPassword
        ]);
    }

    /**
     * Update user package status.
     */
    public function updatePackageStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,pending,cancelled,expired',
        ]);

        $userPackage = \App\Models\UserPackage::findOrFail($id);

        $oldStatus = $userPackage->status;
        $userPackage->status = $request->status;

        // If activating, set paid_at and expiry_date
        if ($request->status === 'active' && $oldStatus !== 'active') {
            $userPackage->paid_at = now();
            $durationDays = $userPackage->package->duration_days ?? 0;
            $userPackage->expiry_date = $durationDays > 0 ? now()->addDays($durationDays) : null;
        }

        $userPackage->save();

        ActivityLog::log('update_package', "Changed package status from {$oldStatus} to {$request->status}", $userPackage);

        return response()->json([
            'success' => true,
            'message' => "Status paket berhasil diubah menjadi {$request->status}.",
        ]);
    }

    /**
     * Change user's active package.
     */
    public function changeUserPackage(Request $request, $userId)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
        ]);

        $user = User::findOrFail($userId);
        $package = \App\Models\Package::findOrFail($request->package_id);

        // Deactivate current active packages
        \App\Models\UserPackage::where('user_id', $userId)
            ->where('status', 'active')
            ->update(['status' => 'cancelled']);

        // Create new active package
        $userPackage = \App\Models\UserPackage::create([
            'user_id' => $userId,
            'package_id' => $package->id,
            'order_id' => 'ADMIN-' . strtoupper(Str::random(8)) . '-' . time(),
            'status' => 'active',
            'amount' => $package->price,
            'paid_at' => now(),
            'expiry_date' => $package->duration_days > 0 ? now()->addDays($package->duration_days) : null,
        ]);

        ActivityLog::log('change_package', "Changed user package to {$package->name}", $user);

        return response()->json([
            'success' => true,
            'message' => "Paket user berhasil diubah ke {$package->name}.",
            'package_name' => $package->name,
        ]);
    }
}
