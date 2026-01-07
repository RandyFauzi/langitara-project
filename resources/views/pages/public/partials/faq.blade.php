<section class="section-padding bg-white" id="faq">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="font-serif text-4xl font-bold text-charcoal mb-4">Sering Ditanyakan</h2>
        </div>

        <div class="space-y-4" x-data="{ active: null }">
            <!-- FAQ 1 -->
            <div class="border border-gray-200 rounded-xl overflow-hidden" data-aos="fade-up" data-aos-delay="0">
                <button @click="active = (active === 1 ? null : 1)"
                    class="w-full text-left px-6 py-4 bg-gray-50 hover:bg-gray-100 transition-colors flex justify-between items-center">
                    <span class="font-bold text-charcoal">Apakah bisa edit data setelah undangan jadi?</span>
                    <svg class="w-5 h-5 transform transition-transform" :class="{ 'rotate-180': active === 1 }"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="active === 1" x-collapse class="px-6 py-4 text-gray-600 bg-white">
                    Ya, Anda bisa mengedit data undangan kapan saja selama masa aktif paket masih berlaku tanpa biaya
                    tambahan.
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="border border-gray-200 rounded-xl overflow-hidden" data-aos="fade-up" data-aos-delay="50">
                <button @click="active = (active === 2 ? null : 2)"
                    class="w-full text-left px-6 py-4 bg-gray-50 hover:bg-gray-100 transition-colors flex justify-between items-center">
                    <span class="font-bold text-charcoal">Berapa lama masa aktif undangan?</span>
                    <svg class="w-5 h-5 transform transition-transform" :class="{ 'rotate-180': active === 2 }"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="active === 2" x-collapse class="px-6 py-4 text-gray-600 bg-white">
                    Tergantung paket yang Anda pilih. Paket Free 3 hari, Premium 6 bulan, dan Exclusive selamanya
                    (lifetime).
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="border border-gray-200 rounded-xl overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                <button @click="active = (active === 3 ? null : 3)"
                    class="w-full text-left px-6 py-4 bg-gray-50 hover:bg-gray-100 transition-colors flex justify-between items-center">
                    <span class="font-bold text-charcoal">Apakah data tamu aman?</span>
                    <svg class="w-5 h-5 transform transition-transform" :class="{ 'rotate-180': active === 3 }"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="active === 3" x-collapse class="px-6 py-4 text-gray-600 bg-white">
                    Kami sangat menjaga privasi data Anda. Data tamu hanya bisa diakses oleh Anda dan tidak akan kami
                    bagikan ke pihak ketiga.
                </div>
            </div>
        </div>
    </div>
</section>