@extends('admin.layouts.app')

@section('title', 'Invitation Management')

@section('content')

    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Invitation Management</h1>
            <p class="mt-1 text-sm text-slate-500">Monitor seluruh undangan, status publikasi, dan engagement.</p>
        </div>
        <a href="{{ route('admin.invitations.create') }}"
            class="px-5 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Buat Undangan
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 mb-6">
        <form action="{{ route('admin.invitations.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <!-- Search -->
            <div class="md:col-span-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-xl bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm"
                    placeholder="Cari (Judul, Slug, User)...">
            </div>

            <!-- Status Filter -->
            <div>
                <select name="status" onchange="this.form.submit()"
                    class="block w-full text-sm border-slate-300 rounded-xl focus:ring-blue-500">
                    <option value="all">Semua Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                </select>
            </div>

            <!-- Template Filter -->
            <div>
                <select name="template_id" onchange="this.form.submit()"
                    class="block w-full text-sm border-slate-300 rounded-xl focus:ring-blue-500">
                    <option value="">Semua Template</option>
                    @foreach($templates as $tpl)
                        <option value="{{ $tpl->id }}" {{ request('template_id') == $tpl->id ? 'selected' : '' }}>{{ $tpl->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Reset -->
            <div class="flex items-center">
                <a href="{{ route('admin.invitations.index') }}"
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
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Invitation</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">User</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Event Date</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">RSVP Summary</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($invitations as $inv)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900">{{ $inv->title }}</div>
                                <div class="text-xs text-slate-500 font-mono mt-0.5">/{{ $inv->slug }}</div>
                                <span
                                    class="inline-flex mt-1 items-center px-2 py-0.5 rounded text-[10px] bg-slate-100 text-slate-600 border border-slate-200">
                                    {{ $inv->template->name ?? 'Unknown Tpl' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-slate-900">{{ $inv->user->name ?? 'Deleted User' }}</div>
                                <div class="text-xs text-slate-500">{{ $inv->user->email ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'published' => 'bg-emerald-100 text-emerald-800',
                                        'draft' => 'bg-amber-100 text-amber-800',
                                        'expired' => 'bg-slate-100 text-slate-600',
                                        'archived' => 'bg-rose-100 text-rose-800',
                                    ];
                                    $cls = $statusClasses[$inv->status] ?? 'bg-slate-100 text-slate-800';
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $cls }} capitalize">
                                    {{ $inv->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $inv->event_date ? $inv->event_date->format('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    // Normally valid to aggregate here if eager loaded, or use separate counts
                                    // Since we eager loaded 'rsvps', we can count collection (careful with memory on large sets)
                                    // For scalability, withCount(['rsvps as hadir_count' => ...]) is better but for now collection is mostly fine for paginated 10.
                                    $hadir = $inv->rsvps->where('attendance', 'hadir')->count();
                                    $tidak = $inv->rsvps->where('attendance', 'tidak')->count();
                                    $ragu = $inv->rsvps->where('attendance', 'ragu')->count();
                                @endphp
                                <div class="flex items-center gap-2 text-xs">
                                    <span class="px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-700 font-bold"
                                        title="Hadir">{{ $hadir }} H</span>
                                    <span class="px-1.5 py-0.5 rounded bg-rose-50 text-rose-700 font-bold"
                                        title="Tidak">{{ $tidak }} T</span>
                                    <span class="px-1.5 py-0.5 rounded bg-amber-50 text-amber-700 font-bold"
                                        title="Ragu">{{ $ragu }} R</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.invitations.editor', $inv->id) }}" title="Open Editor" 
                                    class="inline-block text-sm font-medium text-indigo-600 hover:text-indigo-800 bg-white border border-indigo-200 hover:bg-indigo-50 px-3 py-1.5 rounded-lg transition shadow-sm mr-2">
                                    Edit UI
                                </a>
                                <a href="{{ route('admin.invitations.show', $inv->id) }}"
                                    class="inline-block text-sm font-medium text-slate-600 hover:text-slate-800 bg-white border border-slate-200 hover:bg-slate-50 px-3 py-1.5 rounded-lg transition shadow-sm">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">Tidak ada undangan ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-slate-200">
            {{ $invitations->links() }}
        </div>
    </div>

@endsection