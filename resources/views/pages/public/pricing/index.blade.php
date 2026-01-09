@extends('layouts.public')

@section('title', 'Harga - LANGITARA')

@section('content')
<!-- Hero Section -->
<section class="pt-32 pb-16 bg-gradient-to-b from-ivory to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-rose-gold font-medium tracking-widest uppercase text-sm mb-4">PRICELIST</p>
        <h1 class="font-serif text-4xl md:text-5xl font-bold text-charcoal mb-6">
            Pilih Paket <span class="text-rose-gold">Terbaik</span> Anda
        </h1>
        <p class="text-lg text-slate-600 max-w-2xl mx-auto">
            Temukan paket undangan digital yang sesuai dengan kebutuhan acara Anda.
        </p>
    </div>
</section>

<!-- Pricing Cards -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Main Packages Grid (4 columns) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($packages->take(4) as $index => $package)
                <div class="relative bg-white rounded-3xl border-2 {{ $package->is_featured ? 'border-rose-gold shadow-2xl scale-105 z-10' : 'border-slate-100 shadow-lg' }} overflow-hidden transition-all duration-300 hover:shadow-xl flex flex-col">
                    
                    <!-- Featured Badge -->
                    @if($package->is_featured)
                        <div class="absolute top-0 left-0 right-0 bg-gradient-to-r from-rose-gold to-rose-500 text-white text-center py-2 text-xs font-bold uppercase tracking-wider">
                            🔥 Paling Populer
                        </div>
                    @endif

                    <div class="p-6 {{ $package->is_featured ? 'pt-12' : '' }} flex-1 flex flex-col">
                        <!-- Package Name -->
                        <div class="mb-4">
                            <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Paket</p>
                            <h3 class="font-serif text-2xl font-bold text-charcoal">{{ $package->name }}</h3>
                        </div>

                        <!-- Pricing -->
                        <div class="mb-6">
                            @if($package->hasPromo())
                                <p class="text-sm text-slate-400 line-through">{{ $package->formatted_original_price }}</p>
                            @endif
                            <div class="flex items-baseline gap-1">
                                <span class="text-3xl font-bold {{ $package->price == 0 ? 'text-green-600' : 'text-rose-gold' }}">
                                    {{ $package->formatted_price }}
                                </span>
                            </div>
                            @if($package->duration_days > 0)
                                <p class="text-xs text-slate-500 mt-1">Aktif {{ $package->duration_days }} hari</p>
                            @else
                                <p class="text-xs text-slate-500 mt-1">Tanpa batas waktu</p>
                            @endif
                        </div>

                        <!-- Features -->
                        <ul class="space-y-3 mb-6 flex-1">
                            @foreach($package->features ?? [] as $feature)
                                <li class="flex items-start gap-2 text-sm">
                                    @if(str_contains(strtolower($feature), 'tidak') || str_contains(strtolower($feature), 'coming soon'))
                                        <div class="flex-shrink-0 w-4 h-4 rounded-full bg-slate-100 flex items-center justify-center mt-0.5">
                                            <svg class="w-2.5 h-2.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </div>
                                        <span class="text-slate-400">{{ $feature }}</span>
                                    @else
                                        <div class="flex-shrink-0 w-4 h-4 rounded-full bg-green-100 flex items-center justify-center mt-0.5">
                                            <svg class="w-2.5 h-2.5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <span class="text-slate-700">{{ $feature }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>

                        <!-- CTA Button -->
                        <a href="{{ route('register') }}" 
                           class="block w-full text-center py-3 rounded-xl font-semibold transition-all duration-300 {{ $package->is_featured ? 'bg-rose-gold text-white hover:bg-rose-600 shadow-lg' : 'bg-charcoal text-white hover:bg-charcoal/90' }}">
                            {{ $package->can_publish ? 'Pilih Paket' : 'Coba Gratis' }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Partnership Package (Full Width) -->
        @php $partnership = $packages->where('slug', 'partnership')->first(); @endphp
        @if($partnership)
            <div class="mt-12 bg-gradient-to-br from-charcoal to-slate-800 rounded-3xl overflow-hidden shadow-2xl">
                <div class="p-8 md:p-12">
                    <div class="grid md:grid-cols-2 gap-8 items-center">
                        <!-- Left: Info -->
                        <div>
                            <span class="inline-block bg-rose-gold/20 text-rose-gold px-4 py-1 rounded-full text-sm font-semibold mb-4">
                                🤝 Untuk Bisnis & Vendor
                            </span>
                            <h3 class="font-serif text-3xl md:text-4xl font-bold text-white mb-4">{{ $partnership->name }}</h3>
                            <p class="text-slate-300 mb-6">{{ $partnership->description }}</p>
                            
                            <div class="mb-6">
                                <span class="text-sm text-slate-400">Mulai dari</span>
                                <p class="text-4xl font-bold text-white">{{ $partnership->formatted_price }}</p>
                            </div>
                            
                            <a href="https://wa.me/6281234567890?text=Halo,%20saya%20tertarik%20dengan%20Paket%20Partnership" 
                               target="_blank"
                               class="inline-flex items-center gap-2 bg-green-500 text-white font-semibold px-8 py-4 rounded-xl hover:bg-green-600 transition shadow-lg">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                Hubungi Tim Kami
                            </a>
                        </div>
                        
                        <!-- Right: Features -->
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6">
                            <h4 class="text-white font-semibold mb-4">Fitur Lengkap:</h4>
                            <ul class="space-y-3">
                                @foreach($partnership->features ?? [] as $feature)
                                    <li class="flex items-start gap-3 text-sm">
                                        <div class="flex-shrink-0 w-5 h-5 rounded-full bg-green-500/20 flex items-center justify-center mt-0.5">
                                            <svg class="w-3 h-3 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <span class="text-slate-200">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- FAQ Section -->
<section class="py-20 bg-ivory">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="font-serif text-3xl font-bold text-charcoal mb-4">Pertanyaan Umum</h2>
        </div>
        
        <div class="space-y-4" x-data="{ open: null }">
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <button @click="open = open === 1 ? null : 1" class="w-full flex items-center justify-between p-6 text-left">
                    <span class="font-semibold text-charcoal">Apa perbedaan antar paket?</span>
                    <svg class="w-5 h-5 text-slate-500 transition-transform" :class="{ 'rotate-180': open === 1 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open === 1" x-collapse class="px-6 pb-6">
                    <p class="text-slate-600">Perbedaan utama ada pada jumlah undangan, durasi aktivasi, dan akses ke template. Paket Free hanya untuk trial dan tidak bisa dipublish.</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <button @click="open = open === 2 ? null : 2" class="w-full flex items-center justify-between p-6 text-left">
                    <span class="font-semibold text-charcoal">Bisa upgrade paket?</span>
                    <svg class="w-5 h-5 text-slate-500 transition-transform" :class="{ 'rotate-180': open === 2 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open === 2" x-collapse class="px-6 pb-6">
                    <p class="text-slate-600">Ya, Anda bisa upgrade paket kapan saja dengan membayar selisih harga paket.</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <button @click="open = open === 3 ? null : 3" class="w-full flex items-center justify-between p-6 text-left">
                    <span class="font-semibold text-charcoal">Bagaimana cara pembayaran?</span>
                    <svg class="w-5 h-5 text-slate-500 transition-transform" :class="{ 'rotate-180': open === 3 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open === 3" x-collapse class="px-6 pb-6">
                    <p class="text-slate-600">Pembayaran bisa dilakukan via transfer bank, e-wallet (OVO, GoPay, Dana), atau QRIS.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection