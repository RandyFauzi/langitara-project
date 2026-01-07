@extends('admin.layouts.app')

@section('title', 'RSVP Management')

@section('content')

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">RSVP Management</h1>
        <p class="mt-1 text-sm text-slate-500">Monitor konfirmasi kehadiran tamu dari seluruh undangan.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <div class="text-sm font-medium text-slate-500 mb-1">Total RSVP</div>
                <div class="text-3xl font-bold text-slate-900">{{ number_format($stats['total']) }}</div>
            </div>
            <div class="p-3 bg-blue-50 rounded-xl">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                    </path>
                </svg>
            </div>
        </div>

        <!-- Hadir -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <div class="text-sm font-medium text-slate-500 mb-1">Hadir</div>
                <div class="text-3xl font-bold text-emerald-600">{{ number_format($stats['hadir']) }}</div>
            </div>
            <div class="p-3 bg-emerald-50 rounded-xl">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>

        <!-- Tidak Hadir -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <div class="text-sm font-medium text-slate-500 mb-1">Tidak Hadir</div>
                <div class="text-3xl font-bold text-rose-600">{{ number_format($stats['tidak']) }}</div>
            </div>
            <div class="p-3 bg-rose-50 rounded-xl">
                <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
        </div>

        <!-- Ragu/Pending -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <div class="text-sm font-medium text-slate-500 mb-1">Ragu-ragu</div>
                <div class="text-3xl font-bold text-amber-500">{{ number_format($stats['ragu']) }}</div>
            </div>
            <div class="p-3 bg-amber-50 rounded-xl">
                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 mb-6">
        <form action="{{ route('admin.rsvps.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <!-- Search -->
            <div class="md:col-span-2 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-xl bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm"
                    placeholder="Search Guest Name, Invitation, or Slug...">
            </div>

            <!-- Attendance Filter -->
            <div>
                <select name="attendance" onchange="this.form.submit()"
                    class="block w-full text-sm border-slate-300 rounded-xl focus:ring-blue-500 text-slate-600">
                    <option value="all">Semua Status</option>
                    <option value="hadir" {{ request('attendance') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="tidak" {{ request('attendance') == 'tidak' ? 'selected' : '' }}>Tidak Hadir</option>
                    <option value="ragu" {{ request('attendance') == 'ragu' ? 'selected' : '' }}>Ragu-ragu</option>
                </select>
            </div>

            <!-- Reset -->
            <div class="flex items-center">
                <a href="{{ route('admin.rsvps.index') }}"
                    class="text-sm text-slate-500 hover:text-blue-600 font-medium ml-2">Reset Filter</a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Guest Details</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">RSVP Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Invitation Context</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-right">Time</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($rsvps as $rsvp)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-slate-900">{{ $rsvp->guest->name }}</div>
                                <div class="text-xs text-slate-500">{{ $rsvp->guest->phone ?? $rsvp->guest->email ?? '-' }}
                                </div>
                                @if($rsvp->pax > 1)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600 mt-1">
                                        +{{ $rsvp->pax - 1 }} Others
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusMap = [
                                        'hadir' => ['bg-emerald-100', 'text-emerald-700', 'Hadir'],
                                        'tidak' => ['bg-rose-100', 'text-rose-700', 'Tidak Hadir'],
                                        'ragu' => ['bg-amber-100', 'text-amber-700', 'Ragu-ragu'],
                                    ];
                                    $status = $statusMap[$rsvp->attendance] ?? ['bg-gray-100', 'text-gray-700', $rsvp->attendance];
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $status[0] }} {{ $status[1] }}">
                                    {{ $status[2] }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="max-w-xs">
                                    <div class="text-sm font-medium text-slate-900 truncate"
                                        title="{{ $rsvp->guest->invitation->title ?? 'N/A' }}">
                                        {{ $rsvp->guest->invitation->title ?? 'Deleted Invitation' }}
                                    </div>
                                    <div class="flex items-center gap-1 mt-0.5">
                                        <span
                                            class="text-[10px] text-slate-500 bg-slate-100 px-1.5 py-0.5 rounded border border-slate-200">
                                            /{{ $rsvp->guest->invitation->slug ?? '...' }}
                                        </span>
                                        <span class="text-[10px] text-slate-400">
                                            by {{ $rsvp->guest->invitation->user->name ?? 'Unknown' }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-slate-500">
                                <div>{{ $rsvp->created_at->format('d M') }}</div>
                                <div class="text-xs text-slate-400">{{ $rsvp->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button onclick="openRsvpModal({{ $rsvp->id }})"
                                    class="text-sm font-medium text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                        </path>
                                    </svg>
                                    <p class="text-sm">Belum ada data RSVP ditemukan.</p>
                                </div>
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

    <!-- Detail Modal -->
    <div id="rsvpModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" onclick="closeRsvpModal()"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:w-full sm:max-w-lg">

                    <!-- Modal Header -->
                    <div class="bg-slate-50 px-4 py-4 sm:px-6 border-b border-slate-100 flex justify-between items-center">
                        <h3 class="text-lg font-semibold leading-6 text-slate-900" id="modal-title">Detail RSVP</h3>
                        <button type="button" onclick="closeRsvpModal()" class="text-slate-400 hover:text-slate-500">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="px-4 py-5 sm:p-6 space-y-4">
                        <!-- Guest Info -->
                        <div class="bg-blue-50/50 rounded-xl p-4 border border-blue-100">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Tamu</h4>
                                    <div class="text-lg font-bold text-slate-800 mt-1" id="modalGuestName">Loading...</div>
                                </div>
                                <span id="modalStatusBadge"
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    ...
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-3">
                                <div>
                                    <label class="text-xs text-slate-500 block">Kontak</label>
                                    <div class="text-sm font-medium text-slate-900" id="modalContact">-</div>
                                </div>
                                <div>
                                    <label class="text-xs text-slate-500 block">Jumlah Pax</label>
                                    <div class="text-sm font-medium text-slate-900" id="modalPax">-</div>
                                </div>
                            </div>
                        </div>

                        <!-- Invitation Context -->
                        <div class="border border-slate-200 rounded-xl p-4">
                            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-3">Undangan Terkait</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm text-slate-600">Judul</span>
                                    <span class="text-sm font-medium text-slate-900 text-right truncate w-48"
                                        id="modalInvTitle">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-slate-600">URL Slug</span>
                                    <span
                                        class="text-sm font-mono text-blue-600 bg-blue-50 px-2 py-0.5 rounded border border-blue-100"
                                        id="modalInvSlug">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-slate-600">Pemilik (User)</span>
                                    <span class="text-sm font-medium text-slate-900" id="modalOwner">-</span>
                                </div>
                            </div>
                        </div>

                        <!-- Metadata -->
                        <div class="text-xs text-slate-400 pt-2 flex justify-between border-t border-slate-100">
                            <span>Submitted: <span id="modalTime">-</span></span>
                            <span>ID: #<span id="modalId">-</span></span>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button" onclick="closeRsvpModal()"
                            class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-3 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openRsvpModal(id) {
            const modal = document.getElementById('rsvpModal');
            modal.classList.remove('hidden');

            // Fetch Data
            fetch(`/admin/rsvps/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modalGuestName').textContent = data.guest_name;
                    document.getElementById('modalContact').textContent = data.guest_contact;
                    document.getElementById('modalPax').textContent = data.rsvp.pax + ' Orang';
                    document.getElementById('modalInvTitle').textContent = data.invitation_title;
                    document.getElementById('modalInvSlug').textContent = data.invitation_slug;
                    document.getElementById('modalOwner').textContent = data.owner_name;
                    document.getElementById('modalTime').textContent = data.created_formatted;
                    document.getElementById('modalId').textContent = data.rsvp.id;

                    // Status Badge Logic
                    const status = data.rsvp.attendance;
                    const badge = document.getElementById('modalStatusBadge');

                    let classes = 'bg-gray-100 text-gray-800';
                    let label = status;

                    if (status === 'hadir') {
                        classes = 'bg-emerald-100 text-emerald-800';
                        label = 'Hadir';
                    } else if (status === 'tidak') {
                        classes = 'bg-rose-100 text-rose-800';
                        label = 'Tidak Hadir';
                    } else if (status === 'ragu') {
                        classes = 'bg-amber-100 text-amber-800';
                        label = 'Ragu-ragu';
                    }

                    badge.className = `inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${classes}`;
                    badge.textContent = label;
                });
        }

        function closeRsvpModal() {
            document.getElementById('rsvpModal').classList.add('hidden');
        }
    </script>

@endsection