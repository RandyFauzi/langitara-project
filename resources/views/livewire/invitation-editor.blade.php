<div class="min-h-screen bg-[#F3F4F6] flex flex-col font-poppins">

    <!-- TOP NAV -->
    <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 fixed w-full top-0 z-50">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard.index') }}" class="text-gray-500 hover:text-gray-700 transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Editor Undangan</h1>
                <p class="text-xs text-gray-500">{{ $invitation->groom_nickname ?? 'Groom' }} & {{ $invitation->bride_nickname ?? 'Bride' }}</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <span wire:loading class="text-sm text-gray-400">
                <i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...
            </span>

            <button wire:click="save" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                Simpan Draft
            </button>
            
            @if($invitation->status == 'draft')
                <button wire:click="publishInvitation" class="px-5 py-2 text-sm font-bold text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-sm hover:from-blue-600 hover:to-blue-700 transition flex items-center gap-2">
                    <i class="fas fa-rocket"></i> Publish Undangan
                </button>
            @else
                <div class="flex items-center gap-2">
                     <span class="px-3 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full border border-green-200 flex items-center gap-1">
                        <i class="fas fa-check-circle"></i> Live (Tayang)
                    </span>
                     <button wire:click="unpublishInvitation" class="text-xs text-gray-500 hover:text-red-500 underline">
                        Kembalikan ke Draft
                    </button>
                </div>
            @endif
        </div>
    </header>

    <div class="flex-1 flex pt-16 h-screen overflow-hidden">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-white border-r border-gray-200 overflow-y-auto custom-scrollbar flex-shrink-0">
            <nav class="p-4 space-y-1">
                <h3 class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Sections</h3>
                
                @foreach([
                    ['id' => 'cover', 'label' => 'Cover Depan', 'icon' => 'fa-home'],
                    ['id' => 'mempelai', 'label' => 'Data Mempelai', 'icon' => 'fa-heart'],
                    ['id' => 'acara', 'label' => 'Rangkaian Acara', 'icon' => 'fa-calendar-alt'],
                    ['id' => 'gallery', 'label' => 'Galeri Foto', 'icon' => 'fa-images'],
                    ['id' => 'quote', 'label' => 'Quote / Ayat', 'icon' => 'fa-quote-left'],
                    ['id' => 'story', 'label' => 'Love Story', 'icon' => 'fa-book-open'],
                    ['id' => 'gift', 'label' => 'Kado Digital', 'icon' => 'fa-gift'],
                    ['id' => 'guests', 'label' => 'Tamu & Ucapan', 'icon' => 'fa-users'],
                ] as $section)
                    <button wire:click="$set('activeSection', '{{ $section['id'] }}')" 
                        class="w-full flex items-center gap-3 px-3 py-3 text-sm font-medium rounded-lg transition {{ $activeSection == $section['id'] ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }}">
                        <i class="fas {{ $section['icon'] }} text-lg {{ $activeSection == $section['id'] ? 'text-blue-500' : 'text-gray-400' }} w-6 text-center"></i>
                        {{ $section['label'] }}
                    </button>
                @endforeach
                
                <div class="pt-4 mt-4 border-t">
                     <h3 class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Settings</h3>
                     <button wire:click="$set('activeSection', 'tema')" 
                        class="w-full flex items-center gap-3 px-3 py-3 text-sm font-medium rounded-lg transition {{ $activeSection == 'tema' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }}">
                        <i class="fas fa-palette text-lg {{ $activeSection == 'tema' ? 'text-blue-500' : 'text-gray-400' }} w-6 text-center"></i>
                        Ganti Template
                    </button>
                    <button wire:click="$set('activeSection', 'music')" 
                        class="w-full flex items-center gap-3 px-3 py-3 text-sm font-medium rounded-lg transition {{ $activeSection == 'music' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }}">
                        <i class="fas fa-music text-lg {{ $activeSection == 'music' ? 'text-blue-500' : 'text-gray-400' }} w-6 text-center"></i>
                        Musik Latar
                    </button>
                </div>
            </nav>
        </aside>

        <!-- MAIN EDITOR -->
        <main class="flex-1 overflow-y-auto custom-scrollbar bg-[#F3F4F6] p-8">
            <div class="max-w-2xl mx-auto">
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-lg font-semibold text-gray-800">
                            {{ ucfirst($activeSection) }}
                        </h2>
                        <p class="text-sm text-gray-500">Sesuaikan konten undangan Anda.</p>
                    </div>

                    <div class="p-6 space-y-6">
                        
                        <!-- COVER SECTION -->
                        @if($activeSection == 'cover')
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Cover</label>
                                    <input type="text" wire:model.live="invitation.title" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
                                </div>
                                <!-- TODO: Cover Image Upload -->
                            </div>
                        @endif

                        <!-- COUPLE SECTION -->
                        @if($activeSection == 'mempelai')
                            <div class="space-y-6">
                                <!-- Groom -->
                                <div class="p-4 bg-blue-50 rounded-lg border border-blue-100">
                                    <h3 class="font-bold text-gray-700 mb-3 flex items-center"><i class="fas fa-mars mr-2"></i> Mempelai Pria</h3>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                            <input type="text" wire:model.live="invitation.groom_name" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Panggilan</label>
                                                <input type="text" wire:model.live="invitation.groom_nickname" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
                                            </div>
                                             <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ayah</label>
                                                <input type="text" wire:model.live="invitation.groom_father" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
                                            </div>
                                             <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ibu</label>
                                                <input type="text" wire:model.live="invitation.groom_mother" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bride -->
                                <div class="p-4 bg-pink-50 rounded-lg border border-pink-100">
                                     <h3 class="font-bold text-gray-700 mb-3 flex items-center"><i class="fas fa-venus mr-2"></i> Mempelai Wanita</h3>
                                     <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                            <input type="text" wire:model.live="invitation.bride_name" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Panggilan</label>
                                                <input type="text" wire:model.live="invitation.bride_nickname" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
                                            </div>
                                             <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ayah</label>
                                                <input type="text" wire:model.live="invitation.bride_father" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
                                            </div>
                                             <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ibu</label>
                                                <input type="text" wire:model.live="invitation.bride_mother" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- EVENTS SECTION -->
                        @if($activeSection == 'acara')
                             <div class="space-y-6">
                                <!-- Akad -->
                                <div class="border rounded-lg p-4">
                                    <h4 class="font-bold text-gray-800 mb-3">1. Akad Nikah</h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal & Waktu</label>
                                            <input type="datetime-local" wire:model.live="invitation.akad_date" class="w-full rounded-lg border-gray-300 focus:border-blue-500 transition">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                                            <input type="text" wire:model.live="invitation.akad_location" class="w-full rounded-lg border-gray-300 focus:border-blue-500 transition" placeholder="Nama Gedung / Tempat">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                                            <textarea wire:model.live="invitation.akad_address" rows="2" class="w-full rounded-lg border-gray-300 focus:border-blue-500 transition"></textarea>
                                        </div>
                                         <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Link Maps</label>
                                            <input type="url" wire:model.live="invitation.akad_map_link" class="w-full rounded-lg border-gray-300 focus:border-blue-500 transition">
                                        </div>
                                    </div>
                                </div>

                                 <!-- Resepsi -->
                                <div class="border rounded-lg p-4">
                                    <h4 class="font-bold text-gray-800 mb-3">2. Resepsi</h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal & Waktu</label>
                                            <input type="datetime-local" wire:model.live="invitation.resepsi_date" class="w-full rounded-lg border-gray-300 focus:border-blue-500 transition">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                                            <input type="text" wire:model.live="invitation.resepsi_location" class="w-full rounded-lg border-gray-300 focus:border-blue-500 transition" placeholder="Nama Gedung / Tempat">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                                            <textarea wire:model.live="invitation.resepsi_address" rows="2" class="w-full rounded-lg border-gray-300 focus:border-blue-500 transition"></textarea>
                                        </div>
                                          <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Link Maps</label>
                                            <input type="url" wire:model.live="invitation.resepsi_map_link" class="w-full rounded-lg border-gray-300 focus:border-blue-500 transition">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- QUOTE SECTION -->
                        @if($activeSection == 'quote')
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kutipan Ayat / Kata Mutiara</label>
                                    <textarea wire:model.live="invitation.quote_text" rows="4" class="w-full rounded-lg border-gray-300 focus:border-blue-500 transition"></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Sumber Ayat / Penulis</label>
                                    <input type="text" wire:model.live="invitation.quote_author" class="w-full rounded-lg border-gray-300 focus:border-blue-500 transition">
                                </div>
                            </div>
                        @endif

                        <!-- MUSIC SECTION -->
                        @if($activeSection == 'music')
                            <div class="space-y-4">
                                <div class="p-4 bg-gray-50 rounded-lg flex items-center justify-between border">
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Lagu Aktif</p>
                                        <p class="text-xs text-gray-500 font-mono text-ellipsis overflow-hidden w-64">{{ $currentSong->title ?? 'Belum ada lagu dipilih' }}</p>
                                    </div>
                                    @if($currentSong)
                                        <audio controls class="h-8 w-40">
                                            <source src="{{ $currentSong->file_path }}" type="audio/mp3">
                                        </audio>
                                    @endif
                                </div>

                                <div class="grid grid-cols-1 gap-2 max-h-96 overflow-y-auto">
                                    @foreach($songs as $song)
                                        <div class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50 cursor-pointer {{ $invitation->music_path == $song->file_path ? 'border-blue-500 bg-blue-50' : '' }}"
                                             wire:click="selectSong('{{ $song->file_path }}')">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                                    <i class="fas fa-music text-xs"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-800">{{ $song->title }}</p>
                                                    <p class="text-xs text-gray-500">{{ $song->artist ?? 'Unknown' }}</p>
                                                </div>
                                            </div>
                                            @if($invitation->music_path == $song->file_path)
                                                <i class="fas fa-check-circle text-blue-500"></i>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- TEMPLATE SECTION -->
                        @if($activeSection == 'tema')
                            <div class="grid grid-cols-2 gap-4">
                                @foreach($templates as $template)
                                    <div class="group relative rounded-xl overflow-hidden border-2 cursor-pointer transition-all {{ $invitation->template_id == $template->id ? 'border-blue-500 shadow-md transform scale-105' : 'border-gray-200 hover:border-blue-300' }}"
                                         wire:click="changeTemplate({{ $template->id }})">
                                        <img src="{{ asset('storage/'.$template->thumbnail) }}" alt="{{ $template->name }}" class="w-full h-40 object-cover">
                                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-3">
                                            <p class="text-white text-sm font-medium">{{ $template->name }}</p>
                                        </div>
                                        @if($invitation->template_id == $template->id)
                                            <div class="absolute top-2 right-2 bg-blue-500 text-white rounded-full p-1 w-6 h-6 flex items-center justify-center">
                                                <i class="fas fa-check text-xs"></i>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif

                         <!-- GUESTS SECTION -->
                        @if($activeSection == 'guests')
                            <div class="space-y-6">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-sm font-bold text-gray-700">Daftar Tamu ({{ $stats['total_guests'] ?? 0 }})</h3>
                                    {{-- <button class="text-sm text-blue-600 font-medium">+ Tambah Tamu</button> --}}
                                </div>
                                
                                <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200 text-sm text-yellow-800">
                                    <i class="fas fa-info-circle mr-2"></i> Fitur manajemen tamu lengkap tersedia di menu "Tamu" (Sidebar Utama).
                                </div>

                                <div class="overflow-hidden border rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Grup</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 font-mono text-sm">
                                            @forelse($guests as $guest)
                                                <tr>
                                                    <td class="px-4 py-2">{{ $guest->name }}</td>
                                                    <td class="px-4 py-2 text-gray-500">{{ $guest->group_name ?? '-' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="2" class="px-4 py-4 text-center text-gray-400 text-xs italic">Belum ada tamu.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <h3 class="text-sm font-bold text-gray-700 mt-6 pt-6 border-t">Ucapan & Doa ({{ $wishes->count() }})</h3>
                                <div class="space-y-3 max-h-80 overflow-y-auto">
                                    @forelse($wishes as $wish)
                                        <div class="p-3 bg-gray-50 rounded-lg border">
                                            <p class="text-xs font-bold text-gray-800 mb-1">{{ $wish->name }} <span class="text-gray-400 font-normal">- {{ $wish->created_at->diffForHumans() }}</span></p>
                                            <p class="text-sm text-gray-600 italic">"{{ $wish->message }}"</p>
                                        </div>
                                    @empty
                                         <p class="text-gray-400 text-xs italic text-center">Belum ada ucapan.</p>
                                    @endforelse
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </main>

        <!-- RIGHT PANEL: PREVIEW -->
        <aside class="w-[450px] bg-gray-100 border-l border-gray-200 flex items-center justify-center p-6 flex-shrink-0 relative overflow-hidden">
            
             <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 20px 20px;"></div>

            <div class="relative" style="width: 375px; height: 750px;"> 
                <div class="absolute inset-0 bg-black rounded-[3rem] shadow-2xl border-[12px] border-black overflow-hidden z-20 pointer-events-none">
                    <div class="absolute top-0 inset-x-0 h-6 bg-black w-40 mx-auto rounded-b-3xl"></div>
                </div>

                <div class="absolute inset-0 rounded-[2.5rem] overflow-hidden bg-white z-10 my-[12px] mx-[12px]">
                    <iframe 
                        src="{{ route('public.invitation.show', ['slug' => $invitation->slug]) }}?t={{ time() }}" 
                        class="w-full h-full border-0 scroll-smooth"
                        wire:ignore.self 
                    ></iframe>
                </div>
            </div>
        </aside>

    </div>

</div>
