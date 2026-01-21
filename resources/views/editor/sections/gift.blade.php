<div class="space-y-6"
    x-init="if(!form.bank_accounts || form.bank_accounts.length === 0) form.bank_accounts = [{ bank_name: '', account_number: '', account_name: '' }]">

    <div class="flex justify-between items-center border-b border-gray-100 pb-4">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Kado Digital</h3>
            <p class="text-xs text-gray-500">Rekening & alamat untuk penerimaan kado dari tamu.</p>
        </div>

        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" x-model="form.active_sections" value="gift" class="sr-only peer">
            <div
                class="w-11 h-6 bg-gray-200 peer-focus:outline-none ring-0 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-violet-400 peer-checked:to-blue-400">
            </div>
            <span class="ms-3 text-sm font-medium text-gray-700"
                x-text="form.active_sections.includes('gift') ? 'Aktif' : 'Non-aktif'"></span>
        </label>
    </div>

    <!-- Active State -->
    <div x-show="form.active_sections.includes('gift')" class="space-y-6" x-transition>
        <!-- Single Bank Account Section -->
        <div class="bg-violet-50/50 p-5 rounded-2xl border border-violet-100">
            <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-credit-card text-violet-500"></i> Informasi Rekening
            </h4>

            <template x-if="form.bank_accounts && form.bank_accounts.length > 0">
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Nama
                            Bank / E-Wallet</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i
                                    class="fas fa-university text-xs"></i></span>
                            <input type="text" x-model="form.bank_accounts[0].bank_name"
                                @input.debounce.1000ms="autoSave()" placeholder="BCA / Mandiri / GoPay"
                                class="w-full pl-9 pr-4 py-2.5 rounded-xl border-gray-200 bg-white focus:border-violet-400 focus:ring-4 focus:ring-violet-100 transition-all text-sm shadow-sm placeholder-gray-300">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Nomor
                                Rekening</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i
                                        class="fas fa-hashtag text-xs"></i></span>
                                <input type="text" x-model="form.bank_accounts[0].account_number"
                                    @input.debounce.1000ms="autoSave()" placeholder="1234xxxx"
                                    class="w-full pl-9 pr-4 py-2.5 rounded-xl border-gray-200 bg-white focus:border-violet-400 focus:ring-4 focus:ring-violet-100 transition-all text-sm shadow-sm placeholder-gray-300 font-mono">
                            </div>
                        </div>
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Atas
                                Nama</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i
                                        class="fas fa-user text-xs"></i></span>
                                <input type="text" x-model="form.bank_accounts[0].account_name"
                                    @input.debounce.1000ms="autoSave()" placeholder="Nama Pemilik"
                                    class="w-full pl-9 pr-4 py-2.5 rounded-xl border-gray-200 bg-white focus:border-violet-400 focus:ring-4 focus:ring-violet-100 transition-all text-sm shadow-sm placeholder-gray-300">
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Gift Address Section -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200">
            <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-gift text-pink-500"></i> Alamat Kirim Kado (Fisik)
            </h4>
            <div class="relative">
                <textarea name="gift_address" x-model="form.gift_address" @input.debounce.1000ms="autoSave()" rows="3"
                    placeholder="Masukkan alamat lengkap penerima kado..."
                    class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-violet-400 focus:ring-4 focus:ring-violet-100 transition-all text-sm shadow-sm resize-none placeholder-gray-400"></textarea>
                <div class="absolute bottom-3 right-3 text-gray-300">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
            </div>
            <p class="text-[10px] text-gray-400 mt-2 flex items-center gap-1">
                <i class="fas fa-info-circle"></i> Alamat ini akan ditampilkan bagi tamu yang ingin mengirim kado fisik.
            </p>
        </div>
    </div>
</div>