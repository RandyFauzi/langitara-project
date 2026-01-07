<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title ?? 'The Wedding' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=Great+Vibes&family=Montserrat:wght@300;400;500&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS (Injected via Vite or CDN for Preview stability if Vite not running) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom Template Styles */
        :root {
            --color-primary: #D4AF37;
            /* Soft Gold */
            --color-secondary: #FDFBF7;
            /* Ivory / Cream */
            --color-text: #4A4A4A;
            --font-heading: 'Cormorant Garamond', serif;
            --font-script: 'Great Vibes', cursive;
            --font-body: 'Montserrat', sans-serif;
        }

        body {
            font-family: var(--font-body);
            color: var(--color-text);
            background-color: var(--color-secondary);
        }

        h1,
        h2,
        h3,
        h4 {
            font-family: var(--font-heading);
        }

        .font-script {
            font-family: var(--font-script);
        }

        .fade-in-up {
            animation: fadeInUp 1s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="antialiased overflow-x-hidden">

    <!-- Main Container -->
    <main class="w-full max-w-[500px] mx-auto bg-white shadow-2xl min-h-screen relative">

        <!-- Sections -->
        @if($features['cover'] ?? true)
            @include('templates.gardenia-love.sections.cover')
        @endif

        @if($features['quote'] ?? false)
            @include('templates.gardenia-love.sections.quote')
        @endif

        @if($features['couple'] ?? true)
            @include('templates.gardenia-love.sections.couple')
        @endif

        @if($features['love_story'] ?? false)
            @include('templates.gardenia-love.sections.love-story')
        @endif

        @if($features['carousel'] ?? false)
            @include('templates.gardenia-love.sections.carousel')
        @endif

        @if($features['events'] ?? true)
            @include('templates.gardenia-love.sections.events')
        @endif

        @if($features['countdown'] ?? false)
            @include('templates.gardenia-love.sections.countdown')
        @endif

        @if($features['location'] ?? true)
            @include('templates.gardenia-love.sections.location')
        @endif

        @if($features['gallery'] ?? false)
            @include('templates.gardenia-love.sections.gallery')
        @endif

        @if($features['rsvp'] ?? true)
            @include('templates.gardenia-love.sections.rsvp')
        @endif

        @if($features['gift'] ?? false)
            @include('templates.gardenia-love.sections.gift')
        @endif

        @if($features['wishes'] ?? false)
            @include('templates.gardenia-love.sections.wishes')
        @endif

        @if($features['closing'] ?? true)
            @include('templates.gardenia-love.sections.closing')
        @endif

    </main>

    @if(!empty($meta['song_url']))
        <audio id="bg-music" loop>
            <source src="{{ $meta['song_url'] }}" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>

        <!-- Floating Music Control -->
        <button id="music-control" onclick="toggleMusic()"
            class="fixed bottom-6 right-6 z-50 w-12 h-12 bg-white/80 backdrop-blur rounded-full shadow-lg flex items-center justify-center text-amber-600 animate-spin-slow border border-amber-100 hover:bg-white transition">
            <!-- Icon Playing -->
            <svg id="icon-play" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                </path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <!-- Icon Pause -->
            <svg id="icon-pause" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </button>
    @endif

    <!-- Custom Toast Notification -->
    <div id="toast-container"
        class="fixed bottom-24 left-1/2 transform -translate-x-1/2 z-50 transition-all duration-300 opacity-0 translate-y-10 pointer-events-none">
        <div class="bg-slate-800/90 backdrop-blur text-white px-6 py-3 rounded-full shadow-2xl flex items-center gap-3">
            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span id="toast-message" class="text-sm font-medium">Notification</span>
        </div>
    </div>

    <script>
        // --- Scroll Animation ---
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in-up');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('section > div').forEach((el) => {
            observer.observe(el);
        });

        // --- Music Player Logic ---
        const music = document.getElementById('bg-music');
        const btnMusic = document.getElementById('music-control');
        const iconPlay = document.getElementById('icon-play');
        const iconPause = document.getElementById('icon-pause');
        let isPlaying = true;

        if (music && btnMusic) {
            // Auto-play attempt (often blocked by browser policy until interaction)
            window.addEventListener('click', () => {
                if (!isPlaying && music.paused) {
                    toggleMusic();
                }
            }, { once: true });
        }

        function toggleMusic() {
            if (music.paused) {
                music.play();
                iconPlay.classList.add('hidden');
                iconPause.classList.remove('hidden');
                btnMusic.classList.add('animate-spin-slow');
                isPlaying = true;
            } else {
                music.pause();
                iconPlay.classList.remove('hidden');
                iconPause.classList.add('hidden');
                btnMusic.classList.remove('animate-spin-slow');
                isPlaying = false;
            }
        }

        // --- Toast Notification Logic ---
        function showToast(message) {
            const container = document.getElementById('toast-container');
            const msgSpan = document.getElementById('toast-message');

            msgSpan.innerText = message;

            // Show
            container.classList.remove('opacity-0', 'translate-y-10', 'pointer-events-none');

            // Hide after 3s
            setTimeout(() => {
                container.classList.add('opacity-0', 'translate-y-10', 'pointer-events-none');
            }, 3000);
        }
    </script>
</body>

</html>