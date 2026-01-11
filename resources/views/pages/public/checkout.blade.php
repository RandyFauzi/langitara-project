@extends('layouts.public')

@section('content')
    <section class="min-h-screen bg-gradient-to-b from-white to-gray-50 py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12" data-aos="fade-up">
                <h1 class="font-serif text-4xl font-bold text-charcoal mb-4">Checkout</h1>
                <p class="text-gray-600">Selesaikan pembayaran untuk mengaktifkan paket</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Package Details -->
                <div class="bg-white rounded-2xl shadow-lg p-8" data-aos="fade-right">
                    <h2 class="text-xl font-bold text-charcoal mb-6">Detail Paket</h2>

                    <div class="border-b border-gray-100 pb-6 mb-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-2xl font-bold text-charcoal font-serif">{{ $package->name }}</h3>
                                <p class="text-gray-500 text-sm mt-1">
                                    @if($package->duration_days > 0)
                                        Aktif selama {{ $package->duration_days }} hari
                                    @else
                                        Tanpa batas waktu
                                    @endif
                                </p>
                            </div>
                            <div class="text-right">
                                @if($package->hasPromo())
                                    <span class="text-gray-400 line-through text-sm">{{ $package->formatted_original_price }}</span>
                                @endif
                                <div class="text-3xl font-bold text-amber-700 font-serif">{{ $package->formatted_price }}</div>
                            </div>
                        </div>

                        @if($package->description)
                            <p class="text-gray-600 text-sm">{{ $package->description }}</p>
                        @endif
                    </div>

                    <!-- Features -->
                    <h4 class="font-semibold text-charcoal mb-4">Fitur yang Didapat:</h4>
                    <ul class="space-y-3">
                        @foreach($package->features ?? [] as $feature)
                            <li class="flex items-start gap-3">
                                @if(str_contains(strtolower($feature), 'tidak'))
                                    <svg class="w-5 h-5 text-gray-300 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <span class="text-gray-400">{{ $feature }}</span>
                                @else
                                    <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">{{ $feature }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Payment Section -->
                <div class="bg-white rounded-2xl shadow-lg p-8" data-aos="fade-left">
                    <h2 class="text-xl font-bold text-charcoal mb-6">Pembayaran</h2>

                    <!-- User Info -->
                    <div class="bg-gray-50 rounded-xl p-4 mb-6">
                        <p class="text-sm text-gray-500 mb-1">Akun</p>
                        <p class="font-semibold text-charcoal">{{ auth()->user()->name }}</p>
                        <p class="text-gray-600 text-sm">{{ auth()->user()->email }}</p>
                    </div>

                    <!-- Order Summary -->
                    <div class="border-t border-gray-100 pt-6 mb-6">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Paket {{ $package->name }}</span>
                            <span class="font-semibold">{{ $package->formatted_price }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold text-charcoal border-t border-gray-100 pt-4 mt-4">
                            <span>Total</span>
                            <span class="text-amber-700">{{ $package->formatted_price }}</span>
                        </div>
                    </div>

                    <!-- Pay Button -->
                    <button id="pay-button"
                        class="w-full py-4 bg-gradient-to-r from-amber-700 to-amber-800 text-white font-bold rounded-xl hover:from-amber-800 hover:to-amber-900 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed"
                        data-package-id="{{ $package->id }}">
                        <span id="btn-text">Bayar Sekarang</span>
                        <span id="btn-loading" class="hidden">
                            <svg class="animate-spin h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>

                    <!-- Secure Payment Note -->
                    <div class="mt-6 text-center">
                        <div class="flex items-center justify-center gap-2 text-gray-500 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <span>Pembayaran aman dengan Midtrans</span>
                        </div>
                        <div class="mt-4 flex items-center justify-center gap-4 opacity-60">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/8/86/Gopay_logo.svg" alt="GoPay" class="h-6">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_dana_blue.svg" alt="DANA" class="h-5">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/e/eb/Logo_ovo_purple.svg" alt="OVO" class="h-5">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popup Overlay -->
    <div id="popup-overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center">
        <div id="popup-content" class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0">
            <!-- Error Popup -->
            <div id="popup-error" class="hidden">
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-charcoal mb-2">Pembayaran Gagal</h3>
                    <p id="popup-error-message" class="text-gray-600 mb-6">Terjadi kesalahan saat memproses pembayaran.</p>
                    <button onclick="closePopup()" class="w-full py-3 bg-charcoal text-white rounded-xl font-semibold hover:bg-charcoal/90 transition">
                        Coba Lagi
                    </button>
                </div>
            </div>

            <!-- Pending Popup -->
            <div id="popup-pending" class="hidden">
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-charcoal mb-2">Menunggu Pembayaran</h3>
                    <p class="text-gray-600 mb-6">Silakan selesaikan pembayaran Anda sesuai instruksi yang diberikan.</p>
                    <button onclick="window.location.href='{{ route('dashboard.index') }}'" class="w-full py-3 bg-amber-600 text-white rounded-xl font-semibold hover:bg-amber-700 transition">
                        Lihat Status
                    </button>
                </div>
            </div>

            <!-- Success Popup -->
            <div id="popup-success" class="hidden">
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-charcoal mb-2">Pembayaran Berhasil!</h3>
                    <p class="text-gray-600 mb-6">Paket Anda sudah aktif. Anda akan diarahkan ke dashboard.</p>
                    <div class="w-full bg-gray-200 rounded-full h-1">
                        <div class="bg-green-500 h-1 rounded-full animate-pulse" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Midtrans Snap JS -->
    <script src="{{ $snapUrl }}" data-client-key="{{ $clientKey }}"></script>
    <script>
        // Popup Functions
        function showPopup(type, message = '') {
            const overlay = document.getElementById('popup-overlay');
            const content = document.getElementById('popup-content');
            const errorPopup = document.getElementById('popup-error');
            const pendingPopup = document.getElementById('popup-pending');
            const successPopup = document.getElementById('popup-success');
            const errorMessage = document.getElementById('popup-error-message');

            // Hide all popups first
            errorPopup.classList.add('hidden');
            pendingPopup.classList.add('hidden');
            successPopup.classList.add('hidden');

            // Show the correct popup
            if (type === 'error') {
                errorPopup.classList.remove('hidden');
                if (message) errorMessage.textContent = message;
            } else if (type === 'pending') {
                pendingPopup.classList.remove('hidden');
            } else if (type === 'success') {
                successPopup.classList.remove('hidden');
            }

            // Show overlay with animation
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
            
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closePopup() {
            const overlay = document.getElementById('popup-overlay');
            const content = document.getElementById('popup-content');
            
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                overlay.classList.add('hidden');
                overlay.classList.remove('flex');
            }, 300);
        }

        // Close popup when clicking overlay
        document.getElementById('popup-overlay').addEventListener('click', function(e) {
            if (e.target === this) {
                closePopup();
            }
        });

        // Payment Handler
        document.getElementById('pay-button').addEventListener('click', async function() {
            const button = this;
            const btnText = document.getElementById('btn-text');
            const btnLoading = document.getElementById('btn-loading');
            const packageId = button.dataset.packageId;

            // Show loading
            button.disabled = true;
            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');

            try {
                // Request Snap token from server
                const response = await fetch('{{ route("payment.snap-token") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ package_id: packageId })
                });

                const data = await response.json();

                if (!data.success) {
                    throw new Error(data.message || 'Gagal memproses pembayaran. Silakan coba lagi.');
                }

                // Open Midtrans Snap popup
                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        console.log('Payment success:', result);
                        showPopup('success');
                        setTimeout(() => {
                            window.location.href = '{{ route("checkout.finish") }}?order_id=' + data.order_id + '&transaction_status=settlement';
                        }, 2000);
                    },
                    onPending: function(result) {
                        console.log('Payment pending:', result);
                        showPopup('pending');
                    },
                    onError: function(result) {
                        console.error('Payment error:', result);
                        showPopup('error', 'Pembayaran gagal. Silakan coba lagi atau gunakan metode pembayaran lain.');
                        resetButton();
                    },
                    onClose: function() {
                        console.log('Payment popup closed');
                        resetButton();
                    }
                });
            } catch (error) {
                console.error('Error:', error);
                showPopup('error', error.message || 'Terjadi kesalahan. Silakan coba lagi.');
                resetButton();
            }

            function resetButton() {
                button.disabled = false;
                btnText.classList.remove('hidden');
                btnLoading.classList.add('hidden');
            }
        });
    </script>
@endpush