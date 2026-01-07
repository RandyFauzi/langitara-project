@extends('admin.layouts.app')

@section('title', 'Invitation Detail')

@section('content')

    <!-- Breadcrumb -->
    <div class="mb-6 flex items-center gap-2 text-sm text-slate-500">
        <a href="{{ route('admin.invitations.index') }}" class="hover:text-blue-600 transition">Invitations</a>
        <span>/</span>
        <span class="text-slate-800 font-medium">Detail</span>
        <span>/</span>
        <span class="text-slate-400">#{{ $invitation->id }}</span>
    </div>

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">{{ $invitation->title }}</h1>
            <div class="flex items-center gap-3 mt-2 text-sm">
                <a href="{{ url('/invitation/' . $invitation->slug) }}" target="_blank"
                    class="font-mono text-blue-600 bg-blue-50 px-2 py-0.5 rounded border border-blue-100 hover:underline flex items-center gap-1">
                    /{{ $invitation->slug }}
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
                <span class="text-slate-300">|</span>
                @php
                    $statusClasses = [
                        'published' => 'bg-emerald-100 text-emerald-800',
                        'draft' => 'bg-amber-100 text-amber-800',
                        'expired' => 'bg-slate-100 text-slate-600',
                    ];
                    $cls = $statusClasses[$invitation->status] ?? 'bg-slate-100 text-slate-800';
                @endphp
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $cls }} capitalize">
                    {{ $invitation->status }}
                </span>
            </div>
        </div>
        <div class="flex gap-2">
            <form action="{{ route('admin.invitations.impersonate', $invitation->id) }}" method="POST">
                @csrf
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-900 text-white font-medium py-2.5 px-4 rounded-xl transition shadow-sm text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linkecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                    Impersonate User
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left Column: Details & Actions -->
        <div class="space-y-6">
            <!-- Overview Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide mb-4">Invitation Overview</h3>
                <div class="space-y-4">
                    <div>
                        <div class="text-xs text-slate-500 uppercase">Owner</div>
                        <div class="flex items-center gap-2 mt-1">
                            <div
                                class="h-8 w-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500">
                                {{ substr($invitation->user->name ?? 'U', 0, 2) }}
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-slate-900">{{ $invitation->user->name ?? 'Unknown' }}
                                </div>
                                <div class="text-xs text-slate-500">{{ $invitation->user->email ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="text-xs text-slate-500 uppercase">Template</div>
                            <div class="text-sm font-medium text-slate-800 mt-1">{{ $invitation->template->name ?? '-' }}
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500 uppercase">Package</div>
                            <div class="text-sm font-medium text-blue-600 mt-1">{{ $invitation->package->name ?? '-' }}
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="text-xs text-slate-500 uppercase">Values</div>
                            <div class="text-sm font-medium text-slate-800 mt-1">
                                {{ $invitation->event_date ? $invitation->event_date->format('d M Y') : '-' }}
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500 uppercase">Created</div>
                            <div class="text-sm font-medium text-slate-800 mt-1">
                                {{ $invitation->created_at->format('d M Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RSVP Summary Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide mb-4">RSVP Summary</h3>

                <div class="flex items-end justify-between mb-4">
                    <div>
                        <div class="text-3xl font-bold text-slate-900">{{ $rsvpStats['total'] }}</div>
                        <div class="text-xs text-slate-500">Total Responses</div>
                    </div>
                    <!-- Mini pie chart or simplified visual could go here -->
                </div>

                <div class="space-y-3">
                    <!-- Hadir -->
                    <div class="bg-emerald-50 rounded-xl p-3 flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span class="text-sm font-medium text-emerald-900">Hadir</span>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-emerald-700">{{ $rsvpStats['hadir'] }}</div>
                            <div class="text-[10px] text-emerald-600 uppercase">Pax</div>
                        </div>
                    </div>
                    <!-- Tidak -->
                    <div class="bg-rose-50 rounded-xl p-3 flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            <span class="text-sm font-medium text-rose-900">Tidak Hadir</span>
                        </div>
                        <div class="text-lg font-bold text-rose-700">{{ $rsvpStats['tidak'] }}</div>
                    </div>
                    <!-- Ragu -->
                    <div class="bg-amber-50 rounded-xl p-3 flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            <span class="text-sm font-medium text-amber-900">Ragu-ragu</span>
                        </div>
                        <div class="text-lg font-bold text-amber-700">{{ $rsvpStats['ragu'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: RSVP Guest List -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="text-base font-bold text-slate-800">Guest RSVP List</h3>

                    <!-- Simple Filter -->
                    <form action="{{ route('admin.invitations.show', $invitation->id) }}" method="GET">
                        <select name="rsvp_status" onchange="this.form.submit()"
                            class="text-xs border-slate-300 rounded-lg focus:ring-blue-500">
                            <option value="">All Status</option>
                            <option value="hadir" {{ request('rsvp_status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                            <option value="tidak" {{ request('rsvp_status') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            <option value="ragu" {{ request('rsvp_status') == 'ragu' ? 'selected' : '' }}>Ragu</option>
                        </select>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase">Guest Name</th>
                                <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase">Pax</th>
                                <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($rsvps as $rsvp)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-slate-900">{{ $rsvp->guest->name }}</div>
                                        <div class="text-xs text-slate-500">
                                            {{ $rsvp->guest->phone ?? $rsvp->guest->email ?? '-' }}</div>
                                        @if($rsvp->guest->category)
                                            <span
                                                class="inline-block mt-1 px-1.5 py-0.5 bg-slate-100 text-slate-500 text-[10px] rounded border border-slate-200">
                                                {{ $rsvp->guest->category }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusMap = [
                                                'hadir' => ['bg-emerald-100', 'text-emerald-700', 'Hadir'],
                                                'tidak' => ['bg-rose-100', 'text-rose-700', 'Tidak'],
                                                'ragu' => ['bg-amber-100', 'text-amber-700', 'Ragu'],
                                            ];
                                            $status = $statusMap[$rsvp->attendance] ?? ['bg-gray-100', 'text-gray-700', $rsvp->attendance];
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold {{ $status[0] }} {{ $status[1] }}">
                                            {{ $status[2] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-mono text-slate-600">
                                        {{ $rsvp->pax }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-slate-600">{{ $rsvp->created_at->format('d M Y') }}</div>
                                        <div class="text-xs text-slate-400">{{ $rsvp->created_at->format('H:i') }}</div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                                        No RSVP data found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $rsvps->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection