<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Start Query
        $query = Order::with(['user', 'package', 'invitation'])
            ->latest();

        // Search Filters
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($u) use ($search) {
                    $u->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('payment_status', $request->status);
        }

        $orders = $query->paginate(10)->withQueryString();

        // Statistics
        $totalOrders = Order::count();
        $paidOrders = Order::where('payment_status', 'paid')->count();
        $pendingOrders = Order::where('payment_status', 'pending')->count();
        $failedOrders = Order::where('payment_status', 'failed')->count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('amount');

        return view('admin.orders.index', compact(
            'orders',
            'totalOrders',
            'paidOrders',
            'pendingOrders',
            'failedOrders',
            'totalRevenue'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'package', 'invitation']);
        return view('admin.orders.show', compact('order'));
    }
}
