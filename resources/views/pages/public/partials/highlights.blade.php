<section class="bg-white py-12 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Main Highlights -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-50 transition-colors"
                data-aos="fade-up" data-aos-delay="0">
                <div
                    class="w-12 h-12 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-serif font-bold text-charcoal">Cepat & Mudah</h3>
                    <p class="text-sm text-gray-500">Selesai dalam < 10 menit.</p>
                </div>
            </div>
            <div class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-50 transition-colors"
                data-aos="fade-up" data-aos-delay="100">
                <div
                    class="w-12 h-12 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-serif font-bold text-charcoal">Desain Premium</h3>
                    <p class="text-sm text-gray-500">Eksklusif & Professional.</p>
                </div>
            </div>
            <div class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-50 transition-colors"
                data-aos="fade-up" data-aos-delay="200">
                <div
                    class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-serif font-bold text-charcoal">Fitur Lengkap</h3>
                    <p class="text-sm text-gray-500">RSVP, Maps, Gallery, dll.</p>
                </div>
            </div>
        </div>

        <!-- Marquee / Auto Slide -->
        <div class="overflow-hidden relative w-full mask-gradient-x">
            <div
                class="flex space-x-12 animate-marquee items-center opacity-60 grayscale hover:grayscale-0 transition-all duration-500">
                <!-- Placeholders -->
                <span class="text-xl font-serif font-bold text-gray-400 whitespace-nowrap">Wedding Organizer Top</span>
                <span class="text-xl font-serif font-bold text-gray-400 whitespace-nowrap">Luxury Events</span>
                <span class="text-xl font-serif font-bold text-gray-400 whitespace-nowrap">Bridestory</span>
                <span class="text-xl font-serif font-bold text-gray-400 whitespace-nowrap">Weddingku</span>
                <span class="text-xl font-serif font-bold text-gray-400 whitespace-nowrap">The Bride Dept</span>
                <!-- Duplicate for loop effect -->
                <span class="text-xl font-serif font-bold text-gray-400 whitespace-nowrap">Wedding Organizer Top</span>
                <span class="text-xl font-serif font-bold text-gray-400 whitespace-nowrap">Luxury Events</span>
                <span class="text-xl font-serif font-bold text-gray-400 whitespace-nowrap">Bridestory</span>
            </div>
        </div>
    </div>

    <style>
        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .animate-marquee {
            animation: marquee 20s linear infinite;
        }

        .mask-gradient-x {
            -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
            mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
        }
    </style>
</section>