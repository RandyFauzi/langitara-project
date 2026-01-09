<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-slate-800">Events</h3>
        <button @click="addEvent()"
            class="px-3 py-1.5 text-sm bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 font-medium transition">
            + Add Event
        </button>
    </div>

    <div class="space-y-4">
        <template x-for="(event, index) in (form.events || [])" :key="index">
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm relative group">
                <button @click="removeEvent(index)"
                    class="absolute top-4 right-4 text-slate-400 hover:text-red-500 transition opacity-0 group-hover:opacity-100"
                    title="Remove Event">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-slate-500 mb-1">Nama Acara</label>
                        <input type="text" x-model="event.title"
                            class="w-full rounded border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Akad Nikah / Resepsi">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Tanggal</label>
                        <input type="date" x-model="event.date" class="w-full rounded border-slate-300 text-sm">
                    </div>

                    <div class="flex gap-2">
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-slate-500 mb-1">Jam Mulai</label>
                            <input type="time" x-model="event.time_start"
                                class="w-full rounded border-slate-300 text-sm">
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-slate-500 mb-1">Selesai</label>
                            <input type="time" x-model="event.time_end" class="w-full rounded border-slate-300 text-sm">
                        </div>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-slate-500 mb-1">Nama Lokasi</label>
                        <input type="text" x-model="event.location_name"
                            class="w-full rounded border-slate-300 text-sm">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-slate-500 mb-1">Alamat Lengkap</label>
                        <textarea x-model="event.address" rows="2"
                            class="w-full rounded border-slate-300 text-sm"></textarea>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-slate-500 mb-1">Google/Waze Map URL</label>
                        <input type="text" x-model="event.map_url"
                            class="w-full rounded border-slate-300 text-sm text-slate-600">
                    </div>
                </div>

                <!-- Sort Order Controls (Optional improvement if needed later) -->
                <div class="flex items-center gap-2 mt-3 pt-3 border-t border-slate-100">
                    <button @click="moveItem('events', index, -1)"
                        class="text-xs text-slate-400 hover:text-indigo-600 font-medium">Move Up</button>
                    <button @click="moveItem('events', index, 1)"
                        class="text-xs text-slate-400 hover:text-indigo-600 font-medium">Move Down</button>
                </div>
            </div>
        </template>

        <!-- Empty State -->
        <div x-show="!form.events || form.events.length === 0"
            class="text-center py-8 bg-slate-50 rounded-lg border border-dashed border-slate-300">
            <p class="text-slate-500 text-sm">Belum ada acara ditambahkan</p>
        </div>
    </div>
</div>