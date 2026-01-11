<section class="section-padding bg-[#FAF8F5] relative overflow-hidden" id="about">
    <!-- Floating Ornaments with Animation -->
    <!-- Top Right Ornament -->
    <div class="absolute top-0 right-0 w-48 h-48 z-0 animate-float-slow opacity-70">
        <img src="{{ asset('images/hero/ornament.png') }}" class="w-full h-full object-contain transform rotate-180"
            alt="Ornament">
    </div>

    <!-- Bottom Left Ornament -->
    <div class="absolute -bottom-10 -left-10 w-56 h-56 z-0 animate-float-medium opacity-60">
        <img src="{{ asset('images/hero/ornament.png') }}" class="w-full h-full object-contain" alt="Ornament">
    </div>

    <!-- Small Floating Ornament - Bottom Right -->
    <div class="absolute bottom-20 right-20 w-32 h-32 z-0 animate-float-fast opacity-50 hidden lg:block">
        <img src="{{ asset('images/hero/ornament.png') }}" class="w-full h-full object-contain transform scale-75"
            alt="Ornament">
    </div>

    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-16 items-center relative z-10">
        <!-- Left - Couple Image with Ornaments -->
        <div class="relative" data-aos="fade-right">
            <div class="relative w-full max-w-xl mx-auto lg:scale-110">
                <!-- Main Couple Image -->
                <img src="{{ asset('images/hero/couple.png') }}" class="w-full h-auto relative z-10 drop-shadow-xl"
                    alt="Wedding Couple">

                <!-- Decorative Glow Effects -->
                <div class="absolute -top-5 -right-5 w-24 h-24 bg-champagne/40 rounded-full blur-2xl animate-pulse z-0">
                </div>
                <div
                    class="absolute -bottom-5 -left-5 w-28 h-28 bg-rose-200/50 rounded-full blur-2xl animate-pulse z-0">
                </div>
            </div>
        </div>

        <!-- Right - Content -->
        <div data-aos="fade-left">
            <h4 class="text-rose-600 font-bold tracking-widest uppercase text-sm mb-2">Tentang Langitara</h4>
            <h2 class="font-serif text-4xl font-bold text-charcoal mb-6">Wujudkan Pernikahan Anda dengan Undangan
                Spesial</h2>
            <p class="text-gray-600 mb-6 leading-relaxed">
                Langitara hadir untuk membantu Anda berbagi cerita cinta yang tak terlupakan.
                Setiap undangan bukan sekadar informasi, melainkan bagian dari kisah perjalanan pernikahan yang penuh
                makna.
            </p>
            <p class="text-gray-600 mb-8 leading-relaxed">
                Kami percaya bahwa setiap pernikahan pantas dikenang dengan cara yang istimewa. Dengan desain elegan dan
                pilihan yang dapat disesuaikan, kami membantu Anda menciptakan undangan yang sempurna untuk momen
                berharga ini.
            </p>

            <a href="{{ route('public.about') }}"
                class="text-charcoal font-semibold border-b-2 border-rose-400 hover:text-rose-600 hover:border-rose-600 transition-colors inline-flex items-center gap-2">
                Pelajari Lebih Lanjut
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                    </path>
                </svg>
            </a>
        </div>
    </div>
</section>

<style>
    /* Floating Animation Keyframes for About Section */
    @keyframes float-slow {

        0%,
        100% {
            transform: translateY(0) rotate(180deg);
        }

        50% {
            transform: translateY(-20px) rotate(185deg);
        }
    }

    @keyframes float-medium {

        0%,
        100% {
            transform: translateY(0) rotate(0deg);
        }

        50% {
            transform: translateY(-15px) rotate(-5deg);
        }
    }

    @keyframes float-fast {

        0%,
        100% {
            transform: translateY(0) scale(0.75);
        }

        50% {
            transform: translateY(-10px) scale(0.78);
        }
    }

    /* Apply Animations */
    .animate-float-slow {
        animation: float-slow 6s ease-in-out infinite;
    }

    .animate-float-medium {
        animation: float-medium 5s ease-in-out infinite;
    }

    .animate-float-fast {
        animation: float-fast 4s ease-in-out infinite;
    }
</style>