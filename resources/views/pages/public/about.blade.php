@extends('layouts.public')

@section('title', 'Tentang Kami - LANGITARA')

@section('content')
    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 bg-gradient-to-b from-ivory to-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Text -->
                <div>
                    <p class="text-rose-gold font-medium tracking-widest uppercase text-sm mb-4">Tentang Kami</p>
                    <h1 class="font-serif text-4xl md:text-5xl lg:text-6xl font-bold text-charcoal leading-tight mb-6">
                        Menciptakan Momen<br>
                        <span class="text-rose-gold">Tak Terlupakan</span>
                    </h1>
                    <p class="text-lg text-slate-600 leading-relaxed mb-8">
                        LANGITARA hadir untuk membantu Anda menciptakan undangan digital premium yang elegan,
                        personal, dan mudah dibagikan kepada semua tamu spesial Anda.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('public.templates.index') }}"
                            class="inline-flex items-center gap-2 bg-charcoal text-white font-semibold px-8 py-4 rounded-xl hover:bg-charcoal/90 transition shadow-lg">
                            Lihat Template
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>
                <!-- Image -->
                <div class="relative">
                    <div class="aspect-[4/3] rounded-3xl overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1519741497674-611481863552?w=800&q=80"
                            alt="Wedding Celebration" class="w-full h-full object-cover">
                    </div>
                    <!-- Floating badge -->
                    <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl shadow-xl p-6 hidden md:block">
                        <p class="text-4xl font-bold text-charcoal">3+</p>
                        <p class="text-sm text-slate-500">Tahun Pengalaman</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-charcoal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <p class="text-4xl md:text-5xl font-bold text-white mb-2">1000+</p>
                    <p class="text-slate-300">Undangan Dibuat</p>
                </div>
                <div>
                    <p class="text-4xl md:text-5xl font-bold text-white mb-2">500+</p>
                    <p class="text-slate-300">Klien Bahagia</p>
                </div>
                <div>
                    <p class="text-4xl md:text-5xl font-bold text-white mb-2">25+</p>
                    <p class="text-slate-300">Template Premium</p>
                </div>
                <div>
                    <p class="text-4xl md:text-5xl font-bold text-white mb-2">99%</p>
                    <p class="text-slate-300">Kepuasan Pelanggan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <!-- Image -->
                <div class="order-2 md:order-1">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <div class="aspect-[3/4] rounded-2xl overflow-hidden shadow-lg">
                                <img src="https://images.unsplash.com/photo-1606216794074-735e91aa2c92?w=400&q=80"
                                    alt="Wedding Detail" class="w-full h-full object-cover">
                            </div>
                        </div>
                        <div class="space-y-4 pt-8">
                            <div class="aspect-[3/4] rounded-2xl overflow-hidden shadow-lg">
                                <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=400&q=80"
                                    alt="Happy Couple" class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Text -->
                <div class="order-1 md:order-2">
                    <p class="text-rose-gold font-medium tracking-widest uppercase text-sm mb-4">Misi Kami</p>
                    <h2 class="font-serif text-3xl md:text-4xl font-bold text-charcoal mb-6">
                        Memberikan Pengalaman Digital Premium
                    </h2>
                    <p class="text-slate-600 leading-relaxed mb-6">
                        Kami percaya bahwa setiap momen spesial layak diabadikan dengan cara yang indah.
                        LANGITARA hadir dengan visi menjadikan undangan digital sebagai pengalaman yang
                        tak terlupakan, bukan sekadar informasi biasa.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <div
                                class="flex-shrink-0 w-6 h-6 rounded-full bg-green-100 flex items-center justify-center mt-1">
                                <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="text-slate-600"><strong class="text-charcoal">Kualitas Premium</strong> - Template
                                dirancang dengan standar tinggi dan detail yang sempurna.</p>
                        </li>
                        <li class="flex items-start gap-3">
                            <div
                                class="flex-shrink-0 w-6 h-6 rounded-full bg-green-100 flex items-center justify-center mt-1">
                                <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="text-slate-600"><strong class="text-charcoal">Personalisasi Mudah</strong> - Sesuaikan
                                setiap detail undangan sesuai keinginan Anda.</p>
                        </li>
                        <li class="flex items-start gap-3">
                            <div
                                class="flex-shrink-0 w-6 h-6 rounded-full bg-green-100 flex items-center justify-center mt-1">
                                <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="text-slate-600"><strong class="text-charcoal">Dukungan 24/7</strong> - Tim kami siap
                                membantu kapan saja Anda membutuhkan.</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-20 bg-gradient-to-b from-ivory to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <p class="text-rose-gold font-medium tracking-widest uppercase text-sm mb-4">Nilai Kami</p>
                <h2 class="font-serif text-3xl md:text-4xl font-bold text-charcoal">
                    Mengapa Memilih LANGITARA?
                </h2>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Value 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-100 hover:shadow-lg transition">
                    <div class="w-14 h-14 bg-rose-gold/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-rose-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-charcoal mb-3">Dibuat dengan Cinta</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Setiap template dibuat dengan penuh perhatian dan dedikasi untuk memberikan hasil terbaik.
                    </p>
                </div>
                <!-- Value 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-100 hover:shadow-lg transition">
                    <div class="w-14 h-14 bg-rose-gold/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-rose-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-charcoal mb-3">Cepat & Responsif</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Undangan Anda akan tampil sempurna di semua perangkat, dari desktop hingga smartphone.
                    </p>
                </div>
                <!-- Value 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-100 hover:shadow-lg transition">
                    <div class="w-14 h-14 bg-rose-gold/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-rose-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-charcoal mb-3">Aman & Terpercaya</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Data Anda aman bersama kami dengan sistem keamanan dan backup yang terjamin.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <p class="text-rose-gold font-medium tracking-widest uppercase text-sm mb-4">Testimoni</p>
                <h2 class="font-serif text-3xl md:text-4xl font-bold text-charcoal">
                    Apa Kata Klien Kami?
                </h2>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-ivory rounded-2xl p-8">
                    <div class="flex items-center gap-1 mb-4">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                    <p class="text-slate-600 leading-relaxed mb-6">
                        "Undangan yang sangat cantik dan elegan. Tamu-tamu kami semua terkesima dengan desainnya. Terima
                        kasih LANGITARA!"
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-rose-gold/20 flex items-center justify-center">
                            <span class="text-rose-gold font-bold">AS</span>
                        </div>
                        <div>
                            <p class="font-semibold text-charcoal">Andi & Sari</p>
                            <p class="text-sm text-slate-500">Wedding 2024</p>
                        </div>
                    </div>
                </div>
                <!-- Testimonial 2 -->
                <div class="bg-ivory rounded-2xl p-8">
                    <div class="flex items-center gap-1 mb-4">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                    <p class="text-slate-600 leading-relaxed mb-6">
                        "Prosesnya sangat mudah dan hasilnya luar biasa. Tim support juga sangat responsif dan helpful."
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-rose-gold/20 flex items-center justify-center">
                            <span class="text-rose-gold font-bold">BD</span>
                        </div>
                        <div>
                            <p class="font-semibold text-charcoal">Budi & Dewi</p>
                            <p class="text-sm text-slate-500">Wedding 2024</p>
                        </div>
                    </div>
                </div>
                <!-- Testimonial 3 -->
                <div class="bg-ivory rounded-2xl p-8">
                    <div class="flex items-center gap-1 mb-4">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                    <p class="text-slate-600 leading-relaxed mb-6">
                        "Harga terjangkau dengan kualitas premium. Sangat recommended untuk pasangan yang ingin undangan
                        digital berkelas."
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-rose-gold/20 flex items-center justify-center">
                            <span class="text-rose-gold font-bold">RM</span>
                        </div>
                        <div>
                            <p class="font-semibold text-charcoal">Raka & Maya</p>
                            <p class="text-sm text-slate-500">Wedding 2023</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-charcoal to-charcoal/90">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-serif text-3xl md:text-4xl font-bold text-white mb-6">
                Siap Membuat Undangan Impian Anda?
            </h2>
            <p class="text-lg text-slate-300 mb-8 max-w-2xl mx-auto">
                Hubungi kami sekarang untuk konsultasi gratis atau mulai buat undangan digital Anda sendiri.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('public.templates.index') }}"
                    class="inline-flex items-center gap-2 bg-rose-gold text-white font-semibold px-8 py-4 rounded-xl hover:bg-rose-gold/90 transition shadow-lg">
                    Mulai Sekarang
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
                <a href="https://wa.me/6281234567890" target="_blank"
                    class="inline-flex items-center gap-2 bg-white text-charcoal font-semibold px-8 py-4 rounded-xl hover:bg-ivory transition shadow-lg">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    Hubungi via WhatsApp
                </a>
            </div>
        </div>
    </section>
@endsection