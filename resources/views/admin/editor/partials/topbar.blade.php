<header
    class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 fixed top-0 left-0 right-0 z-50">
    <div class="flex items-center gap-4">
        <!-- Logo / Back -->
        <a href="{{ route('admin.invitations.index') }}" class="text-slate-500 hover:text-slate-800 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <!-- Title / Status -->
        <div>
            <h1 class="font-semibold text-lg leading-tight" x-text="form.meta?.title || 'Untitled Invitation'"></h1>
            <div class="flex items-center gap-2 text-xs">
                <span class="inline-flex items-center gap-1 font-medium transition-colors duration-300" :class="{
                        'text-green-600': !saving && !dirty,
                        'text-amber-600': saving,
                        'text-slate-400': !saving && dirty
                    }">
                    <span x-show="!saving && !dirty" class="w-2 h-2 rounded-full bg-green-500"></span>
                    <span x-show="saving" class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    <span x-show="!saving && dirty" class="w-2 h-2 rounded-full bg-slate-400"></span>
                    <span x-text="saving ? 'Saving...' : (!dirty ? 'Saved' : 'Unsaved')"></span>
                </span>
                <span class="text-slate-300">|</span>
                <span class="text-slate-500">{{ $invitationSlug }}</span>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center gap-3">
        <button @click="forcePreview && forcePreview()"
            class="hidden md:flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-slate-600 hover:bg-slate-100 rounded-lg transition"
            title="Refresh Preview">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Refresh
        </button>
        <a href="{{ route('public.templates.show', $invitationSlug) }}" target="_blank"
            class="flex items-center gap-2 px-4 py-2 bg-slate-900 text-white text-sm font-medium rounded-lg hover:bg-slate-800 transition shadow-sm">
            <span>Publish</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
        </a>
    </div>
</header>