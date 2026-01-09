@extends('admin.editor.layout')

@section('title', 'Editor')

@section('content')

    <!-- Left Sidebar: Sections (Desktop) -->
    @include('admin.editor.sidebar')

    <!-- Center: Form Editor -->
    <section class="flex-1 h-full bg-slate-50 relative overflow-hidden flex flex-col"
        :class="{'hidden': isMobile && activeTab !== 'edit'}">
        <!-- Mobile Section Title -->
        <div class="md:hidden px-4 py-3 bg-white border-b border-slate-200 flex items-center justify-between">
            <h2 class="font-semibold text-slate-800" x-text="currentSectionLabel"></h2>
            <button @click="activeTab = 'sections'" class="text-sm text-indigo-600 font-medium">Change</button>
        </div>

        <div class="flex-1 overflow-y-auto p-4 md:p-8 pb-24 md:pb-8">
            <div class="max-w-2xl mx-auto">

                <!-- Loading State -->
                <div x-show="isLoading" class="flex flex-col items-center justify-center py-20">
                    <svg class="animate-spin h-8 w-8 text-indigo-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <p class="text-slate-500">Loading editor...</p>
                </div>

                <!-- Forms -->
                <div x-show="!isLoading" x-transition.opacity>

                    <div x-show="activeSection === 'meta'">
                        @include('admin.editor.sections.meta')
                    </div>

                    <div x-show="activeSection === 'couple'">
                        @include('admin.editor.sections.couple')
                    </div>

                    <div x-show="activeSection === 'events'">
                        @include('admin.editor.sections.events')
                    </div>

                    <div x-show="activeSection === 'quote'">
                        @include('admin.editor.sections.quote')
                    </div>

                    <div x-show="activeSection === 'location'">
                        @include('admin.editor.sections.location')
                    </div>

                    <div x-show="activeSection === 'gallery'">
                        @include('admin.editor.sections.gallery')
                    </div>

                    <div x-show="activeSection === 'love_story'">
                        @include('admin.editor.sections.love_story')
                    </div>

                    <div x-show="activeSection === 'music'">
                        @include('admin.editor.sections.music')
                    </div>

                    <div x-show="activeSection === 'gift'">
                        @include('admin.editor.sections.gift')
                    </div>

                    <div x-show="activeSection === 'rsvp'">
                        @include('admin.editor.sections.rsvp')
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Right: Preview (Desktop) -->
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

    <!-- Mobile Preview Tab (Full Screen) -->
    <div x-show="activeTab === 'preview' && isMobile" class="absolute inset-0 z-40 bg-white pt-16 pb-16">
        <iframe id="mobilePreviewFrame" class="w-full h-full bg-white" frameborder="0"></iframe>
        <div x-show="isPreviewLoading" class="absolute inset-0 bg-white/80 flex items-center justify-center">
            <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        </div>
    </div>

    <!-- Mobile Section List Tab -->
    <div x-show="activeTab === 'sections' && isMobile"
        class="absolute inset-0 z-40 bg-slate-50 pt-16 pb-16 overflow-y-auto">
        <div class="p-4">
            <h2 class="text-sm font-bold text-slate-500 uppercase mb-4">Select Section</h2>
            <div class="space-y-2">
                <template x-for="section in sections" :key="section.id">
                    <button @click="activeSection = section.id; activeTab = 'edit'"
                        class="w-full flex items-center gap-3 p-4 bg-white rounded-xl shadow-sm border border-slate-100 active:scale-95 transition">
                        <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center"
                            x-html="section.icon"></div>
                        <div class="text-left flex-1">
                            <h3 class="font-semibold text-slate-800" x-text="section.label"></h3>
                            <p class="text-xs text-slate-500">Edit content</p>
                        </div>
                    </button>
                </template>
            </div>
        </div>
    </div>

@endsection