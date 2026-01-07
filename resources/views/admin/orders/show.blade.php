@extends('admin.layouts.app')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')

    <!-- HEADER & BACK BUTTON -->
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.orders.index') }}"
            class="p-2 rounded-full bg-white border border-slate-200 text-slate-500 hover:text-slate-800 hover:bg-slate-50 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-3">
                Order #{{ $order->id }}
                @if($order->payment_status === 'paid')
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">PAID</span>
                @elseif($order->payment_status === 'pending')
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">PENDING</span>
                @else
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800">{{ strtoupper($order->payment_status) }}</span>
                @endif
            </h1>
            <p class="text-sm text-slate-500 mt-1">Dibuat pada {{ $order->created_at->format('d F Y, H:i') }} WIB</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- LEFT COLUMN: INVOICE & ITEM -->
        <div class="lg:col-span-2 space-y-6">

            <!-- INVOICE CARD -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800">Rincian Tagihan</h3>
                    <span
                        class="text-xs font-mono text-slate-400">INV-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Item Layanan</p>
                            <h4 class="text-lg font-bold text-slate-900">{{ $order->package->name }}</h4>
                            <p class="text-sm text-slate-600 mt-1">Durasi: {{ $order->package->duration_days }} Hari</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Harga</p>
                            <h4 class="text-lg font-bold text-slate-900">Rp {{ number_format($order->amount, 0, ',', '.') }}
                            </h4>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-4 flex justify-between items-center">
                        <span class="font-bold text-slate-800">Total Pembayaran</span>
                        <span class="text-2xl font-bold text-indigo-600">Rp
                            {{ number_format($order->amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- PAYMENT HISTORY (Placeholder for future development) -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h3 class="font-bold text-slate-800 mb-4">Riwayat Pembayaran</h3>
                <div class="relative pl-4 border-l-2 border-slate-200 space-y-6">
                    <div class="relative">
                        <div class="absolute -left-[21px] bg-indigo-500 h-3 w-3 rounded-full border-2 border-white"></div>
                        <p class="text-sm font-semibold text-slate-800">Order Dibuat</p>
                        <p class="text-xs text-slate-500">{{ $order->created_at->format('d M Y H:i') }}</p>
                    </div>
                    @if($order->payment_status == 'paid')
                        <div class="relative">
                            <div class="absolute -left-[21px] bg-emerald-500 h-3 w-3 rounded-full border-2 border-white"></div>
                            <p class="text-sm font-semibold text-slate-800">Pembayaran Berhasil</p>
                            <p class="text-xs text-slate-500">{{ $order->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN: CUSTOMER INFO -->
        <div class="space-y-6">

            <!-- CUSTOMER PROFILE -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h3 class="font-bold text-slate-800 mb-4">Informasi Pelanggan</h3>
                <div class="flex items-center gap-4 mb-6">
                    <div
                        class="h-12 w-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-lg">
                        {{ substr($order->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-slate-900">{{ $order->user->name }}</p>
                        <p class="text-xs text-slate-500">Member since {{ $order->user->created_at->format('Y') }}</p>
                    </div>
                </div>

                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-slate-500 mb-1">Email Address</p>
                        <p class="font-medium text-slate-800">{{ $order->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500 mb-1">Phone Number</p>
                        <p class="font-medium text-slate-800">{{ $order->user->phone ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- RELATED INVITATION -->
            @if($order->invitation)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <h3 class="font-bold text-slate-800 mb-4">Undangan Terkait</h3>
                    <div class="bg-slate-50 rounded-lg p-4 border border-slate-100">
                        <p class="font-bold text-indigo-700 mb-1">{{ $order->invitation->title }}</p>
                        <p class="text-xs text-slate-500 mb-2">{{ $order->invitation->slug }}</p>
                        <a href="#" class="text-xs font-semibold text-indigo-600 hover:underline">Lihat Undangan &rarr;</a>
                    </div>
                </div>
            @endif

        </div>
    </div>

@endsection