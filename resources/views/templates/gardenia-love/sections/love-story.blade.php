<section id="love-story" class="py-20 px-6 bg-white">
    <div class="text-center mb-16">
        <h2 class="font-script text-5xl text-amber-600 mb-2">Our Love Story</h2>
        <p class="text-slate-500 text-sm tracking-wide">A JOURNEY TO FOREVER</p>
    </div>

    <div class="relative space-y-12">
        <!-- Vertical Line -->
        <div class="absolute left-8 md:left-1/2 top-0 bottom-0 w-px bg-amber-200 -z-10"></div>

        @if(isset($love_story) && is_array($love_story))
            @foreach($love_story as $index => $story)
                <div
                    class="relative flex items-start gap-6 md:gap-0 {{ $index % 2 == 0 ? 'md:flex-row' : 'md:flex-row-reverse' }}">

                    <!-- Date Badge -->
                    <div
                        class="absolute left-8 md:left-1/2 transform -translate-x-1/2 w-4 h-4 rounded-full bg-amber-400 border-4 border-white shadow">
                    </div>

                    <!-- Content -->
                    <div
                        class="ml-12 md:ml-0 w-full md:w-1/2 {{ $index % 2 == 0 ? 'md:pr-12 md:text-right' : 'md:pl-12 md:text-left' }}">
                        <div class="bg-slate-50 p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition">
                            <span
                                class="inline-block px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full mb-2">
                                {{ $story['year'] }}
                            </span>
                            <h4 class="font-heading text-xl font-bold text-slate-800 mb-2">{{ $story['title'] }}</h4>
                            <p class="text-sm text-slate-600 leading-relaxed">
                                {{ $story['story'] }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

    </div>
</section>