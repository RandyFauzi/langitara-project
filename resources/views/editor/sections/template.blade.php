<div class="space-y-6">
    <div class="flex justify-between items-center border-b border-gray-100 pb-4">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Pilih Tema</h3>
            <p class="text-xs text-gray-500">Sesuaikan suasana undangan dengan tema pilihan.</p>
        </div>
        <div class="hidden sm:block">
            <span class="text-xs text-gray-400 bg-gray-50 px-3 py-1.5 rounded-full border border-gray-200">
                <i class="fas fa-info-circle mr-1"></i> Klik untuk mengganti tema
            </span>
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($templates as $template)
            <div class="group relative bg-white rounded-2xl overflow-hidden transition-all duration-300 cursor-pointer shadow-sm hover:shadow-xl hover:-translate-y-1"
                :class="form.template_id == {{ $template->id }} ? 'ring-4 ring-violet-400 ring-offset-2 shadow-lg' : 'border border-gray-200 hover:border-violet-300'"
                @click="changeTemplate({{ $template->id }})">

                <!-- Preview Image -->
                <div class="aspect-[3/4] bg-gray-100 relative overflow-hidden">
                    @if($template->preview_image_path)
                        <img src="{{ asset($template->preview_image_path) }}" alt="{{ $template->name }}"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    @else
                        <div class="flex flex-col items-center justify-center h-full text-gray-400 bg-slate-50">
                            <i class="fas fa-image text-3xl mb-2 opacity-50"></i>
                            <span class="text-[10px] font-medium uppercase tracking-widest">No Preview</span>
                        </div>
                    @endif

                    <!-- Overlay -->
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-60 group-hover:opacity-40 transition-opacity">
                    </div>

                    <!-- Hover Action -->
                    <div
                        class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                        <div
                            class="bg-white/90 backdrop-blur-sm text-violet-600 px-4 py-2 rounded-full font-bold text-xs shadow-lg transform scale-90 group-hover:scale-100 transition-transform">
                            <i class="fas fa-check-circle mr-1"></i> Pilih Tema
                        </div>
                    </div>

                    <!-- Active Badge -->
                    <div x-show="form.template_id == {{ $template->id }}"
                        class="absolute top-3 right-3 bg-violet-600 text-white text-[10px] font-bold px-2 py-1 rounded-lg shadow-lg flex items-center gap-1 z-10">
                        <i class="fas fa-check"></i> Dipakai
                    </div>

                    <!-- Premium Badge -->
                    @if($template->is_premium)
                        <div
                            class="absolute top-3 left-3 bg-amber-400 text-white text-[10px] font-bold px-2 py-1 rounded-lg shadow-lg flex items-center gap-1 z-10">
                            <i class="fas fa-crown"></i> Premium
                        </div>
                    @endif
                </div>

                <!-- Info -->
                <div class="p-4 relative">
                    <h4 class="font-bold text-gray-800 text-sm mb-1 truncate">{{ $template->name }}</h4>
                    <div class="flex items-center justify-between mt-2">
                        <span
                            class="text-[10px] font-medium text-gray-500 uppercase tracking-wider bg-gray-100 px-2 py-1 rounded-md">
                            {{ $template->category }}
                        </span>

                        <!-- Simple Price Label -->
                        @if(!$template->is_premium)
                            <span
                                class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md border border-emerald-100">
                                Free
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>