<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\UserPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    /**
     * Initialize Midtrans configuration.
     */
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Show the checkout page for a package.
     */
    public function checkout(Package $package)
    {
        // Redirect to login if not authenticated
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('message', 'Silakan login terlebih dahulu untuk membeli paket.');
        }

        // Free package - activate directly
        if ($package->price == 0) {
            return $this->activateFreePackage($package);
        }

        return view('pages.public.checkout', [
            'package' => $package,
            'clientKey' => config('midtrans.client_key'),
            'snapUrl' => config('midtrans.snap_url'),
        ]);
    }

    /**
     * Activate free package without payment.
     */
    private function activateFreePackage(Package $package)
    {
        $orderId = 'FREE-' . Auth::id() . '-' . time();

        $userPackage = UserPackage::create([
            'user_id' => Auth::id(),
            'package_id' => $package->id,
            'order_id' => $orderId,
            'status' => 'active',
            'amount' => 0,
            'payment_type' => 'free',
            'paid_at' => now(),
            'expiry_date' => $package->duration_days > 0
                ? now()->addDays($package->duration_days)
                : null,
        ]);

        return redirect()->route('dashboard.index')
            ->with('success', 'Paket ' . $package->name . ' berhasil diaktifkan!');
    }

    /**
     * Generate Midtrans Snap token.
     */
    public function createSnapToken(Request $request)
    {
        // Validate Midtrans configuration
        if (empty(config('midtrans.server_key')) || empty(config('midtrans.client_key'))) {
            Log::error('Midtrans configuration missing. Please add MIDTRANS_SERVER_KEY and MIDTRANS_CLIENT_KEY to .env file.');
            return response()->json([
                'success' => false,
                'message' => 'Konfigurasi pembayaran belum lengkap. Silakan hubungi admin.',
            ], 500);
        }

        $request->validate([
            'package_id' => 'required|exists:packages,id',
        ]);

        $package = Package::findOrFail($request->package_id);
        $user = Auth::user();

        // Generate unique order ID
        $orderId = 'LGT-' . $user->id . '-' . time();

        // Create pending user package record
        $userPackage = UserPackage::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'order_id' => $orderId,
            'status' => 'pending',
            'amount' => $package->price,
        ]);

        // Midtrans transaction parameters
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $package->price,
            ],
            'item_details' => [
                [
                    'id' => $package->slug,
                    'price' => (int) $package->price,
                    'quantity' => 1,
                    'name' => 'Paket ' . $package->name,
                ],
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'callbacks' => [
                'finish' => route('checkout.finish'),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $orderId,
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Error: ' . $e->getMessage());

            // Delete pending record on error
            $userPackage->delete();

            // Provide more specific error message
            $errorMessage = 'Gagal memproses pembayaran. ';
            if (str_contains($e->getMessage(), 'ServerKey') || str_contains($e->getMessage(), 'ClientKey')) {
                $errorMessage .= 'Konfigurasi pembayaran tidak valid.';
            } else {
                $errorMessage .= 'Silakan coba lagi.';
            }

            return response()->json([
                'success' => false,
                'message' => $errorMessage,
            ], 500);
        }
    }

    /**
     * Handle Midtrans notification webhook.
     */
    public function notification(Request $request)
    {
        try {
            $notification = new Notification();

            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $paymentType = $notification->payment_type;
            $transactionId = $notification->transaction_id;
            $fraudStatus = $notification->fraud_status ?? null;

            Log::info('Midtrans Notification', [
                'order_id' => $orderId,
                'status' => $transactionStatus,
                'payment_type' => $paymentType,
            ]);

            $userPackage = UserPackage::where('order_id', $orderId)->first();

            if (!$userPackage) {
                Log::warning('UserPackage not found for order: ' . $orderId);
                return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
            }

            // Process based on transaction status
            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                // Check fraud status for credit card
                if ($paymentType == 'credit_card' && $fraudStatus == 'challenge') {
                    $userPackage->update(['status' => 'pending']);
                } else {
                    // Payment success - activate package
                    $userPackage->update([
                        'transaction_id' => $transactionId,
                        'payment_type' => $paymentType,
                        'midtrans_response' => $notification->getResponse(),
                    ]);
                    $userPackage->activate();

                    Log::info('Package activated for order: ' . $orderId);
                }
            } elseif ($transactionStatus == 'pending') {
                $userPackage->update([
                    'status' => 'pending',
                    'payment_type' => $paymentType,
                ]);
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $userPackage->update([
                    'status' => 'cancelled',
                    'midtrans_response' => $notification->getResponse(),
                ]);
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Handle finish redirect from Midtrans.
     */
    public function finish(Request $request)
    {
        $orderId = $request->get('order_id');
        $transactionStatus = $request->get('transaction_status');

        if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
            return redirect()->route('dashboard.index')
                ->with('success', 'Pembayaran berhasil! Paket Anda sudah aktif.');
        } elseif ($transactionStatus == 'pending') {
            return redirect()->route('payment.status')
                ->with('info', 'Menunggu pembayaran. Silakan selesaikan pembayaran Anda.');
        } else {
            return redirect()->route('public.pricing')
                ->with('error', 'Pembayaran dibatalkan atau gagal.');
        }
    }

    /**
     * Show payment status page with pending payments.
     */
    public function status()
    {
        $user = Auth::user();

        // Get all user's payments
        $pendingPayments = UserPackage::where('user_id', $user->id)
            ->where('status', 'pending')
            ->with('package')
            ->orderBy('created_at', 'desc')
            ->get();

        $activePayments = UserPackage::where('user_id', $user->id)
            ->where('status', 'active')
            ->with('package')
            ->orderBy('created_at', 'desc')
            ->get();

        $cancelledPayments = UserPackage::where('user_id', $user->id)
            ->where('status', 'cancelled')
            ->with('package')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('pages.public.payment-status', [
            'pendingPayments' => $pendingPayments,
            'activePayments' => $activePayments,
            'cancelledPayments' => $cancelledPayments,
            'clientKey' => config('midtrans.client_key'),
            'snapUrl' => config('midtrans.snap_url'),
        ]);
    }

    /**
     * Continue a pending payment by regenerating snap token.
     */
    public function continuePayment(UserPackage $userPackage)
    {
        // Verify ownership
        if ($userPackage->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        // Check if still pending
        if ($userPackage->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran ini sudah tidak berlaku.',
            ], 400);
        }

        $package = $userPackage->package;

        // Midtrans transaction parameters
        $params = [
            'transaction_details' => [
                'order_id' => $userPackage->order_id,
                'gross_amount' => (int) $userPackage->amount,
            ],
            'item_details' => [
                [
                    'id' => $package->slug,
                    'price' => (int) $userPackage->amount,
                    'quantity' => 1,
                    'name' => 'Paket ' . $package->name,
                ],
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'callbacks' => [
                'finish' => route('checkout.finish'),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $userPackage->order_id,
            ]);
        } catch (\Exception $e) {
            Log::error('Continue Payment Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal melanjutkan pembayaran. Silakan coba lagi.',
            ], 500);
        }
    }

    /**
     * Cancel a pending payment.
     */
    public function cancelPayment(UserPackage $userPackage)
    {
        // Verify ownership
        if ($userPackage->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        // Check if still pending
        if ($userPackage->status !== 'pending') {
            return redirect()->back()->with('error', 'Pembayaran ini sudah tidak dapat dibatalkan.');
        }

        $userPackage->update(['status' => 'cancelled']);

        return redirect()->route('payment.status')
            ->with('success', 'Pembayaran berhasil dibatalkan.');
    }
}

