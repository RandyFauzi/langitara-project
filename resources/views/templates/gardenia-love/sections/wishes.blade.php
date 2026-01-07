<section id="wishes" class="py-20 px-6 bg-[#FDFBF7]">
    <div class="text-center mb-10">
        <h2 class="font-script text-5xl text-amber-600 mb-2">Best Wishes</h2>
    </div>

    <div class="max-w-xl mx-auto space-y-4 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
        <!-- Dummy Wishes Loop -->
        @for ($i = 0; $i < 3; $i++)
            <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm">
                <div class="flex items-center gap-3 mb-3">
                    <div
                        class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 font-bold text-xs ring-2 ring-white shadow">
                        {{ ['AD', 'JS', 'MR'][$i] }}
                    </div>
                    <div>
                        <h5 class="text-sm font-bold text-slate-800">{{ ['Ananda Dwi', 'John Smith', 'Maria R.'][$i] }}</h5>
                        <p class="text-[10px] text-slate-400">Just now</p>
                    </div>
                </div>
                <p class="text-sm text-slate-600 leading-relaxed">
                    {{ ['Happy Wedding! Semoga menjadi keluarga sakinah mawaddah warahmah.', 'Congratulations on your big day!', 'Wishing you a lifetime of love and happiness together.'][$i] }}
                </p>
            </div>
        @endfor
    </div>

    <!-- CSS for clean scrollbar -->
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #D4AF37;
            border-radius: 4px;
        }
    </style>
</section>