<nav x-data="{ open: false, scrambled: false }" @scroll.window="scrambled = (window.pageYOffset > 20) ? true : false"
    :class="{ 'bg-white/80 backdrop-blur-md shadow-sm': scrambled, 'bg-transparent': !scrambled }"
    class="fixed w-full z-50 transition-all duration-300 top-0 left-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('public.home') }}" class="font-serif text-2xl font-bold tracking-wider text-charcoal">
                    LANGITARA
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-8 items-center">
                <a href="{{ route('public.home') }}"
                    class="text-charcoal hover:text-rose-gold transition-colors font-medium text-sm tracking-wide">Beranda</a>
                <a href="{{ route('public.templates.index') }}"
                    class="text-charcoal hover:text-rose-gold transition-colors font-medium text-sm tracking-wide">Template</a>
                <a href="{{ route('public.pricing') }}"
                    class="text-charcoal hover:text-rose-gold transition-colors font-medium text-sm tracking-wide">Harga</a>
                <a href="{{ route('public.about') }}"
                    class="text-charcoal hover:text-rose-gold transition-colors font-medium text-sm tracking-wide">Tentang</a>

                <a href="{{ route('login') }}"
                    class="text-charcoal font-medium text-sm tracking-wide hover:underline">Masuk</a>
                <a href="{{ route('register') }}" class="btn-primary">Buat Undangan</a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="-mr-2 flex items-center md:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-charcoal hover:text-rose-gold focus:outline-none transition-colors">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-white border-t">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <a href="{{ route('public.home') }}"
                class="block px-3 py-2 text-base font-medium text-charcoal hover:text-rose-gold">Beranda</a>
            <a href="{{ route('public.templates.index') }}"
                class="block px-3 py-2 text-base font-medium text-charcoal hover:text-rose-gold">Template</a>
            <a href="{{ route('public.pricing') }}"
                class="block px-3 py-2 text-base font-medium text-charcoal hover:text-rose-gold">Harga</a>
            <a href="{{ route('public.about') }}"
                class="block px-3 py-2 text-base font-medium text-charcoal hover:text-rose-gold">Tentang</a>
            <div class="border-t my-2"></div>
            <a href="{{ route('login') }}"
                class="block px-3 py-2 text-base font-medium text-charcoal hover:text-rose-gold">Masuk</a>
            <a href="{{ route('register') }}"
                class="block w-full text-center mt-4 px-3 py-3 bg-charcoal text-white rounded-lg">Buat Undangan</a>
        </div>
    </div>
</nav>