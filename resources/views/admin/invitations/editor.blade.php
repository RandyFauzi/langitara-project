@extends('admin.editor.shell')

@section('title', 'Editor - ' . $invitation->title)

@section('content')

    <style>
        /* CSS Failsafe for Sidebar Visibility */
        @media (min-width: 768px) {
            aside { display: flex !important; }
            .mobile-only { display: none !important; }
        }
    </style>

    <div x-data="editor({{ $invitation->id }})" x-init="init()" class="h-full w-full flex flex-col" x-cloak>
        
        <!-- Top Bar -->
        @include('admin.editor.partials.topbar')
        
        <!-- Saving Indicator (Top Right) -->
        <div class="fixed top-4 right-4 z-50 pointer-events-none">
            <span x-show="saving" x-transition class="bg-indigo-600 text-white text-xs px-3 py-1 rounded shadow">Saving...</span>
            <span x-show="!saving && !dirty" x-transition class="bg-green-500 text-white text-xs px-3 py-1 rounded shadow">Saved</span>
            <span x-show="!saving && dirty" x-transition class="bg-amber-500 text-white text-xs px-3 py-1 rounded shadow">Unsaved</span>
        </div>

        <!-- Main Content Area -->
        <main class="flex-1 pt-16 flex overflow-hidden">
            
            <!-- Left Sidebar -->
            @include('admin.editor.partials.sidebar')

            <!-- Center: Form Editor -->
            <section class="flex-1 h-full bg-slate-50 relative overflow-hidden flex flex-col"
                :class="{ 'hidden': isMobile && activeTab !== 'edit' }">
                
                <!-- Mobile Section Title -->
                <div class="md:hidden px-4 py-3 bg-white border-b border-slate-200 flex items-center justify-between">
                    <h2 class="font-semibold text-slate-800" x-text="currentSectionLabel"></h2>
                    <button @click="activeTab = 'sections'" class="text-sm text-indigo-600 font-medium">Change</button>
                </div>

                <div class="flex-1 overflow-y-auto p-4 md:p-8 pb-24 md:pb-8">
                    <div class="max-w-2xl mx-auto">

                        <!-- Loading State -->
                        <div x-show="loading" class="flex flex-col items-center justify-center py-20">
                            <svg class="animate-spin h-8 w-8 text-indigo-600 mb-4" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <p class="text-slate-500">Loading editor...</p>
                        </div>

                        <!-- Forms -->
                        <div x-show="!loading" x-transition.opacity>

                            <div x-show="activeMenu === 'meta'">
                                @include('admin.editor.forms.meta')
                            </div>

                            <div x-show="activeMenu === 'couple'">
                                @include('admin.editor.forms.couple')
                            </div>

                            <div x-show="activeMenu === 'events'">
                                @include('admin.editor.forms.events')
                            </div>

                            <div x-show="activeMenu === 'closing' || activeMenu === 'quote'">
                                @include('admin.editor.forms.closing')
                            </div>

                            <div x-show="activeMenu === 'location'">
                                @include('admin.editor.forms.location')
                            </div>

                            <div x-show="activeMenu === 'album'">
                                @include('admin.editor.forms.gallery')
                            </div>

                            <div x-show="activeMenu === 'story'">
                                @include('admin.editor.forms.love_story')
                            </div>

                            <div x-show="activeMenu === 'music'">
                                @include('admin.editor.forms.music')
                            </div>

                            <div x-show="activeMenu === 'gift'">
                                @include('admin.editor.forms.gift')
                            </div>

                            <div x-show="activeMenu === 'rsvp'">
                                @include('admin.editor.forms.rsvp')
                            </div>

                            <div x-show="activeMenu === 'guests'">
                                @include('admin.editor.forms.guests')
                            </div>

                        </div>
                    </div>
                </div>
            </section>

            <!-- Right: Preview -->
            @include('admin.editor.partials.preview')

        </main>

        <!-- Mobile Preview Tab (Full Screen) -->
        <div x-show="activeTab === 'preview' && isMobile" class="absolute inset-0 z-40 bg-white pt-16 pb-16">
            <iframe id="mobilePreviewFrame" class="w-full h-full bg-white" frameborder="0"></iframe>
            <div x-show="isPreviewLoading" class="absolute inset-0 bg-white/80 flex items-center justify-center">
                <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
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
                        <button @click="activeMenu = section.id; activeTab = 'edit'"
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

        <!-- Mobile Bottom Tabs -->
        <div
            class="md:hidden fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-slate-200 flex items-center justify-around z-50">
            <button @click="activeTab = 'edit'" :class="activeTab === 'edit' ? 'text-indigo-600' : 'text-slate-500'"
                class="flex flex-col items-center gap-1 p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span class="text-xs font-medium">Edit</span>
            </button>
            <button @click="activeTab = 'sections'"
                :class="activeTab === 'sections' ? 'text-indigo-600' : 'text-slate-500'"
                class="flex flex-col items-center gap-1 p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span class="text-xs font-medium">Sections</span>
            </button>
            <button @click="activeTab = 'preview'" :class="activeTab === 'preview' ? 'text-indigo-600' : 'text-slate-500'"
                class="flex flex-col items-center gap-1 p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <span class="text-xs font-medium">Preview</span>
            </button>
        </div>

    </div>

@endsection