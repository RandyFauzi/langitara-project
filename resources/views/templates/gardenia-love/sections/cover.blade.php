<section id="cover"
    class="relative h-screen w-full overflow-hidden flex items-center justify-center text-center bg-slate-50">
    <!-- Background Image placeholder or binding -->
    <div class="absolute inset-0 z-0">
        <img src="{{ $data['meta']['cover_image'] ?? 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80&w=2000' }}"
            alt="Wedding Background" class="w-full h-full object-cover opacity-80" />
        <div class="absolute inset-0 bg-white/30 backdrop-blur-[2px]"></div>
    </div>

    <div class="relative z-10 px-6 py-12 flex flex-col items-center justify-center h-full fade-in-up">
        <p class="uppercase tracking-[0.2em] text-sm mb-4 text-slate-600">
            {{ $data['meta']['title'] ?? 'The Wedding Of' }}</p>

        <h1 class="text-6xl md:text-7xl font-script text-amber-600 mb-2 leading-tight">
            {{ $data['couple']['bride_name'] ?? 'Bride' }}
        </h1>
        <span class="text-4xl font-serif italic text-slate-400 my-2">&</span>
        <h1 class="text-6xl md:text-7xl font-script text-slate-800 mb-8 leading-tight">
            {{ $data['couple']['groom_name'] ?? 'Groom' }}
        </h1>

        <div class="flex items-center gap-4 mt-8">
            <div class="h-[1px] w-12 bg-slate-400"></div>
            <p class="text-lg font-serif italic text-slate-700">
                {{ $data['meta']['event_date'] ?? '01 . 01 . 2026' }}
            </p>
            <div class="h-[1px] w-12 bg-slate-400"></div>
        </div>

        <div class="absolute bottom-10 animate-bounce">
            <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3">
                </path>
            </svg>
        </div>
    </div>
</section>