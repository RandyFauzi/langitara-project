@extends('admin.layouts.app')

@section('title', 'Daftar Pesanan')

@section('content')

<!-- HEADER -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">
            Pesanan & Transaksi
        </h1>
        <p class="mt-1 text-sm text-slate-500">
            Monitor dan kelola semua transaksi pengguna Langitara.
        </p>
    </div>
</div>

<!-- STATS CARDS -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
    @include('admin.components.stat-card', [
        'title' => 'Total Pendapatan',
        'value' => 'Rp ' . number_format($totalRevenue, 0, ',', '.'),
        'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        'bgIcon' => 'bg-emerald-500',
        'trend' => 'Lifetime Revenue'
    ])

    @include('admin.components.stat-card', [
        'title' => 'Pesanan Dibayar',
        'value' => number_format($paidOrders),
        'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        'bgIcon' => 'bg-sky-500',
        'trend' => 'Transaksi sukses'
    ])

    @include('admin.components.stat-card', [
        'title' => 'Menunggu Pembayaran',
        'value' => number_format($pendingOrders),
        'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        'bgIcon' => 'bg-amber-500',
        'trend' => 'Perlu ditindaklanjuti'
    ])

    @include('admin.components.stat-card', [
        'title' => 'Gagal / Batal',
        'value' => number_format($failedOrders),
        'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        'bgIcon' => 'bg-rose-500',
        'trend' => 'Expired atau error'
    ])
</div>

<!-- FILTERS & SEARCH -->
<div class="bg-white rounded-t-2xl border-x border-t border-slate-200 p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    
    <!-- TABS STATUS -->
    <div class="flex items-center space-x-1 bg-slate-100 p-1 rounded-lg self-start">
        <a href="{{ route('admin.orders.index') }}" class="px-4 py-1.5 text-sm font-medium rounded-md {{ !request('status') ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
            Semua
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="px-4 py-1.5 text-sm font-medium rounded-md {{ request('status') == 'pending' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
            Pending
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'paid']) }}" class="px-4 py-1.5 text-sm font-medium rounded-md {{ request('status') == 'paid' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
            Paid
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'failed']) }}" class="px-4 py-1.5 text-sm font-medium rounded-md {{ request('status') == 'failed' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
            Failed
        </a>
    </div>

    <!-- SEARCH -->
    <form method="GET" action="{{ route('admin.orders.index') }}" class="relative w-full sm:w-64">
        @if(request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
        @endif
        <input type="text" name="search" value="{{ request('search') }}" 
            class="w-full pl-10 pr-4 py-2 text-sm border border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" 
            placeholder="Cari ID, Nama, Email...">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
    </form>
</div>

<!-- ORDERS TABLE -->
<div class="bg-white border md:rounded-b-2xl border-slate-200 overflow-hidden shadow-sm mb-10">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 text-slate-600 text-xs uppercase font-semibold">
                <tr>
                    <th class="px-6 py-4">ID Order</th>
                    <th class="px-6 py-4">User</th>
                    <th class="px-6 py-4">Paket</th>
                    <th class="px-6 py-4 text-right">Total</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($orders as $order)
                <tr class="hover:bg-slate-50 transition duration-150">
                    <td class="px-6 py-4 font-mono font-medium text-slate-700">
                        #{{ $order->id }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="font-medium text-slate-900">{{ $order->user->name }}</span>
                            <span class="text-xs text-slate-500">{{ $order->user->email }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">
                            {{ $order->package->name }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right font-semibold text-slate-700">
                        Rp {{ number_format($order->amount, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($order->payment_status === 'paid')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                PAID
                            </span>
                        @elseif($order->payment_status === 'pending')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                PENDING
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-800">
                                {{ strtoupper($order->payment_status) }}
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-slate-500 text-xs">
                        {{ $order->created_at->format('d M Y H:i') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-xs border border-indigo-200 px-3 py-1 rounded hover:bg-indigo-50 transition">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-10 text-center text-slate-400">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-slate-200 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <span class="text-sm">Tidak ada pesanan ditemukan.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- PAGINATION -->
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
        {{ $orders->links() }} 
    </div>
</div>

@endsection
