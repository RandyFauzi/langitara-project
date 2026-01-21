<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title ?? 'The Wedding' }}</title>
    
    <!-- Langitara Standard Data Block -->
    @php
        $couple = $invitation->couple ?? $couple ?? new \stdClass();
        $events = $invitation->events ?? $events ?? new \stdClass();
        $meta = $invitation->meta ?? $meta ?? new \stdClass();
        $gallery = $invitation->gallery ?? $gallery ?? [];
        $rsvps = $rsvps ?? collect([]); // Ensure rsvps is always a collection
        $guest_name = $guest_name ?? 'Tamu Undangan';
    @endphp

    <!-- External Libs -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Lato:wght@300;400;700&display=swap"
        rel="stylesheet">
        :root {
            --sage: #8A9A5B;
            --sage-dark: #4B5F35;
            --gold: #C5A059;
            --cream: #F9F9F4;
            --text-main: #2C3E50;
        }

        .font-serif { font-family: 'Playfair Display', serif; }
        .font-sans { font-family: 'Lato', sans-serif; }
        [x-cloak] { display: none !important; }

        .text-sage { color: var(--sage); }
        .bg-sage { background-color: var(--sage); }
        .text-gold { color: var(--gold); }
        .bg-gold { background-color: var(--gold); }
        .border-gold { border-color: var(--gold); }
        
        .bg-texture {
            background-color: var(--cream);
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.6' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.05'/%3E%3C/svg%3E");
        }

        /* Animations */
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-spin-slow { animation: spin 12s linear infinite; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Ornamental Classes */
        .flower-corner {
            position: absolute;
            width: 150px;
            pointer-events: none;
            z-index: 10;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
        }
        
        /* Glassmorphism */
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
        }
</head>

<body class="font-sans antialiased text-gray-700 bg-stone-50 overflow-hidden lg:flex" x-data="{ 
          open: false, 
          isPlaying: false, 
          toggleAudio() {
              if (!this.$refs.player) return;
              if (this.isPlaying) {
                  this.$refs.player.pause();
              } else {
                  this.$refs.player.play();
              }
              this.isPlaying = !this.isPlaying;
          },
          openInvitation() {
              this.open = true;
              if (this.$refs.player) {
                  this.$refs.player.play()
                      .then(() => { this.isPlaying = true; })
                      .catch(() => { console.log('Autoplay blocked'); });
              }
              // Scroll logic handled by overflow container
          }
      }">

    <!-- DESKTOP LEFT SECTION -->
    <section class="hidden lg:flex w-[calc(100%-480px)] fixed inset-y-0 left-0 bg-stone-900 flex-col justify-center items-center text-center p-12 text-white z-0">
        <div class="absolute inset-0 opacity-40 bg-center bg-cover" 
             style="background-image: url('{{ $invitation->cover_image ?? asset('assets/templates/gardenia-love/images/cover_bg.jpg') }}');"></div>
        <div class="absolute inset-0 bg-black/30"></div>
        
        <div class="relative z-10 animate-float">
            <p class="text-sm tracking-[0.5em] uppercase text-gold mb-6">The Wedding of</p>
            <h1 class="font-serif text-7xl mb-4">{{ $couple->groom_nickname ?? 'Groom' }} & {{ $couple->bride_nickname ?? 'Bride' }}</h1>
            <div class="w-24 h-1 bg-gold mx-auto my-8"></div>
            <p class="font-serif text-2xl italic opacity-90">
                {{ \Carbon\Carbon::parse($events->akad_date ?? $invitation->akad_date)->translatedFormat('l, d F Y') }}
            </p>
        </div>
    </section>

    <!-- RIGHT SECTION (Mobile Container) -->
    <div class="w-full lg:max-w-[480px] ml-auto h-screen relative bg-stone-50 shadow-2xl lg:overflow-y-auto" :class="open ? 'overflow-auto' : 'overflow-hidden'">
        
        <!-- 1. COVER GATE (The Locking Screen) -->
        <section id="cover-gate"
            class="absolute inset-0 z-50 flex flex-col items-center justify-center bg-stone-900 text-white transition-transform duration-1000 ease-in-out"
            :class="open ? '-translate-y-full' : 'translate-y-0'"
            style="background-image: url('{{ $invitation->cover_image ?? asset('assets/templates/gardenia-love/images/cover_bg.jpg') }}'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px]"></div>
            
            <!-- Decorative Frame in Corners -->
            <img src="{{ asset('assets/templates/gardenia-love/images/floral_corner.png') }}" 
                 class="absolute top-0 left-0 w-48 opacity-90" style="transform: rotate(0deg);">
            <img src="{{ asset('assets/templates/gardenia-love/images/floral_corner.png') }}" 
                 class="absolute bottom-0 right-0 w-48 opacity-90" style="transform: rotate(180deg);">
    
            <div class="relative z-10 text-center px-6 animate-float space-y-6 max-w-sm w-full">
                <div class="glass-card rounded-2xl p-8 border-t border-white/30">
                    <p class="text-xs tracking-[0.4em] uppercase text-gold mb-4">The Wedding of</p>
                    <h1 class="font-serif text-5xl md:text-6xl text-white mb-2 leading-tight drop-shadow-lg">
                        {{ $couple->groom_nickname ?? $invitation->groom_nickname }} 
                        <br><span class="text-3xl italic font-light">&</span><br> 
                        {{ $couple->bride_nickname ?? $invitation->bride_nickname }}
                    </h1>
                    
                    <div class="w-16 h-1 bg-white/50 mx-auto my-6 rounded-full"></div>
    
                    <!-- Guest Badge -->
                    <div class="py-2">
                        <p class="text-[10px] uppercase tracking-widest mb-2 opacity-80">Kepada Yth.</p>
                        <h2 class="font-serif text-2xl font-bold break-words text-gold">{{ $guest_name }}</h2>
                        <p class="text-[10px] mt-1 opacity-70">Di Tempat</p>
                    </div>
    
                    <button @click="openInvitation()"
                        class="mt-8 px-10 py-3 bg-gold text-white rounded-full text-xs font-bold tracking-widest hover:scale-105 transition shadow-xl hover:bg-white hover:text-sage uppercase">
                        Buka Undangan
                    </button>
                </div>
            </div>
        </section>
    
        <!-- MAIN CONTENT -->
        <main class="w-full bg-white min-h-screen relative z-10">

        <!-- 2. QUOTE / AYAT -->
        <section class="py-20 px-8 text-center bg-texture relative overflow-hidden">
            <!-- Corner Florals -->
            <img src="{{ asset('assets/templates/gardenia-love/images/floral_corner.png') }}" 
                 class="flower-corner" style="top: -20px; left: -20px; transform: rotate(-45deg);">
            <img src="{{ asset('assets/templates/gardenia-love/images/floral_corner.png') }}" 
                 class="flower-corner" style="bottom: -20px; right: -20px; transform: rotate(135deg);">

            <div class="relative z-10" data-aos="fade-up">
                <i class="fas fa-quote-right text-gold text-2xl mb-4"></i>
                <p class="font-serif italic text-xl text-sage/90 mb-6 leading-relaxed">"{{ $meta->quote_text ?? $invitation->quote_text ?? '' }}"</p>
                <div class="w-12 h-0.5 bg-gold mx-auto mb-4"></div>
                <p class="text-xs font-bold uppercase tracking-widest text-sage-dark">{{ $meta->quote_author ?? $invitation->quote_author ?? '' }}</p>
            </div>
        </section>

        <!-- 3 & 4. PROFIL MEMPELAI (Couple) -->
        <section class="py-16 px-6 bg-texture text-center relative">
            
            <!-- Groom -->
            <div class="mb-12 relative" data-aos="fade-up">
                <div class="w-48 h-48 mx-auto relative flex items-center justify-center mb-6">
                    <!-- Wreath -->
                    <img src="{{ asset('assets/templates/gardenia-love/images/floral_wreath.png') }}" 
                         class="absolute inset-0 w-full h-full object-contain animate-spin-slow" style="animation-duration: 20s;">
                    
                    <!-- Photo -->
                    <div class="w-32 h-32 rounded-full overflow-hidden border-2 border-white shadow-inner relative z-10">
                         @if($couple->groom_photo ?? $invitation->groom_photo)
                            <img src="{{ $couple->groom_photo ?? $invitation->groom_photo }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-200"></div>
                        @endif
                    </div>
                </div>
                <h2 class="font-serif text-4xl font-bold text-sage mb-2">{{ $couple->groom_nickname ?? $invitation->groom_nickname ?? 'Groom' }}</h2>
                <p class="text-lg font-serif text-gold mb-2">{{ $couple->groom_name ?? $invitation->groom_name ?? 'Groom Name' }}</p>
                <p class="text-sm text-gray-500">Putra dari Bpk. {{ $couple->groom_father ?? $invitation->groom_father }} & Ibu
                    {{ $couple->groom_mother ?? $invitation->groom_mother }}</p>
                
                 @if($couple->groom_instagram ?? $invitation->groom_instagram)
                    <a href="{{ $couple->groom_instagram ?? $invitation->groom_instagram }}" target="_blank" 
                       class="inline-block mt-4 text-sage hover:text-gold text-sm transition">
                        <i class="fab fa-instagram"></i> Instagram
                    </a>
                @endif
            </div>

            <div class="text-center font-serif text-5xl text-gold/30 mb-12 my-8">&</div>

            <!-- Bride -->
            <div data-aos="fade-up">
                 <div class="w-48 h-48 mx-auto relative flex items-center justify-center mb-6">
                    <!-- Wreath -->
                    <img src="{{ asset('assets/templates/gardenia-love/images/floral_wreath.png') }}" 
                         class="absolute inset-0 w-full h-full object-contain animate-spin-slow" style="animation-duration: 25s; animation-direction: reverse;">
                    
                    <!-- Photo -->
                    <div class="w-32 h-32 rounded-full overflow-hidden border-2 border-white shadow-inner relative z-10">
                        @if($couple->bride_photo ?? $invitation->bride_photo)
                            <img src="{{ $couple->bride_photo ?? $invitation->bride_photo }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-200"></div>
                        @endif
                    </div>
                </div>
                <h2 class="font-serif text-4xl font-bold text-sage mb-2">{{ $couple->bride_nickname ?? $invitation->bride_nickname ?? 'Bride' }}</h2>
                <p class="text-lg font-serif text-gold mb-2">{{ $couple->bride_name ?? $invitation->bride_name ?? 'Bride Name' }}</p>
                <p class="text-sm text-gray-500">Putri dari Bpk. {{ $couple->bride_father ?? $invitation->bride_father }} & Ibu
                    {{ $couple->bride_mother ?? $invitation->bride_mother }}</p>
                
                 @if($couple->bride_instagram ?? $invitation->bride_instagram)
                    <a href="{{ $couple->bride_instagram ?? $invitation->bride_instagram }}" target="_blank" 
                       class="inline-block mt-4 text-sage hover:text-gold text-sm transition">
                        <i class="fab fa-instagram"></i> Instagram
                    </a>
                @endif
            </div>
        </section>

        <!-- 5. LOVE STORY -->
        @if(!empty($invitation->love_stories))
            <section class="py-20 px-6 bg-white relative">
                 <!-- Side Ornament -->
                <img src="{{ asset('assets/templates/gardenia-love/images/floral_corner.png') }}" 
                     class="flower-corner" style="top: 50%; left: -40px; transform: translateY(-50%) rotate(-90deg); opacity: 0.3;">

                <h2 class="font-serif text-3xl text-center text-sage mb-12" data-aos="fade-up">Kisah Cinta</h2>
                
                <div class="space-y-12 border-l-2 border-gold/30 ml-4 pl-8 relative z-10 max-w-lg mx-auto">
                    @foreach($invitation->love_stories as $story)
                        <div class="relative group" data-aos="fade-left">
                            <span class="absolute -left-[43px] top-0 w-6 h-6 bg-gold rounded-full border-4 border-white shadow-md group-hover:scale-110 transition-transform"></span>
                            <span
                                class="text-sm font-bold text-sage-dark uppercase mb-2 block tracking-wider">{{ $story['year'] ?? $story['date'] ?? 'Moment' }}</span>
                            <h3 class="font-bold text-xl text-gray-800 mb-2 font-serif">{{ $story['title'] }}</h3>
                            <p class="text-sm text-gray-600 leading-relaxed bg-stone-50 p-4 rounded-lg shadow-sm border border-stone-100">
                                {{ $story['story'] ?? $story['description'] ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- 6. AUTO CAROUSEL (First 4 photos) -->
        @php $carouselPhotos = array_slice($invitation->gallery_photos ?? [], 0, 4); @endphp
        @if(count($carouselPhotos) > 0)
            <section class="py-10 bg-stone-100" x-data="{ 
                        active: 0, 
                        total: {{ count($carouselPhotos) }},
                        init() { setInterval(() => { this.active = (this.active + 1) % this.total }, 3000) }
                     }">
                <div class="relative h-64 overflow-hidden">
                    @foreach($carouselPhotos as $index => $photo)
                        <img src="{{ $photo }}"
                            class="absolute inset-0 w-full h-full object-cover transition-opacity duration-1000"
                            :class="active === {{ $index }} ? 'opacity-100' : 'opacity-0'" alt="Gallery {{ $index }}">
                    @endforeach

                    <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2 z-10">
                        @foreach($carouselPhotos as $index => $photo)
                            <div class="w-2 h-2 rounded-full transition-colors duration-300 shadow-sm"
                                :class="active === {{ $index }} ? 'bg-white' : 'bg-white/50'"></div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- 7. EVENT DETAILS -->
        <section class="py-20 px-6 bg-sage text-white text-center relative overflow-hidden">
             <!-- Bg Pattern Overlay -->
             <div class="absolute inset-0 opacity-10" 
                  style="background-image: url('data:image/svg+xml,%3Csvg width=\'20\' height=\'20\' viewBox=\'0 0 20 20\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M1 1h2v2H1V1zm4 4h2v2H5V5zm4 4h2v2H9V9zm4 4h2v2h-2v-2zm4 4h2v2h-2v-2z\' fill=\'%23ffffff\' fill-rule=\'evenodd\'/%3E%3C/svg%3E');">
             </div>

            <h2 class="font-serif text-4xl mb-12 text-gold relative z-10" data-aos="fade-down">Rangkaian Acara</h2>

            <!-- Akad -->
            <div class="mb-8 border border-white/30 p-8 rounded-2xl bg-white/10 backdrop-blur-md relative z-10 max-w-sm mx-auto shadow-xl" 
                 data-aos="fade-up" x-data="{ showMap: false }">
                 
                <!-- Corner Decoration -->
                <img src="{{ asset('assets/templates/gardenia-love/images/floral_corner.png') }}" 
                     class="absolute -top-4 -right-4 w-24 opacity-80" style="transform: rotate(90deg);">

                <h3 class="font-serif text-3xl font-bold mb-4 uppercase tracking-widest text-gold drop-shadow-sm">Akad Nikah</h3>
                <div class="my-6 border-t border-b border-white/20 py-4">
                    <p class="text-2xl font-bold font-serif">
                        {{ \Carbon\Carbon::parse($events->akad_date ?? $invitation->akad_date)->translatedFormat('l, d F Y') }}
                    </p>
                    <p class="text-sm mt-1 opacity-90 tracking-wide">
                        {{ \Carbon\Carbon::parse($events->akad_date ?? $invitation->akad_date)->format('H:i') }} WIB - Selesai
                    </p>
                </div>
                <p class="font-bold text-lg">{{ $events->akad_location ?? $invitation->akad_location }}</p>
                <p class="text-sm opacity-80 mt-1 px-4 leading-relaxed">{{ $events->akad_address ?? $invitation->akad_address }}</p>
                
                @if($events->akad_map_link ?? $invitation->akad_map_link || $events->akad_map_embed ?? $invitation->akad_map_embed)
                    <div class="mt-8 flex flex-wrap justify-center gap-4">
                        @if($events->akad_map_link ?? $invitation->akad_map_link)
                            <a href="{{ $events->akad_map_link ?? $invitation->akad_map_link }}" target="_blank"
                                class="px-6 py-2.5 bg-gold text-white text-[10px] font-bold rounded-full hover:bg-white hover:text-sage transition shadow-lg tracking-widest uppercase">
                                Google Maps
                            </a>
                        @endif
                        
                        @if($events->akad_map_embed ?? $invitation->akad_map_embed)
                            <button @click="showMap = !showMap" 
                                class="px-6 py-2.5 bg-transparent border border-white/40 text-white text-[10px] font-bold rounded-full hover:bg-white hover:text-sage transition tracking-widest uppercase">
                                <span x-text="showMap ? 'Tutup Peta' : 'Lihat Peta'">Lihat Peta</span>
                            </button>
                        @endif
                    </div>
                    @if($events->akad_map_embed ?? $invitation->akad_map_embed)
                        <div x-show="showMap" x-collapse x-cloak class="mt-6">
                            <div class="rounded-lg overflow-hidden shadow-2xl border border-white/20 relative w-full aspect-video">
                                {!! $events->akad_map_embed ?? $invitation->akad_map_embed !!}
                            </div>
                        </div>
                    @endif
                @endif
            </div>

            <!-- Resepsi -->
            @if($events->resepsi_date ?? $invitation->resepsi_date)
                <div class="border border-white/30 p-8 rounded-2xl bg-white/10 backdrop-blur-md relative z-10 max-w-sm mx-auto shadow-xl" 
                     data-aos="fade-up" data-aos-delay="200" x-data="{ showMap: false }">
                    
                    <!-- Corner Decoration -->
                    <img src="{{ asset('assets/templates/gardenia-love/images/floral_corner.png') }}" 
                         class="absolute -top-4 -left-4 w-24 opacity-80" style="transform: rotate(0deg) scaleX(-1);">

                    <h3 class="font-serif text-3xl font-bold mb-4 uppercase tracking-widest text-gold drop-shadow-sm">Resepsi</h3>
                    <div class="my-6 border-t border-b border-white/20 py-4">
                        <p class="text-2xl font-bold font-serif">
                            {{ \Carbon\Carbon::parse($events->resepsi_date ?? $invitation->resepsi_date)->translatedFormat('l, d F Y') }}
                        </p>
                        <p class="text-sm mt-1 opacity-90 tracking-wide">
                            {{ \Carbon\Carbon::parse($events->resepsi_date ?? $invitation->resepsi_date)->format('H:i') }} WIB - Selesai
                        </p>
                    </div>
                    <p class="font-bold text-lg">{{ $events->resepsi_location ?? $invitation->resepsi_location }}</p>
                    <p class="text-sm opacity-80 mt-1 px-4 leading-relaxed">{{ $events->resepsi_address ?? $invitation->resepsi_address }}</p>
                    
                     @if($events->resepsi_map_link ?? $invitation->resepsi_map_link || $events->resepsi_map_embed ?? $invitation->resepsi_map_embed)
                        <div class="mt-8 flex flex-wrap justify-center gap-4">
                            @if($events->resepsi_map_link ?? $invitation->resepsi_map_link)
                                <a href="{{ $events->resepsi_map_link ?? $invitation->resepsi_map_link }}" target="_blank"
                                    class="px-6 py-2.5 bg-gold text-white text-[10px] font-bold rounded-full hover:bg-white hover:text-sage transition shadow-lg tracking-widest uppercase">
                                    Google Maps
                                </a>
                            @endif
                            
                            @if($events->resepsi_map_embed ?? $invitation->resepsi_map_embed)
                                <button @click="showMap = !showMap" 
                                    class="px-6 py-2.5 bg-transparent border border-white/40 text-white text-[10px] font-bold rounded-full hover:bg-white hover:text-sage transition tracking-widest uppercase">
                                    <span x-text="showMap ? 'Tutup Peta' : 'Lihat Peta'">Lihat Peta</span>
                                </button>
                            @endif
                        </div>
                        @if($events->resepsi_map_embed ?? $invitation->resepsi_map_embed)
                            <div x-show="showMap" x-collapse x-cloak class="mt-6">
                                <div class="rounded-lg overflow-hidden shadow-2xl border border-white/20 relative w-full aspect-video">
                                    {!! $events->resepsi_map_embed ?? $invitation->resepsi_map_embed !!}
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            @endif
        </section>

        <!-- 8. COUNTDOWN -->
        <section class="py-12 bg-stone-800 text-white text-center" x-data="countdown('{{ $invitation->akad_date }}')"
            x-init="start()">
            <p class="text-xs font-bold tracking-[0.3em] text-gold mb-6 uppercase">Menuju Hari Bahagia</p>
            <div class="flex justify-center gap-4">
                <div class="bg-white/10 p-3 rounded w-16"><span class="block text-2xl font-bold"
                        x-text="days">00</span><span class="text-[10px] opacity-60">HARI</span></div>
                <div class="bg-white/10 p-3 rounded w-16"><span class="block text-2xl font-bold"
                        x-text="hours">00</span><span class="text-[10px] opacity-60">JAM</span></div>
                <div class="bg-white/10 p-3 rounded w-16"><span class="block text-2xl font-bold"
                        x-text="minutes">00</span><span class="text-[10px] opacity-60">MENIT</span></div>
                <div class="bg-white/10 p-3 rounded w-16"><span class="block text-2xl font-bold"
                        x-text="seconds">00</span><span class="text-[10px] opacity-60">DETIK</span></div>
            </div>
        </section>

        <!-- 9. LOCATION MAP PLACEHOLDER -->


        <!-- 10. GALLERY GRID (Remaining photos) -->
        @php $gridPhotos = array_slice($invitation->gallery_photos ?? [], 4); @endphp
        @if(count($gridPhotos) > 0)
            <section class="py-20 px-4 bg-white relative">
                 <h2 class="font-serif text-3xl text-center text-sage mb-8" data-aos="fade-up">Galeri Foto</h2>
                 
                 <!-- Decorative Floral Divider -->
                 <div class="flex justify-center mb-12">
                     <img src="{{ asset('assets/templates/gardenia-love/images/floral_wreath.png') }}" class="w-16 h-16 opacity-50">
                 </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 max-w-4xl mx-auto">
                    @foreach($gridPhotos as $index => $photo)
                        <div class="aspect-square bg-gray-100 rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300" data-aos="zoom-in" data-aos-delay="{{ $index * 100 }}">
                            <img src="{{ $photo }}" loading="lazy" class="w-full h-full object-cover hover:scale-110 transition-transform duration-700">
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- 11. RSVP FORM -->
        <section class="py-20 px-6 bg-texture relative overflow-hidden" x-data="{
            loading: false,
            submitRsvp() {
                this.loading = true;
                const form = this.$el.querySelector('form');
                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.$dispatch('new-rsvp', {
                            name: formData.get('name'),
                            message: formData.get('message'),
                            status: formData.get('status'),
                            time: 'Baru saja' 
                        });
                        form.reset();
                        alert('Terima kasih! Konfirmasi kehadiran Anda telah tersimpan.');
                    } else {
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan jaringan.');
                })
                .finally(() => {
                    this.loading = false;
                });
            }
        }">
            <!-- Corner Florals for RSVP Card -->
             <img src="{{ asset('assets/templates/gardenia-love/images/floral_corner.png') }}" 
                 class="flower-corner absolute" style="top: 20px; right: -30px; transform: rotate(45deg); opacity: 0.5; width: 200px;">

            <h2 class="font-serif text-3xl text-center text-sage mb-8 relative z-10" data-aos="fade-down">Konfirmasi Kehadiran</h2>
            
            <div class="glass-card p-8 rounded-2xl max-w-sm mx-auto relative z-10 border-t-4 border-gold">
                <form action="{{ route('public.rsvp.store') }}" method="POST" class="space-y-5" @submit.prevent="submitRsvp">
                    @csrf
                    <input type="hidden" name="invitation_id" value="{{ $invitation->id }}">
                    
                    <div>
                        <label class="block text-xs font-bold uppercase text-sage mb-1 tracking-wider">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ $guest_name !== 'Tamu Undangan' ? $guest_name : '' }}" 
                               class="w-full border-gray-200 rounded-lg p-3 bg-white/80 focus:ring-gold focus:border-gold transition shadow-sm" required placeholder="Hadirin yang terhormat...">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold uppercase text-sage mb-1 tracking-wider">Status Kehadiran</label>
                        <select name="status" class="w-full border-gray-200 rounded-lg p-3 bg-white/80 focus:ring-gold focus:border-gold transition shadow-sm" required>
                            <option value="hadir">Akan Hadir</option>
                            <option value="tidak_hadir">Tidak Dapat Hadir</option>
                            <option value="ragu">Masih Ragu</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-sage mb-1 tracking-wider">Jumlah Orang</label>
                        <select name="amount" class="w-full border-gray-200 rounded-lg p-3 bg-white/80 focus:ring-gold focus:border-gold transition shadow-sm">
                            <option value="1">1 Orang</option>
                            <option value="2">2 Orang</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-sage mb-1 tracking-wider">Ucapan & Doa</label>
                        <textarea name="message" rows="3" class="w-full border-gray-200 rounded-lg p-3 bg-white/80 focus:ring-gold focus:border-gold transition shadow-sm" placeholder="Tulis ucapan selamat..."></textarea>
                    </div>

                    <button type="submit" class="w-full py-3.5 bg-sage text-white font-bold rounded-lg hover:bg-gold transition disabled:opacity-50 shadow-lg tracking-widest uppercase text-sm" :disabled="loading">
                        <span x-show="!loading">Kirim Konfirmasi</span>
                        <span x-show="loading">Mengirim...</span>
                    </button>
                </form>
            </div>
        </section>

        <!-- 12. WEDDING GIFT -->
        <section class="py-16 px-6 bg-white text-center">
            <h2 class="font-serif text-3xl text-sage mb-2">Wedding Gift</h2>
            <p class="text-sm text-gray-500 mb-8 max-w-xs mx-auto">Kehadiran dan doa restu Anda adalah kado terindah
                bagi kami.</p>

            <div class="space-y-6">
                @if(!empty($invitation->bank_accounts))
                    @foreach($invitation->bank_accounts as $bank)
                        <div class="p-6 border border-gray-200 rounded-xl bg-gray-50">
                            <h4 class="font-bold text-lg text-sage mb-1">{{ $bank['bank_name'] }}</h4>
                            <p class="text-2xl font-mono text-gray-800 tracking-widest my-2 select-all">
                                {{ $bank['account_number'] }}</p>
                            <p class="text-sm text-gray-500 mb-4">a.n {{ $bank['account_name'] }}</p>

                            <button
                                @click="navigator.clipboard.writeText('{{ $bank['account_number'] }}'); alert('Nomor rekening disalin!')"
                                class="px-4 py-2 bg-white border border-gray-300 rounded text-xs font-bold uppercase hover:bg-gold hover:text-white hover:border-transparent transition">
                                Salin No. Rekening
                            </button>
                        </div>
                    @endforeach
                @endif

                @if($invitation->gift_address)
                    <div class="mt-8 p-6 border border-gray-200 rounded-xl bg-gray-50">
                        <h4 class="font-bold text-lg text-sage mb-2">Kirim Kado Fisik</h4>
                        <p class="text-sm text-gray-600 italic px-4">{{ $invitation->gift_address }}</p>
                    </div>
                @endif
            </div>
        </section>

        <!-- 13. WISHES / UCAPAN -->
        <section class="py-16 px-6 bg-stone-50" 
                 x-data="{ 
                     rsvps: {{ $rsvps->map(fn($r) => ['name' => $r->name, 'message' => $r->message, 'time' => $r->created_at->diffForHumans()])->values()->toJson() }} 
                 }" 
                 @new-rsvp.window="rsvps.unshift($event.detail)">
            <h2 class="font-serif text-3xl text-center text-sage mb-8">Ucapan & Doa</h2>
            <div class="bg-white rounded-xl shadow-inner p-6 max-h-96 overflow-y-auto space-y-4">
                <template x-for="rsvp in rsvps" :key="rsvp.name + rsvp.time">
                    <div class="border-b border-gray-100 pb-3 last:border-0 animate-fade-in-up">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-bold text-sm text-stone-800" x-text="rsvp.name"></span>
                            <span class="text-[10px] px-2 py-0.5 bg-gray-100 text-gray-500 rounded-full" x-text="rsvp.time"></span>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed" x-text="rsvp.message"></p>
                    </div>
                </template>
                
                <div x-show="rsvps.length === 0" class="text-center text-gray-400 py-4">
                    Belum ada ucapan. Jadilah yang pertama!
                </div>
            </div>
        </section>

        <!-- 14. CLOSING -->
        <section class="py-24 px-6 bg-stone-900 text-white text-center">
            <p class="text-lg opacity-80 mb-8 max-w-xs mx-auto italic font-serif">"Merupakan suatu kehormatan dan
                kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir."</p>
            <h2 class="font-serif text-3xl mb-12 text-gold">Wassalamu'alaikum Wr. Wb.</h2>
            <h1 class="font-serif text-4xl mb-8">{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}
            </h1>
            <div class="mt-16 pt-8 border-t border-white/10 opacity-40 text-[10px] tracking-[0.3em]">
                POWERED BY LANGITARA
            </div>
        </section>

    </main>
    </div> <!-- End Right Section -->

    <!-- FLOATING MUSIC PLAYER -->
    <!-- FLOATING MUSIC PLAYER -->
    <x-public.music-player :invitation="$invitation" />

    <script>
        function countdown(targetDate) {
            return {
                days: '00', hours: '00', minutes: '00', seconds: '00',
                start() {
                    const endDate = new Date(targetDate).getTime();
                    if (isNaN(endDate)) return;

                    setInterval(() => {
                        const now = new Date().getTime();
                        const distance = endDate - now;
                        if (distance < 0) {
                            this.days = '00'; this.hours = '00'; this.minutes = '00'; this.seconds = '00';
                        } else {
                            this.days = String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, '0');
                            this.hours = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                            this.minutes = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                            this.seconds = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');
                        }
                    }, 1000);
                }
            }
        }
        
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100,
            easing: 'ease-out-cubic'
        });
    </script>
</body>

</html>