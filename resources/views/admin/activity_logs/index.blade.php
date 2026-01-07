@extends('admin.layouts.app')

@section('title', 'Activity Logs')

@section('content')

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Activity Logs</h1>
        <p class="mt-1 text-sm text-slate-500">Audit trail lengkap aktivitas user, admin, dan sistem.</p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 mb-6">
        <form action="{{ route('admin.activity-logs.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <!-- Search -->
            <div class="md:col-span-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-xl bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm"
                    placeholder="Search logs...">
            </div>

            <!-- Actor Filter -->
            <div>
                <select name="actor_type" onchange="this.form.submit()"
                    class="block w-full text-sm border-slate-300 rounded-xl focus:ring-blue-500">
                    <option value="all">Semua Actor</option>
                    <option value="user" {{ request('actor_type') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ request('actor_type') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="system" {{ request('actor_type') == 'system' ? 'selected' : '' }}>System</option>
                </select>
            </div>

            <!-- Date Filter -->
            <div>
                <input type="date" name="date" value="{{ request('date') }}" onchange="this.form.submit()"
                    class="block w-full text-sm border-slate-300 rounded-xl focus:ring-blue-500 text-slate-500">
            </div>

            <!-- Reset -->
            <div class="flex items-center">
                <a href="{{ route('admin.activity-logs.index') }}"
                    class="text-sm text-slate-500 hover:text-blue-600 font-medium">Reset Filter</a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Actor</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Action</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Entity</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Description</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-right">Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @php
                                        $badges = [
                                            'admin' => 'bg-purple-100 text-purple-700',
                                            'user' => 'bg-blue-100 text-blue-700',
                                            'system' => 'bg-slate-100 text-slate-600',
                                        ];
                                        $cls = $badges[$log->actor_type] ?? 'bg-gray-100';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-[10px] uppercase font-bold {{ $cls }}">
                                        {{ $log->actor_type }}
                                    </span>
                                    <div class="text-sm font-semibold text-slate-900">{{ $log->actor_name ?? 'Unknown' }}</div>
                                </div>
                                @if($log->ip_address)
                                    <div class="text-[10px] text-slate-400 font-mono mt-1 pl-14">{{ $log->ip_address }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-slate-700 capitalize">{{ $log->action }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($log->entity_type)
                                    <div class="text-xs font-bold text-slate-500 uppercase">{{ $log->entity_type }}</div>
                                    <div class="text-sm font-mono text-slate-800">#{{ $log->entity_id }}</div>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-600 max-w-xs truncate" title="{{ $log->description }}">
                                    {{ $log->description }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-slate-500">
                                <div>{{ $log->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-slate-400">{{ $log->created_at->format('H:i:s') }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">Log aktivitas kosong.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-slate-200">
            {{ $logs->links() }}
        </div>
    </div>
@endsection