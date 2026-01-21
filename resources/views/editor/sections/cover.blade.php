<div class="space-y-6">
    <!-- Section Toggle & Header -->
    <div class="flex justify-between items-center border-b border-gray-100 pb-4">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Cover Undangan</h3>
            <p class="text-xs text-gray-500">Tampilan utama saat undangan dibuka.</p>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" x-model="form.active_sections" value="cover" class="sr-only peer">
            <div
                class="w-11 h-6 bg-gray-200 peer-focus:outline-none ring-0 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-violet-400 peer-checked:to-blue-400">
            </div>
            <span class="ms-3 text-sm font-medium text-gray-700"
                x-text="form.active_sections.includes('cover') ? 'Aktif' : 'Non-aktif'"></span>
        </label>
    </div>

    <!-- Title Input -->
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Utama</label>
        <div class="relative">
            <input type="text" name="title" x-model="form.title" @input.debounce.1000ms="autoSave()"
                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-violet-100 focus:border-violet-400 outline-none transition-all placeholder-gray-400 text-gray-800"
                placeholder="The Wedding Of">
            <div class="absolute right-3 top-3 text-gray-400 pointer-events-none">
                <i class="fas fa-heading"></i>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-2">Biasanya diisi: "The Wedding Of", "Walimatul Ursy", dll.</p>
    </div>

    <!-- Cover Image Upload -->
    <div
        class="p-5 bg-gray-50 rounded-2xl border border-gray-100 border-dashed hover:border-violet-300 transition-colors group">
        <label class="block text-sm font-semibold text-gray-700 mb-3 group-hover:text-violet-600 transition-colors">Foto
            Background</label>

        <div class="flex items-start gap-5">
            <!-- Preview Box -->
            <div
                class="w-24 h-32 flex-shrink-0 bg-white rounded-lg shadow-sm border border-gray-200 flex items-center justify-center overflow-hidden relative group-hover:shadow-md transition-shadow">
                <template x-if="form.cover_image">
                    <img :src="form.cover_image"
                        class="w-full h-full object-cover cursor-pointer hover:opacity-75 transition"
                        @click="$refs.coverInput.click()">
                </template>
                <template x-if="!form.cover_image">
                    <div class="text-center p-2">
                        <i class="fas fa-image text-gray-300 text-2xl mb-1"></i>
                        <span class="block text-[9px] text-gray-400">No Image</span>
                    </div>
                </template>

                <!-- Hover Overlay -->
                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity cursor-pointer"
                    @click="$refs.coverInput.click()">
                    <i class="fas fa-pen text-white"></i>
                </div>
            </div>

            <!-- Upload Controls -->
            <div class="flex-1">
                <input x-ref="coverInput" type="file" name="cover_image" @change="uploadImage($event, 'cover_image')"
                    class="block w-full text-sm text-gray-500 
                              file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 
                              file:text-sm file:font-bold 
                              file:bg-violet-50 file:text-violet-600 
                              hover:file:bg-violet-100 transition cursor-pointer mb-2" accept="image/*">

                <p class="text-xs text-gray-500 leading-relaxed">
                    Gunakan foto dengan orientasi <strong class="text-gray-700">Potrait (9:16)</strong> untuk hasil
                    terbaik di HP.<br>
                    Format: JPG/PNG, Max 2MB.
                </p>
            </div>
        </div>
    </div>
</div>