@extends('admin.layouts.app')

@section('title', 'Template Management')

@section('content')
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Template Gallery</h1>
            <p class="mt-1 text-sm text-slate-500">Manage invitation templates, styles, and access levels.</p>
        </div>
        <!-- Add Button Removed as per strict Architect rules (Templates are code-based) -->
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 mb-8">
        <form action="{{ route('admin.templates.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="md:col-span-2 relative">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="block w-full pl-4 pr-3 py-2.5 border border-slate-300 rounded-xl bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Search templates...">
            </div>

            <!-- Category -->
            <select name="category" onchange="this.form.submit()"
                class="block w-full text-sm border-slate-300 rounded-xl focus:ring-indigo-500 text-slate-600">
                <option value="all">All Categories</option>
                <option value="floral" {{ request('category') == 'floral' ? 'selected' : '' }}>Floral</option>
                <option value="minimalist" {{ request('category') == 'minimalist' ? 'selected' : '' }}>Minimalist</option>
                <option value="modern" {{ request('category') == 'modern' ? 'selected' : '' }}>Modern</option>
                <option value="luxury" {{ request('category') == 'luxury' ? 'selected' : '' }}>Luxury</option>
            </select>

            <!-- Access -->
            <select name="access" onchange="this.form.submit()"
                class="block w-full text-sm border-slate-300 rounded-xl focus:ring-indigo-500 text-slate-600">
                <option value="all">All Access Levels</option>
                <option value="free" {{ request('access') == 'free' ? 'selected' : '' }}>Free</option>
                <option value="premium" {{ request('access') == 'premium' ? 'selected' : '' }}>Premium</option>
                <option value="exclusive" {{ request('access') == 'exclusive' ? 'selected' : '' }}>Exclusive</option>
                <option value="wo" {{ request('access') == 'wo' ? 'selected' : '' }}>Wedding Org</option>
            </select>
        </form>
    </div>

    <!-- Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($templates as $tpl)
            <div
                class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden">
                <!-- Thumbnail -->
                <div class="relative aspect-[4/3] bg-slate-100 overflow-hidden">
                    <img src="{{ $tpl->preview_image_path ?? 'https://placehold.co/600x450/f1f5f9/94a3b8?text=' . urlencode($tpl->name) }}"
                        alt="{{ $tpl->name }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                    <!-- Overlay Actions -->
                    <div
                        class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                        <a href="{{ route('admin.templates.preview', $tpl->id) }}" target="_blank"
                            class="bg-white/90 hover:bg-white text-slate-900 px-3 py-1.5 rounded-lg text-sm font-medium backdrop-blur-sm transition">
                            Preview
                        </a>
                        <button onclick='editTemplate(@json($tpl))'
                            class="bg-indigo-600/90 hover:bg-indigo-600 text-white px-3 py-1.5 rounded-lg text-sm font-medium backdrop-blur-sm transition">
                            Edit
                        </button>

                        <!-- Toggle Visibility -->
                        <form action="{{ route('admin.templates.toggle', $tpl->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="{{ $tpl->status === 'active' ? 'bg-amber-500/90 hover:bg-amber-500' : 'bg-emerald-500/90 hover:bg-emerald-500' }} text-white px-3 py-1.5 rounded-lg text-sm font-medium backdrop-blur-sm transition">
                                {{ $tpl->status === 'active' ? 'Hide' : 'Show' }}
                            </button>
                        </form>

                        <!-- Delete -->
                        <form id="delete-form-{{ $tpl->id }}" action="{{ route('admin.templates.destroy', $tpl->id) }}"
                            method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete({{ $tpl->id }})"
                                class="bg-red-600/90 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-sm font-medium backdrop-blur-sm transition">
                                Delete
                            </button>
                        </form>
                    </div>

                    <!-- Badges -->
                    <div class="absolute top-3 left-3 flex gap-1">
                        @if($tpl->status === 'inactive')
                            <span
                                class="px-2 py-1 bg-slate-900/80 text-white text-[10px] uppercase font-bold rounded backdrop-blur-md">Inactive</span>
                        @endif
                        @php
                            $accessColors = [
                                'free' => 'bg-emerald-500/90 text-white',
                                'premium' => 'bg-amber-500/90 text-white',
                                'exclusive' => 'bg-purple-600/90 text-white',
                                'wo' => 'bg-rose-600/90 text-white',
                            ];
                        @endphp
                        <span
                            class="px-2 py-1 {{ $accessColors[$tpl->package_access] ?? 'bg-slate-500' }} text-[10px] uppercase font-bold rounded backdrop-blur-md shadow-sm">
                            {{ $tpl->package_access }}
                        </span>
                    </div>
                </div>

                <!-- Info -->
                <div class="p-4 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-1">
                            <h3 class="font-bold text-slate-900 truncate" title="{{ $tpl->name }}">{{ $tpl->name }}</h3>
                        </div>
                        <div class="text-xs text-slate-500 mb-3 capitalize">{{ $tpl->category }}</div>
                    </div>

                    <div class="flex justify-between items-end border-t border-slate-100 pt-3">
                        <div class="text-xs text-slate-400 font-mono">{{ $tpl->folder_name }}</div>
                        <div class="flex items-center text-xs text-slate-500"
                            title="Used by {{ $tpl->invitations_count }} invitations">
                            <svg class="w-3.5 h-3.5 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            {{ number_format($tpl->invitations_count) }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4">
                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-slate-900">No templates found</h3>
                <p class="text-slate-500 text-sm mt-1">Get started by creating your first template blueprint.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $templates->links() }}
    </div>

    <!-- Template Modal (Edit Only) -->
    <dialog id="templateModal"
        class="modal m-auto rounded-2xl shadow-2xl p-0 w-full max-w-lg backdrop:bg-slate-900/40 backdrop:backdrop-blur-[2px]">
        <div class="bg-white flex flex-col max-h-[90vh]">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="text-lg font-bold text-slate-800" id="modalTitle">Edit Template</h3>
                <button onclick="document.getElementById('templateModal').close()"
                    class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form id="templateForm" method="POST" action="" class="p-6 overflow-y-auto space-y-4">
                @csrf
                <div id="method-spoof"></div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Template Name</label>
                    <input type="text" name="name" id="name" required
                        class="block w-full border-slate-300 rounded-lg focus:ring-indigo-500 text-sm"
                        placeholder="e.g. Gardenia Love">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Category</label>
                    <select name="category" id="category"
                        class="block w-full border-slate-300 rounded-lg focus:ring-indigo-500 text-sm">
                        <option value="floral">Floral</option>
                        <option value="minimalist">Minimalist</option>
                        <option value="modern">Modern</option>
                        <option value="luxury">Luxury</option>
                        <option value="traditional">Traditional</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Folder Name (View Path)</label>
                    <input type="text" name="folder_name" id="folder_name" required readonly
                        class="block w-full border-slate-300 rounded-lg bg-slate-50 text-slate-500 focus:ring-indigo-500 text-sm font-mono cursor-not-allowed"
                        placeholder="gardenia-love">
                    <p class="text-[10px] text-slate-500 mt-1">Cannot be edited. Must match folder in
                        resources/views/templates/</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Access Level</label>
                        <select name="package_access" id="package_access"
                            class="block w-full border-slate-300 rounded-lg focus:ring-indigo-500 text-sm">
                            <option value="free">Free</option>
                            <option value="premium">Premium</option>
                            <option value="exclusive">Exclusive</option>
                            <option value="wo">Wedding Org Only</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                        <select name="status" id="status"
                            class="block w-full border-slate-300 rounded-lg focus:ring-indigo-500 text-sm">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Preview Image URL</label>
                    <input type="text" name="preview_image" id="preview_image"
                        class="block w-full border-slate-300 rounded-lg focus:ring-indigo-500 text-sm"
                        placeholder="https://...">
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="button" onclick="document.getElementById('templateModal').close()"
                        class="mr-3 px-4 py-2 text-sm text-slate-600 hover:text-slate-800 font-medium">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-lg shadow-sm">Save
                        Changes</button>
                </div>
            </form>
        </div>
    </dialog>

    <script>
        // SweetAlert2 Delete Confirmation
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Template?',
                text: "Anda yakin ingin menghapus template ini? Semua file (View & Assets) akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }

        // Open Modal for Edit
        function editTemplate(tpl) {
            document.getElementById('templateForm').reset();
            document.getElementById('method-spoof').innerHTML = '@method("PUT")';
            document.getElementById('templateForm').action = `/admin/templates/${tpl.id}`;
            // Title is static 'Edit Template' now

            // Fill Fields
            document.getElementById('name').value = tpl.name;
            document.getElementById('category').value = tpl.category;
            document.getElementById('folder_name').value = tpl.folder_name;

            // Strictly Readonly
            // Folder name input already has readonly attribute in HTML, but we ensure it here just in case
            const folderInput = document.getElementById('folder_name');
            folderInput.readOnly = true;
            // No need to toggle classes as it is always readonly now

            document.getElementById('package_access').value = tpl.package_access;
            document.getElementById('status').value = tpl.status;
            document.getElementById('preview_image').value = tpl.preview_image_path;

            document.getElementById('templateModal').showModal();
        }
    </script>
@endsection