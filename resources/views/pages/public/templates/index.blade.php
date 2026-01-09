@extends('layouts.public')

@section('title', 'Template Undangan - LANGITARA')

@section('content')
    <!-- Hero Section -->
    <section class="pt-32 pb-12 bg-gradient-to-b from-ivory to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-rose-gold font-medium tracking-widest uppercase text-sm mb-4">Katalog Template</p>
            <h1 class="font-serif text-4xl md:text-5xl font-bold text-charcoal mb-6">
                Pilih Template <span class="text-rose-gold">Undangan</span> Anda
            </h1>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                Pilih dari berbagai template undangan digital yang tersedia sesuai tema dan gaya Anda.
            </p>
        </div>
    </section>

    <!-- Filter & Templates -->
    <section class="py-12 bg-white" x-data="templateGallery()" x-init="init()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Category Filters -->
            <div class="flex flex-wrap justify-center gap-3 mb-12">
                <button @click="filterCategory('all')"
                    :class="activeCategory === 'all' ? 'bg-charcoal text-white' : 'bg-white text-charcoal border-2 border-slate-200 hover:border-rose-gold'"
                    class="px-6 py-2.5 rounded-full font-semibold transition-all duration-300">
                    Semua
                </button>
                <button @click="filterCategory('basic')"
                    :class="activeCategory === 'basic' ? 'bg-charcoal text-white' : 'bg-white text-charcoal border-2 border-slate-200 hover:border-rose-gold'"
                    class="px-6 py-2.5 rounded-full font-semibold transition-all duration-300">
                    Basic
                </button>
                <button @click="filterCategory('premium')"
                    :class="activeCategory === 'premium' ? 'bg-charcoal text-white' : 'bg-white text-charcoal border-2 border-slate-200 hover:border-rose-gold'"
                    class="px-6 py-2.5 rounded-full font-semibold transition-all duration-300">
                    Premium
                </button>
                <button @click="filterCategory('exclusive')"
                    :class="activeCategory === 'exclusive' ? 'bg-charcoal text-white' : 'bg-white text-charcoal border-2 border-slate-200 hover:border-rose-gold'"
                    class="px-6 py-2.5 rounded-full font-semibold transition-all duration-300">
                    Eksklusif
                </button>
                <button @click="filterCategory('luxury')"
                    :class="activeCategory === 'luxury' ? 'bg-charcoal text-white' : 'bg-white text-charcoal border-2 border-slate-200 hover:border-rose-gold'"
                    class="px-6 py-2.5 rounded-full font-semibold transition-all duration-300">
                    Luxury
                </button>
            </div>

            <!-- Templates Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="templates-grid">
                <!-- Initial templates from server -->
                @forelse($templates as $template)
                    <div
                        class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100">
                        <!-- Thumbnail -->
                        <div class="relative aspect-[4/5] overflow-hidden bg-slate-100">
                            @if($template->preview_image_path)
                                <img src="{{ asset($template->preview_image_path) }}" alt="{{ $template->name }}"
                                    class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
                                    loading="lazy">
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center bg-gradient-to-br from-ivory to-slate-100">
                                    <svg class="w-16 h-16 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif

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

                            <!-- Hover Overlay -->
                            <div class="absolute inset-0 bg-charcoal/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <a href="{{ $template->slug ? route('public.templates.show', $template->slug) : route('public.templates.index') }}"
                                    class="inline-flex items-center gap-2 bg-white text-charcoal font-semibold px-6 py-3 rounded-xl hover:bg-rose-gold hover:text-white transition-all duration-300 shadow-lg">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Preview
                                </a>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="p-5">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-serif text-lg font-bold text-charcoal">{{ $template->name }}</h3>
                                @if($template->category)
                                    <span class="text-xs text-slate-500 uppercase tracking-wider">{{ $template->category }}</span>
                                @endif
                            </div>
                            <a href="{{ $template->slug ? route('public.templates.show', $template->slug) : route('public.templates.index') }}"
                                class="inline-flex items-center gap-2 bg-rose-gold/10 text-rose-gold text-sm font-semibold px-4 py-2 rounded-lg hover:bg-rose-gold hover:text-white transition-all duration-300">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Preview
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-slate-100 flex items-center justify-center">
                            <svg class="w-10 h-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-charcoal mb-2">Belum Ada Template</h3>
                        <p class="text-slate-500">Template akan segera hadir.</p>
                    </div>
                @endforelse

                <!-- Dynamic templates loaded via AJAX will be appended here -->
                <template x-for="template in templates" :key="template.id">
                    <div
                        class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100">
                        <div class="relative aspect-[4/5] overflow-hidden bg-slate-100">
                            <img x-show="template.preview_image" :src="template.preview_image" :alt="template.name"
                                class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
                                loading="lazy">
                            <div x-show="!template.preview_image"
                                class="w-full h-full flex items-center justify-center bg-gradient-to-br from-ivory to-slate-100">
                                <svg class="w-16 h-16 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>

                            <div x-show="template.is_premium" class="absolute top-4 right-4">
                                <span
                                    class="inline-flex items-center gap-1 bg-rose-gold text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    Premium
                                </span>
                            </div>

                            <div class="absolute inset-0 bg-charcoal/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <a :href="template.url"
                                    class="inline-flex items-center gap-2 bg-white text-charcoal font-semibold px-6 py-3 rounded-xl hover:bg-rose-gold hover:text-white transition-all duration-300 shadow-lg">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Preview
                                </a>
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-serif text-lg font-bold text-charcoal" x-text="template.name"></h3>
                                <span x-show="template.category" class="text-xs text-slate-500 uppercase tracking-wider"
                                    x-text="template.category"></span>
                            </div>
                            <a :href="template.url" 
                               class="inline-flex items-center gap-2 bg-rose-gold/10 text-rose-gold text-sm font-semibold px-4 py-2 rounded-lg hover:bg-rose-gold hover:text-white transition-all duration-300">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Preview
                            </a>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Loading Indicator -->
            <div x-show="loading" class="flex justify-center py-12">
                <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-rose-gold"></div>
            </div>

            <!-- Load More Button (fallback for non-scroll) -->
            <div x-show="hasMore && !loading" class="text-center mt-12">
                <button @click="loadMore()"
                    class="bg-charcoal text-white font-semibold px-8 py-4 rounded-xl hover:bg-charcoal/90 transition shadow-lg">
                    Muat Lebih Banyak
                </button>
            </div>

            <!-- No More Templates -->
            <div x-show="!hasMore && templates.length > 0" class="text-center py-8">
                <p class="text-slate-500">Semua template telah ditampilkan.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-charcoal">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-serif text-3xl font-bold text-white mb-4">Tidak Menemukan Template yang Cocok?</h2>
            <p class="text-slate-300 mb-8">Hubungi kami untuk request template custom sesuai keinginan Anda.</p>
            <a href="https://wa.me/6281234567890?text=Halo,%20saya%20ingin%20request%20template%20custom" target="_blank"
                class="inline-flex items-center gap-2 bg-green-500 text-white font-semibold px-8 py-4 rounded-xl hover:bg-green-600 transition shadow-lg">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                </svg>
                Hubungi via WhatsApp
            </a>
        </div>
    </section>

    @push('scripts')
        <script>
            function templateGallery() {
                return {
                    templates: [],
                    activeCategory: '{{ $category }}',
                    currentPage: {{ $templates->currentPage() }},
                    hasMore: {{ $templates->hasMorePages() ? 'true' : 'false' }},
                    loading: false,

                    init() {
                        // Setup infinite scroll
                        this.setupInfiniteScroll();
                    },

                    setupInfiniteScroll() {
                        const observer = new IntersectionObserver((entries) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting && this.hasMore && !this.loading) {
                                    this.loadMore();
                                }
                            });
                        }, { rootMargin: '100px' });

                        // Observe a sentinel element at the bottom
                        const sentinel = document.createElement('div');
                        sentinel.id = 'scroll-sentinel';
                        document.getElementById('templates-grid').after(sentinel);
                        observer.observe(sentinel);
                    },

                    async filterCategory(category) {
                        this.activeCategory = category;
                        this.currentPage = 0; // Reset to 0 so loadMore loads page 1
                        this.templates = [];
                        this.hasMore = true;

                        // Clear existing server-rendered templates from DOM
                        const grid = document.getElementById('templates-grid');
                        const serverTemplates = grid.querySelectorAll(':scope > div.group');
                        serverTemplates.forEach(el => el.remove());

                        // Load fresh from page 1
                        await this.loadMore();
                    },

                    async loadMore() {
                        if (this.loading || !this.hasMore) return;

                        this.loading = true;

                        try {
                            const nextPage = this.currentPage + 1;
                            const response = await fetch(`{{ route('public.templates.index') }}?category=${this.activeCategory}&page=${nextPage}`, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json',
                                }
                            });

                            const data = await response.json();

                            this.templates = [...this.templates, ...data.templates];
                            this.hasMore = data.hasMore;
                            this.currentPage = nextPage;

                        } catch (error) {
                            console.error('Error loading templates:', error);
                        } finally {
                            this.loading = false;
                        }
                    }
                }
            }
        </script>
    @endpush
@endsection