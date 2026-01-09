<aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col h-full overflow-y-auto">
    <!-- Brand / Title -->
    {{-- <div class="p-4 border-b border-slate-100">
        <h2 class="font-bold text-slate-800">Editor</h2>
    </div> --}}

    <nav class="flex-1 py-4 space-y-1">

        {{-- Dasbor --}}
        <a href="{{ route('admin.invitations.index') }}"
            class="group flex items-center px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-l-4 border-transparent hover:border-slate-300">
            <svg class="mr-3 h-5 w-5 text-slate-400 group-hover:text-slate-500" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Dasbor
        </a>

        {{-- Tampilan --}}
        <button @click="activeMenu = 'meta'"
            :class="activeMenu === 'meta' ? 'bg-indigo-50 border-indigo-600 text-indigo-700' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900 hover:border-slate-300'"
            class="w-full group flex items-center px-4 py-2.5 text-sm font-medium border-l-4 transition-colors">
            <div class="mr-3 text-slate-400 group-hover:text-slate-500"
                :class="{'text-indigo-600': activeMenu === 'meta'}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            Tampilan
            <span x-show="sectionHasError('meta')" class="ml-auto w-2 h-2 rounded-full bg-red-500"></span>
        </button>


        {{-- Isi (Collapsible) --}}
        <div x-data="{ open: true }">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-4 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wider hover:text-slate-700 mt-4 mb-1">
                Isi
                <svg :class="{'rotate-90': open}" class="h-3 w-3 transition-transform" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd" />
                </svg>
            </button>
            <div x-show="open" class="space-y-0.5">

                {{-- Couple --}}
                <button @click="activeMenu = 'couple'"
                    :class="activeMenu === 'couple' ? 'bg-indigo-50 border-indigo-600 text-indigo-700' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900 hover:border-slate-300'"
                    class="w-full group flex items-center px-4 py-2 text-sm font-medium border-l-4 transition-colors">
                    <span class="ml-8">Mempelai</span>
                </button>

                {{-- Events --}}
                <button @click="activeMenu = 'events'"
                    :class="activeMenu === 'events' ? 'bg-indigo-50 border-indigo-600 text-indigo-700' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900 hover:border-slate-300'"
                    class="w-full group flex items-center px-4 py-2 text-sm font-medium border-l-4 transition-colors">
                    <span class="ml-8">Acara</span>
                </button>

                {{-- Location --}}
                <button @click="activeMenu = 'location'"
                    :class="activeMenu === 'location' ? 'bg-indigo-50 border-indigo-600 text-indigo-700' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900 hover:border-slate-300'"
                    class="w-full group flex items-center px-4 py-2 text-sm font-medium border-l-4 transition-colors">
                    <span class="ml-8">Lokasi</span>
                </button>

                {{-- Album Foto --}}
                <button @click="activeMenu = 'album'"
                    :class="activeMenu === 'album' ? 'bg-indigo-50 border-indigo-600 text-indigo-700' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900 hover:border-slate-300'"
                    class="w-full group flex items-center px-4 py-2 text-sm font-medium border-l-4 transition-colors">
                    <span class="ml-8">Album foto</span>
                    <span x-show="sectionHasError('album')" class="ml-auto w-2 h-2 rounded-full bg-red-500"></span>
                </button>

                {{-- Cerita --}}
                <button @click="activeMenu = 'story'"
                    :class="activeMenu === 'story' ? 'bg-indigo-50 border-indigo-600 text-indigo-700' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900 hover:border-slate-300'"
                    class="w-full group flex items-center px-4 py-2 text-sm font-medium border-l-4 transition-colors">
                    <span class="ml-8">Cerita</span>
                    <span x-show="sectionHasError('story')" class="ml-auto w-2 h-2 rounded-full bg-red-500"></span>
                </button>

                {{-- Penutup --}}
                <button @click="activeMenu = 'closing'"
                    :class="activeMenu === 'closing' ? 'bg-indigo-50 border-indigo-600 text-indigo-700' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900 hover:border-slate-300'"
                    class="w-full group flex items-center px-4 py-2 text-sm font-medium border-l-4 transition-colors">
                    <span class="ml-8">Penutup</span>
                    <span x-show="sectionHasError('closing')" class="ml-auto w-2 h-2 rounded-full bg-red-500"></span>
                </button>

            </div>
        </div>

        {{-- Tamu (Collapsible) --}}
        <div x-data="{ open: true }">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-4 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wider hover:text-slate-700 mt-4 mb-1">
                Tamu
                <svg :class="{'rotate-90': open}" class="h-3 w-3 transition-transform" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd" />
                </svg>
            </button>
            <div x-show="open" class="space-y-0.5">
                {{-- Guest List --}}
                <button @click="activeMenu = 'guests'"
                    :class="activeMenu === 'guests' ? 'bg-indigo-50 border-indigo-600 text-indigo-700' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900 hover:border-slate-300'"
                    class="w-full group flex items-center px-4 py-2 text-sm font-medium border-l-4 transition-colors">
                    <span class="ml-8">Daftar tamu</span>
                </button>

                {{-- RSVP --}}
                <button @click="activeMenu = 'rsvp'"
                    :class="activeMenu === 'rsvp' ? 'bg-indigo-50 border-indigo-600 text-indigo-700' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900 hover:border-slate-300'"
                    class="w-full group flex items-center px-4 py-2 text-sm font-medium border-l-4 transition-colors">
                    <span class="ml-8">RSVP</span>
                </button>

                {{-- Gift --}}
                <button @click="activeMenu = 'gift'"
                    :class="activeMenu === 'gift' ? 'bg-indigo-50 border-indigo-600 text-indigo-700' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900 hover:border-slate-300'"
                    class="w-full group flex items-center px-4 py-2 text-sm font-medium border-l-4 transition-colors">
                    <span class="ml-8">Hadiah</span>
                </button>
            </div>
        </div>

        {{-- Pengaturan (Collapsible) --}}
        <div x-data="{ open: true }">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-4 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wider hover:text-slate-700 mt-4 mb-1">
                Pengaturan
                <svg :class="{'rotate-90': open}" class="h-3 w-3 transition-transform" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd" />
                </svg>
            </button>
            <div x-show="open" class="space-y-0.5">
                {{-- Latar Musik --}}
                <button @click="activeMenu = 'music'"
                    :class="activeMenu === 'music' ? 'bg-indigo-50 border-indigo-600 text-indigo-700' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900 hover:border-slate-300'"
                    class="w-full group flex items-center px-4 py-2 text-sm font-medium border-l-4 transition-colors">
                    <span class="ml-8">Latar musik</span>
                    <span x-show="sectionHasError('music')" class="ml-auto w-2 h-2 rounded-full bg-red-500"></span>
                </button>
            </div>
        </div>

        {{-- Ekstra (Collapsible) --}}
        <div x-data="{ open: false }">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-4 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wider hover:text-slate-700 mt-4 mb-1">
                Ekstra
                <svg :class="{'rotate-90': open}" class="h-3 w-3 transition-transform" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd" />
                </svg>
            </button>
            <div x-show="open" class="space-y-0.5">
                <!-- Future Extras -->
                <div class="px-4 py-2 text-xs text-slate-400 italic">No extra features yet</div>
            </div>
        </div>

    </nav>
</aside>