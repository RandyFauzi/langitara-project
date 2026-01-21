<div x-data="{ activeCoupleTab: 'groom' }" class="space-y-6">
    <!-- Header with Toggle -->
    <div class="flex justify-between items-center border-b border-gray-100 pb-4">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Profil Mempelai</h3>
            <p class="text-xs text-gray-500">Data diri mempelai pria dan wanita.</p>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" x-model="form.active_sections" value="couple" class="sr-only peer">
            <div
                class="w-11 h-6 bg-gray-200 peer-focus:outline-none ring-0 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-violet-400 peer-checked:to-blue-400">
            </div>
            <span class="ms-3 text-sm font-medium text-gray-700"
                x-text="form.active_sections.includes('couple') ? 'Aktif' : 'Non-aktif'"></span>
        </label>
    </div>

    <!-- Tab Navigation -->
    <div class="flex p-1 space-x-1 bg-gray-100/50 rounded-xl">
        <button @click="activeCoupleTab = 'groom'"
            :class="activeCoupleTab === 'groom' ? 'bg-white shadow-sm text-indigo-900 font-semibold' : 'text-gray-500 hover:text-gray-700'"
            class="flex-1 py-2.5 text-sm rounded-lg transition-all flex items-center justify-center gap-2">
            <i class="fas fa-mars text-blue-500"></i> Mempelai Pria
        </button>
        <button @click="activeCoupleTab = 'bride'"
            :class="activeCoupleTab === 'bride' ? 'bg-white shadow-sm text-pink-900 font-semibold' : 'text-gray-500 hover:text-gray-700'"
            class="flex-1 py-2.5 text-sm rounded-lg transition-all flex items-center justify-center gap-2">
            <i class="fas fa-venus text-pink-500"></i> Mempelai Wanita
        </button>
    </div>

    <!-- Groom Content -->
    <div x-show="activeCoupleTab === 'groom'" x-transition:enter.opacity.duration.300ms class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="groom_name" x-model="form.groom_name" @input.debounce.1000ms="autoSave()"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 outline-none transition text-gray-800"
                    placeholder="Contoh: Sasuke Uchiha">
            </div>

            <!-- Nickname -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Panggilan</label>
                <input type="text" name="groom_nickname" x-model="form.groom_nickname"
                    @input.debounce.1000ms="autoSave()"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 outline-none transition text-gray-800"
                    placeholder="Contoh: Sasuke">
            </div>

            <!-- Parent Label -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Ayah</label>
                <input type="text" name="groom_father" x-model="form.groom_father" @input.debounce.1000ms="autoSave()"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 outline-none transition text-gray-800"
                    placeholder="Nama Ayah">
            </div>

            <!-- Mother -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Ibu</label>
                <input type="text" name="groom_mother" x-model="form.groom_mother" @input.debounce.1000ms="autoSave()"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 outline-none transition text-gray-800"
                    placeholder="Nama Ibu">
            </div>

            <!-- Photo Upload -->
            <div
                class="md:col-span-2 p-5 bg-blue-50/50 rounded-2xl border border-blue-100 border-dashed hover:border-blue-300 transition-colors group">
                <label class="block text-sm font-semibold text-blue-900 mb-3">Foto Mempelai Pria</label>
                <div class="flex items-center gap-5">
                    <div class="w-20 h-20 flex-shrink-0 bg-white rounded-full shadow-sm border border-blue-100 flex items-center justify-center overflow-hidden relative cursor-pointer group-hover:shadow-md transition"
                        @click="$refs.groomPhoto.click()">
                        <template x-if="form.groom_photo">
                            <img :src="form.groom_photo" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!form.groom_photo">
                            <i class="fas fa-user text-blue-200 text-2xl"></i>
                        </template>
                        <div
                            class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 hover:opacity-100 transition">
                            <i class="fas fa-camera text-white"></i>
                        </div>
                    </div>
                    <div>
                        <input x-ref="groomPhoto" type="file" @change="uploadImage($event, 'groom_photo')"
                            class="hidden" accept="image/*">
                        <button @click="$refs.groomPhoto.click()"
                            class="text-sm px-4 py-2 bg-white border border-blue-200 text-blue-700 rounded-lg hover:bg-blue-50 transition font-medium shadow-sm">
                            Upload Foto
                        </button>
                        <p class="text-xs text-blue-400 mt-2">Format Square (1:1) disarankan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bride Content -->
    <div x-show="activeCoupleTab === 'bride'" x-transition:enter.opacity.duration.300ms class="space-y-6" x-cloak>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="bride_name" x-model="form.bride_name" @input.debounce.1000ms="autoSave()"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-pink-100 focus:border-pink-400 outline-none transition text-gray-800"
                    placeholder="Contoh: Sakura Haruno">
            </div>

            <!-- Nickname -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Panggilan</label>
                <input type="text" name="bride_nickname" x-model="form.bride_nickname"
                    @input.debounce.1000ms="autoSave()"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-pink-100 focus:border-pink-400 outline-none transition text-gray-800"
                    placeholder="Contoh: Sakura">
            </div>

            <!-- Parent Label -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Ayah</label>
                <input type="text" name="bride_father" x-model="form.bride_father" @input.debounce.1000ms="autoSave()"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-pink-100 focus:border-pink-400 outline-none transition text-gray-800"
                    placeholder="Nama Ayah">
            </div>

            <!-- Mother -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Ibu</label>
                <input type="text" name="bride_mother" x-model="form.bride_mother" @input.debounce.1000ms="autoSave()"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-pink-100 focus:border-pink-400 outline-none transition text-gray-800"
                    placeholder="Nama Ibu">
            </div>

            <!-- Photo Upload -->
            <div
                class="md:col-span-2 p-5 bg-pink-50/50 rounded-2xl border border-pink-100 border-dashed hover:border-pink-300 transition-colors group">
                <label class="block text-sm font-semibold text-pink-900 mb-3">Foto Mempelai Wanita</label>
                <div class="flex items-center gap-5">
                    <div class="w-20 h-20 flex-shrink-0 bg-white rounded-full shadow-sm border border-pink-100 flex items-center justify-center overflow-hidden relative cursor-pointer group-hover:shadow-md transition"
                        @click="$refs.bridePhoto.click()">
                        <template x-if="form.bride_photo">
                            <img :src="form.bride_photo" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!form.bride_photo">
                            <i class="fas fa-user text-pink-200 text-2xl"></i>
                        </template>
                        <div
                            class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 hover:opacity-100 transition">
                            <i class="fas fa-camera text-white"></i>
                        </div>
                    </div>
                    <div>
                        <input x-ref="bridePhoto" type="file" @change="uploadImage($event, 'bride_photo')"
                            class="hidden" accept="image/*">
                        <button @click="$refs.bridePhoto.click()"
                            class="text-sm px-4 py-2 bg-white border border-pink-200 text-pink-700 rounded-lg hover:bg-pink-50 transition font-medium shadow-sm">
                            Upload Foto
                        </button>
                        <p class="text-xs text-pink-400 mt-2">Format Square (1:1) disarankan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>