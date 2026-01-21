<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title ?? 'The Wedding' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Lato:wght@300;400;700&display=swap"
        rel="stylesheet">
    <style>
        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .font-sans {
            font-family: 'Lato', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        .text-gold {
            color: #d4af37;
        }

        .bg-gold {
            background-color: #d4af37;
        }

        .border-gold {
            border-color: #d4af37;
        }

        .text-sage {
            color: #556b2f;
        }

        .bg-sage {
            background-color: #556b2f;
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-spin-slow {
            animation: spin 8s linear infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="font-sans antialiased text-gray-700 bg-stone-50" x-data="{ 
          open: false, 
          isPlaying: false, 
          toggleAudio() {
              if (this.isPlaying) {
                  this.$refs.player.pause();
              } else {
                  this.$refs.player.play();
              }
              this.isPlaying = !this.isPlaying;
          },
          openInvitation() {
              this.open = true;
              this.$refs.player.play()
                  .then(() => { this.isPlaying = true; })
                  .catch(() => { console.log('Autoplay blocked'); });
              window.scrollTo(0,0);
          }
      }" :class="open ? 'overflow-auto' : 'overflow-hidden h-screen'">

    <!-- 1. COVER GATE (The Locking Screen) -->
    <section id="cover-gate"
        class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-stone-900 text-white transition-transform duration-1000 ease-in-out"
        :class="open ? '-translate-y-full' : 'translate-y-0'"
        style="background-image: url('{{ $invitation->cover_image }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-black/50"></div>

        <div class="relative z-10 text-center px-6 animate-float space-y-6">
            <p class="text-sm tracking-[0.3em] uppercase opacity-90">The Wedding of</p>
            <h1 class="font-serif text-5xl md:text-7xl mb-4">
                {{ $invitation->groom_nickname }} <span class="text-gold">&</span> {{ $invitation->bride_nickname }}
            </h1>

            <!-- Guest Badge -->
            <div class="py-6">
                <p class="text-xs uppercase tracking-widest mb-2 opacity-80">Kepada Yth. Bapak/Ibu/Saudara/i</p>
                <div
                    class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg px-8 py-4 mx-auto max-w-xs shadow-xl">
                    <h2 class="font-serif text-2xl font-bold break-words">{{ $guest_name }}</h2>
                    <p class="text-xs mt-1 opacity-70">Di Tempat</p>
                </div>
            </div>

            <button @click="openInvitation()"
                class="mt-8 px-8 py-3 bg-white text-stone-900 rounded-full font-bold tracking-widest hover:scale-105 transition shadow-lg border-4 border-transparent hover:border-gold cursor-pointer">
                BUKA UNDANGAN
            </button>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <main class="max-w-md mx-auto bg-white shadow-2xl min-h-screen relative z-10">

        <!-- 2. QUOTE / AYAT -->
        <section class="py-16 px-8 text-center bg-white">
            <p class="font-serif italic text-xl text-sage/80 mb-4">"{{ $invitation->quote_text }}"</p>
            <p class="text-xs font-bold uppercase tracking-widest text-gold">{{ $invitation->quote_author }}</p>
        </section>

        <!-- 3 & 4. PROFIL MEMPELAI (Couple) -->
        <section class="py-12 px-6 bg-stone-50 text-center">
            <!-- Groom -->
            <div class="mb-12" data-aos="fade-up">
                <div
                    class="w-40 h-40 mx-auto rounded-full overflow-hidden border-4 border-white shadow-md mb-4 bg-gray-200">
                    @if($invitation->groom_photo)
                        <img src="{{ $invitation->groom_photo }}" class="w-full h-full object-cover">
                    @endif
                </div>
                <h2 class="font-serif text-3xl font-bold text-sage mb-2">{{ $invitation->groom_name }}</h2>
                <p class="text-sm text-gray-500">Putra dari Bpk. {{ $invitation->groom_father }} & Ibu
                    {{ $invitation->groom_mother }}
                </p>
            </div>

            <div class="text-center font-serif text-4xl text-gold mb-12">&</div>

            <!-- Bride -->
            <div data-aos="fade-up">
                <div
                    class="w-40 h-40 mx-auto rounded-full overflow-hidden border-4 border-white shadow-md mb-4 bg-gray-200">
                    @if($invitation->bride_photo)
                        <img src="{{ $invitation->bride_photo }}" class="w-full h-full object-cover">
                    @endif
                </div>
                <h2 class="font-serif text-3xl font-bold text-sage mb-2">{{ $invitation->bride_name }}</h2>
                <p class="text-sm text-gray-500">Putri dari Bpk. {{ $invitation->bride_father }} & Ibu
                    {{ $invitation->bride_mother }}
                </p>
            </div>
        </section>

        <!-- 5. LOVE STORY -->
        @if(!empty($invitation->love_stories))
            <section class="py-16 px-6 bg-white">
                <h2 class="font-serif text-3xl text-center text-sage mb-10">Kisah Cinta</h2>
                <div class="space-y-8 border-l-2 border-gold/30 ml-4 pl-8">
                    @foreach($invitation->love_stories as $story)
                        <div class="relative">
                            <span class="absolute -left-[41px] top-0 w-5 h-5 bg-gold rounded-full border-4 border-white"></span>
                            <span
                                class="text-xs font-bold text-gold uppercase mb-1 block">{{ $story['year'] ?? $story['date'] ?? 'Moment' }}</span>
                            <h3 class="font-bold text-gray-800 mb-2">{{ $story['title'] }}</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                {{ $story['story'] ?? $story['description'] ?? '' }}
                            </p>
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
        <section class="py-16 px-6 bg-sage text-white text-center">
            <h2 class="font-serif text-3xl mb-12 text-gold">Rangkaian Acara</h2>

            <!-- Akad -->
            <div class="mb-12 border border-white/20 p-8 rounded-lg bg-white/5 backdrop-blur-sm">
                <h3 class="font-serif text-2xl font-bold mb-4 uppercase">Akad Nikah</h3>
                <div class="my-6 border-t border-b border-white/10 py-4">
                    <p class="text-xl font-bold">
                        {{ \Carbon\Carbon::parse($invitation->akad_date)->translatedFormat('l, d F Y') }}
                    </p>
                    <p class="text-sm mt-1 opacity-80">
                        {{ \Carbon\Carbon::parse($invitation->akad_date)->format('H:i') }} WIB - Selesai
                    </p>
                </div>
                <p class="font-bold">{{ $invitation->akad_location }}</p>
                <p class="text-sm opacity-80 mt-1 px-4">{{ $invitation->akad_address }}</p>
                @if($invitation->akad_map_link)
                    <a href="{{ $invitation->akad_map_link }}" target="_blank"
                        class="inline-block mt-6 px-6 py-2 bg-gold text-white text-xs font-bold rounded-full hover:bg-white hover:text-sage transition cursor-pointer">
                        GOOGLE MAPS
                    </a>
                @endif
            </div>

            <!-- Resepsi (Check existence) -->
            @if($invitation->resepsi_date)
                <div class="border border-white/20 p-8 rounded-lg bg-white/5 backdrop-blur-sm">
                    <h3 class="font-serif text-2xl font-bold mb-4 uppercase">Resepsi</h3>
                    <div class="my-6 border-t border-b border-white/10 py-4">
                        <p class="text-xl font-bold">
                            {{ \Carbon\Carbon::parse($invitation->resepsi_date)->translatedFormat('l, d F Y') }}
                        </p>
                        <p class="text-sm mt-1 opacity-80">
                            {{ \Carbon\Carbon::parse($invitation->resepsi_date)->format('H:i') }} WIB - Selesai
                        </p>
                    </div>
                    <p class="font-bold">{{ $invitation->resepsi_location }}</p>
                    <p class="text-sm opacity-80 mt-1 px-4">{{ $invitation->resepsi_address }}</p>
                    @if($invitation->resepsi_map_link)
                        <a href="{{ $invitation->resepsi_map_link }}" target="_blank"
                            class="inline-block mt-6 px-6 py-2 bg-gold text-white text-xs font-bold rounded-full hover:bg-white hover:text-sage transition cursor-pointer">
                            GOOGLE MAPS
                        </a>
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
        <section class="h-64 bg-gray-200 relative flex items-center justify-center text-gray-500">
            <div class="text-center">
                <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                </svg>
                <p class="text-xs font-bold tracking-widest">PETA LOKASI</p>
            </div>
        </section>

        <!-- 10. GALLERY GRID (Remaining photos) -->
        @php $gridPhotos = array_slice($invitation->gallery_photos ?? [], 4); @endphp
        @if(count($gridPhotos) > 0)
            <section class="py-16 px-4 bg-white">
                <h2 class="font-serif text-3xl text-center text-sage mb-8">Galeri Foto</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                    @foreach($gridPhotos as $photo)
                        <div class="aspect-square bg-gray-100 rounded overflow-hidden">
                            <img src="{{ $photo }}" loading="lazy" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- 11. RSVP FORM -->
        <section class="py-16 px-6 bg-stone-50">
            <h2 class="font-serif text-3xl text-center text-sage mb-8">Konfirmasi Kehadiran</h2>
            <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-gold">
                <form action="{{ route('public.rsvp.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="invitation_id" value="{{ $invitation->id }}">

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Nama</label>
                        <input type="text" name="name" value="{{ $guest_name !== 'Tamu Undangan' ? $guest_name : '' }}"
                            class="w-full border-gray-300 rounded focus:ring-gold focus:border-gold" required
                            placeholder="Nama Anda">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Status Kehadiran</label>
                        <select name="status" class="w-full border-gray-300 rounded focus:ring-gold focus:border-gold"
                            required>
                            <option value="hadir">Hadir</option>
                            <option value="tidak_hadir">Tidak Hadir</option>
                            <option value="ragu">Masih Ragu</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Jumlah Orang</label>
                        <select name="amount" class="w-full border-gray-300 rounded focus:ring-gold focus:border-gold">
                            <option value="1">1 Orang</option>
                            <option value="2">2 Orang</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Ucapan & Doa</label>
                        <textarea name="message" rows="3"
                            class="w-full border-gray-300 rounded focus:ring-gold focus:border-gold"
                            placeholder="Tulis ucapan selamat..."></textarea>
                    </div>

                    <button type="submit"
                        class="w-full py-3 bg-sage text-white font-bold rounded hover:bg-opacity-90 transition">
                        Kirim Konfirmasi
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
                                {{ $bank['account_number'] }}
                            </p>
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
        <section class="py-16 px-6 bg-stone-50">
            <h2 class="font-serif text-3xl text-center text-sage mb-8">Ucapan & Doa</h2>
            <div class="bg-white rounded-xl shadow-inner p-6 max-h-96 overflow-y-auto space-y-4">
                @forelse($rsvps as $rsvp)
                    <div class="border-b border-gray-100 pb-3 last:border-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-bold text-sm text-stone-800">{{ $rsvp->name }}</span>
                            <span
                                class="text-[10px] px-2 py-0.5 bg-gray-100 text-gray-500 rounded-full">{{ $rsvp->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed">"{{ $rsvp->message }}"</p>
                    </div>
                @empty
                    <p class="text-center text-gray-400 py-4">Belum ada ucapan.</p>
                @endforelse
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

    <!-- FLOATING MUSIC PLAYER -->
    @if($invitation->music_path)
        <div class="fixed bottom-6 right-6 z-50">
            <audio x-ref="player" loop src="{{ asset($invitation->music_path) }}"></audio>
            <button @click="toggleAudio()"
                class="w-12 h-12 bg-white/90 backdrop-blur rounded-full shadow-xl flex items-center justify-center text-sage hover:scale-110 transition animate-spin-slow"
                :class="{'animate-spin': isPlaying}">
                <span x-show="isPlaying">🎵</span>
                <span x-show="!isPlaying">🔇</span>
            </button>
        </div>
    @endif

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
    </script>
</body>

</html>