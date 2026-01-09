<section id="couple" class="py-20 px-6 bg-[#FDFBF7]">
    <div class="text-center mb-12">
        <h2 class="font-script text-5xl text-amber-600 mb-2">Happy Couple</h2>
        <p class="text-slate-500 text-sm tracking-wide">WE ARE GETTING MARRIED</p>
    </div>

    <!-- Bride -->
    <div class="flex flex-col items-center text-center mb-16">
        <div
            class="w-48 h-64 overflow-hidden rounded-full border-4 border-white shadow-xl mb-6 transform hover:scale-105 transition-transform duration-500">
            <img src="{{ $data['couple']['bride_photo'] ?? 'https://images.unsplash.com/photo-1510419262272-91136b856b3b?w=500&auto=format&fit=crop&q=60' }}"
                alt="Bride" class="w-full h-full object-cover">
        </div>
        <h3 class="font-heading text-3xl font-bold text-slate-800 mb-2">
            {{ $data['couple']['bride_name'] ?? 'Bride Name' }}</h3>
        <p class="text-sm text-slate-500 mb-2">Putri dari</p>
        <p class="font-serif text-lg text-slate-700 italic mb-4">{{ $data['couple']['bride_parents'] ?? 'Bapak & Ibu' }}
        </p>

        @if(!empty($data['couple']['bride_instagram']))
            <a href="https://instagram.com/{{ $data['couple']['bride_instagram'] }}" target="_blank"
                class="px-4 py-2 bg-white rounded-full text-xs font-bold text-slate-600 shadow-sm hover:text-amber-600 hover:shadow transition">
                <i class="fab fa-instagram mr-1"></i> @ {{ $data['couple']['bride_instagram'] }}
            </a>
        @endif
    </div>

    <div class="flex justify-center items-center mb-16">
        <span class="font-script text-6xl text-amber-400">&</span>
    </div>

    <!-- Groom -->
    <div class="flex flex-col items-center text-center">
        <div
            class="w-48 h-64 overflow-hidden rounded-full border-4 border-white shadow-xl mb-6 transform hover:scale-105 transition-transform duration-500">
            <img src="{{ $data['couple']['groom_photo'] ?? 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=500&auto=format&fit=crop&q=60' }}"
                alt="Groom" class="w-full h-full object-cover">
        </div>
        <h3 class="font-heading text-3xl font-bold text-slate-800 mb-2">
            {{ $data['couple']['groom_name'] ?? 'Groom Name' }}</h3>
        <p class="text-sm text-slate-500 mb-2">Putra dari</p>
        <p class="font-serif text-lg text-slate-700 italic mb-4">{{ $data['couple']['groom_parents'] ?? 'Bapak & Ibu' }}
        </p>

        @if(!empty($data['couple']['groom_instagram']))
            <a href="https://instagram.com/{{ $data['couple']['groom_instagram'] }}" target="_blank"
                class="px-4 py-2 bg-white rounded-full text-xs font-bold text-slate-600 shadow-sm hover:text-amber-600 hover:shadow transition">
                <i class="fab fa-instagram mr-1"></i> @ {{ $data['couple']['groom_instagram'] }}
            </a>
        @endif
    </div>
</section>