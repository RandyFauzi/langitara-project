@extends('layouts.public')

@section('content')
<section class="min-h-screen bg-gradient-to-b from-white to-gray-50 py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="font-serif text-4xl font-bold text-charcoal mb-4">Status Pembayaran</h1>
            <p class="text-gray-600">Kelola dan lanjutkan pembayaran Anda</p>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-xl text-amber-700">
                {{ session('info') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <!-- Pending Payments -->
        @if($pendingPayments->count() > 0)
            <div class="mb-8">
                <h2 class="text-xl font-bold text-charcoal mb-4 flex items-center gap-2">
                    <span class="w-3 h-3 bg-amber-500 rounded-full animate-pulse"></span>
                    Menunggu Pembayaran
                </h2>

                <div class="space-y-4">
                    @foreach($pendingPayments as $payment)
                        <div class="bg-white rounded-2xl shadow-lg border-2 border-amber-200 overflow-hidden">
                            <div class="p-6">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-semibold rounded-full">
                                                Menunggu Pembayaran
                                            </span>
                                            <span class="text-gray-400 text-sm">{{ $payment->order_id }}</span>
                                        </div>
                                        <h3 class="text-xl font-bold text-charcoal">Paket {{ $payment->package->name }}</h3>
                                        <p class="text-gray-500 text-sm mt-1">
                                            Dibuat: {{ $payment->created_at->format('d M Y, H:i') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-2xl font-bold text-amber-700">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <!-- Instructions -->
                                <div class="mt-4 p-4 bg-amber-50 rounded-xl">
                                    <p class="text-amber-800 text-sm">
                                        <strong>Instruksi:</strong> Klik tombol "Lanjutkan Pembayaran" untuk menyelesaikan transaksi Anda. 
                                        Anda dapat membayar menggunakan berbagai metode seperti GoPay, DANA, OVO, atau transfer bank.
                                    </p>
                                </div>

                                <!-- Actions -->
                                <div class="mt-4 flex flex-col sm:flex-row gap-3">
                                    <button type="button" 
                                        class="continue-payment-btn flex-1 py-3 bg-gradient-to-r from-amber-600 to-amber-700 text-white font-bold rounded-xl hover:from-amber-700 hover:to-amber-800 transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2"
                                        data-payment-id="{{ $payment->id }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                        <span>Lanjutkan Pembayaran</span>
                                    </button>
                                    <button type="button" 
                                        class="cancel-payment-btn py-3 px-6 border-2 border-gray-200 text-gray-600 font-semibold rounded-xl hover:bg-gray-50 transition"
                                        data-payment-id="{{ $payment->id }}"
                                        data-payment-name="Paket {{ $payment->package->name }}">
                                        Batalkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Active Packages -->
        @if($activePayments->count() > 0)
            <div class="mb-8">
                <h2 class="text-xl font-bold text-charcoal mb-4 flex items-center gap-2">
                    <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                    Paket Aktif
                </h2>

                <div class="space-y-4">
                    @foreach($activePayments as $payment)
                        <div class="bg-white rounded-2xl shadow-lg border border-green-200 p-6">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div>
                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                                        Aktif
                                    </span>
                                    <h3 class="text-xl font-bold text-charcoal mt-2">Paket {{ $payment->package->name }}</h3>
                                    <p class="text-gray-500 text-sm mt-1">
                                        @if($payment->expiry_date)
                                            Berlaku hingga: {{ $payment->expiry_date->format('d M Y') }}
                                        @else
                                            Berlaku selamanya
                                        @endif
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-green-600 font-semibold">✓ Dibayar</p>
                                    <p class="text-gray-500 text-sm">{{ $payment->paid_at?->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Cancelled/Expired Payments -->
        @if($cancelledPayments->count() > 0)
            <div>
                <h2 class="text-xl font-bold text-charcoal mb-4 flex items-center gap-2">
                    <span class="w-3 h-3 bg-gray-400 rounded-full"></span>
                    Riwayat Dibatalkan
                </h2>

                <div class="space-y-4">
                    @foreach($cancelledPayments as $payment)
                        <div class="bg-white rounded-2xl shadow border border-gray-200 p-6 opacity-60">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div>
                                    <span class="px-3 py-1 bg-gray-100 text-gray-500 text-xs font-semibold rounded-full">
                                        Dibatalkan
                                    </span>
                                    <h3 class="text-lg font-semibold text-gray-600 mt-2">Paket {{ $payment->package->name }}</h3>
                                    <p class="text-gray-400 text-sm">{{ $payment->order_id }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-gray-500">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Empty State -->
        @if($pendingPayments->count() == 0 && $activePayments->count() == 0 && $cancelledPayments->count() == 0)
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-charcoal mb-2">Belum Ada Transaksi</h3>
                <p class="text-gray-500 mb-6">Anda belum melakukan pembelian paket apapun.</p>
                <a href="{{ route('public.pricing') }}" class="inline-flex items-center gap-2 bg-amber-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-amber-700 transition">
                    <span>Lihat Paket</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        @endif

        <!-- Back to Dashboard -->
        <div class="mt-8 text-center">
            <a href="{{ route('dashboard.index') }}" class="text-gray-500 hover:text-charcoal transition">
                ← Kembali ke Dashboard
            </a>
        </div>
    </div>
</section>

<!-- Cancel Confirmation Dialog -->
<dialog id="dialog-cancel" class="m-auto rounded-2xl shadow-2xl p-0 w-full max-w-sm backdrop:bg-slate-900/40 backdrop:backdrop-blur-sm">
    <div class="p-6 text-center">
        <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-charcoal mb-2">Batalkan Pembayaran?</h3>
        <p class="text-gray-500 text-sm mb-6" id="dialog-cancel-message">Apakah Anda yakin ingin membatalkan pembayaran ini?</p>
        <form id="cancel-form" method="POST" class="flex gap-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="document.getElementById('dialog-cancel').close()" 
                class="flex-1 py-2.5 px-4 border border-gray-200 text-gray-600 rounded-xl font-medium hover:bg-gray-50 transition">
                Tidak
            </button>
            <button type="submit" 
                class="flex-1 py-2.5 px-4 bg-red-500 text-white rounded-xl font-medium hover:bg-red-600 transition">
                Ya, Batalkan
            </button>
        </form>
    </div>
</dialog>

<!-- Alert Dialog -->
<dialog id="dialog-alert" class="m-auto rounded-2xl shadow-2xl p-0 w-full max-w-sm backdrop:bg-slate-900/40 backdrop:backdrop-blur-sm">
    <div class="p-6 text-center">
        <div id="alert-icon" class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4"></div>
        <h3 id="alert-title" class="text-lg font-bold text-charcoal mb-2">Title</h3>
        <p id="alert-message" class="text-gray-500 text-sm mb-6">Message</p>
        <button type="button" onclick="document.getElementById('dialog-alert').close()" 
            class="w-full py-2.5 px-4 bg-charcoal text-white rounded-xl font-medium hover:bg-charcoal/90 transition">
            Tutup
        </button>
    </div>
</dialog>
@endsection

@push('scripts')
<script src="{{ $snapUrl }}" data-client-key="{{ $clientKey }}"></script>
<script>
    // Alert dialog function
    function showAlert(type, title, message) {
        const dialog = document.getElementById('dialog-alert');
        const iconDiv = document.getElementById('alert-icon');
        const titleEl = document.getElementById('alert-title');
        const messageEl = document.getElementById('alert-message');

        titleEl.textContent = title;
        messageEl.textContent = message;

        if (type === 'error') {
            iconDiv.className = 'w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4 bg-red-100';
            iconDiv.innerHTML = '<svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
        } else if (type === 'success') {
            iconDiv.className = 'w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4 bg-green-100';
            iconDiv.innerHTML = '<svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
        } else {
            iconDiv.className = 'w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4 bg-amber-100';
            iconDiv.innerHTML = '<svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
        }

        dialog.showModal();
    }

    // Cancel payment buttons
    document.querySelectorAll('.cancel-payment-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const paymentId = this.dataset.paymentId;
            const paymentName = this.dataset.paymentName;
            const dialog = document.getElementById('dialog-cancel');
            const form = document.getElementById('cancel-form');
            const message = document.getElementById('dialog-cancel-message');

            form.action = `/payment/${paymentId}/cancel`;
            message.textContent = `Apakah Anda yakin ingin membatalkan pembayaran untuk ${paymentName}?`;
            dialog.showModal();
        });
    });

    // Continue Payment buttons
    document.querySelectorAll('.continue-payment-btn').forEach(btn => {
        btn.addEventListener('click', async function() {
            const paymentId = this.dataset.paymentId;
            const button = this;
            const originalText = button.innerHTML;

            // Show loading
            button.disabled = true;
            button.innerHTML = '<svg class="animate-spin h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

            try {
                const response = await fetch(`/payment/${paymentId}/continue`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                });

                const data = await response.json();

                if (!data.success) {
                    throw new Error(data.message || 'Gagal melanjutkan pembayaran');
                }

                // Reset button
                button.disabled = false;
                button.innerHTML = originalText;

                // Open Midtrans Snap
                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        window.location.href = '{{ route("checkout.finish") }}?order_id=' + data.order_id + '&transaction_status=settlement';
                    },
                    onPending: function(result) {
                        window.location.reload();
                    },
                    onError: function(result) {
                        showAlert('error', 'Pembayaran Gagal', 'Pembayaran gagal. Silakan coba lagi.');
                    },
                    onClose: function() {
                        // User closed popup
                    }
                });
            } catch (error) {
                button.disabled = false;
                button.innerHTML = originalText;
                showAlert('error', 'Gagal', error.message);
            }
        });
    });
</script>
@endpush
