<div class="space-y-6">
    <!-- Header with Toggle -->
    <div class="flex justify-between items-center border-b border-gray-100 pb-4">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Galeri Foto</h3>
            <p class="text-xs text-gray-500">Bagikan momen indah Anda (Maks. 8 foto).</p>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" x-model="form.active_sections" value="gallery" class="sr-only peer">
            <div
                class="w-11 h-6 bg-gray-200 peer-focus:outline-none ring-0 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-violet-400 peer-checked:to-blue-400">
            </div>
            <span class="ms-3 text-sm font-medium text-gray-700"
                x-text="form.active_sections.includes('gallery') ? 'Aktif' : 'Non-aktif'"></span>
        </label>
    </div>

    <!-- Upload Controls -->
    <div class="flex items-center justify-between bg-violet-50/50 p-4 rounded-xl border border-violet-100">
        <div class="flex items-center gap-3">
            <div
                class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-violet-500 shadow-sm border border-violet-100">
                <i class="fas fa-images"></i>
            </div>
            <div>
                <span class="block text-sm font-bold text-gray-800">
                    <span x-text="form.gallery_photos ? form.gallery_photos.length : 0"></span>/8 Foto
                </span>
                <span class="text-xs text-gray-500">Total foto terupload</span>
            </div>
        </div>

        <button @click="$refs.galleryInput.click()" :disabled="form.gallery_photos && form.gallery_photos.length >= 8"
            class="px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition-all transform hover:scale-105 active:scale-95 flex items-center gap-2"
            :class="form.gallery_photos && form.gallery_photos.length >= 8 
                    ? 'bg-gray-100 text-gray-400 cursor-not-allowed border border-gray-200' 
                    : 'bg-white text-violet-600 border border-violet-200 hover:bg-violet-50 hover:border-violet-300'">
            <i class="fas fa-cloud-upload-alt"></i> Upload Foto
        </button>

        <!-- Hidden Input -->
        <input x-ref="galleryInput" type="file" multiple accept="image/*" class="hidden"
            @change="uploadGalleryImages($event)">
    </div>

    <!-- Limit Warning -->
    <div x-show="form.gallery_photos && form.gallery_photos.length >= 8" x-transition
        class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-xl text-sm flex items-start gap-3">
        <i class="fas fa-exclamation-triangle mt-0.5 text-amber-500"></i>
        <span>Batas maksimal 8 foto telah tercapai. Hapus beberapa foto jika ingin menambahkan yang baru.</span>
    </div>

    <!-- Grid -->
    <div class="min-h-[200px]">
        <template x-if="!form.gallery_photos || form.gallery_photos.length === 0">
            <div class="text-center py-12 bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl group cursor-pointer hover:border-violet-300 hover:bg-violet-50/30 transition-colors"
                @click="$refs.galleryInput.click()">
                <div
                    class="w-16 h-16 bg-white rounded-full shadow-sm flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-image text-gray-300 text-2xl group-hover:text-violet-400"></i>
                </div>
                <h4 class="text-gray-900 font-medium mb-1">Galeri Masih Kosong</h4>
                <p class="text-sm text-gray-400">Klik disini untuk mulai mengupload foto</p>
            </div>
        </template>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4"
            x-show="form.gallery_photos && form.gallery_photos.length > 0">
            <template x-for="(img, index) in form.gallery_photos" :key="index">
                <div
                    class="relative group aspect-[4/5] bg-gray-100 rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition-all">
                    <img :src="img" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">

                    <!-- Overlay -->
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>

                    <!-- Remove Button -->
                    <button @click="removeGalleryPhoto(index)"
                        class="absolute top-2 right-2 w-8 h-8 flex items-center justify-center bg-white/90 text-red-500 rounded-full opacity-0 group-hover:opacity-100 transition-all hover:bg-red-500 hover:text-white shadow-sm transform hover:rotate-90">
                        <i class="fas fa-times"></i>
                    </button>

                    <!-- Index Badge -->
                    <span
                        class="absolute bottom-3 left-3 bg-white/20 backdrop-blur-md text-white border border-white/30 text-[10px] font-bold px-2 py-1 rounded-lg"
                        x-text="'#' + (index + 1)"></span>
                </div>
            </template>
        </div>
    </div>

    <!-- Standard Form Inputs (Hidden) -->
    <template x-for="(img, index) in form.gallery_photos" :key="'input-'+index">
        <input type="hidden" name="gallery_photos[]" :value="img">
    </template>
</div>