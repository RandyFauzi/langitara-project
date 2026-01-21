<section id="gallery" class="py-20 px-6 bg-white" x-data="{ 
    activeSlide: 0, 
    slides: {{ json_encode(array_slice($gallery_images ?? $data['gallery_images'] ?? [], 0, 4)) }},
    gridImages: {{ json_encode(array_slice($gallery_images ?? $data['gallery_images'] ?? [], 4, 4)) }} 
}" x-init="if(slides.length > 1) setInterval(() => { activeSlide = (activeSlide + 1) % slides.length }, 4000)">
    
    <div class="text-center mb-12">
        <h2 class="font-script text-5xl text-amber-600 mb-2">Our Gallery</h2>
        <p class="text-gray-500 italic">Momen bahagia kami</p>
    </div>

    <div class="max-w-4xl mx-auto">
        <!-- 1. Carousel (Top 4 Images) -->
        <template x-if="slides.length > 0">
            <div class="relative w-full aspect-[3/4] md:aspect-[16/9] rounded-2xl overflow-hidden shadow-lg mb-4">
                <template x-for="(slide, index) in slides" :key="index">
                    <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                         :class="activeSlide === index ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                        <img :src="slide" class="w-full h-full object-cover">
                    </div>
                </template>
                
                <!-- Indicators -->
                <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 z-20">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="activeSlide = index" 
                                class="w-2 h-2 rounded-full transition-all"
                                :class="activeSlide === index ? 'bg-white w-6' : 'bg-white/50 hover:bg-white'">
                        </button>
                    </template>
                </div>
            </div>
        </template>

        <!-- 2. Grid (Next 4 Images) -->
        <template x-if="gridImages.length > 0">
            <div class="grid grid-cols-2 gap-2 mt-2">
                <template x-for="(img, index) in gridImages" :key="index">
                    <div class="aspect-square rounded-xl overflow-hidden shadow-sm hover:shadow-md transition">
                         <img :src="img" class="w-full h-full object-cover hover:scale-110 transition duration-700">
                    </div>
                </template>
            </div>
        </template>
    </div>
</section>