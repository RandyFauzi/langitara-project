<div class="space-y-6" x-data="{
    activeTab: {{ $customMusic && !$invitation->music_path ? "'custom'" : "'library'" }}, // library | custom
    customUrl: '{{ $customMusic ? $customMusic->url : '' }}',
    customMusic: {{ json_encode($customMusic) }},
    showTerms: false,
    termsAccepted: {{ $customMusic ? 'true' : 'false' }},
    isLoading: false,
    isDeleting: false,
    previewEmbed: '{{ $customMusic ? $customMusic->embed_url : '' }}',
    
    // Premium Check (Account Level OR Invitation Level)
    isPremium: {{ (
    ($invitation->package && $invitation->package->price > 0) ||
    (Auth::user()->active_package && Auth::user()->active_package->price > 0)
) ? 'true' : 'false' }},

    saveCustomMusic() {
        if (!this.termsAccepted) {
            Swal.fire('Wajib Disetujui', 'Anda harus menyetujui syarat & ketentuan hak cipta.', 'warning');
            return;
        }
        
        this.isLoading = true;
        
        fetch(`/editor/{{ $invitation->slug }}/music`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ url: this.customUrl })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                this.customMusic = data.music;
                this.previewEmbed = data.music.embed_url;
                
                // Update parent form to clear music_path
                this.form.music_path = null;
                
                // Update currentSong display in parent
                this.currentSong = { title: 'Custom Music', url: this.customUrl }; 
                
                // Dispatch event to parent to clear music_path
                this.$dispatch('custom-music-updated');

                // Force Refresh Preview Iframe (Mobile & Desktop)
                const frameMobile = document.getElementById('previewFrame');
                const frameDesktop = document.getElementById('previewFrameDesktop');
                if (frameMobile) frameMobile.src = frameMobile.src.split('?')[0] + '?t=' + Date.now();
                if (frameDesktop) frameDesktop.src = frameDesktop.src.split('?')[0] + '?t=' + Date.now();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Musik custom berhasil disimpan.',
                    timer: 1500,
                    showConfirmButton: false
                });
            } else {
                Swal.fire('Gagal', data.message, 'error');
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
        })
        .finally(() => {
            this.isLoading = false;
        });
    },

    deleteCustomMusic() {
        Swal.fire({
            title: 'Hapus Custom Music?',
            text: 'Musik akan dikembalikan ke pustaka lagu default.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.isDeleting = true;

                fetch(`/editor/{{ $invitation->slug }}/music`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').content,
                        'Accept': 'application/json',
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.customMusic = null;
                        this.customUrl = '';
                        this.previewEmbed = '';
                        this.activeTab = 'library';
                        
                        // Force Refresh Preview Iframe
                        const frameMobile = document.getElementById('previewFrame');
                        const frameDesktop = document.getElementById('previewFrameDesktop');
                        if (frameMobile) frameMobile.src = frameMobile.src.split('?')[0] + '?t=' + Date.now();
                        if (frameDesktop) frameDesktop.src = frameDesktop.src.split('?')[0] + '?t=' + Date.now();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Custom music berhasil dihapus. Silakan pilih lagu dari pustaka.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire('Gagal', data.message, 'error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
                })
                .finally(() => {
                    this.isDeleting = false;
                });
            }
        });
    }
}">
    <div class="flex justify-between items-center border-b border-gray-100 pb-4">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Latar Musik</h3>
            <p class="text-xs text-gray-500">Pilih musik latar untuk undangan Anda.</p>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" x-model="form.active_sections" value="music" class="sr-only peer">
            <div
                class="w-11 h-6 bg-gray-200 peer-focus:outline-none ring-0 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-violet-400 peer-checked:to-blue-400">
            </div>
            <span class="ms-3 text-sm font-medium text-gray-700"
                x-text="form.active_sections.includes('music') ? 'Aktif' : 'Non-aktif'"></span>
        </label>
    </div>

    <div x-show="form.active_sections.includes('music')" x-transition class="space-y-6">

        <!-- Tabs -->
        <div class="flex p-1 bg-gray-100 rounded-xl relative z-0">
            <div class="absolute h-[calc(100%-8px)] top-1 left-1 bg-white rounded-lg shadow-sm transition-all duration-300 w-[calc(50%-4px)]"
                :class="activeTab === 'library' ? 'translate-x-0' : 'translate-x-full'"></div>

            <button @click="activeTab = 'library'"
                class="relative z-10 w-1/2 py-2 text-sm font-bold text-center transition-colors rounded-lg"
                :class="activeTab === 'library' ? 'text-violet-600' : 'text-gray-500 hover:text-gray-700'">
                <i class="fas fa-music mr-2"></i> Pustaka Lagu
            </button>
            <button @click="activeTab = 'custom'"
                class="relative z-10 w-1/2 py-2 text-sm font-bold text-center transition-colors rounded-lg flex items-center justify-center gap-2"
                :class="activeTab === 'custom' ? 'text-violet-600' : 'text-gray-500 hover:text-gray-700'">
                @if(
                        !($invitation->package && $invitation->package->price > 0) &&
                        !(Auth::user()->active_package && Auth::user()->active_package->price > 0)
                    )
                    <i class="fas fa-lock text-xs"></i>
                @endif
                <i class="fas fa-link"></i> Custom Link
            </button>
        </div>

        <!-- TAB: LIBRARY -->
        <div x-show="activeTab === 'library'" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
            <!-- Current Song Player (Library) -->
            <div class="bg-violet-50/50 p-6 rounded-2xl border border-violet-100 mb-6"
                x-show="!customMusic && form.music_path">
                <div class="flex items-center gap-4">
                    <div
                        class="w-16 h-16 rounded-full bg-gradient-to-br from-violet-500 to-fuchsia-500 flex items-center justify-center text-white shadow-lg shadow-violet-200">
                        <i class="fas fa-music text-2xl animate-pulse"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-[10px] font-bold text-violet-500 uppercase tracking-widest mb-1">Sedang Dipilih
                        </p>
                        <h4 class="text-lg font-bold text-gray-900 leading-none mb-2"
                            x-text="currentSong.title || 'Belum memilih lagu'"></h4>

                        <!-- Audio Player -->
                        <div x-effect="if(currentSong.url) $refs.mainPlayer.load()">
                            <audio x-ref="mainPlayer" controls class="w-full h-8 block"
                                style="filter: sepia(20%) saturate(70%) grayscale(1) contrast(99%) invert(12%);">
                                <source
                                    :src="currentSong.url && (currentSong.url.startsWith('http') || currentSong.url.startsWith('/')) ? currentSong.url : '/' + currentSong.url"
                                    type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-list text-violet-500"></i> Daftar Lagu Tersedia
                    </h4>
                </div>

                <div class="grid grid-cols-1 gap-3 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                    @foreach($songs as $song)
                        <div class="group flex items-center p-3 rounded-xl transition-all cursor-pointer border hover:shadow-md"
                            :class="form.music_path == '{{ $song->file_path }}' 
                                                                            ? 'bg-white border-violet-300 ring-4 ring-violet-50 shadow-md' 
                                                                            : 'bg-white border-gray-100 hover:border-violet-200'"
                            @click="selectSong({{ $song->id }}, '{{ $song->file_path }}', '{{ $song->title }}'); customMusic = null;">

                            <!-- Play Preview Button -->
                            <button
                                @click.stop="$refs['preview_{{ $song->id }}'].paused ? $refs['preview_{{ $song->id }}'].play() : $refs['preview_{{ $song->id }}'].pause()"
                                class="mr-4 w-10 h-10 rounded-full flex items-center justify-center transition-all shadow-sm"
                                :class="$refs['preview_{{ $song->id }}'] && !$refs['preview_{{ $song->id }}'].paused ? 'bg-violet-500 text-white shadow-violet-200' : 'bg-gray-100 text-gray-500 hover:bg-violet-100 hover:text-violet-600'">

                                <i class="fas"
                                    :class="$refs['preview_{{ $song->id }}'] && !$refs['preview_{{ $song->id }}'].paused ? 'fa-pause' : 'fa-play pl-0.5'"></i>
                            </button>

                            <audio x-ref="preview_{{ $song->id }}" class="hidden" @play="$refs.mainPlayer.pause()">
                                <source src="{{ asset($song->file_path) }}" type="audio/mpeg">
                            </audio>

                            <div class="flex-1">
                                <p class="font-bold text-gray-800 text-sm group-hover:text-violet-700 transition-colors">
                                    {{ $song->title }}
                                </p>
                                <p class="text-xs text-gray-500 flex items-center gap-1">
                                    <i class="fas fa-microphone-alt text-[10px]"></i> {{ $song->artist }}
                                </p>
                            </div>

                            <!-- Selected Indicator -->
                            <div x-show="form.music_path == '{{ $song->file_path }}'"
                                class="text-violet-500 animate-bounce">
                                <i class="fas fa-check-circle text-xl"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- TAB: CUSTOM LINK -->
        <div x-show="activeTab === 'custom'" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 -translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
            @if(
                    ($invitation->package && $invitation->package->price > 0) ||
                    (Auth::user()->active_package && Auth::user()->active_package->price > 0)
                )
                <div class="bg-violet-50 border border-violet-100 rounded-2xl p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <i class="fab fa-spotify text-2xl text-green-500"></i>
                        <i class="fab fa-youtube text-2xl text-red-500"></i>
                        <i class="fab fa-soundcloud text-2xl text-orange-500"></i>
                        <span class="text-sm font-bold text-gray-700 ml-2">Custom Link Embed</span>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Link Lagu
                            (YouTube/Spotify/SoundCloud)</label>
                        <input type="text" x-model="customUrl"
                            class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-violet-100 focus:border-violet-400 outline-none transition text-gray-800"
                            placeholder="https://open.spotify.com/track/...">
                        <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                            <i class="fas fa-info-circle"></i> Pastikan link berasal dari platform resmi. Bukan file MP3.
                        </p>
                    </div>

                    <!-- Terms Checkbox -->
                    <div class="flex items-start gap-2 mb-6 p-4 bg-white rounded-xl border border-gray-100">
                        <div class="flex items-center h-5 mt-0.5">
                            <input type="checkbox" x-model="termsAccepted" id="terms"
                                class="w-4 h-4 text-violet-600 border-gray-300 rounded focus:ring-violet-500">
                        </div>
                        <div class="ml-2 text-xs">
                            <label for="terms" class="font-medium text-gray-700">Saya menyetujui dan bertanggung jawab atas
                                link musik yang saya gunakan.</label>
                            <p class="text-gray-500 mt-1">Saya memastikan link berasal dari platform resmi dan memiliki izin
                                yang sah.</p>
                            <button @click="showTerms = true" class="text-violet-600 hover:underline mt-1">Baca Kebijakan
                                Lengkap</button>
                        </div>
                    </div>

                    <button @click="saveCustomMusic()" :disabled="isLoading || !customUrl"
                        class="w-full py-3 bg-violet-600 hover:bg-violet-700 text-white font-bold rounded-xl shadow-md transition-all flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas" :class="isLoading ? 'fa-spinner fa-spin' : 'fa-save'"></i>
                        <span x-text="isLoading ? 'Menyimpan...' : 'Simpan Musik'"></span>
                    </button>
                </div>

                <!-- Preview Player -->
                <div x-show="previewEmbed" class="mt-6 bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
                    <!-- Active Custom Music Indicator -->
                    <div x-show="customMusic" class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                            <h5 class="text-sm font-bold text-gray-800">Custom Music Aktif</h5>
                        </div>
                        <span class="text-[10px] font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full"
                            x-text="customMusic?.provider?.toUpperCase()"></span>
                    </div>

                    <div class="aspect-w-16 aspect-h-9 w-full bg-gray-100 rounded-xl overflow-hidden">
                        <iframe :src="previewEmbed" class="w-full h-full" frameborder="0" allow="autoplay; encrypted-media"
                            allowfullscreen loading="lazy"></iframe>
                    </div>

                    <!-- Delete Custom Music Button -->
                    <button x-show="customMusic" @click="deleteCustomMusic()" :disabled="isDeleting"
                        class="w-full mt-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-600 font-bold rounded-xl border border-red-200 transition-all flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas" :class="isDeleting ? 'fa-spinner fa-spin' : 'fa-trash-alt'"></i>
                        <span x-text="isDeleting ? 'Menghapus...' : 'Hapus Custom Music & Kembali ke Pustaka'"></span>
                    </button>
                </div>
            @else
                <!-- Upgrade Alert -->
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 rounded-2xl p-8 text-center">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                        <i class="fas fa-crown text-yellow-500 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Fitur Premium</h3>
                    <p class="text-sm text-gray-600 mb-6 max-w-xs mx-auto">
                        Upgrade ke paket Premium untuk menggunakan lagu dari YouTube, Spotify, atau SoundCloud.
                    </p>
                    <a href="{{ route('public.pricing') }}" target="_blank"
                        class="inline-flex items-center justify-center px-6 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-gray-800 transition shadow-lg">
                        Upgrade Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Terms Modal -->
    <template x-teleport="body">
        <div x-show="showTerms" class="relative z-[9999]" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div x-show="showTerms" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="showTerms = false">
            </div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center">
                    <div x-show="showTerms" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-xl">

                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-900">Kebijakan Penggunaan Musik</h3>
                            <button @click="showTerms = false" class="text-gray-400 hover:text-gray-600 transition"><i
                                    class="fas fa-times"></i></button>
                        </div>

                        <div
                            class="px-6 py-6 max-h-[60vh] overflow-y-auto text-sm text-gray-600 space-y-4 leading-relaxed">
                            <p><strong>1. Ringkasan Ketentuan</strong><br>
                                Platform Langitara hanya mendukung pemutaran musik melalui tautan resmi dari YouTube,
                                Spotify, dan SoundCloud. Kami tidak menyediakan fitur upload musik MP3.</p>

                            <p><strong>2. Tanggung Jawab Pengguna</strong><br>
                                Dengan menambahkan link musik, Anda menyatakan bahwa:
                            <ul class="list-disc pl-5 mt-1 space-y-1">
                                <li>Link musik berasal dari platform resmi.</li>
                                <li>Anda memiliki hak/izin untuk menggunakan konten tersebut.</li>
                                <li>Anda bertanggung jawab penuh atas segala risiko klaim Hak Cipta.</li>
                            </ul>
                            </p>

                            <p><strong>3. Larangan</strong><br>
                                Pengguna dilarang menggunakan file audio langsung (.mp3, .wav) atau link dari situs
                                ilegal.</p>

                            <p><strong>4. Dasar Hukum (Indonesia)</strong><br>
                                Penggunaan musik termasuk dalam pemanfaatan Hak Cipta sebagaimana diatur dalam UU No. 28
                                Tahun 2014 tentang Hak Cipta.</p>

                            <p><strong>5. Batasan Tanggung Jawab</strong><br>
                                Langitara tidak menjamin ketersediaan atau status hukum konten pihak ketiga. Kami berhak
                                menghapus link yang melanggar kebijakan.</p>
                        </div>

                        <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3">
                            <button @click="showTerms = false"
                                class="px-4 py-2 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-100 transition">Tutup</button>
                            <button @click="termsAccepted = true; showTerms = false"
                                class="px-4 py-2 bg-violet-600 text-white font-bold rounded-xl hover:bg-violet-700 transition">Saya
                                Setuju</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>