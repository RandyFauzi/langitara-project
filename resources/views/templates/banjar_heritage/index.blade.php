<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Wedding of {{ $couple->groom_nickname ?? 'Syahril' }} & {{ $couple->bride_nickname ?? 'Elyana' }}</title>

    <!-- External Libs -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @php
        $couple = $invitation->couple ?? $invitation ?? new \stdClass();
        $events = $invitation->events ?? $invitation ?? new \stdClass();
        $meta = $invitation->meta ?? $invitation ?? new \stdClass();
        $gallery = $invitation->gallery ?? [];
        $bank_accounts = $invitation->bank_accounts ?? [];
        $love_stories = $invitation->love_stories ?? [];
        $rsvps = $rsvps ?? collect([]);
        $guest_name = $guest_name ?? 'Tamu Undangan';
    @endphp

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/templates/banjar_heritage/css/style.css') }}">

    <!-- Tailwind config for specific colors -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        maroon: '#722C2C',
                        'maroon-dark': '#361111',
                        gold: '#D7BB83',
                        'gold-dark': '#A38C5E',
                        cream: '#FFFCF3',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-black text-white overflow-hidden">

    <!-- AUDIO / CUSTOM MUSIC -->
    @if($invitation->music)
        <!-- Custom Music (Spotify/YouTube/SoundCloud Embed) -->
        <div id="custom-music-player"
            class="fixed bottom-24 right-6 hidden z-[60] cursor-pointer bg-white/10 backdrop-blur-md p-3 rounded-full border border-gold/50"
            onclick="toggleCustomPlayer()">
            @if($invitation->music->provider === 'spotify')
                <i class="fab fa-spotify text-xl" style="color: #1DB954;"></i>
            @elseif($invitation->music->provider === 'youtube')
                <i class="fab fa-youtube text-xl" style="color: #FF0000;"></i>
            @else
                <i class="fab fa-soundcloud text-xl" style="color: #ff5500;"></i>
            @endif
        </div>
        <div id="custom-music-embed"
            style="display: none; position: fixed; bottom: 100px; right: 16px; z-index: 9999; 
                     background: white; border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); overflow: hidden; width: 320px;">
            <div
                style="display: flex; justify-content: space-between; align-items: center; padding: 8px 12px; background: #f3f4f6;">
                <span style="font-size: 10px; font-weight: bold; text-transform: uppercase; color: #6b7280;">Music
                    Player</span>
                <button onclick="toggleCustomPlayer()"
                    style="background: none; border: none; color: #9ca3af; cursor: pointer;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @if($invitation->music->provider === 'spotify')
                <iframe src="{{ $invitation->music->embed_url }}" width="100%" height="152" frameBorder="0"
                    allow="autoplay; clipboard-write; encrypted-media" loading="lazy"></iframe>
            @elseif($invitation->music->provider === 'soundcloud')
                <iframe width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay"
                    src="{{ $invitation->music->embed_url }}"></iframe>
            @else
                <div style="aspect-ratio: 16/9;">
                    <iframe src="{{ $invitation->music->embed_url }}" width="100%" height="100%" frameborder="0"
                        allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>
            @endif
        </div>
        <script>
            function toggleCustomPlayer() {
                const embed = document.getElementById('custom-music-embed');
                embed.style.display = embed.style.display === 'none' ? 'block' : 'none';
            }
        </script>
    @else
        <!-- Library Music (Standard Audio) -->
        <audio id="bg-music" loop>
            <source src="{{ asset($invitation->music_path ?? 'assets/music/default.mp3') }}" type="audio/mp3">
        </audio>

        <!-- MUSIC CONTROL (Floating) -->
        <div id="music-control"
            class="fixed bottom-24 right-6 hidden z-[60] cursor-pointer bg-white/10 backdrop-blur-md p-3 rounded-full border border-gold/50 animate-spin-slow">
            <i class="fas fa-compact-disc text-xl text-gold"></i>
        </div>
    @endif

    <!-- COVER SECTION (Full Screen) -->
    <section id="cover-section"
        class="fixed inset-0 z-[100] w-full h-full bg-maroon-dark flex flex-col items-center justify-center">
        <!-- Video Background -->
        <div class="absolute inset-0 w-full h-full overflow-hidden">
            <!-- Local Video Path -->
            <video id="cover-video" autoplay loop muted playsinline class="w-full h-full object-cover opacity-60">
                <source src="{{ asset('assets/templates/banjar_heritage/video/motion_bg.mp4') }}" type="video/mp4">
            </video>
            <!-- Overlay Color from JSON (Multiply #361111) -->
            <div class="absolute inset-0 bg-maroon-dark/60 mix-blend-multiply"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 text-center space-y-4 px-6">
            <p class="font-cormorant text-md font-bold uppercase tracking-widest mb-4" data-aos="fade-down"
                data-aos-delay="500">The Wedding of</p>

            <h1 class="font-pinyon text-5xl md:text-6xl text-gold drop-shadow-lg" data-aos="zoom-in"
                data-aos-delay="800">
                {{ $couple->bride_nickname ?? 'Elyana' }} <span class="font-alex text-4xl text-white">&</span>
                {{ $couple->groom_nickname ?? 'Syahril' }}
            </h1>

            <div class="py-4" data-aos="fade-up" data-aos-delay="1000">
                <p class="font-poppins text-xs uppercase tracking-widest text-white/80">Kepada Yth:</p>
                <div class="mt-2 bg-white/10 backdrop-blur-sm border border-gold/30 rounded-xl py-3 px-6 inline-block">
                    <h3 class="font-cormorant text-xl font-bold">{{ $guest_name ?? 'Tamu Undangan' }}</h3>
                </div>
            </div>

            <button id="btn-open" class="btn-gold flex items-center justify-center gap-2 mx-auto mt-6"
                data-aos="fade-up" data-aos-delay="1200">
                <i class="far fa-envelope"></i>
                <span>Buka Undangan</span>
            </button>
        </div>
    </section>

    <!-- MAIN SCROLLABLE CONTENT -->
    <!-- Max Width MD to simulate mobile app feel on desktop, per Langitara standard -->
    <div id="main-content" class="relative w-full max-w-md mx-auto bg-cream text-maroon-dark shadow-2xl min-h-screen">

        <!-- QUOTES SECTION -->
        <section class="relative py-20 px-6 bg-maroon text-cream text-center overflow-hidden">
            <!-- Background Pattern from JSON -->
            <div class="absolute inset-0 opacity-10 mix-blend-multiply pointer-events-none"
                style="background-image: url('https://bitwave.my.id/wp-content/uploads/2025/03/Banjar-Seamless-Pattern.png');">
            </div>

            <!-- Top Motif -->
            <img src="https://bitwave.my.id/wp-content/uploads/2025/03/Banjar-Motif-Atas.png"
                class="w-full mb-8 relative z-10" data-aos="zoom-in-up">

            <!-- Sec 1 Image -->
            <div class="mb-10 p-4 relative z-10" data-aos="zoom-in-up">
                <img src="https://bitwave.my.id/wp-content/uploads/2024/12/Heritage-10.jpeg"
                    class="w-full rounded-2xl shadow-lg border-2 border-gold" alt="Couple">
            </div>

            <!-- Initials -->
            <div class="flex justify-center items-center gap-4 mb-8 font-cormorant text-4xl font-bold text-gold relative z-10"
                data-aos="zoom-in-up">
                <span>{{ substr($couple->bride_nickname ?? 'E', 0, 1) }}</span>
                <span class="font-pinyon text-3xl text-white">&</span>
                <span>{{ substr($couple->groom_nickname ?? 'S', 0, 1) }}</span>
            </div>

            <!-- Quote Text -->
            <blockquote class="font-cormorant text-lg italic leading-relaxed px-4 relative z-10" data-aos="zoom-in-up">
                "And among His signs is that He created for you mates from among yourselves, that you may dwell in
                tranquility with them, and He has put love and mercy between your (hearts)."
            </blockquote>
            <p class="mt-4 font-cormorant font-bold text-gold relative z-10" data-aos="zoom-in-up">- QS. Ar-Rum : 21 -
            </p>

            <!-- Bottom Motif -->
            <img src="https://bitwave.my.id/wp-content/uploads/2025/03/Banjar-Motif-Bawah.png"
                class="w-full mt-12 relative z-10" data-aos="zoom-in-up">
        </section>

        <!-- COUPLE SECTION ("Mempelai") -->
        <section class="relative py-16 px-6 bg-cream text-center">

            <!-- Box Container (Radius 200px style from JSON) -->
            <div class="relative bg-cream border-4 border-gold radius-200 py-16 px-4 shadow-xl" data-aos="zoom-in-up">
                <!-- Inner Pattern -->
                <div class="absolute inset-0 radius-200 opacity-20 pointer-events-none"
                    style="background-image: url('https://bitwave.my.id/wp-content/uploads/2025/03/Banjar-Seamless-Pattern.png');">
                </div>

                <!-- Icon -->
                <img src="https://bitwave.my.id/wp-content/uploads/2025/03/Banjar-Icon.png"
                    class="h-24 mx-auto mb-6 relative z-10" alt="Icon">

                <h2 class="font-pinyon text-4xl text-maroon-dark mb-4 relative z-10">We are<br>Getting Married!</h2>
                <p class="font-poppins text-xs text-maroon-dark/80 relative z-10">
                    Maha Suci Allah yang telah menciptakan makhluk-Nya berpasang-pasangan.
                </p>
            </div>

            <!-- BRIDE -->
            <div class="mt-12 group" data-aos="zoom-in-up">
                <div class="relative w-40 h-40 mx-auto mb-6">
                    <!-- Decor Back -->
                    <img src="https://bitwave.my.id/wp-content/uploads/2025/03/Banjar-Couple-Belakang-2.png"
                        class="absolute -top-10 -left-10 w-[160%] max-w-none pointer-events-none" alt="Decor">
                    <!-- Photo -->
                    <div class="w-full h-full rounded-full overflow-hidden border-2 border-gold relative z-10">
                        <img src="{{ $couple->bride_photo ?? 'https://via.placeholder.com/200' }}"
                            class="w-full h-full object-cover" alt="Bride">
                    </div>
                    <!-- Decor Front: Adjusted to not cover face -->
                    <img src="https://bitwave.my.id/wp-content/uploads/2025/03/Banjar-Couple-Depan-2.png"
                        class="absolute -bottom-14 -right-12 w-[110%] max-w-none pointer-events-none z-20" alt="Decor">
                </div>
                <h3 class="font-pinyon text-4xl text-gold">{{ $couple->bride_nickname ?? 'Elyana' }}</h3>
                <p class="font-cormorant text-xl font-bold uppercase mt-1">
                    {{ $couple->bride_name ?? 'Elyana Azkiya Nur' }}
                </p>
                <p class="font-poppins text-xs mt-2">Putri dari Bpk. {{ $couple->bride_father ?? 'Father' }} <br>& Ibu
                    {{ $couple->bride_mother ?? 'Mother' }}
                </p>
                <a href="#" class="inline-block mt-4 btn-gold text-xs px-6 py-2"><i class="fab fa-instagram"></i>
                    Instagram</a>
            </div>

            <div class="font-pinyon text-5xl text-maroon my-8" data-aos="zoom-in-up">&</div>

            <!-- GROOM -->
            <div class="mb-12 group" data-aos="zoom-in-up">
                <div class="relative w-40 h-40 mx-auto mb-6">
                    <!-- Decor Back -->
                    <img src="https://bitwave.my.id/wp-content/uploads/2025/03/Banjar-Couple-Belakang-1.png"
                        class="absolute -top-10 -left-4 w-[140%] max-w-none pointer-events-none" alt="Decor">
                    <!-- Photo -->
                    <div class="w-full h-full rounded-full overflow-hidden border-2 border-gold relative z-10">
                        <img src="{{ $couple->groom_photo ?? 'https://via.placeholder.com/200' }}"
                            class="w-full h-full object-cover" alt="Groom">
                    </div>
                    <!-- Decor Front: Adjusted to not cover face -->
                    <img src="https://bitwave.my.id/wp-content/uploads/2025/03/Banjar-Couple-Depan-1.png"
                        class="absolute -bottom-12 -left-12 w-[110%] max-w-none pointer-events-none z-20" alt="Decor">
                </div>
                <h3 class="font-pinyon text-4xl text-gold">{{ $couple->groom_nickname ?? 'Syahril' }}</h3>
                <p class="font-cormorant text-xl font-bold uppercase mt-1">{{ $couple->groom_name ?? 'Syahril Rendra' }}
                </p>
                <p class="font-poppins text-xs mt-2">Putra dari Bpk. {{ $couple->groom_father ?? 'Father' }} <br>& Ibu
                    {{ $couple->groom_mother ?? 'Mother' }}
                </p>
                <a href="#" class="inline-block mt-4 btn-gold text-xs px-6 py-2"><i class="fab fa-instagram"></i>
                    Instagram</a>
            </div>

        </section>

        <!-- ACARA (EVENTS) -->
        <section class="relative py-20 px-4 bg-cream">

            <!-- AKAD -->
            <div class="relative bg-cream border-2 border-gold radius-500 py-20 px-6 text-center shadow-lg mb-12 overflow-hidden"
                data-aos="zoom-in-up">
                <!-- Inner Bg overlay -->
                <div class="absolute inset-0 bg-maroon/5 opacity-20 pointer-events-none"></div>

                <h2 class="font-pinyon text-4xl text-maroon-dark mb-4">Akad Nikah</h2>

                <div class="border-y border-gold/50 py-4 my-6">
                    <p class="font-cormorant text-2xl font-bold uppercase">
                        {{ $events->akad_date ? \Carbon\Carbon::parse($events->akad_date)->translatedFormat('l') : 'Minggu' }}
                    </p>
                    <p class="font-cormorant text-xl font-bold uppercase text-gold">
                        {{ $events->akad_date ? \Carbon\Carbon::parse($events->akad_date)->translatedFormat('d F Y') : '31 Desember 2025' }}
                    </p>
                </div>

                <p class="font-poppins text-sm mb-6">{{ $events->akad_time ?? '08:00 - 10:00 WIB' }}</p>

                <div class="mb-8">
                    <i class="fas fa-map-marker-alt text-2xl text-gold mb-2"></i>
                    <p class="font-cormorant font-bold uppercase">{{ $events->akad_location ?? 'Lokasi Akad' }}</p>
                    <p class="font-poppins text-xs px-4">{{ $events->akad_address ?? 'Alamat Lengkap' }}</p>
                </div>

                <a href="{{ $events->akad_map_link ?? '#' }}" class="btn-gold"><i
                        class="fas fa-map-marker-alt mr-2"></i> Google Maps</a>
            </div>

            <!-- RESEPSI -->
            <div class="relative bg-cream border-2 border-gold radius-500 py-20 px-6 text-center shadow-lg overflow-hidden"
                data-aos="zoom-in-up">
                <!-- Inner Bg overlay -->
                <div class="absolute inset-0 bg-maroon/5 opacity-20 pointer-events-none"></div>

                <h2 class="font-pinyon text-4xl text-maroon-dark mb-4">Resepsi</h2>

                <div class="border-y border-gold/50 py-4 my-6">
                    <p class="font-cormorant text-2xl font-bold uppercase">
                        {{ $events->resepsi_date ? \Carbon\Carbon::parse($events->resepsi_date)->translatedFormat('l') : 'Minggu' }}
                    </p>
                    <p class="font-cormorant text-xl font-bold uppercase text-gold">
                        {{ $events->resepsi_date ? \Carbon\Carbon::parse($events->resepsi_date)->translatedFormat('d F Y') : '31 Desember 2025' }}
                    </p>
                </div>

                <p class="font-poppins text-sm mb-6">{{ $events->resepsi_time ?? '11:00 - 17:00 WIB' }}</p>

                <div class="mb-8">
                    <i class="fas fa-map-marker-alt text-2xl text-gold mb-2"></i>
                    <p class="font-cormorant font-bold uppercase">{{ $events->resepsi_location ?? 'Lokasi Resepsi' }}
                    </p>
                    <p class="font-poppins text-xs px-4">{{ $events->resepsi_address ?? 'Alamat Lengkap' }}</p>
                </div>

                <a href="{{ $events->resepsi_map_link ?? '#' }}" class="btn-gold"><i
                        class="fas fa-map-marker-alt mr-2"></i> Google Maps</a>
            </div>

        </section>

        <!-- LIVE STREAMING -->
        <section class="py-12 px-6 bg-cream text-center" data-aos="zoom-in-up">
            <div class="border-4 border-gold radius-20 bg-cream/50 p-8 shadow-md">
                <h2 class="font-pinyon text-4xl text-maroon-dark mb-4">Live Streaming</h2>
                <p class="font-poppins text-xs mb-6">Temui kami secara virtual untuk menyaksikan acara pernikahan kami
                    melalui tautan di bawah ini:</p>
                <div class="flex flex-col gap-3">
                    <a href="#" class="btn-gold w-full block">Instagram</a>
                    <a href="#" class="btn-gold w-full block">Youtube</a>
                </div>
            </div>
        </section>

        <!-- LOVE STORY -->
        @if(!empty($love_stories))
            <section class="py-16 px-6 bg-cream text-center" data-aos="zoom-in-up">
                <h2 class="font-pinyon text-4xl text-gold mb-8">Love Story</h2>

                <!-- Story Items -->
                <div class="space-y-6">
                    @foreach($love_stories as $story)
                        <div class="border-2 border-gold radius-20 p-6 bg-white/50 shadow-sm">
                            <span
                                class="font-cormorant text-2xl font-bold block mb-2">{{ $story['year'] ?? $story['date'] ?? 'Moment' }}</span>
                            <h3 class="font-bold text-lg mb-2 text-maroon-dark">{{ $story['title'] ?? '' }}</h3>
                            <p class="font-poppins text-xs text-justify">{{ $story['story'] ?? $story['description'] ?? '' }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- GIFT -->
        <section class="py-16 px-6 bg-maroon text-cream text-center relative overflow-hidden">
            <!-- Overlay Pattern -->
            <div class="absolute inset-0 opacity-10 mix-blend-multiply pointer-events-none"
                style="background-image: url('https://bitwave.my.id/wp-content/uploads/2025/03/Banjar-Seamless-Pattern.png');">
            </div>

            <div class="relative z-10" data-aos="zoom-in-up">
                <i class="fas fa-gifts text-4xl mb-4 text-gold"></i>
                <h2 class="font-pinyon text-4xl mb-2">Wedding Gift</h2>
                <p class="font-poppins text-xs mb-8">Tanpa mengurangi rasa hormat, bagi yang ingin memberikan tanda
                    kasih.</p>

                <div class="space-y-4">
                    @foreach($bank_accounts as $bank)
                        <div class="bg-cream text-maroon-dark radius-20 p-8 border-4 border-gold relative">
                            <div class="flex justify-end mb-4">
                                <!-- Bank Logo Placeholder/Dynamic if available -->
                                <span
                                    class="font-bold text-lg border-b-2 border-maroon-dark">{{ $bank['bank_name'] ?? 'Bank' }}</span>
                            </div>
                            <p class="font-poppins text-sm text-left mb-1">{{ $bank['bank_name'] ?? 'Bank' }}</p>
                            <p class="font-poppins text-sm text-left mb-1">No. Rekening {{ $bank['account_number'] }}</p>
                            <p class="font-poppins text-sm text-left font-bold mb-4">a.n {{ $bank['account_name'] }}</p>

                            <button class="btn-gold w-full text-xs py-2 hover:opacity-90 transition"
                                onclick="navigator.clipboard.writeText('{{ $bank['account_number'] }}'); alert('Nomor rekening disalin!');">
                                Salin Rekening
                            </button>
                        </div>
                    @endforeach
                </div>

                @if($invitation->gift_address)
                    <div class="mt-8 bg-cream/10 border border-gold/30 p-6 radius-20 backdrop-blur-sm">
                        <h3 class="font-cormorant text-xl font-bold mb-2">Kirim Kado Fisik</h3>
                        <p class="font-poppins text-xs leading-relaxed">
                            {{ $invitation->gift_address }}
                        </p>
                    </div>
                @endif
            </div>
        </section>

        <!-- RSVP FORM -->
        <section class="py-16 px-6 bg-cream text-center" x-data="{
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
            <h2 class="font-pinyon text-4xl text-maroon-dark mb-8" data-aos="zoom-in-up">RSVP</h2>

            <div class="border-4 border-gold radius-20 p-8 bg-white/50 shadow-lg max-w-sm mx-auto"
                data-aos="zoom-in-up">
                <form action="{{ route('public.rsvp.store') }}" method="POST" class="space-y-4"
                    @submit.prevent="submitRsvp">
                    @csrf
                    <input type="hidden" name="invitation_id" value="{{ $invitation->id }}">

                    <div class="text-left">
                        <label class="block font-cormorant font-bold text-lg text-maroon-dark mb-1">Nama</label>
                        <input type="text" name="name" value="{{ $guest_name !== 'Tamu Undangan' ? $guest_name : '' }}"
                            class="w-full border-2 border-gold/50 rounded p-2 bg-cream focus:border-maroon focus:ring-0 font-poppins text-sm"
                            required placeholder="Nama Anda">
                    </div>

                    <div class="text-left">
                        <label class="block font-cormorant font-bold text-lg text-maroon-dark mb-1">Kehadiran</label>
                        <select name="status"
                            class="w-full border-2 border-gold/50 rounded p-2 bg-cream focus:border-maroon focus:ring-0 font-poppins text-sm"
                            required>
                            <option value="hadir">Hadir</option>
                            <option value="tidak_hadir">Tidak Hadir</option>
                            <option value="ragu">Masih Ragu</option>
                        </select>
                    </div>

                    <div class="text-left">
                        <label class="block font-cormorant font-bold text-lg text-maroon-dark mb-1">Jumlah</label>
                        <select name="amount"
                            class="w-full border-2 border-gold/50 rounded p-2 bg-cream focus:border-maroon focus:ring-0 font-poppins text-sm">
                            <option value="1">1 Orang</option>
                            <option value="2">2 Orang</option>
                        </select>
                    </div>

                    <div class="text-left">
                        <label class="block font-cormorant font-bold text-lg text-maroon-dark mb-1">Ucapan</label>
                        <textarea name="message" rows="3"
                            class="w-full border-2 border-gold/50 rounded p-2 bg-cream focus:border-maroon focus:ring-0 font-poppins text-sm"
                            placeholder="Berikan ucapan..."></textarea>
                    </div>

                    <button type="submit" class="btn-gold w-full mt-4" :disabled="loading">
                        <span x-show="!loading">Kirim Konfirmasi</span>
                        <span x-show="loading">Mengirim...</span>
                    </button>
                </form>
            </div>
        </section>

        <!-- WISHES LIST -->
        <section class="py-16 px-6 bg-maroon text-cream text-center" x-data="{ 
                     rsvps: {{ $rsvps->map(fn($r) => ['name' => $r->name, 'message' => $r->message, 'time' => $r->created_at->diffForHumans()])->values()->toJson() }} 
                 }" @new-rsvp.window="rsvps.unshift($event.detail)">
            <h2 class="font-pinyon text-4xl text-gold mb-8" data-aos="zoom-in-up">Ucapan & Doa</h2>

            <div class="bg-cream/10 border border-gold/30 radius-20 p-6 max-h-96 overflow-y-auto space-y-4 backdrop-blur-md"
                data-aos="zoom-in-up">
                <template x-for="rsvp in rsvps" :key="rsvp.name + rsvp.time">
                    <div class="border-b border-white/10 pb-3 text-left animate-fade-in-up">
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-cormorant font-bold text-lg text-gold" x-text="rsvp.name"></span>
                            <span class="text-[10px] text-white/50" x-text="rsvp.time"></span>
                        </div>
                        <p class="font-poppins text-xs leading-relaxed opacity-90" x-text="rsvp.message"></p>
                    </div>
                </template>
                <div x-show="rsvps.length === 0" class="text-center opacity-50 text-sm py-4">
                    Belum ada ucapan.
                </div>
            </div>
        </section>

        <!-- TERIMA KASIH -->
        <section class="py-20 px-6 bg-black text-white text-center"
            style="background-image: url('https://bitwave.my.id/wp-content/uploads/2024/12/Heritage-12.jpeg'); background-size: cover;">
            <div class="bg-black/50 p-8 radius-20 backdrop-blur-sm" data-aos="zoom-in-up">
                <p class="font-poppins text-xs mb-4">Suatu kebahagiaan & kehormatan bagi kami, apabila
                    Bapak/Ibu/Saudara/i, berkenan hadir dan memberikan do'a restu kepada kami.</p>
                <h3 class="font-pinyon text-3xl text-gold mb-2">Elyana & Syahril</h3>
            </div>

            <div class="mt-8 text-xs font-poppins opacity-50">
                Original Design by elemenpress.com <br>
                Recreated by Langitara
            </div>
        </section>

    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();

        // Music & Open Logic
        const btnOpen = document.getElementById('btn-open');
        const coverSection = document.getElementById('cover-section');
        const mainContent = document.getElementById('main-content');

        // Elements for library music (may not exist if custom music is used)
        const bgMusic = document.getElementById('bg-music');
        const musicControl = document.getElementById('music-control');
        const customMusicPlayer = document.getElementById('custom-music-player');

        let isPlaying = false;

        btnOpen.addEventListener('click', () => {
            // Unlock scroll
            document.body.classList.remove('overflow-hidden');

            // Hide Cover
            coverSection.style.transition = 'transform 1s ease-in-out';
            coverSection.style.transform = 'translateY(-100%)';

            // Handle music based on type
            if (bgMusic && musicControl) {
                // Library Music - Play audio
                const musicIcon = musicControl.querySelector('i');
                bgMusic.play().then(() => {
                    isPlaying = true;
                    musicControl.classList.remove('hidden');
                    musicControl.classList.add('flex');
                    musicIcon.classList.add('spin');
                    musicIcon.classList.remove('fa-volume-mute');
                    musicIcon.classList.add('fa-compact-disc');
                }).catch(e => console.log('Autoplay blocked'));
            } else if (customMusicPlayer) {
                // Custom Music - Show player button
                customMusicPlayer.classList.remove('hidden');
                customMusicPlayer.classList.add('flex');
            }
        });

        // Library music toggle (only if elements exist)
        if (musicControl && bgMusic) {
            const musicIcon = musicControl.querySelector('i');
            musicControl.addEventListener('click', () => {
                if (isPlaying) {
                    bgMusic.pause();
                    musicIcon.classList.remove('spin');
                } else {
                    bgMusic.play();
                    musicIcon.classList.add('spin');
                }
                isPlaying = !isPlaying;
            });
        }

    </script>
</body>

</html>