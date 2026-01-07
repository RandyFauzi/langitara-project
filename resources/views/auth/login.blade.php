<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Langitara</title>
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
            <img src="https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                alt="Wedding Background" class="absolute inset-0 w-full h-full object-cover opacity-60">

            <!-- Overlay Content -->
            <div class="relative z-10 text-center px-12">
                <h1 class="text-6xl font-bold text-amber-50 mb-6 drop-shadow-md">Langitara</h1>
                <p class="text-xl text-amber-100/90 font-light leading-relaxed max-w-lg mx-auto">
                    Platform undangan digital eksklusif untuk momen bahagiamu. <br>
                    Elegan, mudah, dan tak terlupakan.
                </p>
                <div class="mt-12 flex justify-center gap-4">
                    <div class="w-16 h-1 bg-amber-400 rounded-full"></div>
                    <div class="w-4 h-1 bg-amber-400/50 rounded-full"></div>
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
                    <h2 class="mt-6 text-3xl font-bold tracking-tight text-slate-900 font-serif">Selamat Datang Kembali
                    </h2>
                    <p class="mt-2 text-sm text-slate-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}"
                            class="font-medium text-amber-600 hover:text-amber-500 transition">
                            Daftar sekarang
                        </a>
                    </p>
                </div>

                <div class="mt-8">
                    <div class="mt-6">
                        <form action="{{ route('login') }}" method="POST" class="space-y-6">
                            @csrf

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
                                    <input id="password" name="password" type="password" autocomplete="current-password"
                                        required
                                        class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-3 px-4 bg-slate-50 border transition-colors hover:bg-white"
                                        placeholder="••••••••">
                                </div>
                            </div>

                            <!-- Remember Me & Forgot -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input id="remember-me" name="remember" type="checkbox"
                                        class="h-4 w-4 rounded border-slate-300 text-amber-600 focus:ring-amber-500">
                                    <label for="remember-me" class="ml-2 block text-sm text-slate-900">Ingat
                                        saya</label>
                                </div>
                                <div class="text-sm">
                                    <a href="#" class="font-medium text-amber-600 hover:text-amber-500">Lupa
                                        password?</a>
                                </div>
                            </div>

                            <!-- Submit -->
                            <div>
                                <button type="submit"
                                    class="flex w-full justify-center rounded-xl border border-transparent bg-slate-900 py-3 px-4 text-sm font-bold text-white shadow-sm hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition-all transform hover:-translate-y-0.5">
                                    Masuk
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="mt-6">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-slate-200"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="bg-white px-2 text-slate-500">Atau masuk dengan</span>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <a href="#"
                                class="inline-flex w-full justify-center rounded-xl border border-slate-200 bg-white py-2.5 px-4 text-sm font-medium text-slate-500 shadow-sm hover:bg-slate-50 transition">
                                <span class="sr-only">Sign in with Google</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 7.373-2.36 1.173-1.2 1.8-2.96 1.8-4.907 0-.48-.053-.88-.147-1.28L12.48 10.92z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="inline-flex w-full justify-center rounded-xl border border-slate-200 bg-white py-2.5 px-4 text-sm font-medium text-slate-500 shadow-sm hover:bg-slate-50 transition">
                                <span class="sr-only">Sign in with Facebook</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>