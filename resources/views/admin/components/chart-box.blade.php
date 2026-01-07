<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 h-full">
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-bold text-gray-800 text-lg">{{ $title ?? 'Chart' }}</h3>
        <button class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                </path>
            </svg>
        </button>
    </div>
    <div class="relative">
        {{ $slot }}
    </div>
</div>