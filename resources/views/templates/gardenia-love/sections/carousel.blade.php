<section id="highlight" class="py-20 bg-[#FDFBF7] overflow-hidden">
    <div class="text-center mb-10">
        <h2 class="font-script text-5xl text-amber-600 mb-2">Moments</h2>
        <p class="text-slate-500 text-sm tracking-wide">CAPTURED MEMORIES</p>
    </div>

    <!-- Scrolling Container -->
    <div class="flex space-x-4 overflow-x-auto pb-8 px-6 snap-x snap-mandatory scrollbar-hide">
        @if(isset($data['gallery']) && is_array($data['gallery']))
            @foreach(array_slice($data['gallery'], 0, 5) as $image)
                <div class="flex-none w-72 aspect-[3/4] rounded-2xl overflow-hidden shadow-lg snap-center">
                    <img src="{{ $image }}" alt="Moment"
                        class="w-full h-full object-cover transform hover:scale-110 transition duration-700">
                </div>
            @endforeach
        @endif
    </div>
</section>