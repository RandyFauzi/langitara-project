<section class="section-padding bg-cream relative overflow-hidden" id="about">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
        <div class="relative" data-aos="fade-right">
            <div
                class="aspect-square bg-gray-200 rounded-full overflow-hidden border-4 border-white shadow-xl relative z-10 w-4/5 mx-auto">
                <img src="https://images.unsplash.com/photo-1511285560982-1351c4f809b9?q=80&w=800&auto=format&fit=crop"
                    class="w-full h-full object-cover" alt="Couple">
            </div>
            <!-- Decorative Circle -->
            <div class="absolute top-10 right-0 w-32 h-32 bg-rose-100 rounded-full -z-0"></div>
            <div
                class="absolute bottom-10 left-0 w-48 h-48 bg-champagne rounded-full -z-0 mix-blend-multiply opacity-50">
            </div>
        </div>

        <div data-aos="fade-left">
            <h4 class="text-rose-600 font-bold tracking-widest uppercase text-sm mb-2">Tentang Langitara</h4>
            <h2 class="font-serif text-4xl font-bold text-charcoal mb-6">Mewujudkan Undangan Impian Tanpa Batas</h2>
            <p class="text-gray-600 mb-6 leading-relaxed">
                Langitara hadir untuk menjembatani tradisi dan teknologi. Kami percaya bahwa undangan pernikahan bukan
                sekadar informasi, melainkan cerminan dari kisah cinta Anda.
            </p>
            <p class="text-gray-600 mb-8 leading-relaxed">
                Dengan desain luxury minimalist dan teknologi modern, kami membantu ribuan pasangan membagikan kabar
                bahagia mereka dengan cara yang berkesan dan elegan.
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