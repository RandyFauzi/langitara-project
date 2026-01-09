<div class="space-y-6">
    <h3 class="text-lg font-semibold text-slate-800">Background Music</h3>

    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
        <label class="block text-sm font-medium text-slate-700 mb-1">Select Song</label>
        {{-- Ideally this is a searchable select or a list of songs with audio previews --}}
        {{-- For MVP, we'll use a simple select, populating it via a backend variable shared to view or fetch via JS
        --}}
        {{-- Since we didn't implement the fetch in JS yet, we can render the options server-side if passed, or just
        input ID for now --}}

        <select x-model="form.music.song_id"
            class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
            <option value="">No Music</option>
            @foreach(\App\Models\Song::all() as $song)
                <option value="{{ $song->id }}">{{ $song->title }} - {{ $song->artist }}</option>
            @endforeach
        </select>

        <p class="mt-2 text-xs text-slate-500">Music will play automatically when the invitation is opened.</p>
    </div>
</div>