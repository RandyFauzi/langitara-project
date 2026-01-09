<div x-data="{ tab: 'config' }" class="h-full flex flex-col">
    <!-- Header with Tabs -->
    <div class="px-6 py-4 border-b border-slate-200 bg-white">
        <h2 class="text-xl font-bold text-slate-800 mb-4">Cerita Cinta</h2>
        <div class="flex items-center gap-6">
            <button @click="tab = 'config'"
                :class="tab === 'config' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-slate-500 hover:text-slate-700'"
                class="pb-2 text-sm font-medium transition-colors">
                Konfigurasi
            </button>
            <button @click="tab = 'stories'"
                :class="tab === 'stories' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-slate-500 hover:text-slate-700'"
                class="pb-2 text-sm font-medium transition-colors">
                Daftar Cerita
            </button>
        </div>
    </div>

    <!-- Content Scroller -->
    <div class="flex-1 overflow-y-auto p-6 space-y-6">

        <!-- Config Tab -->
        <div x-show="tab === 'config'" class="space-y-6">

            <!-- Enable Toggle -->
            <div>
                <label class="flex items-center space-x-3">
                    <input type="checkbox" x-model="form.story.enabled"
                        class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-sm font-medium text-slate-700">Aktifkan Cerita Cinta</span>
                </label>
            </div>

            <!-- Title -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Judul Bagian</label>
                <input type="text" x-model="form.story.title"
                    class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Contoh: Kisah Kami">
            </div>

            <!-- Layout Radio -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-3">Tampilan Cerita</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <template x-for="layout in ['slider', 'vertical']">
                        <label class="cursor-pointer relative">
                            <input type="radio" name="story_layout" :value="layout" x-model="form.story.layout"
                                class="peer sr-only">
                            <div
                                class="p-4 bg-white border rounded-lg peer-checked:border-indigo-600 peer-checked:ring-1 peer-checked:ring-indigo-600 hover:bg-slate-50 transition flex flex-col items-center gap-2">
                                <div class="w-full h-10 bg-slate-100 rounded mb-2 flex items-center justify-center text-xs text-slate-400 uppercase"
                                    x-text="layout"></div>
                            </div>
                        </label>
                    </template>
                </div>
            </div>

        </div>

        <!-- Stories Tab -->
        <div x-show="tab === 'stories'" class="space-y-6">

            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-slate-700">Timeline</h3>
                <button @click="addLoveStory"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                    + Tambah Cerita
                </button>
            </div>

            <div class="space-y-4">
                <template x-for="(item, index) in form.story.items" :key="index">
                    <div class="bg-white border boundary-item p-4 rounded-xl shadow-sm relative group space-y-4">

                        <!-- Header / Reorder Actions -->
                        <div class="flex items-center justify-between border-b pb-3 border-slate-100">
                            <span class="text-xs font-bold text-slate-400" x-text="'#' + (index + 1)"></span>
                            <div class="flex items-center gap-2">
                                <button @click="moveItem('story.items', index, -1)"
                                    class="text-slate-400 hover:text-indigo-600 p-1" title="Move Up">Up</button>
                                <button @click="moveItem('story.items', index, 1)"
                                    class="text-slate-400 hover:text-indigo-600 p-1" title="Move Down">Down</button>
                                <button @click="removeLoveStory(index)"
                                    class="text-slate-400 hover:text-red-600 p-1 ml-2" title="Delete">Del</button>
                            </div>
                        </div>

                        <!-- Content Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Image -->
                            <div class="md:col-span-1">
                                <div
                                    class="relative aspect-[3/4] bg-slate-100 rounded-lg overflow-hidden border border-slate-200 group-hover:border-indigo-200 transition">
                                    <template x-if="item.image">
                                        <img :src="item.image" class="absolute inset-0 w-full h-full object-cover">
                                    </template>

                                    <!-- Upload Overlay -->
                                    <label
                                        class="absolute inset-0 bg-black/0 group-hover:bg-black/10 cursor-pointer flex items-center justify-center transition-all">
                                        <span
                                            class="bg-white/90 px-2 py-1 rounded text-xs font-semibold shadow opacity-0 group-hover:opacity-100 scale-90 group-hover:scale-100 transition">
                                            Ganti Foto
                                        </span>
                                        <input type="file" accept="image/*" class="hidden" @change="async (e) => {
                                                const url = await uploadImage(e.target.files[0]);
                                                if(url) item.image = url;
                                                e.target.value = '';
                                            }">
                                    </label>
                                </div>
                            </div>

                            <!-- Fields -->
                            <div class="md:col-span-3 space-y-3">
                                <div class="grid grid-cols-3 gap-3">
                                    <div class="col-span-1">
                                        <label class="block text-xs font-medium text-slate-500 mb-1">Tahun</label>
                                        <input type="text" x-model="item.year"
                                            class="w-full text-sm rounded border-slate-200">
                                    </div>
                                    <div class="col-span-2">
                                        <label class="block text-xs font-medium text-slate-500 mb-1">Judul Momen</label>
                                        <input type="text" x-model="item.title"
                                            class="w-full text-sm rounded border-slate-200">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-500 mb-1">Cerita Singkat</label>
                                    <textarea x-model="item.story" rows="3"
                                        class="w-full text-sm rounded border-slate-200"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </template>

                <!-- Empty State -->
                <div x-show="form.story.items.length === 0" class="text-center py-12 text-slate-400">
                    <p>Belum ada cerita.</p>
                </div>
            </div>

        </div>

    </div>
</div>