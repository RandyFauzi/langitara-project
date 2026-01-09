<div x-data="{ tab: 'photos' }" class="h-full flex flex-col">
    <!-- Header with Tabs -->
    <div class="px-6 py-4 border-b border-slate-200 bg-white">
        <h2 class="text-xl font-bold text-slate-800 mb-4">Galeri Foto</h2>
        <div class="flex items-center gap-6">
            <button @click="tab = 'photos'"
                :class="tab === 'photos' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-slate-500 hover:text-slate-700'"
                class="pb-2 text-sm font-medium transition-colors">
                Foto
            </button>
            <button @click="tab = 'config'"
                :class="tab === 'config' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-slate-500 hover:text-slate-700'"
                class="pb-2 text-sm font-medium transition-colors">
                Opsi
            </button>
        </div>
    </div>

    <!-- Content Scroller -->
    <div class="flex-1 overflow-y-auto p-6 space-y-6">

        <!-- Photos Tab -->
        <div x-show="tab === 'photos'" class="space-y-6">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-slate-700">Daftar Foto</h3>
                <label
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition cursor-pointer flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Upload Foto
                    <input type="file" multiple accept="image/*" class="hidden" @change="async (e) => {
                            for(let file of e.target.files) {
                                const url = await uploadImage(file);
                                if(url) addGalleryItem(url);
                            }
                            e.target.value = '';
                        }">
                </label>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <template x-for="(item, index) in form.album.items" :key="index">
                    <div
                        class="group relative aspect-square bg-slate-100 rounded-lg overflow-hidden border border-slate-200 hover:border-indigo-500 transition">
                        <img :src="item.url" class="w-full h-full object-cover">

                        <!-- Overlay Actions -->
                        <div
                            class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                            <button @click="moveItem('album.items', index, -1)"
                                class="p-1 bg-white/20 hover:bg-white text-white hover:text-indigo-600 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button @click="removeGalleryItem(index)"
                                class="p-1 bg-white/20 hover:bg-white text-white hover:text-red-600 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                            <button @click="moveItem('album.items', index, 1)"
                                class="p-1 bg-white/20 hover:bg-white text-white hover:text-indigo-600 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <div x-show="form.album.items.length === 0"
                class="text-center py-12 text-slate-400 border border-dashed border-slate-200 rounded-xl">
                <p>Belum ada foto.</p>
            </div>
        </div>

        <!-- Config Tab -->
        <div x-show="tab === 'config'" class="space-y-6">
            <div>
                <label class="flex items-center space-x-3">
                    <input type="checkbox" x-model="form.album.enabled"
                        class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-sm font-medium text-slate-700">Aktifkan Galeri</span>
                </label>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Judul Bagian</label>
                <input type="text" x-model="form.album.title"
                    class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Keterangan</label>
                <textarea x-model="form.album.description" rows="2"
                    class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
            </div>

            <!-- Future: Layout Selector -->
        </div>

    </div>
</div>