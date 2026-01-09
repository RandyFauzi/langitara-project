<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-slate-800">RSVP Config</h3>
        <div class="flex items-center gap-2">
            <span class="text-sm text-slate-600" x-text="form.rsvp?.enabled ? 'Enabled' : 'Disabled'"></span>
            <button @click="form.rsvp.enabled = !form.rsvp.enabled"
                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                :class="form.rsvp?.enabled ? 'bg-indigo-600' : 'bg-slate-200'">
                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
                    :class="form.rsvp?.enabled ? 'translate-x-6' : 'translate-x-1'"></span>
            </button>
        </div>
    </div>

    <div x-show="form.rsvp?.enabled" x-transition
        class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm space-y-4">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Max Guests Allow Per RSVP</label>
            <input type="number" x-model="form.rsvp.max_pax"
                class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                placeholder="e.g. 2">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Confirmation Note</label>
            <textarea x-model="form.rsvp.note" rows="2"
                class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                placeholder="Please confirm your attendance..."></textarea>
        </div>
    </div>
</div>