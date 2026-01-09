<div class="space-y-6">
    <h3 class="text-lg font-semibold text-slate-800">Primary Location</h3>

    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm space-y-4">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Venue Name <span
                    class="text-red-500">*</span></label>
            <input type="text" x-model="form.location.name"
                class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                placeholder="e.g. Hotel Mulia">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Address <span
                    class="text-red-500">*</span></label>
            <textarea x-model="form.location.address" rows="3"
                class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Map Embed Code (Iframe)</label>
            <textarea x-model="form.location.map_embed" rows="4"
                class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm font-mono text-xs text-slate-600"
                placeholder="<iframe src='...'></iframe>"></textarea>
            <p class="mt-1 text-xs text-slate-500">Copy the "Embed a map" HTML code from Google Maps.</p>
        </div>
    </div>
</div>