@extends('layouts.public')

@section('content')
<div class="pt-24 pb-16 min-h-screen bg-gradient-to-b from-ivory to-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- Greeting Section -->
        <div class="bg-white/60 backdrop-blur-sm border border-slate-100 p-6 md:p-8 rounded-2xl flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-semibold text-charcoal">
                    Selamat datang, {{ $user->name }}! 👋
                </h1>
                <p class="text-slate-500 mt-1">Kelola undangan digital Anda dari sini.</p>
            </div>
            <a href="{{ route('public.templates.index') }}"
                class="inline-flex items-center justify-center gap-2 bg-charcoal text-white font-semibold px-6 py-3 rounded-xl hover:bg-charcoal/90 transition shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Undangan
            </a>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Total Undangan -->
            <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
                <p class="text-3xl font-bold text-charcoal">{{ $stats['total_invitations'] }}</p>
                <p class="text-sm text-slate-500 mt-1">Total Undangan</p>
            </div>

            <!-- Published -->
            <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
                <p class="text-3xl font-bold text-green-600">{{ $stats['published_invitations'] }}</p>
                <p class="text-sm text-slate-500 mt-1">Terpublish</p>
            </div>

            <!-- Total Guests -->
            <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
                <p class="text-3xl font-bold text-charcoal">{{ $stats['total_guests'] }}</p>
                <p class="text-sm text-slate-500 mt-1">Total Tamu</p>
            </div>

            <!-- Total RSVPs -->
            <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
                <p class="text-3xl font-bold text-charcoal">{{ $stats['total_rsvps'] }}</p>
                <p class="text-sm text-slate-500 mt-1">RSVP</p>
            </div>
        </div>

        <!-- Undangan Saya -->
        <div>
            <h2 class="text-lg font-semibold text-charcoal mb-4">Undangan Saya</h2>

            @if($invitations->count() > 0)
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($invitations as $invitation)
                        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-md transition group">
                            <!-- Thumbnail -->
                            <div class="aspect-[16/9] bg-slate-100 relative overflow-hidden">
                                @if($invitation['template_thumbnail'])
                                    <img src="{{ $invitation['template_thumbnail'] }}" alt="{{ $invitation['title'] }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <!-- Status Badge -->
                                <div class="absolute top-3 right-3">
                                    @if($invitation['status'] === 'published')
                                        <span class="inline-flex items-center rounded-full bg-green-500 px-2.5 py-0.5 text-xs font-medium text-white shadow">
                                            Published
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-amber-500 px-2.5 py-0.5 text-xs font-medium text-white shadow">
                                            Draft
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-4">
                                <h4 class="font-semibold text-charcoal truncate">{{ $invitation['title'] }}</h4>
                                @if($invitation['event_date'])
                                    <p class="text-xs text-slate-400 mt-1">
                                        {{ \Carbon\Carbon::parse($invitation['event_date'])->format('d M Y') }}
                                    </p>
                                @endif

                                <!-- Actions -->
                                <div class="flex items-center gap-2 mt-4">
                                    <a href="{{ route('admin.invitations.editor', $invitation['id']) }}" 
                                       class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-charcoal text-white rounded-lg text-sm font-medium hover:bg-charcoal/90 transition">
                                        Edit
                                    </a>
                                    @if($invitation['status'] === 'published')
                                        <a href="{{ $invitation['public_url'] }}" target="_blank"
                                           class="inline-flex items-center justify-center px-3 py-2 bg-slate-100 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-200 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl border border-dashed border-slate-200 p-12 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-charcoal mb-1">Belum ada undangan</h4>
                    <p class="text-slate-500 text-sm mb-6">Mulai buat undangan digital pertama Anda sekarang.</p>
                    <a href="{{ route('public.templates.index') }}" 
                       class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-charcoal text-white font-semibold rounded-xl hover:bg-charcoal/90 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Buat Undangan Pertama
                    </a>
                </div>
            @endif
        </div>

        <!-- Account Link -->
        <div class="text-center pt-4">
            <a href="{{ route('dashboard.account') }}" class="text-sm text-slate-500 hover:text-charcoal transition">
                Pengaturan Akun →
            </a>
        </div>

    </div>
</div>
@endsection