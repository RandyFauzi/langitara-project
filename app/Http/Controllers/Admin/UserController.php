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
            }
        ])->withCount(['orders', 'invitations'])->findOrFail($id);

        $totalSpent = $user->orders->where('payment_status', 'paid')->sum('amount');

        // Add calculated attributes for JSON
        $user->total_spent = number_format($totalSpent, 0, ',', '.');
        $user->formatted_created_at = $user->created_at->format('d M Y, H:i');

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
}
