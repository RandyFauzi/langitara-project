@extends('layouts.public')

@section('content')
    <div class="pt-24 pb-16 min-h-screen bg-gradient-to-b from-ivory to-white">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Back Link -->
            <div class="mb-6">
                <a href="{{ route('dashboard.account') }}"
                    class="inline-flex items-center text-sm text-slate-500 hover:text-charcoal transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Pengaturan
                </a>
            </div>

            <h1 class="text-2xl font-semibold text-charcoal mb-6">Ubah Password</h1>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 rounded-xl bg-green-50 p-4 border border-green-100">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Password Form -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="text-lg font-semibold text-charcoal">Update Password</h3>
                    <p class="text-sm text-slate-500">Pastikan akun Anda menggunakan password yang kuat.</p>
                </div>
                <form action="{{ route('dashboard.account.password.update') }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-slate-700 mb-1">Password Saat
                            Ini</label>
                        <input type="password" name="current_password" id="current_password"
                            class="w-full rounded-lg border-slate-200 focus:border-rose-gold focus:ring-rose-gold shadow-sm @error('current_password') border-red-300 @enderror">
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password Baru</label>
                        <input type="password" name="password" id="password"
                            class="w-full rounded-lg border-slate-200 focus:border-rose-gold focus:ring-rose-gold shadow-sm @error('password') border-red-300 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi
                            Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full rounded-lg border-slate-200 focus:border-rose-gold focus:ring-rose-gold shadow-sm">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-6 py-2.5 bg-charcoal text-white font-semibold rounded-lg hover:bg-charcoal/90 transition shadow-sm">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection