<aside class="hidden md:flex flex-col w-[400px] h-full bg-slate-100 border-l border-slate-200">
    <div class="p-3 border-b border-slate-200 bg-white flex items-center justify-between">
        <span class="text-xs font-semibold text-slate-500 uppercase">Live Preview</span>
        <div class="flex items-center gap-2 bg-slate-100 p-1 rounded-lg">
            <button @click="previewMode = 'mobile'"
                :class="previewMode === 'mobile' ? 'bg-white shadow text-indigo-600' : 'text-slate-500 hover:text-slate-700'"
                class="p-1.5 rounded transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
            </button>
            <button @click="previewMode = 'desktop'"
                :class="previewMode === 'desktop' ? 'bg-white shadow text-indigo-600' : 'text-slate-500 hover:text-slate-700'"
                class="p-1.5 rounded transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </button>
        </div>
    </div>
    <div class="flex-1 overflow-hidden flex items-center justify-center p-4">
        <div class="relative transition-all duration-300 bg-white shadow-2xl overflow-hidden"
            :class="previewMode === 'mobile' ? 'w-[320px] h-[640px] rounded-[3rem] border-[8px] border-slate-900' : 'w-full h-full rounded-lg border border-slate-200'">
            <iframe id="previewFrame" class="w-full h-full bg-white" frameborder="0"></iframe>
            <!-- Loading Overlay -->
            <div x-show="isPreviewLoading" class="absolute inset-0 bg-white/80 flex items-center justify-center">
                <svg class="animate-spin h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
            </div>
        </div>
    </div>
</aside>