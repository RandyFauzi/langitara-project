<section class="relative h-screen flex items-center overflow-hidden bg-ivory">
    <!-- Background Wedding Image - Semi Transparent -->
    <div class="absolute inset-0 z-0 opacity-50 bg-cover bg-center"
        style="background-image: url('{{ asset('images/hero/wedding-1.jpg') }}');">
    </div>
    <!-- Gradient Overlay for Text Readability -->
    <div class="absolute inset-0 bg-gradient-to-r from-ivory/80 via-ivory/60 to-transparent z-10"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div data-aos="fade-up" data-aos-duration="1000">
                <span
                    class="inline-block py-1 px-3 rounded-full bg-champagne text-charcoal text-xs font-semibold tracking-wider mb-6">#1
                    PLATFORM UNDANGAN DIGITAL</span>
                <h1 class="font-serif text-5xl md:text-7xl font-bold text-charcoal leading-tight mb-6">
                    Bagikan Momen <br>
                    <span class="text-rose-600 block italic">Bahagiamu.</span>
                </h1>
                <p class="text-lg md:text-xl text-gray-600 mb-8 leading-relaxed max-w-lg">
                    Buat undangan pernikahan digital yang elegan, eksklusif, dan penuh cerita dalam hitungan menit.
                </p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('register') }}" class="btn-primary text-center">Buat Undangan Sekarang</a>
                    <a href="{{ route('public.templates.index') }}"
                        class="btn-outline text-center flex items-center justify-center gap-2">
                        <span>Lihat Template</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Right Visual - Phone Mockup with Static Image -->
            <div class="relative hidden lg:block" data-aos="fade-left" data-aos-delay="200" data-aos-duration="1000">
                <div
                    class="relative w-full max-w-lg mx-auto transform rotate-[-5deg] hover:rotate-0 transition-transform duration-700">
                    <!-- Phone Mockup with Static Image -->
                    <div
                        class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border-8 border-gray-900 aspect-[9/19]">
                        <img src="{{ asset('images/hero/wedding-2.jpg') }}" class="w-full h-full object-cover"
                            alt="Wedding Preview">
                    </div>
                </div>
                <!-- Floating Elements -->
                <div class="absolute -top-10 -right-10 w-24 h-24 bg-champagne/50 rounded-full blur-2xl animate-pulse">
                </div>
                <div class="absolute bottom-10 -left-10 w-32 h-32 bg-rose-200/50 rounded-full blur-3xl animate-pulse">
                </div>
            </div>
        </div>
    </div>
</section>