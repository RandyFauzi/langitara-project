@extends('admin.layouts.app')

@section('title', 'Business Overview')

@section('content')

<!-- WELCOME HEADER -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Dashboard Overview</h1>
    <p class="mt-1 text-sm text-slate-500">Monitor performa bisnis, revenue, dan aktivitas pengguna Langitara.</p>
</div>

<!-- TOP STATS: REVENUE & KEY METRICS -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- Revenue Card -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm relative overflow-hidden group">
        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition">
             <svg class="h-16 w-16 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Total Revenue</p>
        <h3 class="text-3xl font-bold text-slate-900 mb-2">
            Rp {{ number_format($revenueStats['total'], 0, ',', '.') }}
        </h3>
        <div class="flex items-center text-xs font-medium">
             <span class="text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">
                 + Rp {{ number_format($revenueStats['this_month'], 0, ',', '.') }}
             </span>
             <span class="text-slate-400 ml-2">Bulan ini</span>
        </div>
    </div>

    <!-- Paid Orders -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
        <div class="flex items-center gap-4 mb-4">
             <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                 <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
             </div>
             <div>
                 <p class="text-sm font-medium text-slate-500">Paid Orders</p>
                 <h3 class="text-2xl font-bold text-slate-900">{{ $orderStats['paid'] }}</h3>
             </div>
        </div>
        <div class="flex gap-2 text-xs">
             <span class="px-2 py-1 bg-slate-100 rounded text-slate-600">Pending: <strong>{{ $orderStats['pending'] }}</strong></span>
             <span class="px-2 py-1 bg-rose-50 rounded text-rose-600">Failed: <strong>{{ $orderStats['failed'] }}</strong></span>
        </div>
    </div>

    <!-- Total Users -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
         <div class="flex items-center gap-4 mb-4">
             <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                 <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
             </div>
             <div>
                 <p class="text-sm font-medium text-slate-500">Total Users</p>
                 <h3 class="text-2xl font-bold text-slate-900">{{ $userStats['total'] }}</h3>
             </div>
        </div>
         <p class="text-xs text-slate-400">
             <span class="text-indigo-600 font-bold">+{{ $userStats['month'] }}</span> user baru bulan ini.
         </p>
    </div>

    <!-- Active Promos -->
    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 text-white shadow-lg shadow-blue-200">
         <div class="flex justify-between items-start mb-4">
             <div>
                 <p class="text-blue-100 text-sm font-medium">Promo Aktif</p>
                 <h3 class="text-3xl font-bold mt-1">{{ $activePromos }}</h3>
             </div>
             <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                  <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
             </div>
         </div>
         <a href="{{ route('admin.promos.index') }}" class="inline-flex items-center text-xs font-semibold text-blue-100 hover:text-white transition">
             Kelola Campaign <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M9 5l7 7-7 7"/></svg>
         </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    
    <!-- LEFT: INVITATION HEALTH -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 lg:col-span-2">
         <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-slate-800">Status Undangan</h3>
         </div>

         <div class="grid grid-cols-3 gap-4 mb-6">
              <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 text-center">
                  <span class="block text-2xl font-bold text-slate-800">{{ $invitationStats['published'] }}</span>
                  <span class="text-xs font-semibold text-emerald-600 uppercase tracking-wide">Published</span>
              </div>
              <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 text-center">
                  <span class="block text-2xl font-bold text-slate-800">{{ $invitationStats['draft'] }}</span>
                  <span class="text-xs font-semibold text-amber-500 uppercase tracking-wide">Draft</span>
              </div>
              <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 text-center">
                  <span class="block text-2xl font-bold text-slate-800">{{ $invitationStats['expired'] }}</span>
                  <span class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Expired</span>
              </div>
         </div>

         <!-- RSVP BAR -->
         <div>
             <div class="flex justify-between items-center mb-2">
                 <h4 class="text-sm font-semibold text-slate-700">RSVP Summary</h4>
                 <span class="text-xs text-slate-400">Total Respons</span>
             </div>
             <div class="h-4 w-full bg-slate-100 rounded-full overflow-hidden flex">
                 <div style="width: {{ $rsvpStats['hadir_pct'] }}%" class="bg-emerald-500 h-full" title="Hadir: {{ $rsvpStats['hadir_pct'] }}%"></div>
                 <div style="width: {{ $rsvpStats['tidak_pct'] }}%" class="bg-rose-500 h-full" title="Tidak Hadir: {{ $rsvpStats['tidak_pct'] }}%"></div>
                 <div style="width: {{ $rsvpStats['ragu_pct'] }}%" class="bg-amber-400 h-full" title="Ragu: {{ $rsvpStats['ragu_pct'] }}%"></div>
             </div>
             <div class="flex justify-between mt-2 text-xs text-slate-500">
                  <span class="flex items-center"><span class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></span> Hadir ({{ $rsvpStats['hadir'] }})</span>
                  <span class="flex items-center"><span class="w-2 h-2 rounded-full bg-rose-500 mr-2"></span> Tidak ({{ $rsvpStats['tidak'] }})</span>
                  <span class="flex items-center"><span class="w-2 h-2 rounded-full bg-amber-400 mr-2"></span> Ragu ({{ $rsvpStats['ragu'] }})</span>
             </div>
         </div>
    </div>

    <!-- RIGHT: TOP PACKAGES -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-6">Paket Terlaris</h3>
        <ul class="space-y-4">
            @forelse($topPackages as $pkg)
            <li class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                     <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                         {{ mb_substr($pkg->name, 0, 1) }}
                     </div>
                     <div>
                         <p class="text-sm font-bold text-slate-900">{{ $pkg->name }}</p>
                         <p class="text-xs text-slate-500">{{ $pkg->total_sold }} terjual</p>
                     </div>
                </div>
                <div class="text-sm font-bold text-slate-700">#{{ $loop->iteration }}</div>
            </li>
            @empty
            <li class="text-sm text-slate-500 text-center py-4">Belum ada data penjualan.</li>
            @endforelse
        </ul>
    </div>
</div>

<!-- ACTIVITY LOGS -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
    <h3 class="text-lg font-bold text-slate-800 mb-4">Aktivitas Terbaru</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-xs text-slate-500 uppercase border-b border-slate-100">
                    <th class="py-3 font-semibold">User</th>
                    <th class="py-3 font-semibold">Action</th>
                    <th class="py-3 font-semibold">Time</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-slate-50">
                @forelse($recentActivities as $log)
                <tr>
                    <td class="py-3 font-medium text-slate-900">{{ $log->user->name ?? 'System' }}</td>
                    <td class="py-3 text-slate-600">{{ $log->description ?? $log->action }}</td>
                    <td class="py-3 text-slate-400 text-xs">{{ $log->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="py-4 text-center text-slate-500">Tidak ada aktivitas terbaru.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection