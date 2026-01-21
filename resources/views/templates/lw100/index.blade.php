<!-- 
    Template: LW100
    Theme: Gold & Blue luxury
    Refactored: Yes (Dynamic Data + RSVP Store)
-->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Wedding of {{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}</title>
    
    <!-- Meta SEO -->
    <meta name="description" content="Undangan Pernikahan {{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}">
    @if($invitation->cover_image)
    <meta property="og:image" content="{{ $invitation->cover_image }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Roboto+Slab:wght@400;500;600&family=Rochester&family=Dancing+Script:wght@600&display=swap"
        rel="stylesheet">

    <!-- Tailwind & Alpine -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <style>
        .font-rochester { font-family: 'Rochester', cursive; }
        .font-kaushan { font-family: 'Kaushan Script', cursive; }
        .font-roboto { font-family: 'Roboto Slab', serif; }
        .font-dancing { font-family: 'Dancing Script', cursive; }

        .c-gold { color: #F9C670; }
        .bg-gold { background-color: #F9C670; }
        .border-gold { border-color: #F9C670; }

        .c-blue { color: #17375E; }
        .bg-blue { background-color: #17375E; }
        .border-blue { border-color: #17375E; }

        .shadow-custom { box-shadow: 0 0 10px 0 #17375E; }
        .shadow-gold { box-shadow: 0 0 10px 0 #F9C670; }

        /* Animation Utilities */
        .animate-float { animation: float 3s ease-in-out infinite; }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>

<body class="font-roboto antialiased overflow-x-hidden bg-[#0f2540]"
    x-data="{ 
        open: false, 
        isPlaying: false, 
        toggleAudio() { 
            if(this.$refs.player.paused) {
                this.$refs.player.play();
                this.isPlaying = true;
            } else {
                this.$refs.player.pause();
                this.isPlaying = false;
            }
        },
        openInvitation() {
            this.open = true;
            this.$refs.player.play().then(() => {
                this.isPlaying = true;
            }).catch(e => console.log('Autoplay blocked', e));
            window.scrollTo(0,0);
        }
    }">

    <!-- AUDIO -->
    @if($invitation->music_path)
        <audio x-ref="player" loop src="{{ asset($invitation->music_path) }}"></audio>
        <div class="fixed bottom-24 right-4 z-[60]">
            <button @click="toggleAudio()"
                class="w-10 h-10 bg-[#FF4A00] text-white rounded-full shadow-lg flex items-center justify-center animate-bounce">
                <i class="fas" :class="isPlaying ? 'fa-volume-up' : 'fa-volume-mute'"></i>
            </button>
        </div>
    @endif

    <!-- POPUP / COVER -->
    <div x-show="!open" class="fixed inset-0 z-[60] flex items-center justify-center bg-cover bg-center"
        style="background-image: url('http://nikahan.vercell.my.id/wp-content/uploads/2022/07/BG-T-10-A-2.png'); background-color: #17375E;">

        <div class="bg-[#F9C670] p-[5px] rounded-[15px] max-w-sm w-full mx-4 shadow-2xl relative">
            <div class="bg-blue rounded-[15px] p-8 text-center border border-white text-gold relative overflow-hidden">
                
                <div class="mb-4">
                    <img src="http://nikahan.vercell.my.id/wp-content/uploads/2022/07/COUPLE-24-1.png"
                        class="w-32 h-32 object-cover rounded-full border-4 border-white mx-auto mb-4 opacity-80">
                </div>

                <h2 class="font-kaushan text-4xl mb-2 text-gold">
                    {{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}
                </h2>

                <p class="text-white text-sm mb-1">Kepada Yth:</p>
                <div class="bg-white/10 p-2 rounded mb-4">
                    <h3 class="text-xl font-bold text-white">{{ $guest_name }}</h3>
                </div>

                <p class="text-white text-xs mb-6 italic">
                    "Tanpa Mengurangi Rasa Hormat, Kami Mengundang Anda Untuk Berhadir Di Acara Pernikahan Kami."
                </p>

                <button @click="openInvitation()"
                    class="bg-gold text-blue px-6 py-2 rounded-full font-bold shadow-lg hover:bg-white transition">
                    <i class="far fa-envelope-open mr-2"></i> Buka Undangan
                </button>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT CONTAINER -->
    <main x-show="open" 
        x-transition:enter="transition ease-out duration-1000"
        x-transition:enter-start="opacity-0 translate-y-10" 
        class="max-w-md mx-auto bg-blue shadow-2xl min-h-screen relative">

        <!-- SECTION 1: HERO -->
        <section id="undangan" class="relative py-24 px-6 bg-cover bg-center text-center"
            style="background-image: url('http://nikahan.vercell.my.id/wp-content/uploads/2022/07/BG-T-10-A-2.png'); border-radius: 0 0 0 0;">

            <img src="http://nikahan.vercell.my.id/wp-content/uploads/2022/07/ORN-T10-A-1.png"
                class="w-[35%] md:w-[20%] mx-auto mb-4 animate-float">

            <p class="font-rochester text-white text-2xl mb-2">The Wedding Of</p>

            <h1 class="font-kaushan c-gold text-6xl leading-tight mb-2">
                {{ $invitation->groom_nickname }} <span class="text-white">&</span> {{ $invitation->bride_nickname }}
            </h1>

            <p class="font-roboto text-white text-xl mb-8">
                {{ \Carbon\Carbon::parse($invitation->akad_date)->translatedFormat('l, d F Y') }}
            </p>

            <img src="http://nikahan.vercell.my.id/wp-content/uploads/2022/07/ORN-T10-A-2.png"
                class="w-[35%] md:w-[20%] mx-auto mb-8">

            <div class="max-w-2xl mx-auto px-4">
                <p class="font-roboto c-gold text-center italic text-sm leading-relaxed">
                    "{{ $invitation->quote_text ?? 'Dan Diantara Tanda-tanda (Kebesaran) -Nya Ialah Dia Menciptakan Pasangan-pasangan Untukmu Dari Jenismu Sendiri...' }}"
                    <br><br>
                    <span class="font-bold">{{ $invitation->quote_author ?? '{ Q.S : Ar-Rum (30) : 21 }' }}</span>
                </p>
            </div>
        </section>

        <!-- SECTION 2: MEMPELAI -->
        <section id="mempelai" class="py-12 px-4 bg-gold relative bg-cover bg-center"
            style="background-attachment: fixed;">

            <div class="bg-blue rounded-[20px] p-6 shadow-custom relative overflow-hidden bg-cover bg-center"
                style="background-image: url('http://nikahan.vercell.my.id/wp-content/uploads/2022/07/BG-T-10-A-2.png');">

                <img src="http://nikahan.vercell.my.id/wp-content/uploads/2022/07/SALAM-T7.png"
                    class="w-[35%] md:w-[20%] mx-auto mb-4">

                <div class="flex items-center justify-center gap-4 mb-4">
                    <span class="h-[3px] w-full bg-white"></span>
                    <i class="fas fa-heart c-gold text-xl"></i>
                    <span class="h-[3px] w-full bg-white"></span>
                </div>

                <p class="font-roboto c-gold text-center text-sm mb-8">
                    Dengan Memohon Rahmat Dan Ridho Dari Allah SWT. Kami Bermaksud Menyelenggarakan Syukuran Pernikahan Putra Putri Kami
                </p>

                <div class="flex flex-col gap-8 border border-[#F6A41A] rounded-[20px] p-6 relative">

                    <!-- GROOM -->
                    <div class="text-center">
                        <div class="w-28 h-28 mx-auto rounded-full overflow-hidden border-2 border-gold mb-4">
                            <img src="{{ $invitation->groom_photo ?? 'https://via.placeholder.com/300' }}" class="w-full h-full object-cover">
                        </div>
                        <h2 class="font-kaushan c-gold text-3xl mb-1">{{ $invitation->groom_name }}</h2>
                        <p class="font-roboto c-gold text-xs">
                            Putra Pertama Dari :<br>
                            Bapak {{ $invitation->groom_father }} & Ibu {{ $invitation->groom_mother }}
                        </p>
                    </div>

                    <div class="text-center text-gold font-kaushan text-2xl">&</div>

                    <!-- BRIDE -->
                    <div class="text-center">
                         <div class="w-28 h-28 mx-auto rounded-full overflow-hidden border-2 border-gold mb-4">
                            <img src="{{ $invitation->bride_photo ?? 'https://via.placeholder.com/300' }}" class="w-full h-full object-cover">
                        </div>
                        <h2 class="font-kaushan c-gold text-3xl mb-1">{{ $invitation->bride_name }}</h2>
                        <p class="font-roboto c-gold text-xs">
                            Putri Pertama Dari :<br>
                            Bapak {{ $invitation->bride_father }} & Ibu {{ $invitation->bride_mother }}
                        </p>
                    </div>

                </div>
            </div>
        </section>

        <!-- SECTION 3: ACARA -->
        <section id="acara" class="py-12 px-4 bg-gold">
            <div class="bg-blue rounded-[20px] p-6 shadow-custom text-center relative overflow-hidden bg-cover"
                style="background-image: url('http://nikahan.vercell.my.id/wp-content/uploads/2022/07/BG-T-10-A-2.png');">

                <div class="flex items-center justify-center gap-4 mb-4">
                    <span class="h-[3px] w-full bg-white"></span>
                    <i class="fas fa-heart c-gold text-xl"></i>
                    <span class="h-[3px] w-full bg-white"></span>
                </div>

                <p class="font-roboto c-gold text-lg mb-8">Insya Allah Acara Akan Dilaksanakan Pada :</p>

                <div class="flex flex-col gap-6">
                    <!-- AKAD -->
                    <div class="border border-gold rounded-[20px] p-6 relative">
                        <img src="http://nikahan.vercell.my.id/wp-content/uploads/2022/07/AKAD-32-1.png" class="w-1/3 mx-auto mb-4">
                        <h3 class="font-dancing c-gold text-3xl mb-4">Akad Nikah</h3>

                        <div class="flex items-center justify-center gap-2 c-gold mb-2">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ \Carbon\Carbon::parse($invitation->akad_date)->translatedFormat('l, d F Y') }}</span>
                        </div>
                        <div class="flex items-center justify-center gap-2 c-gold mb-4">
                            <i class="fas fa-clock"></i>
                            <span>{{ \Carbon\Carbon::parse($invitation->akad_date)->format('H:i') }} WIB - Selesai</span>
                        </div>

                        <p class="font-roboto c-gold text-sm mb-4">{{ $invitation->akad_location }}</p>

                        <!-- MAPS LOGIC -->
                         <div x-data="{ showMap: false }">
                            @if($invitation->akad_map_embed)
                                <button @click="showMap = !showMap" class="bg-gold text-blue px-4 py-1 rounded text-sm font-bold shadow hover:bg-white transition my-2">
                                    <i class="fas fa-map-marked-alt mr-1"></i> <span x-text="showMap ? 'Tutup Peta' : 'Lihat Peta'"></span>
                                </button>
                                <div x-show="showMap" x-collapse class="mt-2 w-full aspect-video rounded overflow-hidden border border-gold">
                                    {!! $invitation->akad_map_embed !!}
                                </div>
                            @elseif($invitation->akad_map_link)
                                <a href="{{ $invitation->akad_map_link }}" target="_blank" class="bg-gold text-blue px-4 py-1 rounded text-sm font-bold shadow hover:bg-white transition inline-block">
                                    <i class="fas fa-location-arrow mr-1"></i> Google Maps
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- RESEPSI -->
                    <div class="border border-gold rounded-[20px] p-6 relative">
                        <img src="http://nikahan.vercell.my.id/wp-content/uploads/2022/07/AKAD-32-2.png" class="w-1/3 mx-auto mb-4">
                        <h3 class="font-dancing c-gold text-3xl mb-4">Resepsi</h3>

                        @if($invitation->resepsi_date)
                            <div class="flex items-center justify-center gap-2 c-gold mb-2">
                                <i class="fas fa-calendar-alt"></i>
                                <span>{{ \Carbon\Carbon::parse($invitation->resepsi_date)->translatedFormat('l, d F Y') }}</span>
                            </div>
                            <div class="flex items-center justify-center gap-2 c-gold mb-4">
                                <i class="fas fa-clock"></i>
                                <span>{{ \Carbon\Carbon::parse($invitation->resepsi_date)->format('H:i') }} WIB - Selesai</span>
                            </div>
                            <p class="font-roboto c-gold text-sm mb-4">{{ $invitation->resepsi_location }}</p>
                            
                             <!-- MAPS LOGIC -->
                            <div x-data="{ showMap: false }">
                                @if($invitation->resepsi_map_embed)
                                    <button @click="showMap = !showMap" class="bg-gold text-blue px-4 py-1 rounded text-sm font-bold shadow hover:bg-white transition my-2">
                                        <i class="fas fa-map-marked-alt mr-1"></i> <span x-text="showMap ? 'Tutup Peta' : 'Lihat Peta'"></span>
                                    </button>
                                    <div x-show="showMap" x-collapse class="mt-2 w-full aspect-video rounded overflow-hidden border border-gold">
                                        {!! $invitation->resepsi_map_embed !!}
                                    </div>
                                @elseif($invitation->resepsi_map_link)
                                    <a href="{{ $invitation->resepsi_map_link }}" target="_blank" class="bg-gold text-blue px-4 py-1 rounded text-sm font-bold shadow hover:bg-white transition inline-block">
                                        <i class="fas fa-location-arrow mr-1"></i> Google Maps
                                    </a>
                                @endif
                            </div>

                        @else
                            <p class="c-gold mb-4 italic">Jadwal Menyusul</p>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 4: GALERY -->
        @if(!empty($invitation->gallery_photos))
        <section id="galery" class="py-12 px-6 bg-blue text-center"
            style="background-image: url('http://nikahan.vercell.my.id/wp-content/uploads/2022/07/BG-T-10-A-2.png');">

            <div class="flex items-center justify-center gap-4 mb-4">
                <span class="h-[3px] w-full bg-white opacity-20"></span>
                <span class="font-dancing text-4xl c-gold">Our Moment</span>
                <i class="fas fa-heart c-gold text-xl"></i>
                <span class="h-[3px] w-full bg-white opacity-20"></span>
            </div>

            <p class="font-roboto c-gold text-sm mb-8 italic">
                "Ya Allah, Dengan Segala Kerendahan Hati, Kami Bersujud Memohon Ridho-Mu..."
            </p>

            <div class="grid grid-cols-2 gap-4">
                @foreach($invitation->gallery_photos as $photo)
                    <div class="rounded-xl overflow-hidden shadow-lg border-2 border-gold/50 cursor-pointer group">
                        <img src="{{ $photo }}" class="w-full h-32 object-cover group-hover:scale-110 transition duration-500">
                    </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- SECTION 5: RSVP / UCAPAN -->
        <section id="ucapan" class="py-12 px-4 bg-gold">
            <div class="bg-blue rounded-[20px] p-6 shadow-custom text-center relative overflow-hidden bg-cover"
                style="background-image: url('http://nikahan.vercell.my.id/wp-content/uploads/2022/07/BG-T-10-A-2.png');">

                <div class="flex items-center justify-center gap-4 mb-4">
                    <span class="h-[3px] w-full bg-white"></span>
                    <i class="fas fa-heart c-gold text-xl"></i>
                    <span class="h-[3px] w-full bg-white"></span>
                </div>

                <p class="font-roboto c-gold text-md mb-8">
                    Tiada Yang Dapat Kami Ungkapkan Selain Rasa Terimakasih...
                </p>

                <!-- Box Couple Name -->
                <div class="border border-gold rounded-[25px] p-6 shadow-gold mb-8">
                    <img src="http://nikahan.vercell.my.id/wp-content/uploads/2022/07/COUPLE-24-1.png"
                        class="w-1/2 mx-auto mb-4 opacity-80">
                    <h2 class="font-kaushan c-gold text-4xl mb-2">{{ $invitation->groom_nickname }} &
                        {{ $invitation->bride_nickname }}</h2>

                    <div class="flex items-center justify-center gap-4 mb-4">
                        <span class="h-[3px] w-full bg-gold"></span>
                        <span class="font-roboto c-gold text-lg">{{ \Carbon\Carbon::parse($invitation->akad_date)->translatedFormat('d F Y') }}</span>
                        <span class="h-[3px] w-full bg-gold"></span>
                    </div>
                </div>

                <!-- FORM GUESTBOOK -->
                <div class="bg-gold/10 p-4 rounded-[20px] border border-gold">
                    <p class="c-gold mb-4 text-xl font-bold">Ucapan & Konfirmasi</p>
                    
                    <form action="{{ route('public.rsvp.store') }}" method="POST" class="space-y-4 text-left">
                        @csrf
                        <input type="hidden" name="invitation_id" value="{{ $invitation->id }}">

                        <div>
                            <input type="text" name="name" placeholder="Nama Anda" value="{{ $guest_name }}" required
                                class="w-full px-4 py-3 rounded-full text-blue focus:outline-none border-2 border-transparent focus:border-gold">
                        </div>
                        
                        <div>
                            <textarea name="message" placeholder="Berikan Ucapan Doa Restu Anda Disini" required
                                class="w-full px-4 py-3 rounded-2xl text-blue focus:outline-none h-24 border-2 border-transparent focus:border-gold"></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <select name="amount" class="w-full px-4 py-3 rounded-full text-blue focus:outline-none cursor-pointer">
                                <option value="1">1 Orang</option>
                                <option value="2">2 Orang</option>
                                <option value="3">3 Orang</option>
                            </select>
                            <select name="status" class="w-full px-4 py-3 rounded-full text-blue focus:outline-none cursor-pointer">
                                <option value="hadir">Hadir</option>
                                <option value="tidak_hadir">Maaf, Tidak Hadir</option>
                            </select>
                        </div>

                        <button type="submit"
                            class="bg-gold text-blue w-full py-3 rounded-full font-bold shadow-lg hover:bg-white hover:text-blue transition transform hover:scale-[1.02]">
                            <i class="fas fa-paper-plane mr-2"></i> Kirim Ucapan
                        </button>
                    </form>
                </div>

            </div>
        </section>

        <!-- SECTION 6: PROKES -->
        <section class="py-12 px-6 bg-gold text-center">
            <h2 class="font-roboto text-blue font-bold text-lg mb-8">Protokol Kesehatan</h2>

            <div class="flex flex-wrap justify-center gap-4">
                <div class="bg-white p-3 rounded-[15px] w-28 shadow-lg border border-blue">
                    <img src="http://nikahan.vercell.my.id/wp-content/uploads/2022/07/1-MEMAKAI-MASKER.png" class="w-12 h-12 mx-auto mb-2">
                    <p class="text-[10px] font-bold text-blue">Memakai Masker</p>
                </div>
                <div class="bg-white p-3 rounded-[15px] w-28 shadow-lg border border-blue">
                    <img src="http://nikahan.vercell.my.id/wp-content/uploads/2022/07/3-MENCUCI-TANGAN.png" class="w-12 h-12 mx-auto mb-2">
                    <p class="text-[10px] font-bold text-blue">Cuci Tangan</p>
                </div>
                <div class="bg-white p-3 rounded-[15px] w-28 shadow-lg border border-blue">
                    <img src="http://nikahan.vercell.my.id/wp-content/uploads/2022/07/4-MENJAGA-JARAK.png" class="w-12 h-12 mx-auto mb-2">
                    <p class="text-[10px] font-bold text-blue">Jaga Jarak</p>
                </div>
            </div>

            <div class="mt-8 text-blue text-xs font-bold opacity-70">
                Created with <i class="fas fa-heart text-red-500"></i> by Langitara
            </div>
        </section>
        
        <!-- PADDING FOR BOTTOM NAV -->
        <div class="h-24 bg-gold"></div>

        <!-- FLOATING NAV -->
        <!-- Use 'absolute' inside sticky? No, fixed relative to window is best for persistent menu. max-w-md constraint via javascript? 
             Easiest: Fixed, centered, but logic: left-1/2 -translate-x-1/2.
             To behave like it is inside the phone, it should be visually compatible.
        -->
        <div class="fixed bottom-4 left-1/2 -translate-x-1/2 bg-[#F9C670] rounded-full px-4 py-2 flex items-center gap-4 border-2 border-blue shadow-2xl z-40 bg-opacity-90 backdrop-blur-sm">
            <a href="#undangan" class="hover:scale-125 transition duration-300"><img src="http://nikahan.vercell.my.id/wp-content/uploads/2022/07/ICON-29-1.png" class="w-5 h-5"></a>
            <a href="#mempelai" class="hover:scale-125 transition duration-300"><img src="http://nikahan.vercell.my.id/wp-content/uploads/2022/07/ICON-29-2.png" class="w-5 h-5"></a>
            <a href="#acara" class="hover:scale-125 transition duration-300"><img src="http://nikahan.vercell.my.id/wp-content/uploads/2022/07/ICON-29-3.png" class="w-5 h-5"></a>
            <a href="#galery" class="hover:scale-125 transition duration-300"><img src="http://nikahan.vercell.my.id/wp-content/uploads/2022/07/ICON-29-4.png" class="w-5 h-5"></a>
            <a href="#ucapan" class="hover:scale-125 transition duration-300"><img src="http://nikahan.vercell.my.id/wp-content/uploads/2022/07/ICON-29-5.png" class="w-5 h-5"></a>
        </div>

    </main>

</body>
</html>