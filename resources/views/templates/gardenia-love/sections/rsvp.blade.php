<section id="rsvp" class="py-20 px-6 bg-[#FDFBF7]">
    <div class="max-w-xl mx-auto bg-white rounded-3xl shadow-xl p-8 border border-slate-100">
        <div class="text-center mb-8">
            <h2 class="font-script text-4xl text-amber-600 mb-2">RSVP</h2>
            <p class="text-slate-500 text-sm">Will you attend?</p>
        </div>

        <form action="{{ $rsvp['action'] ?? '#' }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Name</label>
                <input type="text" name="name" placeholder="Guest Name"
                    class="w-full border-slate-200 rounded-xl focus:ring-amber-500 focus:border-amber-500 bg-slate-50 text-sm py-3 px-4">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Number of
                    Guests</label>
                <select name="pax"
                    class="w-full border-slate-200 rounded-xl focus:ring-amber-500 focus:border-amber-500 bg-slate-50 text-sm py-3 px-4">
                    <option value="1">1 Person</option>
                    <option value="2">2 Persons</option>
                </select>
            </div>

            <div>
                <label
                    class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Confirmation</label>
                <div class="flex gap-4">
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="attendance" value="hadir" class="peer sr-only">
                        <div
                            class="text-center py-3 rounded-xl border border-slate-200 peer-checked:bg-green-50 peer-checked:text-green-700 peer-checked:border-green-200 text-sm text-slate-500 hover:bg-slate-50 transition">
                            Hadir
                        </div>
                    </label>
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="attendance" value="tidak" class="peer sr-only">
                        <div
                            class="text-center py-3 rounded-xl border border-slate-200 peer-checked:bg-rose-50 peer-checked:text-rose-700 peer-checked:border-rose-200 text-sm text-slate-500 hover:bg-slate-50 transition">
                            Maaf
                        </div>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Message</label>
                <textarea name="message" rows="3" placeholder="Wishes for the couple..."
                    class="w-full border-slate-200 rounded-xl focus:ring-amber-500 focus:border-amber-500 bg-slate-50 text-sm py-3 px-4"></textarea>
            </div>

            <button type="submit"
                class="w-full py-4 bg-slate-800 hover:bg-amber-600 text-white font-bold rounded-xl transition shadow-lg mt-4">
                Confirm Attendance
            </button>
        </form>
    </div>
</section>