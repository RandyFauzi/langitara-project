<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Wedding of {{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Raleway:wght@300;400;600;700&display=swap"
        rel="stylesheet">

    <!-- Tailwind & Alpine -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .font-script {
            font-family: 'Great Vibes', cursive;
        }

        .font-body {
            font-family: 'Raleway', sans-serif;
        }

        .text-accent {
            color: #FFB3B1;
        }

        .bg-accent {
            background-color: #FFB3B1;
        }

        .border-accent {
            border-color: #FFB3B1;
        }

        .bg-overlay {
            background-color: rgba(135, 155, 175, 0.95);
        }

        /* #879BAF with 0.95 opacity */

        [x-cloak] {
            display: none !important;
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
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
    </style>
</head>

<body class="font-body text-gray-800 antialiased overflow-hidden" x-data="{ 
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
              document.body.classList.remove('overflow-hidden');
              window.scrollTo({top: window.innerHeight, behavior: 'smooth'});
          }
      }">

    <!-- MUSIC PLAYER -->
    @if($invitation->music_path)
        <div class="fixed bottom-6 right-6 z-50 transition-all duration-500"
            :class="open ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
            <audio x-ref="player" loop src="{{ asset($invitation->music_path) }}"></audio>
            <button @click="toggleAudio()"
                class="w-12 h-12 bg-white rounded-full shadow-lg border-2 border-accent flex items-center justify-center animate-spin-slow">
                <template x-if="isPlaying">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-accent" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </template>
                <template x-if="!isPlaying">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-accent" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </template>
            </button>
        </div>
    @endif

    <!-- 1. HERO / COVER GATE -->
    <header class="relative w-full h-screen flex flex-col items-center justify-center text-center overflow-hidden">
        <!-- Background Fixed -->
        <div class="absolute inset-0 z-0 bg-cover bg-center bg-no-repeat bg-fixed"
            style="background-image: url('{{ $invitation->cover_image }}');">
        </div>
        <!-- Overlay -->
        <div class="absolute inset-0 z-10 bg-overlay"></div>

        <div class="relative z-20 px-6 space-y-6 text-white animate-float">
            <p class="font-body text-xl md:text-2xl font-semibold uppercase tracking-wider text-accent">The Wedding Of
            </p>

            <h1 class="font-script text-6xl md:text-8xl lg:text-9xl text-white drop-shadow-sm">
                {{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}
            </h1>

            <!-- Divider -->
            <div class="flex items-center justify-center gap-4 text-accent opacity-80 my-8">
                <span class="h-px w-12 bg-accent"></span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 animate-pulse" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                </svg>
                <span class="h-px w-12 bg-accent"></span>
            </div>

            <!-- Guest Badge -->
            <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-xl max-w-sm mx-auto mt-8">
                <p class="text-sm font-semibold mb-2">Kepada Yth. Bapak/Ibu/Saudara/i:</p>
                <h3 class="font-body text-2xl font-bold">{{ $guest_name }}</h3>
            </div>

            <button @click="openInvitation()"
                class="mt-10 px-8 py-3 bg-transparent border-2 border-accent text-white font-bold rounded-full hover:bg-accent hover:text-white transition duration-300 transform hover:scale-105 tracking-widest uppercase text-sm">
                Buka Undangan
            </button>
        </div>
    </header>

    <!-- CONTENT WRAPPER -->
    <main class="relative z-30 bg-white">

        <!-- 2. QUOTE (Detail Pernikahan Header in JSON used as divider, but we add Quote similar to JSON logic)-->
        <section class="py-20 px-6 text-center bg-white">
            <div class="text-accent mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </div>
            @if($invitation->quote_text)
                <p class="font-body italic text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    "{{ $invitation->quote_text }}"
                </p>
                <p class="mt-4 font-bold text-accent uppercase tracking-widest text-sm">{{ $invitation->quote_author }}</p>
            @endif
        </section>

        <!-- 3. EVENTS (Replicating the 3-column icon layout) -->
        <!-- Using the same BG Style as HERO for consistency in styling per JSON "background_image" usage -->
        <section class="relative py-20 px-6 bg-fixed bg-cover bg-center"
            style="background-image: url('{{ $invitation->cover_image }}');">
            <div class="absolute inset-0 bg-overlay"></div>
            <div class="relative z-10 max-w-5xl mx-auto text-white">

                <div class="text-center mb-16">
                    <h2
                        class="font-body text-2xl font-bold uppercase tracking-widest mb-4 border-b-2 border-accent inline-block pb-2 text-accent">
                        Rangkaian Acara</h2>
                </div>

                <!-- AKAD -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center mb-12">
                    <!-- Date -->
                    <div class="flex flex-col items-center">
                        <div
                            class="w-16 h-16 border-2 border-accent rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-xl mb-1 text-white">Tanggal</h3>
                        <p class="font-light">
                            {{ \Carbon\Carbon::parse($invitation->akad_date)->translatedFormat('l, d F Y') }}</p>
                    </div>

                    <!-- Time -->
                    <div class="flex flex-col items-center">
                        <div
                            class="w-16 h-16 border-2 border-accent rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-xl mb-1 text-white">Waktu</h3>
                        <p class="font-light">{{ \Carbon\Carbon::parse($invitation->akad_date)->format('H:i') }} WIB</p>
                    </div>

                    <!-- Location -->
                    <div class="flex flex-col items-center">
                        <div
                            class="w-16 h-16 border-2 border-accent rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-xl mb-1 text-white">Lokasi</h3>
                        <p class="font-light px-4">{{ $invitation->akad_location }}</p>

                        @if($invitation->akad_map_embed || $invitation->akad_map_link)
                            <div class="mt-4" x-data="{ showMap: false }">
                                @if($invitation->akad_map_embed)
                                    <button @click="showMap = !showMap"
                                        class="text-accent underline text-sm font-bold uppercase tracking-wider hover:text-white transition">
                                        <span x-text="showMap ? 'Tutup Peta' : 'Lihat Peta'">Lihat Peta</span>
                                    </button>
                                    <div x-show="showMap" x-collapse
                                        class="mt-4 w-full max-w-sm mx-auto bg-white p-1 rounded-lg">
                                        <div class="aspect-video w-full">
                                            {!! $invitation->akad_map_embed !!}
                                        </div>
                                    </div>
                                @elseif($invitation->akad_map_link)
                                    <a href="{{ $invitation->akad_map_link }}" target="_blank"
                                        class="px-4 py-2 border border-accent text-accent rounded-full text-xs font-bold hover:bg-accent hover:text-white transition">Google
                                        Maps</a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- RESEPSI (Repeat Logic if exists) -->
                @if($invitation->resepsi_date)
                    <div class="border-t border-white/20 pt-12 mt-12">
                        <div class="text-center mb-8">
                            <h2 class="font-body text-xl font-bold uppercase tracking-widest text-accent">Resepsi</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                            <div class="flex flex-col items-center">
                                <p class="font-bold text-lg">Tanggal</p>
                                <p class="font-light">
                                    {{ \Carbon\Carbon::parse($invitation->resepsi_date)->translatedFormat('l, d F Y') }}</p>
                            </div>
                            <div class="flex flex-col items-center">
                                <p class="font-bold text-lg">Waktu</p>
                                <p class="font-light">{{ \Carbon\Carbon::parse($invitation->resepsi_date)->format('H:i') }}
                                    WIB</p>
                            </div>
                            <div class="flex flex-col items-center">
                                <p class="font-bold text-lg">Lokasi</p>
                                <p class="font-light px-4">{{ $invitation->resepsi_location }}</p>

                                @if($invitation->resepsi_map_embed || $invitation->resepsi_map_link)
                                    <div class="mt-4" x-data="{ showMap: false }">
                                        @if($invitation->resepsi_map_embed)
                                            <button @click="showMap = !showMap"
                                                class="text-accent underline text-sm font-bold uppercase tracking-wider hover:text-white transition">
                                                <span x-text="showMap ? 'Tutup Peta' : 'Lihat Peta'">Lihat Peta</span>
                                            </button>
                                            <div x-show="showMap" x-collapse
                                                class="mt-4 w-full max-w-sm mx-auto bg-white p-1 rounded-lg">
                                                <div class="aspect-video w-full">
                                                    {!! $invitation->resepsi_map_embed !!}
                                                </div>
                                            </div>
                                        @elseif($invitation->resepsi_map_link)
                                            <a href="{{ $invitation->resepsi_map_link }}" target="_blank"
                                                class="px-4 py-2 border border-accent text-accent rounded-full text-xs font-bold hover:bg-accent hover:text-white transition">Google
                                                Maps</a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </section>

        <!-- 4. COUPLE PROFILE ("Tentang Mempelai") -->
        <section class="py-20 px-6 bg-white relative">
            <div class="text-center mb-16">
                <h2
                    class="font-body text-2xl font-bold uppercase tracking-widest mb-4 border-b-2 border-accent inline-block pb-2 text-accent">
                    Tentang Mempelai</h2>
            </div>

            <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <!-- Groom -->
                <div class="text-center space-y-4">
                    <div class="w-64 h-64 mx-auto rounded-full overflow-hidden border-4 border-accent p-1">
                        @if($invitation->groom_photo)
                            <img src="{{ $invitation->groom_photo }}" class="w-full h-full object-cover rounded-full">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">No Photo
                            </div>
                        @endif
                    </div>
                    <div>
                        <h3 class="font-script text-5xl text-gray-800">{{ $invitation->groom_nickname }}</h3>
                        <p class="font-body font-bold text-xl mt-2 text-gray-600">{{ $invitation->groom_name }}</p>
                        <p class="text-sm text-gray-500 mt-2">Putra dari Bpk. {{ $invitation->groom_father }} & Ibu
                            {{ $invitation->groom_mother }}</p>
                    </div>
                </div>

                <!-- Bride -->
                <div class="text-center space-y-4">
                    <div class="w-64 h-64 mx-auto rounded-full overflow-hidden border-4 border-accent p-1">
                        @if($invitation->bride_photo)
                            <img src="{{ $invitation->bride_photo }}" class="w-full h-full object-cover rounded-full">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">No Photo
                            </div>
                        @endif
                    </div>
                    <div>
                        <h3 class="font-script text-5xl text-gray-800">{{ $invitation->bride_nickname }}</h3>
                        <p class="font-body font-bold text-xl mt-2 text-gray-600">{{ $invitation->bride_name }}</p>
                        <p class="text-sm text-gray-500 mt-2">Putri dari Bpk. {{ $invitation->bride_father }} & Ibu
                            {{ $invitation->bride_mother }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 5. GALLERY CAROUSEL -->
        @if(!empty($invitation->gallery_photos))
            <section class="py-20 bg-gray-50 relative">
                <div class="text-center mb-12">
                    <h2
                        class="font-body text-2xl font-bold uppercase tracking-widest mb-4 border-b-2 border-accent inline-block pb-2 text-accent">
                        Gallery</h2>
                </div>

                <!-- Alpine Carousel -->
                <div x-data="{ 
                        active: 0, 
                        photos: {{ json_encode($invitation->gallery_photos) }},
                        next() { this.active = (this.active + 1) % this.photos.length },
                        prev() { this.active = (this.active - 1 + this.photos.length) % this.photos.length }
                    }" class="relative max-w-4xl mx-auto px-12">

                    <div class="relative overflow-hidden rounded-xl shadow-2xl aspect-[4/3] bg-white">
                        <template x-for="(photo, index) in photos" :key="index">
                            <div x-show="active === index" class="absolute inset-0 transition-opacity duration-500"
                                x-transition:enter="opacity-0" x-transition:enter-end="opacity-100"
                                x-transition:leave="opacity-100" x-transition:leave-end="opacity-0">
                                <img :src="photo" class="w-full h-full object-cover">
                            </div>
                        </template>
                    </div>

                    <button @click="prev"
                        class="absolute left-0 top-1/2 -translate-y-1/2 p-3 bg-white text-accent rounded-full shadow-lg hover:bg-accent hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </button>
                    <button @click="next"
                        class="absolute right-0 top-1/2 -translate-y-1/2 p-3 bg-white text-accent rounded-full shadow-lg hover:bg-accent hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </section>
        @endif

        <!-- 6. RSVP FORM -->
        <section class="py-20 px-6 bg-white relative">
            <div class="max-w-xl mx-auto bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
                <div class="bg-overlay p-6 text-center text-white">
                    <h2 class="font-body text-xl font-bold uppercase tracking-widest">Konfirmasi Kehadiran</h2>
                </div>

                <div class="p-8">
                    <form action="{{ route('public.rsvp.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="invitation_id" value="{{ $invitation->id }}">

                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Nama</label>
                            <input type="text" name="name"
                                value="{{ $guest_name !== 'Tamu Undangan' ? $guest_name : '' }}" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-accent">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Jumlah &
                                Kehadiran</label>
                            <div class="grid grid-cols-2 gap-4">
                                <select name="amount"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-accent">
                                    <option value="1">1 Orang</option>
                                    <option value="2">2 Orang</option>
                                </select>
                                <select name="status"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-accent">
                                    <option value="hadir">Hadir</option>
                                    <option value="tidak_hadir">Tidak Hadir</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Pesan / Ucapan</label>
                            <textarea name="message" rows="3"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-accent"></textarea>
                        </div>

                        <button type="submit"
                            class="w-full py-4 bg-accent text-white font-bold rounded-lg uppercase tracking-widest hover:brightness-90 transition shadow-lg">
                            Kirim Konfirmasi
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <!-- 7. CLOSING -->
        <section class="py-24 px-6 text-center text-white bg-fixed bg-cover bg-center"
            style="background-image: url('{{ $invitation->cover_image }}');">
            <div class="absolute inset-0 bg-overlay z-0"></div>
            <div class="relative z-10 space-y-8 animate-float">
                <p class="font-body text-sm uppercase tracking-widest opacity-80">Terima kasih atas doa & restu Anda</p>
                <h1 class="font-script text-6xl md:text-8xl">{{ $invitation->groom_nickname }} &
                    {{ $invitation->bride_nickname }}</h1>
                <p class="text-xs uppercase tracking-widest opacity-60">Powered by Langitara</p>
            </div>
        </section>

    </main>
</body>

</html>