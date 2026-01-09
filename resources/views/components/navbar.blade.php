<nav x-data="{ open: false, userMenu: false, scrambled: false }"
    @scroll.window="scrambled = (window.pageYOffset > 20) ? true : false"
    :class="{ 'bg-white/80 backdrop-blur-md shadow-sm': scrambled, 'bg-transparent': !scrambled }"
    class="fixed w-full z-50 transition-all duration-300 top-0 left-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('public.home') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Langitara Logo" class="h-12 w-auto">
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-8 items-center">
                <a href="{{ route('public.home') }}"
                    class="text-charcoal hover:text-rose-gold transition-colors font-medium text-base tracking-wide">Beranda</a>
                <a href="{{ route('public.templates.index') }}"
                    class="text-charcoal hover:text-rose-gold transition-colors font-medium text-base tracking-wide">Template</a>
                <a href="{{ route('public.pricing') }}"
                    class="text-charcoal hover:text-rose-gold transition-colors font-medium text-base tracking-wide">Harga</a>
                <a href="{{ route('public.about') }}"
                    class="text-charcoal hover:text-rose-gold transition-colors font-medium text-base tracking-wide">Tentang</a>

                @auth
                    <!-- User Dropdown -->
                    <div class="relative" @click.away="userMenu = false">
                        <button @click="userMenu = !userMenu"
                            class="flex items-center gap-2 text-charcoal font-medium text-base tracking-wide hover:text-rose-gold transition-colors">
                            <span>{{ auth()->user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform"
                                :class="{ 'rotate-180': userMenu }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="userMenu" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-2 z-50"
                            style="display: none;">
                            <a href="{{ route('dashboard.index') }}"
                                class="block px-4 py-2 text-base text-charcoal hover:bg-slate-50 hover:text-rose-gold transition">
                                Dashboard
                            </a>
                            <a href="{{ route('dashboard.account') }}"
                                class="block px-4 py-2 text-base text-charcoal hover:bg-slate-50 hover:text-rose-gold transition">
                                Profil
                            </a>
                            <a href="{{ route('dashboard.account.password') }}"
                                class="block px-4 py-2 text-base text-charcoal hover:bg-slate-50 hover:text-rose-gold transition">
                                Ganti Password
                            </a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-base text-red-600 hover:bg-red-50 transition">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="text-charcoal font-medium text-base tracking-wide hover:underline">Masuk</a>
                @endauth

                <a href="{{ route('register') }}" class="btn-primary text-base">Buat Undangan</a>
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
                class="block px-3 py-2 text-lg font-medium text-charcoal hover:text-rose-gold">Beranda</a>
            <a href="{{ route('public.templates.index') }}"
                class="block px-3 py-2 text-lg font-medium text-charcoal hover:text-rose-gold">Template</a>
            <a href="{{ route('public.pricing') }}"
                class="block px-3 py-2 text-lg font-medium text-charcoal hover:text-rose-gold">Harga</a>
            <a href="{{ route('public.about') }}"
                class="block px-3 py-2 text-lg font-medium text-charcoal hover:text-rose-gold">Tentang</a>

            <div class="border-t my-2"></div>

            @auth
                <div class="px-3 py-2 text-base text-slate-500">{{ auth()->user()->email }}</div>
                <a href="{{ route('dashboard.index') }}"
                    class="block px-3 py-2 text-lg font-medium text-charcoal hover:text-rose-gold">Dashboard</a>
                <a href="{{ route('dashboard.account') }}"
                    class="block px-3 py-2 text-lg font-medium text-charcoal hover:text-rose-gold">Profil</a>
                <a href="{{ route('dashboard.account.password') }}"
                    class="block px-3 py-2 text-lg font-medium text-charcoal hover:text-rose-gold">Ganti Password</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit"
                        class="block w-full text-left px-3 py-2 text-lg font-medium text-red-600 hover:bg-red-50 rounded-lg">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}"
                    class="block px-3 py-2 text-lg font-medium text-charcoal hover:text-rose-gold">Masuk</a>
                <a href="{{ route('register') }}"
                    class="block w-full text-center mt-4 px-3 py-3 bg-charcoal text-white rounded-lg text-lg">Buat
                    Undangan</a>
            @endauth
        </div>
    </div>
</nav>