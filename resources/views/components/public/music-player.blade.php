@props(['invitation'])

<div x-data="{ 
    showEmbed: false,
    toggleEmbed() {
        this.showEmbed = !this.showEmbed;
    }
}" class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-2">

    <!-- Case 1: Custom Music (Embed) -->
    @if($invitation->music)
        <!-- Floating Embed Container (Toggled) -->
        <div x-show="showEmbed" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95"
            class="bg-white/90 backdrop-blur-md p-2 rounded-xl shadow-2xl border border-white/50 w-64 md:w-80 origin-bottom-right"
            style="display: none;">

            <div class="flex justify-between items-center mb-2 px-1">
                <span class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Music Player</span>
                <button @click="showEmbed = false" class="text-gray-400 hover:text-red-500 transition"><i
                        class="fas fa-times"></i></button>
            </div>

            <div class="rounded-lg overflow-hidden bg-black aspect-video relative">
                @if($invitation->music->provider === 'spotify')
                    <iframe src="{{ $invitation->music->embed_url }}" width="100%" height="152" frameBorder="0"
                        allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                        loading="lazy"></iframe>
                @elseif($invitation->music->provider === 'soundcloud')
                    <iframe width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay"
                        src="{{ $invitation->music->embed_url }}"></iframe>
                @else
                    <!-- YouTube -->
                    <iframe src="{{ $invitation->music->embed_url }}" class="absolute inset-0 w-full h-full" frameborder="0"
                        allow="autoplay; encrypted-media" allowfullscreen></iframe>
                @endif
            </div>
        </div>

        <!-- Toggle Button -->
        <button @click="toggleEmbed()"
            class="w-14 h-14 rounded-full shadow-2xl flex items-center justify-center overflow-hidden transition-transform hover:scale-110 bg-white/10 backdrop-blur-sm p-0.5 border border-white/20 relative group">

            <!-- Icon for Provider -->
            <div
                class="absolute inset-0 bg-white/80 opacity-0 group-hover:opacity-100 transition flex items-center justify-center z-10">
                @if($invitation->music->provider === 'spotify')
                    <i class="fab fa-spotify text-2xl text-green-500"></i>
                @elseif($invitation->music->provider === 'soundcloud')
                    <i class="fab fa-soundcloud text-2xl text-orange-500"></i>
                @else
                    <i class="fab fa-youtube text-2xl text-red-500"></i>
                @endif
            </div>

            <img src="{{ asset('images/icons/vinyl.png') }}"
                class="w-full h-full object-cover rounded-full animate-spin-slow" style="animation-duration: 4s;">
        </button>

        <!-- Case 2: Library Music (Standard Audio) -->
    @elseif($invitation->music_path)
        <audio x-ref="player" loop src="{{ asset($invitation->music_path) }}"></audio>
        <button @click="toggleAudio()"
            class="w-14 h-14 rounded-full shadow-2xl flex items-center justify-center overflow-hidden transition-transform hover:scale-110 bg-white/10 backdrop-blur-sm p-0.5 border border-white/20">
            <img src="{{ asset('images/icons/vinyl.png') }}" class="w-full h-full object-cover rounded-full"
                :class="isPlaying ? 'animate-spin-slow' : ''" style="animation-duration: 4s;">
        </button>
    @endif
</div>