<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Editor - {{ $invitation->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Google Fonts for Modern Feel -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .sidebar-scroll {
            scrollbar-width: thin;
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background-color: #e5e7eb;
            border-radius: 4px;
        }

        /* Custom Gradient for Active States */
        .gradient-active {
            background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%);
            color: #1e1b4b;
            /* Indigo 950 for contrast */
            box-shadow: 0 4px 12px -2px rgba(167, 139, 250, 0.3);
        }

        /* Phone Mockup Styles */
        .phone-bezel {
            border-radius: 3rem;
            border: 12px solid #2d3748;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .phone-notch {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 24px;
            background: #2d3748;
            border-bottom-left-radius: 18px;
            border-bottom-right-radius: 18px;
            z-index: 10;
        }
    </style>
</head>

<body class="h-full bg-[#F8F9FC] flex overflow-hidden text-sm" x-data="editorApp()" @custom-music-updated.window="
          form.music_path = null;
          activeSongId = null;
          currentSong = { title: 'Custom Music', url: '' };
      ">

    <!-- LEFT SIDEBAR: NAVIGATION -->
    <aside class="w-72 bg-white flex flex-col z-20 shadow-[4px_0_24px_rgba(0,0,0,0.02)] h-full">
        <!-- Brand -->
        <div class="h-20 flex items-center px-8 border-b border-gray-50">
            <div class="flex items-center gap-3">
                <div
                    class="w-8 h-8 rounded-xl bg-gradient-to-br from-violet-400 to-blue-400 flex items-center justify-center text-white font-bold text-xs shadow-lg shadow-violet-200">
                    L
                </div>
                <div>
                    <h1 class="font-bold text-gray-800 text-lg tracking-tight">Langitara</h1>
                    <span class="text-[10px] font-medium text-gray-400 uppercase tracking-wider block -mt-1">Editor
                        Suite</span>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 overflow-y-auto sidebar-scroll p-4 space-y-1.5">
            <template x-for="section in sections" :key="section.id">
                <button @click="activeTab = section.id"
                    :class="activeTab === section.id ? 'gradient-active font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'"
                    class="w-full flex items-center px-4 py-3.5 rounded-2xl text-left transition-all duration-200 group relative overflow-hidden">

                    <!-- Icon Placeholder (Dynamic based on section ID could be cool, keeping simple circle for now) -->
                    <span class="w-8 h-8 rounded-full flex items-center justify-center mr-3 transition-colors"
                        :class="activeTab === section.id ? 'bg-white/30 text-indigo-900' : 'bg-gray-100 text-gray-400 group-hover:bg-gray-200'">
                        <!-- Simple SVG Icons mapping -->
                        <div x-show="section.id === 'template'"><i class="fas fa-palette text-xs"></i></div>
                        <div x-show="section.id === 'cover'"><i class="fas fa-home text-xs"></i></div>
                        <div x-show="section.id === 'couple'"><i class="fas fa-heart text-xs"></i></div>
                        <div x-show="section.id === 'events'"><i class="fas fa-calendar-alt text-xs"></i></div>
                        <div x-show="section.id === 'gallery'"><i class="fas fa-images text-xs"></i></div>
                        <div x-show="section.id === 'story'"><i class="fas fa-book-open text-xs"></i></div>
                        <div x-show="section.id === 'guests'"><i class="fas fa-users text-xs"></i></div>
                        <div x-show="section.id === 'music'"><i class="fas fa-music text-xs"></i></div>
                        <div
                            x-show="!['template','cover','couple','events','gallery','story','guests','music'].includes(section.id)">
                            <i class="fas fa-circle text-[8px]"></i>
                        </div>
                    </span>

                    <span class="text-sm tracking-wide" x-text="section.label"></span>

                    <!-- Active Indicator Arrow -->
                    <svg x-show="activeTab === section.id" class="w-4 h-4 absolute right-4 text-indigo-900 opacity-50"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </template>
        </nav>

        <!-- Bottom Actions -->
        <div class="p-6 border-t border-gray-50 bg-white">
            <button @click="saveChanges()"
                class="w-full relative group overflow-hidden rounded-xl shadow-lg shadow-violet-200 transition-all hover:scale-[1.02] active:scale-95"
                :disabled="isSaving">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-violet-500 to-blue-500 transition-opacity group-hover:opacity-90">
                </div>
                <div class="relative px-6 py-3.5 flex items-center justify-center">
                    <svg x-show="!isSaving" class="w-5 h-5 text-white mr-2" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                        </path>
                    </svg>
                    <svg x-show="isSaving" x-cloak class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span class="text-white font-bold text-sm tracking-wide"
                        x-text="isSaving ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
                </div>
            </button>

            <a href="{{ route('dashboard.index') }}"
                class="mt-3 w-full flex items-center justify-center px-4 py-2 text-xs font-medium text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>
        </div>
    </aside>

    <!-- CENTER PANEL: FORM -->
    <main class="flex-1 overflow-y-auto bg-[#F8F9FC] relative">
        <!-- Decor Background -->
        <div
            class="absolute top-0 left-0 w-full h-64 bg-gradient-to-b from-violet-50/50 to-transparent pointer-events-none">
        </div>

        <div class="max-w-3xl mx-auto p-10 relative z-10">
            <!-- Header for Section -->
            <div class="mb-8 flex items-end justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 tracking-tight mb-2"
                        x-text="sections.find(s => s.id === activeTab)?.label"></h2>
                    <p class="text-gray-500">Sesuaikan informasi undangan Anda dengan mudah.</p>
                </div>
                <!-- Optional: Helper / Status -->
                <div class="hidden md:flex items-center gap-3">
                    <span
                        class="bg-white px-3 py-1.5 rounded-full border border-gray-100 text-xs text-gray-400 font-medium shadow-sm">
                        <i class="fas fa-check-circle text-green-400 mr-1.5"></i> Auto-saved
                    </span>

                    <button @click="togglePublish()"
                        class="px-4 py-1.5 rounded-full text-xs font-semibold shadow-sm transition-all focus:outline-none"
                        :class="form.status === 'published' 
                            ? 'bg-green-100 text-green-700 border border-green-200 hover:bg-green-200' 
                            : 'bg-indigo-600 text-white border border-transparent hover:bg-indigo-700 shadow-indigo-200'">
                        <i class="fas" :class="form.status === 'published' ? 'fa-globe' : 'fa-upload'"></i>
                        <span x-text="form.status === 'published' ? 'Published' : 'Publish'"></span>
                    </button>

                    <div x-show="form.status === 'published'" x-cloak>
                        <a :href="previewUrl" target="_blank" class="text-xs text-indigo-600 hover:underline">
                            Lihat <i class="fas fa-external-link-alt ml-0.5"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Content Card -->
            <div
                class="bg-white rounded-[2rem] shadow-[0_2px_20px_rgba(0,0,0,0.03)] border border-gray-100/50 overflow-hidden min-h-[600px]">
                <div class="p-8">
                    <!-- Section Includes -->
                    <div x-show="activeTab === 'template'" x-transition.opacity.duration.300ms>
                        @include('editor.sections.template')</div>
                    <div x-show="activeTab === 'cover'" x-transition.opacity.duration.300ms>
                        @include('editor.sections.cover')</div>
                    <div x-show="activeTab === 'couple'" x-transition.opacity.duration.300ms x-cloak>
                        @include('editor.sections.couple')</div>
                    <div x-show="activeTab === 'events'" x-transition.opacity.duration.300ms x-cloak>
                        @include('editor.sections.events')</div>
                    <div x-show="activeTab === 'gallery'" x-transition.opacity.duration.300ms x-cloak>
                        @include('editor.sections.gallery')</div>
                    <div x-show="activeTab === 'story'" x-transition.opacity.duration.300ms x-cloak>
                        @include('editor.sections.story')</div>
                    <div x-show="activeTab === 'guests'" x-transition.opacity.duration.300ms x-cloak>
                        @include('editor.sections.guests')</div>
                    <div x-show="activeTab === 'rsvp'" x-transition.opacity.duration.300ms x-cloak>
                        @include('editor.sections.rsvp')</div>
                    <div x-show="activeTab === 'quote'" x-transition.opacity.duration.300ms x-cloak>
                        @include('editor.sections.quote')</div>
                    <div x-show="activeTab === 'wishes'" x-transition.opacity.duration.300ms x-cloak>
                        @include('editor.sections.wishes')</div>
                    <div x-show="activeTab === 'gift'" x-transition.opacity.duration.300ms x-cloak>
                        @include('editor.sections.gift')</div>
                    <div x-show="activeTab === 'music'" x-transition.opacity.duration.300ms x-cloak>
                        @include('editor.sections.music')</div>

                    <!-- Placeholder -->
                    <div x-show="!['template', 'cover', 'couple', 'events', 'gallery', 'story', 'guests', 'rsvp', 'quote', 'wishes', 'gift', 'music'].includes(activeTab)"
                        x-cloak class="flex flex-col items-center justify-center py-20 text-center">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-tools text-gray-300 text-xl"></i>
                        </div>
                        <h3 class="text-gray-900 font-medium">Dalam Pengembangan</h3>
                        <p class="text-gray-400 text-sm mt-1">Bagian ini akan segera tersedia.</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 text-center">
                <p class="text-xs text-gray-400">Langitara Editor Suite &copy; {{ date('Y') }}</p>
            </div>
        </div>
    </main>

    <!-- RIGHT PANEL: PREVIEW -->
    <aside
        class="w-[500px] bg-[#f0f2f5] border-l border-gray-200 hidden xl:flex flex-col items-center justify-center relative shadow-inner">
        <!-- Abstract Background Pattern -->
        <div class="absolute inset-0 opacity-[0.03]"
            style="background-image: radial-gradient(#6366f1 1px, transparent 1px); background-size: 24px 24px;"></div>

        <div class="relative z-10 flex flex-col items-center">
            <!-- Tools -->
            <div class="mb-6 flex items-center gap-4 bg-white p-2 rounded-full shadow-sm border border-gray-100">
                <button @click="viewMode = 'mobile'"
                    :class="viewMode === 'mobile' ? 'bg-indigo-50 text-indigo-600' : 'text-gray-400 hover:text-gray-600'"
                    class="p-2 rounded-full transition w-10 h-10 flex items-center justify-center">
                    <i class="fas fa-mobile-alt"></i>
                </button>
                <button @click="viewMode = 'desktop'"
                    :class="viewMode === 'desktop' ? 'bg-indigo-50 text-indigo-600' : 'text-gray-400 hover:text-gray-600'"
                    class="p-2 rounded-full transition w-10 h-10 flex items-center justify-center">
                    <i class="fas fa-desktop"></i>
                </button>
                <div class="w-px h-6 bg-gray-200"></div>
                <button @click="refreshPreview()"
                    class="p-2 text-gray-400 hover:text-indigo-600 transition w-10 h-10 flex items-center justify-center">
                    <i class="fas fa-sync-alt"></i>
                </button>
                <a href="{{ route('public.invitation.show', $invitation->slug) }}" target="_blank"
                    class="p-2 text-gray-400 hover:text-indigo-600 transition w-10 h-10 flex items-center justify-center">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </div>

            <!-- Phone Frame -->
            <div x-show="viewMode === 'mobile'"
                class="phone-bezel bg-gray-800 overflow-hidden relative transition-all duration-500 hover:shadow-2xl shadow-xl"
                style="width: 360px; height: 720px;">
                <div class="phone-notch"></div>
                <iframe id="previewFrame" :src="previewUrl" class="w-full h-full bg-white" frameborder="0"></iframe>
            </div>

            <!-- Desktop Frame -->
            <div x-show="viewMode === 'desktop'" x-cloak
                class="w-[460px] h-[720px] bg-white rounded-lg shadow-xl overflow-hidden border border-gray-200">
                <div class="bg-gray-50 border-b p-2 flex gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-red-400"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-yellow-400"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-green-400"></div>
                </div>
                <iframe id="previewFrameDesktop" :src="previewUrl" class="w-full h-[calc(100%-24px)]"
                    frameborder="0"></iframe>
            </div>
        </div>
    </aside>

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- LOGIC (PRESERVED) -->
    <script>
        function editorApp() {
            return {
                activeTab: 'cover',
                isSaving: false,
                viewMode: 'mobile',
                previewUrl: @json(route('public.invitation.show', $invitation->slug)),
                sections: [
                    { id: 'template', label: 'Pilih Tema' },
                    { id: 'cover', label: 'Cover Depan' },
                    { id: 'couple', label: 'Profil Mempelai' },
                    { id: 'events', label: 'Rangkaian Acara' },
                    { id: 'gallery', label: 'Galeri Foto' },
                    { id: 'story', label: 'Love Story' },
                    { id: 'quote', label: 'Quote / Ayat' },
                    { id: 'guests', label: 'Daftar Tamu' },
                    { id: 'rsvp', label: 'Konfirmasi Kehadiran' },
                    { id: 'wishes', label: 'Ucapan & Doa' },
                    { id: 'gift', label: 'Kado Digital' },
                    { id: 'music', label: 'Latar Musik' },
                ],

                // MAIN DATA OBJECT (Mirrors DB Columns)
                form: @json($invitation),

                slug: @json($invitation->slug),

                // Template Logic
                changeTemplate(id) {
                    Swal.fire({
                        title: 'Ganti Tema?',
                        text: "Tampilan undangan akan berubah total sesuai tema yang dipilih.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#2563eb',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Ganti',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.isSaving = true;
                            this.form.template_id = id;

                            fetch(`/editor/${this.slug}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({
                                    _method: 'POST',
                                    template_id: id
                                })
                            })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            title: 'Berhasil!',
                                            text: 'Tema berhasil diganti. Memuat ulang...',
                                            icon: 'success',
                                            timer: 1500,
                                            showConfirmButton: false
                                        }).then(() => {
                                            window.location.reload();
                                        });
                                    } else {
                                        Swal.fire('Gagal', data.message || 'Gagal mengganti template', 'error');
                                        this.isSaving = false;
                                    }
                                })
                                .catch(err => {
                                    console.error(err);
                                    Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
                                    this.isSaving = false;
                                });
                        }
                    });
                },

                // Music Logic UI State
                activeSongId: {{ $currentSong->id ?? 'null' }},
                currentSong: {
                    title: '{{ $currentSong->title ?? "Pilih Lagu" }}',
                    url: '{{ $currentSong->file_path ?? "" }}'
                },

                init() {
                    // Ensure arrays are initialized if null
                    this.form.active_sections = this.form.active_sections || [];
                    this.form.gallery_photos = this.form.gallery_photos || [];
                    this.form.love_stories = this.form.love_stories || [];
                    this.form.bank_accounts = this.form.bank_accounts || [];

                    // Fix Date Format for datetime-local input (YYYY-MM-DDTHH:MM)
                    // Postgres/Laravel standard: 2024-01-01T12:00:00.000000Z
                    if (this.form.akad_date && this.form.akad_date.length > 16) {
                        this.form.akad_date = this.form.akad_date.substring(0, 16);
                    }
                    if (this.form.resepsi_date && this.form.resepsi_date.length > 16) {
                        this.form.resepsi_date = this.form.resepsi_date.substring(0, 16);
                    }
                },

                getSelectedSongName() {
                    return this.currentSong.title;
                },

                getSelectedSongUrl() {
                    return this.currentSong.url;
                },

                // Quote Logic
                quotePresets: {
                    'islam': {
                        text: 'Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu isteri-isteri dari jenismu sendiri, supaya kamu cenderung dan merasa tenteram kepadanya, dan dijadikan-Nya diantaramu rasa kasih dan sayang.',
                        author: 'QS. Ar-Rum: 21'
                    },
                    'kristen': {
                        text: 'Demikianlah mereka bukan lagi dua, melainkan satu. Karena itu, apa yang telah dipersatukan Allah, tidak boleh diceraikan manusia.',
                        author: 'Matius 19:6'
                    },
                    'hindu': {
                        text: 'Tujuan perkawinan adalah untuk melaksanakan Dharma, memperoleh keturunan dan menikmati kama (kesenangan).',
                        author: 'Manawa Dharmasastra'
                    },
                    'buddha': {
                        text: 'Kebencian tidak akan pernah berakhir jika dibalas dengan kebencian. Kebencian hanya akan berakhir dengan cinta kasih.',
                        author: 'Dhammapada'
                    },
                    'konghucu': {
                        text: 'Hanya orang yang memiliki Kebajikan Sempurna yang dapat mengasihi sesama manusia.',
                        author: 'Tengah Sempurna'
                    },
                    'umum': {
                        text: 'Pernikahan bukan tentang mencari orang yang tepat, tapi menjadi orang yang tepat.',
                        author: 'Anonymous'
                    }
                },

                applyQuotePreset(presetKey) {
                    if (presetKey && this.quotePresets[presetKey]) {
                        this.form.quote_text = this.quotePresets[presetKey].text;
                        this.form.quote_author = this.quotePresets[presetKey].author;
                    }
                },

                selectSong(id, url, title) {
                    this.activeSongId = id;
                    this.currentSong = { title: title, url: url };
                    this.form.music_path = url;
                    this.saveChanges();
                    this.refreshPreview();
                },

                refreshPreview() {
                    const frame = this.viewMode === 'mobile'
                        ? document.getElementById('previewFrame')
                        : document.getElementById('previewFrameDesktop');
                    if (frame) {
                        frame.src = this.previewUrl + '?t=' + Date.now();
                    }
                },

                async saveChanges() {
                    this.isSaving = true;
                    try {
                        const response = await fetch(`/editor/${this.slug}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify(this.form) // Send entire form object
                        });

                        const result = await response.json();

                        if (response.ok) {
                            if (!this.silentSave) {
                                this.refreshPreview();
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true
                                });
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Disimpan'
                                });
                            } else {
                                this.refreshPreview();
                            }
                        } else {
                            throw new Error(result.message);
                        }
                    } catch (error) {
                        if (!this.silentSave) Swal.fire('Error', error.message, 'error');
                    } finally {
                        this.isSaving = false;
                        this.silentSave = false;
                    }
                },

                silentSave: false,
                autoSave() {
                    this.silentSave = true;
                    this.saveChanges();
                },

                async uploadImage(event, targetColumn) {
                    const file = event.target.files[0];
                    if (!file) return;

                    const formData = new FormData();
                    formData.append('image', file);
                    formData.append('invitation_slug', this.slug);
                    formData.append('key', targetColumn); // e.g. 'cover_image'

                    try {
                        const response = await fetch("{{ route('editor.media.upload') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                            body: formData
                        });

                        const result = await response.json();

                        if (response.ok) {
                            // Direct assignment to form property
                            this.form[targetColumn] = result.url;
                        } else {
                            throw new Error(result.message);
                        }
                    } catch (error) {
                        Swal.fire('Upload Error', error.message, 'error');
                    }
                },

                async uploadGalleryImages(event) {
                    const files = Array.from(event.target.files);
                    if (files.length === 0) return;

                    // 1. Initialize Array
                    if (!this.form.gallery_photos) this.form.gallery_photos = [];

                    // 2. Limit Check
                    const maxPhotos = 8;
                    const currentCount = this.form.gallery_photos.length;
                    const remainingSlots = maxPhotos - currentCount;

                    if (files.length > remainingSlots) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Batas Tercapai',
                            text: `Maksimal 8 foto. Anda hanya bisa menambah ${remainingSlots} foto lagi.`
                        });
                        event.target.value = '';
                        return;
                    }

                    // 3. Client-Side Validation (Size 5MB & Type)
                    const invalidFiles = files.filter(file => file.size > 5 * 1024 * 1024);
                    if (invalidFiles.length > 0) {
                        Swal.fire('File Terlalu Besar', 'Beberapa file melebihi 5MB. Silakan kompres foto Anda.', 'error');
                        event.target.value = '';
                        return;
                    }

                    // 4. Show Loading
                    Swal.fire({
                        title: 'Mengupload...',
                        html: 'Mohon tunggu, sedang memproses foto.',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });

                    let successCount = 0;
                    let failedCount = 0;

                    // 5. Process Uploads sequentially to maintain order and stability
                    for (const file of files) {
                        const formData = new FormData();
                        formData.append('image', file);
                        formData.append('invitation_slug', this.slug);
                        formData.append('key', 'gallery');

                        try {
                            const response = await fetch("{{ route('editor.media.upload') }}", {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json',
                                },
                                body: formData
                            });

                            const result = await response.json();

                            if (response.ok) {
                                this.form.gallery_photos.push(result.url);
                                successCount++;
                            } else {
                                console.error('Upload failed:', result.message);
                                failedCount++;
                            }
                        } catch (error) {
                            console.error('Network error:', error);
                            failedCount++;
                        }
                    }

                    // 6. Save & Reset
                    if (successCount > 0) {
                        await this.saveChanges();
                    }

                    event.target.value = '';

                    // 7. Feedback
                    if (failedCount === 0) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: `${successCount} foto berhasil diupload!`,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Selesai',
                            text: `${successCount} berhasil, ${failedCount} gagal. Periksa koneksi atau ukuran file.`
                        });
                    }
                },

                removeGalleryPhoto(index) {
                    Swal.fire({
                        title: 'Hapus Foto?',
                        text: "Foto ini akan dihapus dari galeri.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.form.gallery_photos.splice(index, 1);
                            this.saveChanges();
                        }
                    });
                },

                togglePublish() {
                    const nextStatus = this.form.status === 'published' ? 'draft' : 'published';
                    const confirmTitle = nextStatus === 'published'
                        ? 'Publikasikan Undangan?'
                        : 'Kembalikan ke Draft?';
                    const confirmText = nextStatus === 'published'
                        ? 'Undangan akan bisa diakses oleh tamu yang memiliki link.'
                        : 'Link undangan tidak akan bisa diakses publik (hanya Anda).';
                    const confirmBtnColor = nextStatus === 'published' ? '#10b981' : '#f59e0b';

                    Swal.fire({
                        title: confirmTitle,
                        text: confirmText,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: confirmBtnColor,
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: nextStatus === 'published' ? 'Ya, Publikasikan' : 'Ya, Jadikan Draft',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.isSaving = true;
                            fetch(`/editor/${this.slug}/publish`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({ status: nextStatus })
                            })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        this.form.status = data.status;
                                        Swal.fire('Berhasil', data.message, 'success');
                                    } else {
                                        Swal.fire('Gagal', data.message, 'error');
                                    }
                                })
                                .catch(err => {
                                    console.error(err);
                                    Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
                                })
                                .finally(() => {
                                    this.isSaving = false;
                                });
                        }
                    });
                }
            }
        }
    </script>
</body>

</html>