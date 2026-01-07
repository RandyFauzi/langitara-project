<footer class="bg-[#2C3338] text-white pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
            <!-- Brand -->
            <div class="col-span-1 md:col-span-1">
                <h3 class="font-serif text-2xl font-bold tracking-wider mb-4">LANGITARA</h3>
                <p class="text-gray-400 text-sm leading-relaxed mb-6">
                    Platform undangan digital premium untuk momen spesial Anda. Desain elegan, fitur lengkap, dan
                    pengalaman tak terlupakan.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors"><span
                            class="sr-only">Instagram</span><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors"><span
                            class="sr-only">Facebook</span><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors"><span
                            class="sr-only">Twitter</span><i class="fab fa-twitter"></i></a>
                </div>
            </div>

            <!-- Links -->
            <div>
                <h4 class="text-lg font-serif mb-6">Navigasi</h4>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li><a href="{{ route('public.home') }}" class="hover:text-white transition-colors">Beranda</a></li>
                    <li><a href="{{ route('public.templates.index') }}"
                            class="hover:text-white transition-colors">Katalog Template</a></li>
                    <li><a href="{{ route('public.pricing') }}" class="hover:text-white transition-colors">Paket &
                            Harga</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h4 class="text-lg font-serif mb-6">Bantuan</h4>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li><a href="#" class="hover:text-white transition-colors">FAQ</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Hubungi Kami</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="text-lg font-serif mb-6">Kontak</h4>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li>hello@langitara.com</li>
                    <li>+62 812 3456 7890</li>
                    <li>Jakarta, Indonesia</li>
                </ul>
            </div>
        </div>

        <div
            class="border-t border-gray-700 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
            <p>&copy; {{ date('Y') }} Langitara. All rights reserved.</p>
            <p>Made with ❤️ for Weddings</p>
        </div>
    </div>
</footer>