@extends('admin.layouts.app')

@section('title', 'Music Library')

@section('content')

    <!-- HEADER & ACTIONS -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">
                Music Library
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Kelola koleksi lagu dan musik latar untuk undangan.
            </p>
        </div>
        <div class="mt-4 md:mt-0">
            <button onclick="openCreateModal()"
                class="inline-flex items-center px-5 py-2.5 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all hover:shadow-lg hover:-translate-y-0.5">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Upload Lagu
            </button>
        </div>
    </div>

    <!-- ALERTS -->
    @if(session('success'))
        <div class="mb-6 p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 rounded-lg bg-rose-50 border border-rose-200 text-rose-700">
            <div class="flex items-center gap-3 mb-2">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-bold">Gagal Menyimpan</span>
            </div>
            <ul class="list-disc list-inside text-sm space-y-1 ml-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- SONG LIST -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                            Song Info
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                            Preview
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                            Package
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse($songs as $song)
                        <tr class="hover:bg-slate-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-900">{{ $song->title }}</span>
                                    <span class="text-xs text-slate-500">{{ $song->artist ?? 'Unknown Artist' }} • {{ $song->category ?? 'General' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <audio controls class="h-8 w-40 mx-auto">
                                    <source src="{{ $song->url }}" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($song->min_package_level === 'free')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Free
                                    </span>
                                @elseif($song->min_package_level === 'premium')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                        Premium
                                    </span>
                                @elseif($song->min_package_level === 'exclusive')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        Exclusive
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">
                                        {{ ucfirst($song->min_package_level) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($song->status === 'active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-500">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button onclick="editSong({{ $song }})" class="text-blue-600 hover:text-blue-900 mr-3 font-bold transition">Edit</button>
                                <form action="{{ route('admin.songs.destroy', $song->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus lagu ini? File juga akan dihapus.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold transition">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z"></path></svg>
                                <p class="text-sm">Belum ada lagu. Upload sekarang!</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $songs->links() }}
        </div>
    </div>

    <!-- MODAL -->
    <dialog id="modal-song" class="modal m-auto rounded-2xl shadow-2xl p-0 w-full max-w-lg backdrop:bg-slate-900/40 backdrop:backdrop-blur-[2px]">
        <form id="form-song" action="{{ route('admin.songs.store') }}" method="POST" enctype="multipart/form-data" class="bg-white flex flex-col h-auto">
            @csrf
            <div id="method-field"></div>

            <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-start">
                <div>
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">Upload Lagu</h3>
                    <p class="text-sm text-slate-500 mt-1">Format MP3 (Max 10MB)</p>
                </div>
                <button type="button" onclick="document.getElementById('modal-song').close()" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <div class="p-8 space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Judul Lagu</label>
                    <input type="text" name="title" required class="w-full border-slate-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Artist</label>
                    <input type="text" name="artist" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Category</label>
                        <select name="category" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                            <option value="romantic">Romantic</option>
                            <option value="pop">Pop</option>
                            <option value="jazz">Jazz</option>
                            <option value="instrumental">Instrumental</option>
                            <option value="traditional">Traditional</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Package Level</label>
                        <select name="min_package_level" class="w-full border-slate-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5">
                            <option value="free">Free</option>
                            <option value="basic">Basic</option>
                            <option value="premium">Premium</option>
                            <option value="exclusive">Exclusive</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status</label>
                    <div class="flex gap-4 mt-1">
                        <label class="inline-flex items-center">
                            <input type="radio" name="status" value="active" checked class="text-blue-600 focus:ring-blue-500 border-gray-300">
                            <span class="ml-2 text-sm text-slate-700">Active</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="status" value="inactive" class="text-blue-600 focus:ring-blue-500 border-gray-300">
                            <span class="ml-2 text-sm text-slate-700">Inactive</span>
                        </label>
                    </div>
                </div>

                <div class="pt-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">File Audio (MP3)</label>
                    <input type="file" name="file" accept=".mp3,.wav,.ogg" onchange="updateFileName(this)" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition"/>
                    <p id="file-name-display" class="text-sm text-emerald-600 font-medium mt-2"></p>
                    <p class="text-xs text-slate-400 mt-1">Biarkan kosong jika edit dan tidak ingin mengganti file.</p>
                </div>
            </div>

            <div class="px-8 py-5 border-t border-slate-100 bg-slate-50 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('modal-song').close()" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition shadow-sm">
                    Batal
                </button>
                <button type="submit" id="btn-submit-song" class="px-5 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm hover:shadow transition">
                    Upload
                </button>
            </div>
        </form>
    </dialog>

    <script>
        function openCreateModal() {
            const modal = document.getElementById('modal-song');
            const form = document.getElementById('form-song');
            const methodField = document.getElementById('method-field');
            const title = modal.querySelector('h3');
            const btn = document.getElementById('btn-submit-song');

            form.reset();
            form.action = "{{ route('admin.songs.store') }}";
            methodField.innerHTML = '';
            title.innerText = 'Upload Lagu Baru';
            btn.innerText = 'Upload';
            
            form.querySelector('input[name="file"]').required = true;
            document.getElementById('file-name-display').innerText = '';

            modal.showModal();
        }

        function editSong(data) {
            const modal = document.getElementById('modal-song');
            const form = document.getElementById('form-song');
            const methodField = document.getElementById('method-field');
            const title = modal.querySelector('h3');
            const btn = document.getElementById('btn-submit-song');

            form.action = `/admin/songs/${data.id}`;
            methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            title.innerText = 'Edit Lagu: ' + data.title;
            btn.innerText = 'Simpan Perubahan';

            form.querySelector('input[name="title"]').value = data.title;
            form.querySelector('input[name="artist"]').value = data.artist || '';
            form.querySelector('select[name="category"]').value = data.category || 'romantic';
            form.querySelector('select[name="min_package_level"]').value = data.min_package_level;
            
            if (data.status === 'active') {
                form.querySelector('input[name="status"][value="active"]').checked = true;
            } else {
                form.querySelector('input[name="status"][value="inactive"]').checked = true;
            }
            
            // File not required on edit
            form.querySelector('input[name="file"]').required = false;
            document.getElementById('file-name-display').innerText = '';

            modal.showModal();
        }

        function updateFileName(input) {
            const display = document.getElementById('file-name-display');
            if (input.files && input.files.length > 0) {
                display.innerText = 'File chosen: ' + input.files[0].name;
            } else {
                display.innerText = '';
            }
        }
    </script>
@endsection
