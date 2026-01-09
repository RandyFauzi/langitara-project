<div class="h-full flex flex-col">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-slate-200 bg-white flex items-center justify-between">
        <h2 class="text-xl font-bold text-slate-800">Daftar Tamu</h2>
        <div class="flex items-center gap-3">
            <button @click="addGuest"
                class="flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                + Tambah Tamu
            </button>
        </div>
    </div>

    <!-- Stats Bar -->
    <div class="bg-indigo-50 px-6 py-3 border-b border-indigo-100 flex items-center gap-6 text-sm text-indigo-900">
        <div>
            <span class="font-bold text-indigo-700" x-text="form.guests.length"></span> Tamu
        </div>
    </div>

    <!-- Content Scroller -->
    <div class="flex-1 overflow-y-auto p-6">

        <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500">
                    <tr>
                        <th class="px-4 py-3 font-medium">Nama Tamu</th>
                        <th class="px-4 py-3 font-medium">Nomor WhatsApp</th>
                        <th class="px-4 py-3 font-medium w-24">Kategori</th>
                        <th class="px-4 py-3 font-medium w-16 text-center">Pax</th>
                        <th class="px-4 py-3 font-medium w-16"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <template x-for="(guest, index) in form.guests" :key="index">
                        <tr class="group hover:bg-slate-50 transition">
                            <td class="px-4 py-2">
                                <input type="text" x-model="guest.name"
                                    class="w-full bg-transparent border-none p-0 focus:ring-0 font-medium text-slate-800 placeholder-slate-400"
                                    placeholder="Nama Tamu">
                            </td>
                            <td class="px-4 py-2">
                                <input type="text" x-model="guest.phone"
                                    class="w-full bg-transparent border-none p-0 focus:ring-0 text-slate-600 placeholder-slate-400"
                                    placeholder="08...">
                            </td>
                            <td class="px-4 py-2">
                                <select x-model="guest.category"
                                    class="w-full bg-transparent border-none p-0 focus:ring-0 text-slate-600 text-xs">
                                    <option value="Umum">Umum</option>
                                    <option value="VIP">VIP</option>
                                    <option value="VVIP">VVIP</option>
                                    <option value="Keluarga">Keluarga</option>
                                </select>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <input type="number" x-model="guest.pax" min="1"
                                    class="w-full bg-transparent border-none p-0 focus:ring-0 text-center text-slate-600">
                            </td>
                            <td class="px-4 py-2 text-right">
                                <button @click="removeGuest(index)"
                                    class="text-slate-300 hover:text-red-500 transition p-1">
                                    Del
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>

            <div x-show="form.guests.length === 0" class="p-12 text-center text-slate-400">
                <p>Belum ada tamu.</p>
            </div>
        </div>

    </div>
</div>