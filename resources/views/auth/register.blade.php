<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - Langitara</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Outfit:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        h1,
        h2,
        h3,
        .font-serif {
            font-family: 'Cormorant Garamond', serif;
        }
    </style>
</head>

<body class="h-full">
    <div class="flex min-h-full">
        <!-- Left Side: Image/Branding -->
        <div class="hidden lg:flex w-1/2 relative bg-slate-900 items-center justify-center overflow-hidden">
            <!-- Background Image -->
            <img src="https://images.unsplash.com/photo-1511285560982-193905a7972e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                alt="Wedding Decoration" class="absolute inset-0 w-full h-full object-cover opacity-60">

            <!-- Overlay Content -->
            <div class="relative z-10 text-center px-12">
                <h1 class="text-6xl font-bold text-amber-50 mb-6 drop-shadow-md">Langitara</h1>
                <p class="text-xl text-amber-100/90 font-light leading-relaxed max-w-lg mx-auto">
                    Mulai perjalanan indahmu di sini.<br>
                    Buat undangan digital impian dalam hitungan menit.
                </p>
                <div class="mt-12 flex justify-center gap-4">
                    <div class="w-4 h-1 bg-amber-400/50 rounded-full"></div>
                    <div class="w-16 h-1 bg-amber-400 rounded-full"></div>
                </div>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div
            class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24 w-full lg:w-1/2 bg-white">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <!-- Mobile Logo -->
                <div class="lg:hidden mb-10 text-center">
                    <h2 class="text-4xl font-bold text-amber-600 font-serif">Langitara</h2>
                </div>

                <div>
                    <h2 class="mt-6 text-3xl font-bold tracking-tight text-slate-900 font-serif">Buat Akun Baru</h2>
                    <p class="mt-2 text-sm text-slate-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}"
                            class="font-medium text-amber-600 hover:text-amber-500 transition">
                            Masuk di sini
                        </a>
                    </p>
                </div>

                <div class="mt-8">
                    <div class="mt-6">
                        <form action="{{ route('register') }}" method="POST" class="space-y-6">
                            @csrf

                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-slate-700">Nama Lengkap</label>
                                <div class="mt-1">
                                    <input id="name" name="name" type="text" autocomplete="name" required
                                        class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-3 px-4 bg-slate-50 border transition-colors hover:bg-white"
                                        placeholder="John Doe">
                                </div>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-slate-700">Email
                                    address</label>
                                <div class="mt-1">
                                    <input id="email" name="email" type="email" autocomplete="email" required
                                        class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-3 px-4 bg-slate-50 border transition-colors hover:bg-white"
                                        placeholder="nama@email.com">
                                </div>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="space-y-1">
                                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                                <div class="mt-1">
                                    <input id="password" name="password" type="password" autocomplete="new-password"
                                        required
                                        class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-3 px-4 bg-slate-50 border transition-colors hover:bg-white"
                                        placeholder="••••••••">
                                </div>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="space-y-1">
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-slate-700">Konfirmasi Password</label>
                                <div class="mt-1">
                                    <input id="password_confirmation" name="password_confirmation" type="password"
                                        autocomplete="new-password" required
                                        class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-3 px-4 bg-slate-50 border transition-colors hover:bg-white"
                                        placeholder="••••••••">
                                </div>
                            </div>

                            <!-- Submit -->
                            <div>
                                <button type="submit"
                                    class="flex w-full justify-center rounded-xl border border-transparent bg-slate-900 py-3 px-4 text-sm font-bold text-white shadow-sm hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition-all transform hover:-translate-y-0.5">
                                    Daftar Sekarang
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="mt-6">
                        <p class="text-center text-xs text-slate-500">
                            Dengan mendaftar, Anda menyetujui <a href="#"
                                class="font-medium text-amber-600 hover:text-amber-500">Syarat & Ketentuan</a> kami.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>