@extends('admin.layouts.app')

@section('title', 'Promo & Campaigns')

@section('content')

    <!-- HEADER & ACTIONS -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">
                Promo & Campaigns
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Kelola kode promo, voucher diskon, dan campaign marketing.
            </p>
        </div>
        <div class="mt-4 md:mt-0">
            <button onclick="openCreatePromoModal()"
                class="inline-flex items-center px-5 py-2.5 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all hover:shadow-lg hover:-translate-y-0.5">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Buat Promo Baru
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-100 text-emerald-700 px-4 py-3 rounded-xl flex items-center"
            role="alert">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- PROMO MASONRY GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($promos as $promo)
            <div
                class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 relative overflow-hidden flex flex-col h-full">

                <!-- Status Banner -->
                <div class="absolute top-0 right-0 p-4 z-10">
                    @if($promo->status == 'active' && $promo->end_date >= now())
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 shadow-sm backdrop-blur-md">
                            ACTIVE
                        </span>
                    @else
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-500 shadow-sm backdrop-blur-md">
                            INACTIVE
                        </span>
                    @endif
                </div>

                <!-- Image / Gradient Header -->
                <div class="h-32 w-full bg-gradient-to-r from-blue-500 to-indigo-600 relative overflow-hidden">
                    <!-- Pattern -->
                    <div class="absolute inset-0 opacity-10 pattern-dots"></div>

                    @if($promo->image_path)
                        <img src="{{ Storage::url($promo->image_path) }}" class="w-full h-full object-cover">
                    @endif

                    <div class="absolute bottom-0 left-0 p-4 w-full bg-gradient-to-t from-black/50 to-transparent">
                        <span class="text-white font-mono text-xs opacity-80">Campaign ID: {{ $promo->id }}</span>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6 flex-grow flex flex-col">
                    <h3 class="text-lg font-bold text-slate-900 mb-2 leading-tight">
                        {{ $promo->title }}
                    </h3>
                    <p class="text-sm text-slate-500 mb-4 line-clamp-2">
                        {{ $promo->description }}
                    </p>

                    <!-- Voucher Code Box -->
                    @if($promo->code)
                        <div
                            class="bg-blue-50 border border-dashed border-blue-200 rounded-lg p-3 flex justify-between items-center mb-4">
                            <div class="flex items-center gap-2">
                                <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                <span class="text-sm font-bold text-blue-700 tracking-wide font-mono">{{ $promo->code }}</span>
                            </div>
                            <span
                                class="text-xs font-semibold bg-white px-2 py-1 rounded text-blue-600 border border-blue-100 shadow-sm">
                                {{ $promo->discount_type == 'percentage' ? $promo->discount_value . '%' : 'Rp ' . number_format($promo->discount_value / 1000) . 'k' }}
                                OFF
                            </span>
                        </div>
                    @endif

                    <div class="mt-auto border-t border-slate-100 pt-4 text-xs text-slate-500 space-y-1">
                        <div class="flex justify-between">
                            <span>Mulai:</span>
                            <span class="font-medium text-slate-700">{{ $promo->start_date->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Berakhir:</span>
                            <span
                                class="font-medium {{ $promo->end_date < now() ? 'text-rose-500' : 'text-slate-700' }}">{{ $promo->end_date->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-slate-50 p-4 border-t border-slate-100 flex justify-end gap-2">
                    <form action="{{ route('admin.promos.destroy', $promo->id) }}" method="POST"
                        onsubmit="return confirm('Hapus promo ini?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                    <button onclick="editPromo({{ $promo }})"
                        class="p-2 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- CREATE PROMO MODAL -->
    <dialog id="modal-promo"
        class="modal m-auto rounded-2xl shadow-2xl p-0 w-full max-w-3xl backdrop:bg-slate-900/40 backdrop:backdrop-blur-[2px]">
        <form id="form-promo" action="{{ route('admin.promos.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white flex flex-col h-auto">
            @csrf
            <div id="method-field-promo"></div>

            <!-- Header -->
            <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-start">
                <div>
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">Buat Promo Baru</h3>
                    <p class="text-sm text-slate-500 mt-1">Buat campaign marketing atau kode voucher untuk user.</p>
                </div>
                <button type="button" onclick="document.getElementById('modal-promo').close()"
                    class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Left: Basic Info -->
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Judul Promo / Campaign</label>
                        <input type="text" name="title" required
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi</label>
                        <textarea name="description" rows="3" required
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5"></textarea>
                    </div>

                    <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                        <label class="block text-sm font-bold text-blue-800 mb-1.5">Kode Voucher (Opsional)</label>
                        <input type="text" name="code" placeholder="e.g. SALE50"
                            class="w-full border-blue-200 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5 uppercase font-mono tracking-wider">
                        <p class="text-xs text-blue-400 mt-1">Biarkan kosong jika ini promo otomatis tanpa kode.</p>
                    </div>
                </div>

                <!-- Right: Details -->
                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tipe Diskon</label>
                            <select name="discount_type"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5">
                                <option value="percentage">Persentase (%)</option>
                                <option value="fixed">Nominal (Rp)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nilai Diskon</label>
                            <input type="number" name="discount_value" required min="1"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Mulai</label>
                            <input type="date" name="start_date" required
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Berakhir</label>
                            <input type="date" name="end_date" required
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Gambar Banner (Opsional)</label>
                        <input type="file" name="image" accept="image/*"
                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                </div>
            </div>

            <div class="px-8 py-5 border-t border-slate-100 bg-slate-50 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('modal-promo').close()"
                    class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition shadow-sm">
                    Batal
                </button>
                <button type="submit" id="btn-submit-promo"
                    class="px-5 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm hover:shadow transition">
                    Simpan Promo
                </button>
            </div>
        </form>
    </dialog>

    <script>
        function openCreatePromoModal() {
            const modal = document.getElementById('modal-promo');
            const form = document.getElementById('form-promo');
            const methodField = document.getElementById('method-field-promo');
            const title = modal.querySelector('h3');
            const btn = document.getElementById('btn-submit-promo');

            // Reset Form (Create Mode)
            form.reset();
            form.action = "{{ route('admin.promos.store') }}";
            methodField.innerHTML = '';
            title.innerText = 'Buat Promo Baru';
            btn.innerText = 'Simpan Promo';

            modal.showModal();
        }

        function editPromo(data) {
            const modal = document.getElementById('modal-promo');
            const form = document.getElementById('form-promo');
            const methodField = document.getElementById('method-field-promo');
            const title = modal.querySelector('h3');
            const btn = document.getElementById('btn-submit-promo');

            // Set Form (Edit Mode)
            form.action = `/admin/promos/${data.id}`;
            methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            title.innerText = 'Edit Promo';
            btn.innerText = 'Update Promo';

            // Populate fields
            form.querySelector('input[name="title"]').value = data.title;
            form.querySelector('textarea[name="description"]').value = data.description;
            if (data.code) form.querySelector('input[name="code"]').value = data.code;
            form.querySelector('select[name="discount_type"]').value = data.discount_type;
            form.querySelector('input[name="discount_value"]').value = data.discount_value;

            // Dates - convert to input format YYYY-MM-DD
            if (data.start_date) form.querySelector('input[name="start_date"]').value = data.start_date.split('T')[0];
            if (data.end_date) form.querySelector('input[name="end_date"]').value = data.end_date.split('T')[0];

            modal.showModal();
        }
    </script>

@endsection