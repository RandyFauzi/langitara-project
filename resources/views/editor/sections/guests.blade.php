<div x-data="guestManager()" class="space-y-6">
    <!-- Header -->
    <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-gray-100 pb-4">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Daftar Tamu</h3>
            <p class="text-xs text-gray-500">Kelola dan bagikan undangan personal.</p>
        </div>
        <div class="flex items-center gap-2 w-full sm:w-auto">
            <button @click="showAddModal = true"
                class="flex-1 sm:flex-none px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-semibold rounded-xl shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-2">
                <i class="fas fa-plus"></i>
                <span class="hidden sm:inline">Tambah Tamu</span>
                <span class="sm:hidden">Tambah</span>
            </button>
            <div class="relative" x-data="{ openBatch: false }">
                <button @click="openBatch = !openBatch" @click.away="openBatch = false"
                    class="px-4 py-2 bg-white border border-gray-200 text-gray-600 hover:border-gray-300 hover:text-gray-800 text-sm font-medium rounded-xl hover:bg-gray-50 transition flex items-center justify-center gap-2 shadow-sm">
                    <i class="fas fa-ellipsis-v"></i>
                    <span class="hidden sm:inline">Aksi Bulk</span>
                </button>
                <div x-show="openBatch"
                    class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-30"
                    x-cloak x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95">
                    <button @click="copyBroadcastList(); openBatch = false"
                        class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-violet-50 hover:text-violet-600 transition flex items-center gap-2">
                        <i class="fas fa-copy w-4"></i> Salin Daftar Broadcast
                    </button>
                    <button @click="showImportModal = true; openBatch = false"
                        class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition flex items-center gap-2">
                        <i class="fas fa-file-excel w-4"></i> Import Excel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- WhatsApp Template Section -->
    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3 cursor-pointer" @click="showTemplate = !showTemplate">
            <h4 class="text-sm font-bold text-gray-700 flex items-center gap-2">
                <i class="fab fa-whatsapp text-green-500 text-lg"></i> Template Pesan WhatsApp
            </h4>
            <button class="text-gray-400 hover:text-violet-600 transition">
                <i class="fas" :class="showTemplate ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </button>
        </div>

        <div x-show="showTemplate" x-collapse x-cloak>
            <div class="space-y-3">
                <p class="text-xs text-gray-500">
                    Gunakan <strong>[NamaTamu]</strong> untuk menyisipkan nama tamu dan <strong>[Link]</strong> untuk
                    link undangan.
                </p>
                <textarea x-model="waTemplate" rows="4"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-green-100 focus:border-green-400 outline-none transition resize-none text-gray-700"
                    placeholder="Tulis pesan undangan Anda di sini..."></textarea>
                <div class="flex justify-end">
                    <button @click="resetTemplate()"
                        class="text-xs text-gray-400 hover:text-gray-600 font-medium underline">
                        Reset Default
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Summary Check -->
    @if($guests->isEmpty())
        <div
            class="bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 p-10 text-center group hover:border-violet-300 transition-colors">
            <div
                class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm group-hover:scale-110 transition-transform">
                <i class="fas fa-users text-gray-300 text-2xl group-hover:text-violet-400"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Daftar Tamu Kosong</h3>
            <p class="text-gray-500 text-sm mb-5">Anda belum menambahkan tamu undangan.</p>
            <button @click="showAddModal = true"
                class="text-violet-600 hover:text-violet-800 font-bold text-sm hover:underline">
                + Tambah Tamu Manual
            </button>
        </div>
    @else
        <!-- Guest List Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama &
                                Kategori</th>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kontak
                            </th>
                            <th scope="col"
                                class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($guests as $guest)
                            <tr class="hover:bg-violet-50/30 transition group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-br from-violet-100 to-blue-100 text-violet-600 flex items-center justify-center font-bold text-sm shadow-inner cursor-default">
                                            {{ strtoupper(substr($guest->name, 0, 1)) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-800">{{ $guest->name }}</div>
                                            <div class="text-xs text-gray-500 flex items-center gap-1.5 mt-0.5">
                                                @php
                                                    $catClasses = [
                                                        'vip' => 'text-amber-600 bg-amber-100',
                                                        'family' => 'text-blue-600 bg-blue-100',
                                                        'friend' => 'text-emerald-600 bg-emerald-100',
                                                        'colleague' => 'text-gray-600 bg-gray-100',
                                                    ];
                                                @endphp
                                                <span
                                                    class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $catClasses[$guest->category] ?? 'text-gray-500 bg-gray-100' }}">
                                                    {{ ucfirst($guest->category) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        @if($guest->phone_number)
                                            <div class="text-sm text-gray-600 font-medium">
                                                {{ $guest->phone_number }}
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">No. -</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- Send WA Button -->
                                        <a :href="generateWaLink('{{ $guest->name }}', '{{ $guest->phone_number }}', '{{ $guest->getInvitationLink() }}')"
                                            target="_blank"
                                            class="group/btn relative px-3 py-1.5 bg-green-50 text-green-600 hover:bg-green-500 hover:text-white rounded-lg transition-all font-medium text-xs flex items-center gap-1.5 shadow-sm border border-green-100 hover:border-green-500 hover:shadow-green-200"
                                            :class="{'opacity-50 pointer-events-none cursor-not-allowed': !'{{ $guest->phone_number }}'}">
                                            <i class="fab fa-whatsapp text-sm"></i>
                                            <span class="hidden md:inline">Kirim</span>
                                        </a>

                                        <!-- Copy Link Button -->
                                        <button @click="copyLink('{{ $guest->getInvitationLink() }}')"
                                            class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-violet-600 hover:bg-violet-50 rounded-lg transition border border-transparent hover:border-violet-100">
                                            <i class="fas fa-copy text-xs"></i>
                                        </button>

                                        <!-- Actions Menu -->
                                        <div class="relative" x-data="{ open: false }">
                                            <button @click="open = !open" @click.away="open = false"
                                                class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                                                <i class="fas fa-ellipsis-v text-xs"></i>
                                            </button>
                                            <div x-show="open"
                                                class="absolute right-0 mt-1 w-32 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-20"
                                                x-cloak>
                                                <button @click="editGuest({{ json_encode($guest) }}); open = false"
                                                    class="w-full text-left px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 hover:text-violet-600 transition font-medium">
                                                    Edit
                                                </button>
                                                <button
                                                    @click="deleteGuest({{ $guest->id }}, '{{ $guest->name }}'); open = false"
                                                    class="w-full text-left px-3 py-2 text-xs text-red-500 hover:bg-red-50 transition font-medium">
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Add/Edit Modal (Preserved) -->
    <template x-teleport="body">
        <div x-show="showAddModal || showEditModal" class="relative z-[9999]" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <!-- Backdrop -->
            <div x-show="showAddModal || showEditModal" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" @click="closeModal()"
                class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"></div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div x-show="showAddModal || showEditModal" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100">

                        <div class="bg-gray-50/50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-800"
                                x-text="showEditModal ? 'Edit Data Tamu' : 'Tambah Tamu Baru'"></h3>
                            <button @click="closeModal()" class="text-gray-400 hover:text-gray-600 transition">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <form @submit.prevent="submitForm()" class="px-6 py-6 space-y-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                                <input type="text" x-model="form.name" required
                                    class="mt-1 block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-violet-100 focus:border-violet-400 outline-none transition"
                                    placeholder="Contoh: Budi Santoso">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Kategori</label>
                                <select x-model="form.category"
                                    class="mt-1 block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-violet-100 focus:border-violet-400 outline-none transition appearance-none">
                                    <option value="friend">Teman</option>
                                    <option value="family">Keluarga</option>
                                    <option value="colleague">Rekan Kerja</option>
                                    <option value="vip">VIP</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700">No. WhatsApp <span
                                        class="text-gray-400 font-normal ml-1">(Opsional)</span></label>
                                <input type="text" x-model="form.phone_number"
                                    class="mt-1 block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-violet-100 focus:border-violet-400 outline-none transition"
                                    placeholder="Contoh: 08123456789 (Format bebas)">
                            </div>

                            <div class="pt-4 flex flex-row-reverse gap-3">
                                <button type="submit" :disabled="isSubmitting"
                                    class="inline-flex w-full justify-center rounded-xl bg-violet-600 px-5 py-3 text-sm font-bold text-white shadow-sm hover:bg-violet-700 hover:shadow-md transition-all sm:w-auto disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span
                                        x-text="isSubmitting ? 'Menyimpan...' : (showEditModal ? 'Simpan Perubahan' : 'Tambah Tamu')"></span>
                                </button>
                                <button type="button" @click="closeModal()"
                                    class="inline-flex w-full justify-center rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-bold text-gray-600 shadow-sm hover:bg-gray-50 transition-all sm:w-auto">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <!-- Import Modal (Preserved) -->
    <template x-teleport="body">
        <div x-show="showImportModal" class="relative z-[9999]" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div x-show="showImportModal" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" @click="showImportModal = false"
                class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"></div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div x-show="showImportModal" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100">

                        <div class="bg-gray-50/50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-800">Import Tamu dari Excel</h3>
                            <button @click="showImportModal = false"
                                class="text-gray-400 hover:text-gray-600 transition">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <form action="{{ route('editor.guests.import', $invitation->slug) }}" method="POST"
                            enctype="multipart/form-data" class="px-6 py-6 space-y-6">
                            @csrf

                            <div class="bg-blue-50/50 border border-blue-100 rounded-xl p-4 flex gap-4">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-blue-800 font-medium">Pentunjuk Import</p>
                                    <p class="text-xs text-blue-600 mt-1 mb-2">
                                        Gunakan template Excel yang telah disediakan agar sistem dapat membaca data
                                        dengan benar.
                                    </p>
                                    <a href="{{ route('editor.guests.template', $invitation->slug) }}"
                                        class="text-xs font-bold text-blue-600 hover:text-blue-800 underline flex items-center gap-1">
                                        <i class="fas fa-download"></i> Download Template (.xlsx)
                                    </a>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Upload File Excel</label>
                                <input type="file" name="file" required accept=".xlsx, .csv"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 transition cursor-pointer border rounded-xl border-gray-200">
                            </div>

                            <div class="flex flex-row-reverse gap-3 pt-2">
                                <button type="submit"
                                    class="inline-flex w-full justify-center rounded-xl bg-violet-600 px-5 py-3 text-sm font-bold text-white shadow-sm hover:bg-violet-700 hover:shadow-md transition-all sm:w-auto">
                                    Upload & Proses
                                </button>
                                <button type="button" @click="showImportModal = false"
                                    class="inline-flex w-full justify-center rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-bold text-gray-600 shadow-sm hover:bg-gray-50 transition-all sm:w-auto">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>

<script>
    function guestManager() {
        return {
            showAddModal: false,
            showEditModal: false,
            showImportModal: false,
            showTemplate: true,
            isSubmitting: false,
            editingGuestId: null,
            form: { name: '', category: 'friend', phone_number: '' },
            slug: '{{ $invitation->slug }}',

            // WA Template Logic
            waTemplate: "Kepada Yth. Bapak/Ibu/Saudara/i [NamaTamu], \n\nKami mengundang Anda untuk hadir di acara pernikahan kami.\n\nInfo lengkap: [Link]\n\nMohon doa restu Anda. Terima kasih.",

            resetTemplate() {
                this.waTemplate = "Kepada Yth. Bapak/Ibu/Saudara/i [NamaTamu], \n\nKami mengundang Anda untuk hadir di acara pernikahan kami.\n\nInfo lengkap: [Link]\n\nMohon doa restu Anda. Terima kasih.";
                Swal.fire({ toast: true, position: 'top-end', showConfirmButton: false, timer: 1500, icon: 'info', title: 'Template di-reset' });
            },

            generateWaLink(name, phone, link) {
                if (!phone) return '#';

                let message = this.waTemplate
                    .replace('[NamaTamu]', name)
                    .replace('[Link]', link);

                let cleanPhone = phone.replace(/[^0-9]/g, '');
                if (cleanPhone.startsWith('0')) cleanPhone = '62' + cleanPhone.substring(1);

                return `https://wa.me/${cleanPhone}?text=${encodeURIComponent(message)}`;
            },

            copyBroadcastList() {
                // Generate simple list: Name - Link
                let text = "";
                // Note: We need to access JS variable of guests, but here we only have blade loop.
                // Solution: We will grab data from DOM or pass JSON.
                // Better approach: Pass guests as JSON to Alpine.

                // Let's assume we can fetch data or just iterate DOM for simplicity if list is small.
                // But robust way is:
                const guests = @json($guests);

                if (guests.length === 0) {
                    Swal.fire('Info', 'Belum ada tamu', 'info');
                    return;
                }

                text = guests.map(g => `${g.name}: ${window.location.origin}/invitation/{{ $invitation->slug }}?to=${encodeURIComponent(g.name)}`).join('\n');

                navigator.clipboard.writeText(text).then(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil Disalin',
                        text: 'Daftar nama dan link berhasil disalin untuk broadcast.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                });
            },

            closeModal() {
                this.showAddModal = false;
                this.showEditModal = false;
                this.editingGuestId = null;
                this.form = { name: '', category: 'friend', phone_number: '' };
            },

            editGuest(guest) {
                this.form = { name: guest.name, category: guest.category, phone_number: guest.phone_number || '' };
                this.editingGuestId = guest.id;
                this.showEditModal = true;
            },

            async submitForm() {
                this.isSubmitting = true;
                const url = this.showEditModal
                    ? `/editor/${this.slug}/guests/${this.editingGuestId}`
                    : `/editor/${this.slug}/guests`;
                const method = this.showEditModal ? 'PUT' : 'POST';

                try {
                    const res = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(this.form)
                    });
                    if (res.ok) {
                        window.location.reload();
                    } else {
                        Swal.fire({
                            title: 'Gagal',
                            text: 'Terjadi kesalahan saat menyimpan data.',
                            icon: 'error',
                            confirmButtonColor: '#7c3aed'
                        });
                    }
                } catch (e) {
                    console.error(e);
                } finally {
                    this.isSubmitting = false;
                }
            },

            async deleteGuest(id, name) {
                Swal.fire({
                    title: `Hapus ${name}?`,
                    text: "Data tamu yang dihapus tidak dapat dikembalikan.",
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
                            await fetch(`/editor/${this.slug}/guests/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json',
                                }
                            });
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus',
                                showConfirmButton: false,
                                timer: 1000
                            }).then(() => window.location.reload());
                        } catch (e) { console.error(e); }
                    }
                });
            },

            copyLink(text) {
                navigator.clipboard.writeText(text);
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                Toast.fire({
                    icon: 'success',
                    title: 'Link berhasil disalin'
});
            }
        }
    }
</script>