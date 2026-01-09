<section class="section-padding bg-ivory" id="templates">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="font-serif text-4xl font-bold text-charcoal mb-4">Pilihan Desain Eksklusif</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Temukan tema yang paling mewakili warna cinta Anda.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($featuredTemplates ?? [] as $index => $template)
                <div class="group relative bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500"
                    data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">

                    <!-- Card with blur background effect -->
                    <div class="relative">
                        <!-- Background blur effect -->
                        <div class="absolute inset-0 overflow-hidden">
                            @if($template->preview_image_path)
                                <img src="{{ asset($template->preview_image_path) }}"
                                    class="w-full h-full object-cover blur-xl opacity-30 scale-110" alt="">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-rose-gold/20 to-ivory"></div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="relative p-6 pt-8">
                            <!-- Badge -->
                            @if($template->is_premium)
                                <div class="absolute top-4 right-4">
                                    <span
                                        class="inline-flex items-center gap-1 bg-rose-gold text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        Premium
                                    </span>
                                </div>
                            @endif

                            <!-- Template Name -->
                            <h3 class="font-serif text-2xl font-bold text-charcoal mb-2">{{ $template->name }}</h3>

                            <!-- Category/Style badge -->
                            @if($template->category || $template->style)
                                <p class="text-sm text-gray-500 mb-4">{{ $template->category ?? $template->style }}</p>
                            @endif

                            <!-- Preview Image -->
                            <div class="aspect-[4/5] rounded-2xl overflow-hidden shadow-lg mb-6 bg-gray-100">
                                @if($template->preview_image_path)
                                    <img src="{{ asset($template->preview_image_path) }}"
                                        class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700"
                                        alt="{{ $template->name }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- CTA Button -->
                            <a href="{{ $template->slug ? route('public.templates.show', $template->slug) : route('public.templates.index') }}"
                                class="block w-full text-center bg-charcoal/90 hover:bg-charcoal text-white font-semibold py-4 rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl">
                                Lihat Template
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Fallback if no templates -->
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500">Template akan segera hadir.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('public.templates.index') }}" class="btn-outline inline-block">Lihat Semua Template</a>
        </div>
    </div>
</section>