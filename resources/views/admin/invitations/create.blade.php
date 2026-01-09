@extends('admin.layouts.app')

@section('title', 'Buat Undangan Baru')

@section('content')
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Buat Undangan Baru</h1>
                <p class="mt-1 text-sm text-slate-500">Mulai project undangan baru dengan memilih template.</p>
            </div>
            <a href="{{ route('admin.invitations.index') }}"
                class="text-sm font-medium text-slate-500 hover:text-slate-800">
                &larr; Kembali
            </a>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <form action="{{ route('admin.invitations.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- User Select -->
                <div>
                    <label class="block text-sm font-semibold text-slate-900 mb-2">User / Klien</label>
                    <select name="user_id" required
                        class="block w-full border-slate-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- Title -->
                <div>
                    <label class="block text-sm font-semibold text-slate-900 mb-2">Judul Undangan</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        placeholder="Contoh: The Wedding of Andi & Bunga" required
                        class="block w-full border-slate-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                    <p class="mt-1 text-xs text-slate-500">Slug akan digenerate otomatis dari judul ini.</p>
                    @error('title') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- Template Select -->
                <div>
                    <label class="block text-sm font-semibold text-slate-900 mb-2">Pilih Template</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($templates as $tpl)
                            <label
                                class="relative border rounded-xl p-4 cursor-pointer hover:bg-slate-50 transition {{ old('template_id') == $tpl->id ? 'ring-2 ring-blue-500 bg-blue-50' : 'border-slate-200' }}">
                                <input type="radio" name="template_id" value="{{ $tpl->id }}" class="peer sr-only" {{ old('template_id') == $tpl->id ? 'checked' : '' }} required>
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-slate-200 rounded-lg flex-shrink-0 bg-cover bg-center"
                                        style="background-image: url('{{ asset($tpl->preview_image_path ?? '') }}')"></div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-900">{{ $tpl->name }}</div>
                                        <div class="text-xs text-slate-500 capitalize">{{ $tpl->category }}</div>
                                    </div>
                                </div>
                                <div
                                    class="absolute inset-0 border-2 border-transparent peer-checked:border-blue-500 rounded-xl pointer-events-none">
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('template_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- Event Date -->
                <div>
                    <label class="block text-sm font-semibold text-slate-900 mb-2">Tanggal Acara (Opsional)</label>
                    <input type="date" name="event_date" value="{{ old('event_date') }}"
                        class="block w-full border-slate-300 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Submit -->
                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow bg-gradient-to-r from-blue-600 to-indigo-600">
                        Buat & Buka Editor &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection