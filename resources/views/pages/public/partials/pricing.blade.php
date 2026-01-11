<section class="section-padding bg-gradient-to-b from-white to-gray-50" id="pricing">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16" data-aos="fade-up">
            <span
                class="inline-block py-1.5 px-4 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold tracking-widest uppercase mb-4">
                Harga Terbaik
            </span>
            <h2 class="font-serif text-4xl font-bold text-charcoal mb-4">Penawaran Spesial</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Temukan paket yang sesuai dengan kebutuhan dan budget Anda.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $displayPackages = ($packages ?? collect())->take(4);
            @endphp

            @forelse($displayPackages as $index => $package)
                <div class="group relative {{ $package->is_featured ? 'lg:-mt-4 lg:mb-4' : '' }}" data-aos="fade-up"
                    data-aos-delay="{{ $index * 100 }}">
                    <!-- Card -->
                    <div
                        class="relative h-full {{ $package->is_featured ? 'bg-gradient-to-br from-amber-800 via-amber-700 to-amber-900 text-white shadow-2xl shadow-amber-200' : 'bg-white border border-gray-200 hover:border-amber-300 hover:shadow-xl' }} rounded-2xl p-6 transition-all duration-500 flex flex-col overflow-hidden">

                        <!-- Best Seller Badge -->
                        @if($package->is_featured)
                            <div
                                class="absolute -top-0 -right-8 bg-yellow-400 text-amber-900 text-xs font-bold px-10 py-1 rotate-45 shadow-lg">
                                🔥 BEST
                            </div>
                        @endif

                        <!-- Decorative Circle for Featured -->
                        @if($package->is_featured)
                            <div class="absolute -bottom-20 -right-20 w-40 h-40 bg-white/10 rounded-full"></div>
                            <div class="absolute -top-10 -left-10 w-24 h-24 bg-white/10 rounded-full"></div>
                        @endif

                        <div class="relative z-10 flex flex-col h-full">
                            <h3 class="font-bold text-lg {{ $package->is_featured ? 'text-white' : 'text-charcoal' }}">
                                {{ $package->name }}
                            </h3>

                            <div class="my-4">
                                @if($package->hasPromo())
                                    <span
                                        class="{{ $package->is_featured ? 'text-amber-200' : 'text-gray-400' }} line-through text-sm">
                                        {{ $package->formatted_original_price }}
                                    </span>
                                @endif
                                <div class="flex items-baseline gap-1">
                                    <span
                                        class="text-3xl font-bold {{ $package->price == 0 ? ($package->is_featured ? 'text-white' : 'text-green-600') : ($package->is_featured ? 'text-white' : 'text-charcoal') }} font-serif">
                                        {{ $package->formatted_price }}
                                    </span>
                                </div>
                            </div>

                            <p class="{{ $package->is_featured ? 'text-amber-100' : 'text-gray-500' }} text-xs mb-4">
                                @if($package->duration_days > 0)
                                    Aktif {{ $package->duration_days }} hari
                                @else
                                    Tanpa batas waktu
                                @endif
                            </p>

                            <ul class="space-y-2.5 mb-6 text-sm flex-1">
                                @foreach(array_slice($package->features ?? [], 0, 5) as $feature)
                                    <li class="flex items-start gap-2">
                                        @if(str_contains(strtolower($feature), 'tidak'))
                                            <svg class="w-4 h-4 {{ $package->is_featured ? 'text-amber-300' : 'text-gray-300' }} mt-0.5 flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            <span
                                                class="{{ $package->is_featured ? 'text-amber-200' : 'text-gray-400' }}">{{ $feature }}</span>
                                        @else
                                            <svg class="w-4 h-4 {{ $package->is_featured ? 'text-yellow-300' : 'text-green-500' }} mt-0.5 flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span
                                                class="{{ $package->is_featured ? 'text-white' : 'text-gray-600' }}">{{ $feature }}</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>

                            @if($package->price == 0)
                                {{-- Free package: Show as default, not purchasable --}}
                                <div
                                    class="block w-full py-3 text-center rounded-full font-bold text-sm border-2 border-green-200 text-green-600 bg-green-50">
                                    ✓ Paket Default
                                </div>
                            @else
                                            <a href="{{ route('checkout', $package->slug) }}" class="block w-full py-3 text-center rounded-full font-bold transition-all duration-300 text-sm
                                                                        {{ $package->is_featured
                                ? 'bg-yellow-400 text-amber-900 hover:bg-yellow-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5'
                                : 'border-2 border-gray-200 text-gray-600 hover:bg-amber-700 hover:text-white hover:border-amber-700'
                                                                        }}">
                                                Pilih Paket
                                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500">Paket akan segera tersedia.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12 text-center" data-aos="fade-up">
            <a href="{{ route('public.pricing') }}" class="btn-outline inline-flex items-center gap-2 group">
                <span>Lihat Semua Paket</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                    </path>
                </svg>
            </a>
        </div>
    </div>
</section>