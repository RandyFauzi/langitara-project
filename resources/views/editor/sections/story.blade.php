<div class="space-y-6">
    <div class="flex justify-between items-center border-b border-gray-100 pb-4">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Kisah Cinta</h3>
            <p class="text-xs text-gray-500">Bagikan perjalanan cinta Anda dalam timeline.</p>
        </div>

        <div class="flex items-center gap-4">
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" x-model="form.active_sections" value="story" class="sr-only peer">
                <div
                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none ring-0 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-violet-400 peer-checked:to-blue-400">
                </div>
                <span class="ms-3 text-sm font-medium text-gray-700"
                    x-text="form.active_sections.includes('story') ? 'Aktif' : 'Non-aktif'"></span>
            </label>

            <button @click="form.love_stories.push({ year: '', title: '', story: '' }); autoSave()"
                class="px-4 py-2 bg-gradient-to-r from-violet-500 to-fuchsia-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-violet-200 hover:shadow-violet-300 transform hover:-translate-y-0.5 transition-all flex items-center gap-2">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </div>
    </div>

    <!-- Empty State -->
    <template x-if="!form.love_stories || form.love_stories.length === 0">
        <div x-show="form.active_sections.includes('story')" x-transition
            class="p-10 text-center border-2 border-dashed border-gray-200 rounded-2xl bg-gray-50 group hover:border-violet-300 transition-colors">
            <div
                class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm group-hover:scale-110 transition-transform">
                <i class="fas fa-heart text-gray-300 text-2xl group-hover:text-violet-400"></i>
            </div>
            <h3 class="text-sm font-bold text-gray-800">Belum Ada Cerita</h3>
            <p class="text-xs text-gray-500 mt-1 max-w-xs mx-auto">Mulai tambahkan momen spesial perjalanan cinta Anda.
            </p>
            <button @click="form.love_stories.push({ year: '', title: '', story: '' }); autoSave()"
                class="mt-4 text-xs font-bold text-violet-600 hover:text-violet-800 underline">Tambah Cerita
                Pertama</button>
        </div>
    </template>

    <!-- Timeline List -->
    <div x-show="form.active_sections.includes('story')" class="space-y-4 relative" x-transition>
        <!-- Connector Line Visual -->
        <div class="absolute left-6 top-4 bottom-4 w-0.5 bg-gray-100 hidden md:block"></div>

        <template x-for="(item, index) in form.love_stories" :key="index">
            <div
                class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 relative group hover:border-violet-200 transition-all ml-0 md:ml-12">

                <!-- Timeline Dot -->
                <div
                    class="absolute -left-12 top-6 w-8 h-8 rounded-full bg-white border-4 border-violet-100 flex items-center justify-center shadow-sm hidden md:flex">
                    <div class="w-3 h-3 rounded-full bg-violet-500"></div>
                </div>

                <div
                    class="absolute top-4 right-4 flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button @click="form.love_stories.splice(index, 1); autoSave()"
                        class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition-colors"
                        title="Hapus">
                        <i class="fas fa-trash-alt text-xs"></i>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <!-- Year -->
                    <div class="md:col-span-3">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Tahun /
                            Tanggal</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i
                                    class="far fa-calendar-alt text-xs"></i></span>
                            <input type="text" x-model="item.year" @input.debounce.1000ms="autoSave()"
                                placeholder="20xx"
                                class="w-full pl-9 pr-3 py-2 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-violet-400 focus:ring-4 focus:ring-violet-100 transition-all text-sm font-bold text-violet-600">
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="md:col-span-9">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Judul
                            Momen</label>
                        <input type="text" x-model="item.title" @input.debounce.1000ms="autoSave()"
                            placeholder="Pertama Bertemu / Tunangan"
                            class="w-full px-4 py-2 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-violet-400 focus:ring-4 focus:ring-violet-100 transition-all text-sm font-bold text-gray-800">
                    </div>

                    <!-- Story -->
                    <div class="col-span-1 md:col-span-12">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Cerita
                            Singkat</label>
                        <textarea x-model="item.story" @input.debounce.1000ms="autoSave()" rows="3"
                            placeholder="Ceritakan sedikit tentang momen indah ini..."
                            class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-violet-400 focus:ring-4 focus:ring-violet-100 transition-all text-sm text-gray-600 resize-none"></textarea>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>