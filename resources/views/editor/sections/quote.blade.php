<div class="space-y-6">
    <!-- Header with Toggle -->
    <div class="flex justify-between items-center border-b border-gray-100 pb-4">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Quote / Kutipan</h3>
            <p class="text-xs text-gray-500">Kata-kata mutiara atau ayat suci.</p>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" x-model="form.active_sections" value="quote" class="sr-only peer">
            <div
                class="w-11 h-6 bg-gray-200 peer-focus:outline-none ring-0 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-violet-400 peer-checked:to-blue-400">
            </div>
            <span class="ms-3 text-sm font-medium text-gray-700"
                x-text="form.active_sections.includes('quote') ? 'Aktif' : 'Non-aktif'"></span>
        </label>
    </div>

    <!-- Preset Selector -->
    <div class="p-4 bg-violet-50/50 rounded-xl border border-violet-100">
        <label class="block text-sm font-bold text-gray-800 mb-2 flex items-center gap-2">
            <i class="fas fa-magic text-violet-500"></i> Pilih Preset (Opsional)
        </label>
        <div class="relative">
            <select @change="applyQuotePreset($event.target.value)"
                class="w-full pl-4 pr-10 py-3 appearance-none bg-white border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-violet-100 focus:border-violet-400 outline-none transition text-sm text-gray-700 cursor-pointer">
                <option value="">-- Pilih Template Kutipan --</option>
                <option value="islam">Islam (QS. Ar-Rum: 21)</option>
                <option value="kristen">Kristen/Katolik (Matius 19:6)</option>
                <option value="hindu">Hindu (Manawa Dharmasastra)</option>
                <option value="buddha">Buddha (Dhammapada)</option>
                <option value="konghucu">Konghucu (Tengah Sempurna)</option>
                <option value="umum">Umum (Puitis)</option>
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                <i class="fas fa-chevron-down text-xs"></i>
            </div>
        </div>
        <p class="text-xs text-gray-400 mt-2 italic ml-1">*Memilih preset akan otomatis mengisi kolom dibawah ini.</p>
    </div>

    <!-- Text Input -->
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Isi Kutipan</label>
        <textarea name="quote_text" x-model="form.quote_text" @input.debounce.1000ms="autoSave()" rows="5"
            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-violet-100 focus:border-violet-400 outline-none transition text-gray-800 resize-none leading-relaxed"
            placeholder="Contoh: Dan di antara tanda-tanda kekuasaan-Nya..."></textarea>
    </div>

    <!-- Author Input -->
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Sumber / Penulis</label>
        <div class="relative">
            <input type="text" name="quote_author" x-model="form.quote_author" @input.debounce.1000ms="autoSave()"
                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-violet-100 focus:border-violet-400 outline-none transition text-gray-800"
                placeholder="Contoh: QS. Ar-Rum: 21">
            <i class="fas fa-pen-nib absolute right-4 top-3.5 text-gray-300"></i>
        </div>
    </div>
</div>