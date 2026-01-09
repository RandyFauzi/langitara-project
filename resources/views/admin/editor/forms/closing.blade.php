<div class="space-y-6">
    <div class="border-b border-slate-200 pb-4 mb-4">
        <h3 class="text-lg font-medium text-slate-900">Kata Penutup</h3>
        <p class="text-sm text-slate-500">Pesan penutup dan turut mengundang.</p>
    </div>

    <div class="space-y-4">

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Kalimat Penutup</label>
            <textarea x-model="form.closing.text" rows="4"
                class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                placeholder="Contoh: Merupakan suatu kehormatan bagi kami apabila..."></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Turut Mengundang (Opsional)</label>
            <textarea x-model="form.closing.invitees" rows="3"
                class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                placeholder="Keluarga Besar Bpk..."></textarea>
        </div>

    </div>
</div>