<section id="events" class="py-20 px-6 bg-white">
    <div class="text-center mb-16">
        <h2 class="font-script text-5xl text-amber-600 mb-2">Save The Date</h2>
        <p class="text-slate-500 text-sm tracking-wide">WE HOPE YOU CAN JOIN US</p>
    </div>

    <div class="space-y-8 max-w-2xl mx-auto">
        @if(isset($events) && is_array($events))
            @foreach($events as $event)
                <div class="bg-white border border-slate-100 rounded-3xl shadow-lg p-8 relative overflow-hidden group">
                    <!-- Decor -->
                    <div
                        class="absolute -top-10 -right-10 w-32 h-32 bg-amber-50 rounded-full opacity-50 group-hover:scale-150 transition duration-700">
                    </div>

                    <div class="relative z-10 text-center">
                        <h3 class="font-heading text-3xl font-bold text-slate-800 mb-4">{{ $event['title'] ?? 'Event Name' }}
                        </h3>

                        <div class="flex flex-col gap-3 mb-6">
                            <p class="flex items-center justify-center text-slate-600 gap-2">
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span>{{ $event['date_label'] ?? 'Date' }}</span>
                            </p>
                            <p class="flex items-center justify-center text-slate-600 gap-2">
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ $event['time_label'] ?? 'Time' }}</span>
                            </p>
                        </div>

                        <div class="border-t border-slate-100 pt-6">
                            <p class="font-bold text-slate-800 mb-1">{{ $event['location_name'] ?? 'Location' }}</p>
                            <p class="text-sm text-slate-500">
                                {{ $event['address'] ?? 'Alamat lengkap lokasi acara' }}
                            </p>
                        </div>

                        <div class="mt-6">
                            <a href="{{ $event['map_url'] ?? '#' }}" target="_blank"
                                class="inline-block px-6 py-2 bg-slate-800 text-white text-xs font-bold rounded-full hover:bg-amber-600 transition shadow-lg">
                                VIEW LOCATION
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</section>