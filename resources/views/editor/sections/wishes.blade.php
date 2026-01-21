<div x-data="wishesManager()" class="space-y-6">
    <div class="flex justify-between items-center border-b border-gray-100 pb-4">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Ucapan & Doa</h3>
            <p class="text-xs text-gray-500">Kelola ucapan yang tampil di undangan publik.</p>
        </div>
        <div class="flex items-center space-x-3 text-xs font-semibold">
            <span class="flex items-center text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-100">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                {{ $wishes->where('is_visible', true)->count() }} Tampil
            </span>
            <span class="flex items-center text-gray-500 bg-gray-50 px-2.5 py-1 rounded-lg border border-gray-100">
                <span class="w-1.5 h-1.5 rounded-full bg-gray-400 mr-2"></span>
                {{ $wishes->where('is_visible', false)->count() }} Sembunyi
            </span>
        </div>
    </div>

    @if($wishes->isEmpty())
        <div class="bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 p-12 text-center group transition-colors hover:border-violet-300">
            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm group-hover:scale-110 transition-transform">
                <i class="fas fa-comments text-gray-300 text-2xl group-hover:text-violet-400"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Belum Ada Ucapan</h3>
            <p class="text-gray-500 text-sm max-w-sm mx-auto">Ucapan dari tamu akan muncul di sini setelah mereka mengisi buku tamu online.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($wishes as $wish)
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-all relative group"
                 :class="{ 'opacity-60 grayscale': {{ $wish->is_visible ? 'false' : 'true' }} }"
                 x-data="{ localVisible: {{ $wish->is_visible ? 'true' : 'false' }} }">
                
                <!-- Header -->
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-br from-violet-500 to-fuchsia-500 flex items-center justify-center text-white font-bold text-sm shadow-sm ring-2 ring-white">
                            {{ strtoupper(substr($wish->name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900 group-hover:text-violet-600 transition-colors">{{ $wish->name }}</h4>
                            <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wide">{{ $wish->created_at->format('d M, H:i') }}</p>
                        </div>
                    </div>
                    
                    @php
                        $statusColors = [
                            'hadir' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                            'tidak_hadir' => 'bg-red-100 text-red-700 border-red-200',
                            'ragu' => 'bg-amber-100 text-amber-700 border-amber-200',
                        ];
                    @endphp
                    <span class="inline-flex items-center px-2 py-1 rounded-lg text-[10px] font-bold border {{ $statusColors[$wish->status] ?? 'bg-gray-100 text-gray-600 border-gray-200' }}">
                        {{ strtoupper(str_replace('_', ' ', $wish->status)) }}
                    </span>
                </div>
                
                <!-- Message -->
                <div class="mb-5 bg-gray-50/50 p-3 rounded-xl border border-gray-100">
                    <p class="text-xs text-gray-600 leading-relaxed italic">"{{ $wish->message }}"</p>
                </div>
                
                <!-- Actions -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center cursor-pointer select-none" @click="toggleVisibility({{ $wish->id }}, localVisible); localVisible = !localVisible">
                        <div class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                                :class="localVisible ? 'bg-violet-500' : 'bg-gray-200'">
                            <span class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                  :class="localVisible ? 'translate-x-4' : 'translate-x-0'"></span>
                        </div>
                        <span class="ml-2 text-xs font-semibold" 
                              :class="localVisible ? 'text-violet-600' : 'text-gray-400'"
                              x-text="localVisible ? 'Ditampilkan' : 'Disembunyikan'"></span>
                    </div>
                    
                    <button @click="deleteWish({{ $wish->id }}, '{{ $wish->name }}')" 
                            class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white hover:bg-red-500 rounded-lg transition-all"
                            title="Hapus Ucapan">
                        <i class="fas fa-trash-alt text-xs"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    <!-- SweetAlert2 used for confirmation -->
</div>

<script>
    function wishesManager() {
        return {
            slug: '{{ $invitation->slug }}',
            confirmedHidden: [], // Store locally confirmed actions if needed

            async toggleVisibility(wishId, currentState) {
                // Determine new state based on opposite of current
                // Note: The UI updates instantly via x-data, this is the backend sync
                try {
                    const response = await fetch(`/editor/${this.slug}/wishes/${wishId}/toggle`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        }
                    });

                    if (!response.ok) throw new Error('Gagal');
                    
                    // Optional: Toast notification
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal mengubah status visibilitas',
                        confirmButtonColor: '#8b5cf6'
                    });
                     // Revert UI logic here if complex (simplified for now as just boolean flip)
                }
            },

            // Trigger Modal
            deleteWish(wishId, wishName) {
                Swal.fire({
                    title: `Hapus Ucapan?`,
                    text: `Apakah Anda yakin ingin menghapus ucapan dari ${wishName}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#e5e7eb',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                    customClass: {
                        cancelButton: 'text-gray-600 font-bold'
                    }
                }).then(async (result) => {
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
                                    title: 'Terhapus',
                                    showConfirmButton: false,
                                    timer: 1000
                                }).then(() => window.location.reload());
                            } else {
                                Swal.fire('Gagal', 'Gagal menghapus ucapan', 'error');
                            }
                        } catch (error) {
                            Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
                        }
                    }
                });
            }
        }
    }
</script>
