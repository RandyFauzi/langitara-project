<div class="space-y-6">
    <div>
        <h3 class="text-lg font-semibold text-slate-800 mb-1">General Information</h3>
        <p class="text-sm text-slate-500 mb-6">Basic details about the event.</p>

        <div class="grid gap-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Invitation Title <span
                        class="text-red-500">*</span></label>
                <input type="text" x-model="form.meta.title"
                    class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition"
                    placeholder="e.g. Romeo & Juliet Wedding">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                <textarea x-model="form.meta.description" rows="3"
                    class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition"
                    placeholder="SEO description..."></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Event Date <span
                            class="text-red-500">*</span></label>
                    <input type="date" x-model="form.meta.event_date"
                        class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Event Timestamp (Time) <span
                            class="text-red-500">*</span></label>
                    <input type="time" step="1" x-model="form.meta.event_time"
                        class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Timezone <span
                        class="text-red-500">*</span></label>
                <select x-model="form.meta.timezone"
                    class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
                    <option value="Asia/Jakarta">Asia/Jakarta (WIB)</option>
                    <option value="Asia/Makassar">Asia/Makassar (WITA)</option>
                    <option value="Asia/Jayapura">Asia/Jayapura (WIT)</option>
                    <option value="UTC">UTC</option>
                </select>
            </div>
        </div>
    </div>
</div>