<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Tamu - {{ $invitation->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full bg-gray-50" x-data="guestManager()">
    
    <!-- Navigation Header -->
    <header class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('editor.edit', $invitation->slug) }}" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">Daftar Tamu</h1>
                        <p class="text-xs text-gray-500">{{ $invitation->title }}</p>
                    </div>
                </div>
                
                <!-- Navigation Tabs -->
                <nav class="flex space-x-1 bg-gray-100 rounded-lg p-1">
                    <a href="{{ route('editor.guests.index', $invitation->slug) }}" 
                       class="px-4 py-2 text-sm font-medium rounded-md bg-white text-gray-900 shadow-sm">
                        Daftar Tamu
                    </a>
                    <a href="{{ route('editor.stats', $invitation->slug) }}" 
                       class="px-4 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900">
                        Konfirmasi
                    </a>
                    <a href="{{ route('editor.wishes.index', $invitation->slug) }}" 
                       class="px-4 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900">
                        Ucapan
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Action Buttons -->
        <div class="mb-6 flex flex-wrap gap-3">
            <button @click="showAddModal = true" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Tamu
            </button>
            <button class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition" disabled title="Segera Hadir">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                </svg>
                Import Excel
            </button>
            <button class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition" disabled title="Segera Hadir">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Export Data
            </button>
        </div>

        <!-- Stats Summary -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl p-4 border border-gray-200">
                <p class="text-2xl font-bold text-gray-900">{{ $guests->count() }}</p>
                <p class="text-sm text-gray-500">Total Tamu</p>
            </div>
            <div class="bg-white rounded-xl p-4 border border-gray-200">
                <p class="text-2xl font-bold text-amber-600">{{ $guests->where('category', 'vip')->count() }}</p>
                <p class="text-sm text-gray-500">VIP</p>
            </div>
            <div class="bg-white rounded-xl p-4 border border-gray-200">
                <p class="text-2xl font-bold text-blue-600">{{ $guests->where('category', 'family')->count() }}</p>
                <p class="text-sm text-gray-500">Keluarga</p>
            </div>
            <div class="bg-white rounded-xl p-4 border border-gray-200">
                <p class="text-2xl font-bold text-green-600">{{ $guests->where('category', 'friend')->count() }}</p>
                <p class="text-sm text-gray-500">Teman</p>
            </div>
        </div>

        <!-- Guest List Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            @if($guests->isEmpty())
                <div class="text-center py-16">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">Belum Ada Tamu</h3>
                    <p class="text-gray-500 mb-4">Mulai dengan menambahkan tamu undangan Anda.</p>
                    <button @click="showAddModal = true" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Tamu Pertama
                    </button>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. WhatsApp</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($guests as $guest)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-medium">
                                            {{ strtoupper(substr($guest->name, 0, 1)) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $guest->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $categoryColors = [
                                            'vip' => 'bg-amber-100 text-amber-800',
                                            'family' => 'bg-blue-100 text-blue-800',
                                            'friend' => 'bg-green-100 text-green-800',
                                            'colleague' => 'bg-gray-100 text-gray-800',
                                        ];
                                        $categoryLabels = [
                                            'vip' => 'VIP',
                                            'family' => 'Keluarga',
                                            'friend' => 'Teman',
                                            'colleague' => 'Kolega',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $categoryColors[$guest->category] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $categoryLabels[$guest->category] ?? ucfirst($guest->category) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $guest->phone_number ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'sent' => 'bg-blue-100 text-blue-800',
                                            'opened' => 'bg-green-100 text-green-800',
                                        ];
                                        $statusLabels = [
                                            'pending' => 'Belum Dikirim',
                                            'sent' => 'Terkirim',
                                            'opened' => 'Dibuka',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$guest->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $statusLabels[$guest->status] ?? ucfirst($guest->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <!-- Copy Link Button -->
                                        <button @click="copyLink('{{ $guest->getInvitationLink() }}')" 
                                                class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" 
                                                title="Salin Link">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                        </button>
                                        <!-- Edit Button -->
                                        <button @click="editGuest({{ json_encode($guest) }})" 
                                                class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition" 
                                                title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <!-- Delete Button -->
                                        <button @click="deleteGuest({{ $guest->id }}, '{{ $guest->name }}')" 
                                                class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" 
                                                title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </main>

    <!-- Add/Edit Guest Modal -->
    <div x-show="showAddModal || showEditModal" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div x-show="showAddModal || showEditModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="closeModal()"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <!-- Modal panel -->
            <div x-show="showAddModal || showEditModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                
                <form @submit.prevent="submitForm()">
                    <div class="bg-white px-6 pt-6 pb-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4" x-text="showEditModal ? 'Edit Tamu' : 'Tambah Tamu Baru'"></h3>
                        
                        <!-- Name -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" 
                                   x-model="form.name" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                   placeholder="Masukkan nama tamu"
                                   required>
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <select x-model="form.category" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                                <option value="friend">Teman</option>
                                <option value="family">Keluarga</option>
                                <option value="colleague">Kolega</option>
                                <option value="vip">VIP</option>
                            </select>
                        </div>

                        <!-- Phone Number -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp (Opsional)</label>
                            <input type="text" 
                                   x-model="form.phone_number" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                   placeholder="628xxxxxxxxxx">
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                        <button type="button" 
                                @click="closeModal()" 
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition"
                                :disabled="isSubmitting">
                            <span x-show="!isSubmitting" x-text="showEditModal ? 'Simpan Perubahan' : 'Tambah Tamu'"></span>
                            <span x-show="isSubmitting">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function guestManager() {
            return {
                showAddModal: false,
                showEditModal: false,
                isSubmitting: false,
                editingGuestId: null,
                form: {
                    name: '',
                    category: 'friend',
                    phone_number: '',
                },
                slug: @json($invitation->slug),

                closeModal() {
                    this.showAddModal = false;
                    this.showEditModal = false;
                    this.editingGuestId = null;
                    this.form = { name: '', category: 'friend', phone_number: '' };
                },

                editGuest(guest) {
                    this.form = {
                        name: guest.name,
                        category: guest.category,
                        phone_number: guest.phone_number || '',
                    };
                    this.editingGuestId = guest.id;
                    this.showEditModal = true;
                },

                async submitForm() {
                    this.isSubmitting = true;
                    
                    try {
                        const url = this.showEditModal 
                            ? `/editor/${this.slug}/guests/${this.editingGuestId}`
                            : `/editor/${this.slug}/guests`;
                        
                        const method = this.showEditModal ? 'PUT' : 'POST';

                        const response = await fetch(url, {
                            method: method,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify(this.form)
                        });

                        const result = await response.json();

                        if (response.ok) {
                            Swal.fire({
                                icon: 'success',
                                title: this.showEditModal ? 'Tamu Diperbarui!' : 'Tamu Ditambahkan!',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            throw new Error(result.message || 'Terjadi kesalahan');
                        }
                    } catch (error) {
                        Swal.fire('Error', error.message, 'error');
                    } finally {
                        this.isSubmitting = false;
                    }
                },

                async deleteGuest(guestId, guestName) {
                    const result = await Swal.fire({
                        title: 'Hapus Tamu?',
                        text: `Anda yakin ingin menghapus "${guestName}"?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#EF4444',
                        cancelButtonColor: '#6B7280',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    });

                    if (result.isConfirmed) {
                        try {
                            const response = await fetch(`/editor/${this.slug}/guests/${guestId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json',
                                }
                            });

                            if (response.ok) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Terhapus!',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                throw new Error('Gagal menghapus tamu');
                            }
                        } catch (error) {
                            Swal.fire('Error', error.message, 'error');
                        }
                    }
                },

                copyLink(link) {
                    navigator.clipboard.writeText(link).then(() => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Link Disalin!',
                            text: 'Link undangan telah disalin ke clipboard.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }).catch(() => {
                        Swal.fire('Error', 'Gagal menyalin link', 'error');
                    });
                }
            }
        }
    </script>
</body>
</html>
