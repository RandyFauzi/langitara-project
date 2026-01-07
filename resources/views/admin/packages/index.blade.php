@extends('admin.layouts.app')

@section('title', 'Kelola Paket & Layanan')

@section('content')

    <!-- HEADER & ACTIONS -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">
                Paket & Layanan
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Atur skema harga dan fitur paket langganan Langitara.
            </p>
        </div>
        <div class="mt-4 md:mt-0">
            <button onclick="openCreateModal()"
                class="inline-flex items-center px-5 py-2.5 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all hover:shadow-lg hover:-translate-y-0.5">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Paket
            </button>
        </div>
    </div>

    <!-- STATS OVERVIEW -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Paket</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $totalPackages }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-green-50 text-green-600 rounded-xl">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Paket Aktif</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $activePackages }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-slate-50 text-slate-600 rounded-xl">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2"
                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Non-Aktif</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $inactivePackages }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- PREMIUM PACKAGES GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-20">
        @foreach($packages as $package)
            <div
                class="relative group rounded-2xl border shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full overflow-hidden {{ $package->name == 'White Label' ? 'bg-slate-900 text-white border-slate-800' : 'bg-white border-slate-200' }}">

                <!-- Header -->
                <div class="p-6 pb-4">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <!-- Badges Logic -->
                            @if($package->status === 'active')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider mb-2 {{ $package->name == 'White Label' ? 'bg-blue-500/20 text-blue-300 border border-blue-500/30' : 'bg-green-50 text-green-700 border border-green-100' }}">
                                    Active
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider mb-2 bg-slate-100 text-slate-500 border border-slate-200">
                                    Inactive
                                </span>
                            @endif

                            @if($package->name == 'Premium')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider mb-2 bg-amber-50 text-amber-700 border border-amber-100 ml-1">
                                    Popular
                                </span>
                            @elseif($package->name == 'White Label')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider mb-2 bg-rose-500/20 text-rose-300 border border-rose-500/30 ml-1">
                                    For WO
                                </span>
                            @endif

                            <h3
                                class="text-xl font-bold {{ $package->name == 'White Label' ? 'text-white' : 'text-slate-900' }}">
                                {{ $package->name }}
                            </h3>
                        </div>

                        <!-- Toggle Menu -->
                        <div class="relative">
                            <button onclick="document.getElementById('dropdown-{{ $package->id }}').classList.toggle('hidden')"
                                class="p-1 rounded-lg {{ $package->name == 'White Label' ? 'text-slate-400 hover:text-white hover:bg-slate-700' : 'text-slate-400 hover:text-blue-600 hover:bg-slate-50' }} transition">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="2"
                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                </svg>
                            </button>
                            <!-- Dropdown -->
                            <div id="dropdown-{{ $package->id }}"
                                class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 z-20 overflow-hidden animation-fade-in-up">
                                <div class="py-1">
                                    <form action="{{ route('admin.packages.toggle', $package->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            class="w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-blue-600">
                                            {{ $package->status == 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                    <button onclick="editPackage({{ $package }})"
                                        class="w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-blue-600">
                                        Edit Paket
                                    </button>
                                    <button onclick="confirmDelete('{{ $package->id }}', '{{ $package->name }}')"
                                        class="w-full text-left px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 hover:text-rose-700">
                                        Hapus Paket
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-baseline">
                        <span
                            class="text-2xl font-bold {{ $package->name == 'White Label' ? 'text-white' : 'text-slate-900' }}">
                            {{ number_format($package->price, 0, ',', '.') }}
                        </span>
                        <span
                            class="text-sm font-medium {{ $package->name == 'White Label' ? 'text-slate-400' : 'text-slate-500' }} ml-1">IDR</span>
                    </div>
                    <p class="text-xs {{ $package->name == 'White Label' ? 'text-slate-400' : 'text-slate-500' }} mt-1">Per
                        {{ $package->duration_days }} hari
                    </p>
                </div>

                <!-- Divider -->
                <div class="h-px w-full {{ $package->name == 'White Label' ? 'bg-slate-700' : 'bg-slate-100' }}"></div>

                <!-- Features -->
                <div class="p-6 pt-5 flex-grow">
                    <p
                        class="text-xs font-semibold uppercase tracking-wider {{ $package->name == 'White Label' ? 'text-slate-500' : 'text-slate-400' }} mb-4">
                        Core Features</p>
                    <ul class="space-y-3">
                        <li
                            class="flex items-start text-sm {{ $package->name == 'White Label' ? 'text-slate-300' : 'text-slate-600' }}">
                            <svg class="h-5 w-5 {{ $package->name == 'White Label' ? 'text-blue-400' : 'text-blue-500' }} mr-3 shrink-0"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Max <strong>{{ $package->max_invitations }} Undangan</strong></span>
                        </li>
                        <li
                            class="flex items-start text-sm {{ $package->name == 'White Label' ? 'text-slate-300' : 'text-slate-600' }}">
                            <svg class="h-5 w-5 {{ $package->name == 'White Label' ? 'text-blue-400' : 'text-blue-500' }} mr-3 shrink-0"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Hingga <strong>{{ $package->max_guests }} Tamu</strong></span>
                        </li>
                        <li
                            class="flex items-start text-sm {{ $package->name == 'White Label' ? 'text-slate-300' : 'text-slate-600' }}">
                            <svg class="h-5 w-5 {{ $package->name == 'White Label' ? 'text-blue-400' : 'text-blue-500' }} mr-3 shrink-0"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Masa aktif {{ $package->duration_days }} hari</span>
                        </li>
                    </ul>
                </div>

                <!-- Admin Footer -->
                <div
                    class="px-6 py-4 {{ $package->name == 'White Label' ? 'bg-slate-800' : 'bg-slate-50' }} border-t {{ $package->name == 'White Label' ? 'border-slate-700' : 'border-slate-100' }}">
                    <div class="flex items-center justify-between text-xs">
                        <span class="{{ $package->name == 'White Label' ? 'text-slate-500' : 'text-slate-400' }}">ID:
                            {{ $package->id }}</span>
                        <span class="{{ $package->name == 'White Label' ? 'text-slate-500' : 'text-slate-400' }}">Updated
                            {{ $package->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- PREMIUM ADMIN MODAL -->
    <dialog id="modal-package"
        class="modal m-auto rounded-2xl shadow-2xl p-0 w-full max-w-2xl backdrop:bg-slate-900/40 backdrop:backdrop-blur-[2px]">
        <form id="form-package" action="{{ route('admin.packages.store') }}" method="POST"
            class="bg-white flex flex-col h-auto">
            @csrf
            <div id="method-field"></div>

            <!-- Modal Header -->
            <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-start">
                <div>
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">Tambah Paket Baru</h3>
                    <p class="text-sm text-slate-500 mt-1">Konfigurasi paket layanan untuk subscription Langitara.</p>
                </div>
                <button type="button" onclick="document.getElementById('modal-package').close()"
                    class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body: 2 Columns -->
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- Column 1: Basic Info -->
                <div class="space-y-6">
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-indigo-600 mb-4 flex items-center gap-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Informasi Dasar
                        </h4>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Paket</label>
                                <input type="text" name="name" placeholder="e.g. Platinum Plan" required
                                    class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Harga (IDR)</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 text-sm">Rp</span>
                                    <input type="number" name="price" placeholder="0" required min="0"
                                        class="w-full pl-10 border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Durasi</label>
                                <div class="relative">
                                    <input type="number" name="duration_days" value="30" required min="1"
                                        class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5">
                                    <span
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 text-xs font-medium">HARI</span>
                                </div>
                                <p class="text-xs text-slate-400 mt-1">Masa aktif paket setelah pembelian.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Column 2: Limits & Status -->
                <div class="space-y-6">
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-indigo-600 mb-4 flex items-center gap-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="2"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                            Limitasi & Kapasitas
                        </h4>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Max Undangan</label>
                                <input type="number" name="max_invitations" value="1" required min="1"
                                    class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Max Tamu per
                                    Undangan</label>
                                <input type="number" name="max_guests" value="100" required min="1"
                                    class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5">
                            </div>

                            <div class="pt-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Status Awal</label>
                                <div class="flex items-center gap-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status" value="active" checked
                                            class="text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                        <span class="ml-2 text-sm text-slate-700">Active</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status" value="inactive"
                                            class="text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                        <span class="ml-2 text-sm text-slate-700">Inactive</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-8 py-5 border-t border-slate-100 bg-slate-50 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('modal-package').close()"
                    class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition shadow-sm">
                    Batal
                </button>
                <button type="submit" id="btn-submit-package"
                    class="px-5 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm hover:shadow transition">
                    Simpan Paket
                </button>
            </div>
        </form>
    </dialog>

    <!-- DELETE CONFIRMATION MODAL -->
    <dialog id="modal-delete"
        class="modal m-auto rounded-2xl shadow-2xl p-0 w-full max-w-sm backdrop:bg-slate-900/60 backdrop:backdrop-blur-[2px]">
        <div class="bg-white rounded-2xl overflow-hidden">
            <div class="p-6 text-center">
                <div class="w-16 h-16 bg-rose-100 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Hapus Paket?</h3>
                <p class="text-sm text-slate-500 mb-6">
                    Apakah Anda yakin ingin menghapus paket <span id="delete-name" class="font-bold text-slate-800"></span>? Tindakan ini tidak dapat dibatalkan.
                </p>
                
                <form id="form-delete" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex gap-3 justify-center">
                        <button type="button" onclick="document.getElementById('modal-delete').close()"
                            class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition flex-1">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 text-sm font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-sm hover:shadow-lg hover:shadow-rose-200 transition flex-1">
                            Ya, Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </dialog>

    <script>
        function openCreateModal() {
            const modal = document.getElementById('modal-package');
            const form = document.getElementById('form-package');
            const methodField = document.getElementById('method-field');
            const title = modal.querySelector('h3');
            const btn = document.getElementById('btn-submit-package');

            // Reset Form (Create Mode)
            form.reset();
            form.action = "{{ route('admin.packages.store') }}";
            methodField.innerHTML = ''; // No PUT method
            title.innerText = 'Tambah Paket Baru';
            btn.innerText = 'Simpan Paket';
            
            // Set default checks
            form.querySelector('input[name="status"][value="active"]').checked = true;

            modal.showModal();
        }

        function editPackage(data) {
            const modal = document.getElementById('modal-package');
            const form = document.getElementById('form-package');
            const methodField = document.getElementById('method-field');
            const title = modal.querySelector('h3');
            const btn = document.getElementById('btn-submit-package');

            // Set Form (Edit Mode)
            form.action = `/admin/packages/${data.id}`;
            methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            title.innerText = 'Edit Paket: ' + data.name;
            btn.innerText = 'Update Paket';

            // Populate fields
            form.querySelector('input[name="name"]').value = data.name;
            form.querySelector('input[name="price"]').value = data.price;
            form.querySelector('input[name="duration_days"]').value = data.duration_days;
            form.querySelector('input[name="max_invitations"]').value = data.max_invitations;
            form.querySelector('input[name="max_guests"]').value = data.max_guests;
            
            // Radio status
            if (data.status === 'active') {
                form.querySelector('input[name="status"][value="active"]').checked = true;
            } else {
                form.querySelector('input[name="status"][value="inactive"]').checked = true;
            }

            modal.showModal();
        }

        function confirmDelete(id, name) {
            const modal = document.getElementById('modal-delete');
            const form = document.getElementById('form-delete');
            const nameSpan = document.getElementById('delete-name');

            form.action = `/admin/packages/${id}`;
            nameSpan.innerText = `"${name}"`;

            modal.showModal();
        }
    </script>

@endsection