<section class="section-padding bg-white" id="pricing">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="font-serif text-4xl font-bold text-charcoal mb-4">Penawaran Spesial</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Temukan paket yang sesuai dengan kebutuhan dan budget Anda.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse(($packages ?? collect())->take(4) as $index => $package)
                <div class="relative {{ $package->is_featured ? 'border-2 border-rose-500 shadow-xl z-10' : 'border border-gray-200 hover:border-rose-300' }} bg-white rounded-2xl p-6 transition-all duration-300 flex flex-col"
                    data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">

                    <!-- Best Seller Badge -->
                    @if($package->is_featured)
                        <div
                            class="absolute -top-3 left-1/2 -translate-x-1/2 bg-rose-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">
                            🔥 BEST SELLER
                        </div>
                    @endif

                    <h3 class="font-bold text-lg text-charcoal mt-2">{{ $package->name }}</h3>

                    <div class="my-3">
                        @if($package->hasPromo())
                            <span class="text-gray-400 line-through text-sm">{{ $package->formatted_original_price }}</span>
                        @endif
                        <div>
                            <span
                                class="text-2xl font-bold {{ $package->price == 0 ? 'text-green-600' : 'text-charcoal' }} font-serif">
                                {{ $package->formatted_price }}
                            </span>
                        </div>
                    </div>

                    <p class="text-gray-500 text-xs mb-4">
                        @if($package->duration_days > 0)
                            Aktif {{ $package->duration_days }} hari
                        @else
                            Tanpa batas waktu
                        @endif
                    </p>

                    <ul class="space-y-2 mb-6 text-sm text-gray-600 flex-1">
                        @foreach(array_slice($package->features ?? [], 0, 4) as $feature)
                            <li class="flex items-start gap-2">
                                @if(str_contains(strtolower($feature), 'tidak'))
                                    <svg class="w-4 h-4 text-gray-300 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <span class="text-gray-400">{{ $feature }}</span>
                                @else
                                    <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                        </path>
                                    </svg>
                                    <span>{{ $feature }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <a href="{{ route('register') }}"
                        class="block w-full py-2.5 text-center rounded-full font-bold transition-colors text-sm {{ $package->is_featured ? 'bg-rose-600 text-white hover:bg-rose-700 shadow-lg' : 'border-2 border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                        {{ $package->can_publish ? 'Pilih' : 'Coba Gratis' }}
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500">Paket akan segera tersedia.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('public.pricing') }}" class="btn-outline inline-block">Lihat Semua Paket</a>
        </div>
    </div>
</section>