<div class="space-y-6">
    <div>
        <h3 class="text-lg font-semibold text-slate-800 mb-1">Pilih Tema</h3>
        <p class="text-sm text-slate-500 mb-6">Ubah tampilan undangan Anda dengan memilih tema yang tersedia.</p>

        <!-- Search/Filter (Optional, currently simple list) -->

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            @foreach($templates as $template)
                <div class="group relative bg-white border rounded-xl overflow-hidden transition-all duration-200 hover:shadow-lg cursor-pointer"
                    :class="form.template_id == {{ $template->id }} ? 'border-indigo-500 ring-2 ring-indigo-500 ring-offset-2' : 'border-slate-200 hover:border-indigo-300'"
                    @click="changeTemplate({{ $template->id }})">

                    <!-- Preview Image -->
                    <div class="aspect-[3/4] bg-slate-100 relative overflow-hidden">
                        @if($template->preview_image_path)
                            <img src="{{ asset($template->preview_image_path) }}" alt="{{ $template->name }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="flex items-center justify-center h-full text-slate-400">
                                <span class="text-xs">No Preview</span>
                            </div>
                        @endif

                        <!-- Active Badge -->
                        <div x-show="form.template_id == {{ $template->id }}"
                            class="absolute top-2 right-2 bg-indigo-600 text-white text-xs font-bold px-2 py-1 rounded shadow">
                            Dipakai
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="p-4">
                        <h4 class="font-bold text-slate-800 mb-1">{{ $template->name }}</h4>
                        <div class="flex items-center justify-between">
                            <span
                                class="text-xs text-slate-500 px-2 py-0.5 bg-slate-100 rounded">{{ $template->category }}</span>
                            <span
                                class="text-xs font-medium {{ $template->is_premium ? 'text-amber-600' : 'text-green-600' }}">
                                {{ $template->is_premium ? 'Premium' : 'Free' }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>

<script>
    // Helper function to update template
    // We can merge this into editor.js later, but for now we push it to the Alpine scope
    function changeTemplate(id) {
        if (!confirm('Apakah Anda yakin ingin mengganti tema? Tampilan akan berubah.')) return;

        // Get the Alpine scope
        const editor = Alpine.evaluate(document.querySelector('[x-data]'), 'this');

        // Update local state
        editor.form.template_id = id;

        // Call save (we assume save logic exists generally, or we implement direct update)
        // Since editor.js is missing clean save(), we manually trigger update
        editor.loading = true;

        axios.post('/editor/' + editor.invitationSlug, {
            template_id: id,
            _method: 'POST' // or PUT, route is POST in web.php
        })
            .then(res => {
                if (res.data.success) {
                    // Reload to reflect changes (different assets etc)
                    window.location.reload();
                } else {
                    alert('Gagal mengganti template.');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan.');
            })
            .finally(() => {
                editor.loading = false;
            });
    }
</script>