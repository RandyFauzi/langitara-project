<section id="gallery" class="py-20 px-6 bg-white">
    <div class="text-center mb-12">
        <h2 class="font-script text-5xl text-amber-600 mb-2">Our Gallery</h2>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
        @if(isset($gallery) && is_array($gallery))
            @foreach($gallery as $index => $image)
                <div class="relative group aspect-square rounded-xl overflow-hidden cursor-pointer">
                    <img src="{{ $image }}" loading="lazy"
                        class="w-full h-full object-cover transition duration-700 transform group-hover:scale-110"
                        alt="Gallery Image {{ $index + 1 }}">

                    <div
                        class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                        </svg>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</section>