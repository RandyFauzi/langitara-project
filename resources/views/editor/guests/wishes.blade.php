<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Doa & Ucapan - {{ $invitation->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="h-full bg-gray-50" x-data="wishesManager()">

    <!-- Navigation Header -->
    <header class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('editor.edit', $invitation->slug) }}" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">Doa & Ucapan</h1>
                        <p class="text-xs text-gray-500">{{ $invitation->title }}</p>
                    </div>
                </div>

                <!-- Navigation Tabs -->
                <nav class="flex space-x-1 bg-gray-100 rounded-lg p-1">
                    <a href="{{ route('editor.guests.index', $invitation->slug) }}"
                        class="px-4 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900">
                        Daftar Tamu
                    </a>
                    <a href="{{ route('editor.stats', $invitation->slug) }}"
                        class="px-4 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900">
                        Konfirmasi
                    </a>
                    <a href="{{ route('editor.wishes.index', $invitation->slug) }}"
                        class="px-4 py-2 text-sm font-medium rounded-md bg-white text-gray-900 shadow-sm">
                        Ucapan
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Stats Summary -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Ucapan dari Tamu</h2>
                <p class="text-sm text-gray-500">Total {{ $wishes->count() }} ucapan</p>
            </div>
            <div class="flex items-center space-x-4 text-sm">
                <span class="flex items-center text-green-600">
                    <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                    {{ $wishes->where('is_visible', true)->count() }} Ditampilkan
                </span>
                <span class="flex items-center text-gray-500">
                    <span class="w-2 h-2 rounded-full bg-gray-300 mr-2"></span>
                    {{ $wishes->where('is_visible', false)->count() }} Disembunyikan
                </span>
            </div>
        </div>

        @if($wishes->isEmpty())
            <div class="bg-white rounded-xl p-16 border border-gray-200 text-center">
                <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                    </path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Ucapan</h3>
                <p class="text-gray-500 max-w-sm mx-auto">Ucapan dari tamu akan muncul di sini setelah mereka mengirimkan
                    RSVP dengan pesan.</p>
            </div>
        @else
            <!-- Wishes Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($wishes as $wish)
                    <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition relative group"
                        :class="{ 'opacity-60': hiddenWishes.includes({{ $wish->id }}) }"
                        x-data="{ localVisible: {{ $wish->is_visible ? 'true' : 'false' }} }">

                        <!-- Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center text-white font-medium">
                                    {{ strtoupper(substr($wish->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900">{{ $wish->name }}</h4>
                                    <p class="text-xs text-gray-500">{{ $wish->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>

                            <!-- Status Badge -->
                            @php
                                $statusColors = [
                                    'hadir' => 'bg-green-100 text-green-800',
                                    'tidak_hadir' => 'bg-red-100 text-red-800',
                                    'ragu' => 'bg-amber-100 text-amber-800',
                                ];
                                $statusLabels = [
                                    'hadir' => 'Hadir',
                                    'tidak_hadir' => 'Tidak',
                                    'ragu' => 'Ragu',
                                ];
                            @endphp
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$wish->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusLabels[$wish->status] ?? ucfirst($wish->status) }}
                            </span>
                        </div>

                        <!-- Message -->
                        <div class="mb-4">
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $wish->message }}</p>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                            <!-- Visibility Toggle -->
                            <div class="flex items-center">
                                <button type="button"
                                    @click="toggleVisibility({{ $wish->id }}, localVisible); localVisible = !localVisible"
                                    class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                                    :class="localVisible ? 'bg-green-500' : 'bg-gray-300'">
                                    <span class="sr-only">Toggle visibility</span>
                                    <span
                                        class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                        :class="localVisible ? 'translate-x-4' : 'translate-x-0'"></span>
                                </button>
                                <span class="ml-2 text-xs text-gray-500" x-text="localVisible ? 'Tampil' : 'Sembunyi'"></span>
                            </div>

                            <!-- Delete Button -->
                            <button @click="deleteWish({{ $wish->id }}, '{{ $wish->name }}')"
                                class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition opacity-0 group-hover:opacity-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <script>
        function wishesManager() {
            return {
                slug: @json($invitation->slug),
                hiddenWishes: [],

                async toggleVisibility(wishId, currentState) {
                    try {
                        const response = await fetch(`/editor/${this.slug}/wishes/${wishId}/toggle`, {
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            }
                        });

                        if (!response.ok) {
                            throw new Error('Gagal mengubah visibilitas');
                        }

                        // Toggle local state for visual feedback
                        if (currentState) {
                            this.hiddenWishes.push(wishId);
                        } else {
                            this.hiddenWishes = this.hiddenWishes.filter(id => id !== wishId);
                        }

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                        });
                        Toast.fire({
                            icon: 'success',
                            title: currentState ? 'Ucapan disembunyikan' : 'Ucapan ditampilkan'
                        });
                    } catch (error) {
                        Swal.fire('Error', error.message, 'error');
                    }
                },

                async deleteWish(wishId, wishName) {
                    const result = await Swal.fire({
                        title: 'Hapus Ucapan?',
                        text: `Anda yakin ingin menghapus ucapan dari "${wishName}"?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#EF4444',
                        cancelButtonColor: '#6B7280',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    });

                    if (result.isConfirmed) {
                        try {
                            const response = await fetch(`/editor/${this.slug}/wishes/${wishId}`, {
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
                                throw new Error('Gagal menghapus ucapan');
                            }
                        } catch (error) {
                            Swal.fire('Error', error.message, 'error');
                        }
                    }
                }
            }
        }
    </script>
</body>

</html>