<div class="space-y-10">
    <!-- Header with Toggle -->
    <div class="flex justify-between items-center border-b border-gray-100 pb-4">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Rangkaian Acara</h3>
            <p class="text-xs text-gray-500">Jadwal dan lokasi acara pernikahan.</p>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" x-model="form.active_sections" value="events" class="sr-only peer">
            <div
                class="w-11 h-6 bg-gray-200 peer-focus:outline-none ring-0 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-violet-400 peer-checked:to-blue-400">
            </div>
            <span class="ms-3 text-sm font-medium text-gray-700"
                x-text="form.active_sections.includes('events') ? 'Aktif' : 'Non-aktif'"></span>
        </label>
    </div>

    <!-- Event 1 (Akad) -->
    <div class="relative pl-8 border-l-2 border-violet-100">
        <!-- Badge -->
        <span
            class="absolute -left-[17px] top-0 flex h-8 w-8 items-center justify-center rounded-full bg-violet-100 ring-4 ring-white">
            <span class="text-sm font-bold text-violet-600">1</span>
        </span>

        <h4 class="text-lg font-bold text-gray-800 mb-6">Akad Nikah / Pemberkatan</h4>

        <div class="space-y-5">
            <!-- Date & Time -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal & Waktu</label>
                <div class="relative">
                    <input type="datetime-local" name="akad_date" x-model="form.akad_date"
                        @input.debounce.1000ms="autoSave()"
                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-violet-100 focus:border-violet-400 outline-none transition text-gray-800">
                    <i class="fas fa-calendar absolute left-4 top-3.5 text-gray-400"></i>
                </div>
            </div>

            <!-- Location -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lokasi / Gedung</label>
                <input type="text" name="akad_location" x-model="form.akad_location" @input.debounce.1000ms="autoSave()"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-violet-100 focus:border-violet-400 outline-none transition text-gray-800"
                    placeholder="Contoh: Masjid Agung Al-Azhar">
            </div>

            <!-- Address -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap</label>
                <textarea name="akad_address" x-model="form.akad_address" @input.debounce.1000ms="autoSave()" rows="3"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-violet-100 focus:border-violet-400 outline-none transition text-gray-800 resize-none"
                    placeholder="Jl. Sisingamangaraja No.1, Kebayoran Baru..."></textarea>
            </div>

            <!-- Maps -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Link Google Maps</label>
                <div class="flex gap-2">
                    <div class="relative flex-1">
                        <input type="url" name="akad_map_link" x-model="form.akad_map_link"
                            @input.debounce.1000ms="autoSave()"
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-violet-100 focus:border-violet-400 outline-none transition text-gray-800"
                            placeholder="https://goo.gl/maps/...">
                        <i class="fas fa-map-marker-alt absolute left-4 top-3.5 text-gray-400"></i>
                    </div>
                    <a :href="form.akad_map_link" target="_blank" x-show="form.akad_map_link"
                        class="px-4 bg-white border border-gray-200 text-gray-600 rounded-xl hover:bg-gray-50 hover:text-violet-600 transition flex items-center justify-center shadow-sm">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Event 2 (Resepsi) -->
    <div class="relative pl-8 border-l-2 border-blue-100" x-data="{ 
            sameAsAkad: false,
            syncLocation() {
                if (this.sameAsAkad) {
                    this.form.resepsi_location = this.form.akad_location;
                    this.form.resepsi_address = this.form.akad_address;
                    this.form.resepsi_map_link = this.form.akad_map_link;
                    this.autoSave();
                }
            },
            init() {
                // Auto-detect if same
                if (this.form.resepsi_location && this.form.resepsi_location === this.form.akad_location && this.form.akad_location !== '') {
                    this.sameAsAkad = true;
                }
                
                // Watch for toggle change
                this.$watch('sameAsAkad', (val) => {
                    if (val) this.syncLocation();
                });

                // Watch for source changes
                this.$watch('form.akad_location', () => this.syncLocation());
                this.$watch('form.akad_address', () => this.syncLocation());
                this.$watch('form.akad_map_link', () => this.syncLocation());
            }
         }">

        <!-- Badge -->
        <span
            class="absolute -left-[17px] top-0 flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 ring-4 ring-white">
            <span class="text-sm font-bold text-blue-600">2</span>
        </span>

        <h4 class="text-lg font-bold text-gray-800 mb-6">Resepsi Pernikahan</h4>

        <div class="space-y-5">
            <!-- Date & Time -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal & Waktu</label>
                <div class="relative">
                    <input type="datetime-local" name="resepsi_date" x-model="form.resepsi_date"
                        @input.debounce.1000ms="autoSave()"
                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 outline-none transition text-gray-800">
                    <i class="fas fa-calendar absolute left-4 top-3.5 text-gray-400"></i>
                </div>
            </div>

            <!-- Same Location Toggle -->
            <div class="bg-blue-50/50 p-4 rounded-xl flex items-center justify-between border border-blue-100">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white rounded-lg text-blue-500 shadow-sm"><i class="fas fa-map-signs"></i></div>
                    <span class="text-sm font-medium text-blue-800">Lokasi & Alamat sama dengan Akad?</span>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" x-model="sameAsAkad" class="sr-only peer">
                    <div
                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none ring-0 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                    </div>
                </label>
            </div>

            <div x-show="sameAsAkad" x-transition.opacity class="py-4 text-center text-gray-400 text-sm italic">
                Data lokasi disamakan dengan acara Akad Nikah.
            </div>

            <div x-show="!sameAsAkad" x-transition class="space-y-5">
                <!-- Location -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lokasi / Gedung</label>
                    <input type="text" name="resepsi_location" x-model="form.resepsi_location"
                        @input.debounce.1000ms="autoSave()"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 outline-none transition text-gray-800"
                        placeholder="Contoh: Ballroom Hotel Mulia">
                </div>

                <!-- Address -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap</label>
                    <textarea name="resepsi_address" x-model="form.resepsi_address" @input.debounce.1000ms="autoSave()"
                        rows="3"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 outline-none transition text-gray-800 resize-none"
                        placeholder="Jl. Asia Afrika..."></textarea>
                </div>

                <!-- Maps -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Link Google Maps</label>
                    <div class="flex gap-2">
                        <div class="relative flex-1">
                            <input type="url" name="resepsi_map_link" x-model="form.resepsi_map_link"
                                @input.debounce.1000ms="autoSave()"
                                class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 outline-none transition text-gray-800"
                                placeholder="https://goo.gl/maps/...">
                            <i class="fas fa-map-marker-alt absolute left-4 top-3.5 text-gray-400"></i>
                        </div>
                        <a :href="form.resepsi_map_link" target="_blank" x-show="form.resepsi_map_link"
                            class="px-4 bg-white border border-gray-200 text-gray-600 rounded-xl hover:bg-gray-50 hover:text-violet-600 transition flex items-center justify-center shadow-sm">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>