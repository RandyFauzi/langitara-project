<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Wedding of {{ $couple->groom_nickname ?? 'Syahril' }} & {{ $couple->bride_nickname ?? 'Elyana' }}</title>

    <!-- External Libs -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Alex+Brush&family=Cormorant+Infant:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Pinyon+Script&family=Poppins:wght@100;200;300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/templates/betawi-heritage/css/style.css') }}">

    <!-- Favicon Langitara -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <style>
        /* INLINE STYLES FROM SOURCE (Preserved & Enhanced) */
        :root {
            --primary: #C5A059;
            /* More Gold/Brass typical of Betawi */
            --primary-dark: #A3823E;
            --secondary: #2A623A;
            /* Green typical of Betawi homes */
            --text-dark: #1A1A1A;
            --text-light: #FFFFFF;
            --cream: #FFFCF3;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            background-color: var(--secondary);
        }

        .font-pinyon {
            font-family: 'Pinyon Script', cursive;
        }

        .font-cormorant {
            font-family: 'Cormorant Infant', serif;
        }

        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }

        .font-alex {
            font-family: 'Alex Brush', cursive;
        }

        /* --- ORNAMENT: GIGI BALANG (Triangular traditional motif) --- */
        .gigi-balang-top {
            width: 100%;
            height: 40px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M0,0V46.29c47,0,47,46.29,94,46.29s47-46.29,94-46.29S235,0,282,0V120H0Z' fill='%23C5A059' opacity='1'/%3E%3Cpath d='M0,120h1200V0H1120c-47,0-47,46-94,46s-47-46-94-46-47,46-94,46-47-46-94-46-47,46-94,46-47-46-94-46-47,46-94,46-47-46-94-46-47,46-94,46-47-46-94-46S235,92,188,92s-47-46-94-46S47,0,0,0Z' fill='%23C5A059'/%3E%3C/svg%3E");
            /* Simplified Logic: Using a simpler repeating CSS gradient for robustness if SVG is complex */
            background:
                linear-gradient(45deg, transparent 33.333%, var(--primary) 33.333%, var(--primary) 66.667%, transparent 66.667%),
                linear-gradient(-45deg, transparent 33.333%, var(--primary) 33.333%, var(--primary) 66.667%, transparent 66.667%);
            background-size: 20px 40px;
            background-position: 0 0, 10px 0;
            /* Align to make triangles */
            background-repeat: repeat-x;
            position: relative;
            z-index: 10;
        }

        /* Creating a more accurate Gigi Balang shape using CSS mask or clip-path is better, 
           but repeating gradient serves as a lightweight fallback "Triangle" motif. 
           Let's try a pure SVG data URI for the specific "Gigi Balang" look (Triangles with holes). */
        .pattern-gigi-balang {
            width: 100%;
            height: 30px;
            background-color: transparent;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='20' viewBox='0 0 40 20'%3E%3Cpath d='M20 20L0 0h40L20 20z' fill='%23C5A059'/%3E%3C/svg%3E");
            background-size: 40px 20px;
            background-repeat: repeat-x;
            background-position: bottom;
            filter: drop-shadow(0px 2px 2px rgba(0, 0, 0, 0.1));
        }

        .pattern-gigi-balang.inverted {
            transform: rotate(180deg);
        }

        .pattern-gigi-balang.green {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='20' viewBox='0 0 40 20'%3E%3Cpath d='M20 20L0 0h40L20 20z' fill='%232A623A'/%3E%3C/svg%3E");
        }

        /* --- ORNAMENT: BATIK OVERLAY (Subtle Background) --- */
        .bg-batik {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23C5A059' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* --- ORNAMENT: PHOTO FRAME --- */
        .frame-betawi {
            position: relative;
            padding: 10px;
            border-radius: 50%;
            background:
                radial-gradient(circle at center, transparent 68%, var(--primary) 70%, var(--primary) 72%, transparent 72%),
                conic-gradient(from 0deg, transparent 0deg, transparent 45deg, var(--primary) 45deg, var(--primary) 55deg, transparent 55deg);
            background-size: 100% 100%, 100% 100%;
        }

        .frame-betawi::before {
            content: '';
            position: absolute;
            inset: -5px;
            border: 2px dashed var(--primary);
            border-radius: 50%;
            animation: spin 20s linear infinite;
        }

        .container {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        .section-left {
            width: calc(100% - 400px);
            display: none;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
        }

        /* Mobile First Wrapper */
        .section-right {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            position: relative;
            background: #fff;
            min-height: 100vh;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }

        @media (min-width: 1024px) {
            .section-left {
                display: block;
            }

            .section-right {
                margin: 0;
                margin-left: auto;
            }
        }

        .btn-gradient {
            background: linear-gradient(90deg, #D7BB83 0%, #A38C5E 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 5px;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            justify-content: center;
            text-decoration: none;
            transition: transform 0.2s;
        }

        .btn-gradient:hover {
            transform: scale(1.05);
        }

        /* Music Player */
        .music-player {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
            background: white;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            border: 2px solid var(--primary);
        }

        .music-icon {
            font-size: 24px;
            color: var(--primary);
            animation: spin 4s linear infinite;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        .paused {
            animation-play-state: paused !important;
        }

        /* Video Background */
        .video-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        /* Utility */
        .radius-20 {
            border-radius: 20px;
        }

        .radius-200 {
            border-radius: 200px;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5px;
        }

        .carousel-scroll {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding: 10px 0;
            scrollbar-width: none;
        }

        .carousel-scroll::-webkit-scrollbar {
            display: none;
        }

        /* Form Input */
        .form-input,
        .form-textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #D7BB83;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            background: rgba(255, 252, 243, 0.9);
        }

        .form-textarea {
            height: 100px;
            resize: vertical;
        }

        .attendance-buttons {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
        }

        .attendance-btn {
            flex: 1;
            padding: 10px;
            border: 1px solid #D7BB83;
            background: transparent;
            color: #D7BB83;
            border-radius: 8px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s;
        }

        .attendance-btn.active,
        .attendance-btn:hover {
            background: #D7BB83;
            color: white;
        }

        /* Opening Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: scale(1);
            }

            to {
                opacity: 0;
                transform: scale(0.95);
            }
        }

        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(1.1);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .cover-exit {
            animation: fadeOut 0.6s ease-out forwards;
        }

        .intro-enter {
            animation: zoomIn 0.8s ease-out forwards;
        }

        .intro-content-enter>* {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .intro-content-enter>*:nth-child(1) {
            animation-delay: 0.2s;
            opacity: 0;
        }

        .intro-content-enter>*:nth-child(2) {
            animation-delay: 0.4s;
            opacity: 0;
        }

        .intro-content-enter>*:nth-child(3) {
            animation-delay: 0.6s;
            opacity: 0;
        }

        .intro-content-enter>*:nth-child(4) {
            animation-delay: 0.8s;
            opacity: 0;
        }

        .intro-content-enter>*:nth-child(5) {
            animation-delay: 1.0s;
            opacity: 0;
        }

        .intro-content-enter>*:nth-child(6) {
            animation-delay: 1.2s;
            opacity: 0;
        }

        /* Scroll Lock */
        .overflow-hidden {
            overflow: hidden !important;
            height: 100vh !important;
        }

        /* Scroll Indicator */
        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .scroll-indicator {
            animation: bounce 2s infinite;
        }

        /* Floating animation for ornaments */
        @keyframes floatLeft {

            0%,
            100% {
                transform: translateY(0) rotate(-5deg);
            }

            50% {
                transform: translateY(-8px) rotate(-3deg);
            }
        }

        @keyframes floatRight {

            0%,
            100% {
                transform: translateY(0) rotate(5deg);
            }

            50% {
                transform: translateY(-8px) rotate(3deg);
            }
        }

        .ornament-left {
            animation: floatLeft 4s ease-in-out infinite;
        }

        .ornament-right {
            animation: floatRight 4s ease-in-out infinite;
        }

        /* ========================================
           SMOOTH SECTION TRANSITIONS
        ======================================== */

        /* Smooth Scroll Behavior */
        .section-right {
            scroll-behavior: smooth;
        }

        /* Section Divider - Wave Style */
        .section-divider {
            position: relative;
            height: 60px;
            overflow: hidden;
            z-index: 20;
        }

        .section-divider-wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 60px;
        }

        .section-divider-wave svg {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        /* Section Divider - Fade Gradient */
        .section-fade-top {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 80px;
            background: linear-gradient(to bottom, var(--fade-from, #f6f6f0), transparent);
            z-index: 15;
            pointer-events: none;
        }

        .section-fade-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 80px;
            background: linear-gradient(to top, var(--fade-to, #1B1B1B), transparent);
            z-index: 15;
            pointer-events: none;
        }

        /* Ornamental Divider */
        .ornament-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 0;
            position: relative;
            z-index: 10;
        }

        .ornament-divider::before,
        .ornament-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
        }

        .ornament-divider img {
            width: 48px;
            height: 48px;
            margin: 0 16px;
            opacity: 0.6;
            animation: pulse-soft 3s ease-in-out infinite;
        }

        @keyframes pulse-soft {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.6;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
        }

        /* Parallax Layers */
        .parallax-section {
            position: relative;
            overflow: hidden;
        }

        .parallax-bg {
            position: absolute;
            inset: -20%;
            background-size: cover;
            background-position: center;
            background-attachment: scroll;
            will-change: transform;
            z-index: 1;
        }

        /* Reveal Animation on Scroll */
        .reveal-section {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal-section.revealed {
            opacity: 1;
            transform: translateY(0);
        }

        /* Smooth Scale Reveal */
        .reveal-scale {
            opacity: 0;
            transform: scale(0.95);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal-scale.revealed {
            opacity: 1;
            transform: scale(1);
        }

        /* Staggered Children Animation */
        .stagger-children>* {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stagger-children.revealed>*:nth-child(1) {
            transition-delay: 0.1s;
            opacity: 1;
            transform: translateY(0);
        }

        .stagger-children.revealed>*:nth-child(2) {
            transition-delay: 0.2s;
            opacity: 1;
            transform: translateY(0);
        }

        .stagger-children.revealed>*:nth-child(3) {
            transition-delay: 0.3s;
            opacity: 1;
            transform: translateY(0);
        }

        .stagger-children.revealed>*:nth-child(4) {
            transition-delay: 0.4s;
            opacity: 1;
            transform: translateY(0);
        }

        .stagger-children.revealed>*:nth-child(5) {
            transition-delay: 0.5s;
            opacity: 1;
            transform: translateY(0);
        }

        /* Smooth Section Background Transition */
        article {
            position: relative;
        }

        /* SVG Wave Path */
        .wave-path {
            fill: currentColor;
        }

        /* Elegant Curve Divider */
        .curve-divider {
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 50px;
            z-index: 20;
        }

        .curve-divider-top {
            position: absolute;
            top: -1px;
            left: 0;
            width: 100%;
            height: 50px;
            z-index: 20;
            transform: rotate(180deg);
        }

        /* Shimmer Effect for Transitions */
        @keyframes shimmer {
            0% {
                background-position: -100% 0;
            }

            100% {
                background-position: 100% 0;
            }
        }

        .shimmer-line {
            height: 2px;
            background: linear-gradient(90deg,
                    transparent,
                    var(--primary),
                    transparent);
            background-size: 200% 100%;
            animation: shimmer 3s ease-in-out infinite;
        }
    </style>
</head>

<body class="overflow-hidden"> <!-- Initially hidden for cover -->
    @php
        // Data Alias Fix
        $couple = $invitation ?? $couple ?? new \stdClass();
        $events = $invitation ?? $events ?? new \stdClass();

        // Centralized Cover Image Logic
        $coverImage = 'https://bitwave.my.id/wp-content/uploads/2024/12/Heritage-4.jpeg'; // Default

        if (!empty($couple->cover_image)) {
            if (Str::startsWith($couple->cover_image, ['http', 'https'])) {
                $coverImage = $couple->cover_image;
            } else {
                // Fix: Prepend storage/ if missing and not in assets
                $path = $couple->cover_image;
                if (!Str::startsWith($path, 'storage/') && !Str::startsWith($path, 'assets/')) {
                    $path = 'storage/' . $path;
                }
                $coverImage = asset($path);
            }
        }
    @endphp

    <!-- Main Container -->
    <main class="container">
        <!-- Left Section (Desktop Wallpaper) -->
        <section class="section section-left">
            <div style="
                height: 100%;
                width: 100%;
                background: url('{{ $coverImage }}') center center/cover no-repeat;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                position: relative;
            ">
                <div style="position: absolute; width: 100%; height: 100%; background: rgba(0,0,0,0.4);"></div>
                <div style="position: relative; z-index: 10; text-align: center; color: white; padding: 0 40px;">
                    <h2 class="font-pinyon" style="font-size: 36px; margin-bottom: 16px;">The Wedding of</h2>
                    <h1 class="font-cormorant"
                        style="font-size: 60px; font-weight: 700; text-transform: uppercase; margin-bottom: 16px;">
                        {{ $couple->bride_nickname ?? 'Elyana' }} & {{ $couple->groom_nickname ?? 'Syahril' }}
                    </h1>
                    <p class="font-poppins" style="font-size: 18px;">
                        {{ $events->akad_date ? \Carbon\Carbon::parse($events->akad_date)->translatedFormat('l, d F Y') : 'Minggu, 31 Desember 2024' }}
                    </p>
                </div>
            </div>
        </section>

        <!-- Right Section (Mobile Content) -->
        <section class="section section-right" id="main-scroll">

            <!-- 1. COVER / HOME -->
            <article id="cover-section"
                style="position: relative; min-height: 100vh; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                <!-- Bg Video -->
                <video class="video-background" autoplay muted loop playsinline poster="{{ $coverImage }}"
                    style="z-index: 0;">
                    <source src="https://terhubung.id/wp-content/uploads/Motion-Betawi-Compress.mp4" type="video/mp4">
                </video>
                <!-- Overlay -->
                <div
                    style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(0,0,0,0.6), rgba(0,0,0,0.9)); z-index: 10;">
                </div>

                <div
                    style="position: relative; z-index: 20; text-align: center; color: white; padding: 0 32px; width: 100%;">
                    <p class="font-pinyon" style="font-size: 24px; margin-bottom: 16px;" data-aos="fade-down">The
                        Wedding of</p>
                    <h1 class="font-cormorant"
                        style="font-size: 48px; font-weight: 700; line-height: 1.2; text-transform: uppercase; margin-bottom: 32px;"
                        data-aos="zoom-in" data-aos-delay="300">
                        {{ $couple->bride_nickname ?? 'Elyana' }} <br> <span class="font-pinyon"
                            style="font-size: 36px; color: var(--primary); text-transform: none;">&</span> <br>
                        {{ $couple->groom_nickname ?? 'Syahril' }}
                    </h1>

                    <div style="border: 1px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.1); backdrop-filter: blur(4px); border-radius: 12px; padding: 24px; margin-bottom: 32px;"
                        data-aos="fade-up" data-aos-delay="500">
                        <p class="font-poppins" style="font-size: 12px; margin-bottom: 8px;">Kepada Yth:</p>
                        <h3 class="font-cormorant" style="font-size: 24px; font-weight: 700;">
                            {{ $guest_name ?? 'Tamu Undangan' }}
                        </h3>
                    </div>

                    <button id="btn-open" class="btn-gradient" style="animation: pulse 2s infinite;" data-aos="fade-up"
                        data-aos-delay="700">
                        <i class="far fa-envelope"></i> Buka Undangan
                    </button>
                </div>
            </article>

            <!-- 2. Opening Intro -->
            <article id="opening-video"
                style="display: none; position: relative; min-height: 100vh; flex-direction: column; align-items: center; justify-content: center; text-align: center; overflow: hidden;">
                <!-- Background Image -->
                <div
                    style="position: absolute; inset: 0; z-index: 1; background-image: url('{{ $coverImage }}'); background-position: center; background-size: cover; background-repeat: no-repeat;">
                </div>
                <!-- Overlay for text readability -->
                <div
                    style="position: absolute; inset: 0; z-index: 2; background: linear-gradient(to bottom, rgba(0,0,0,0.35), rgba(0,0,0,0.5));">
                </div>

                <!-- Ornament Top -->
                <div class="gigi-balang-top inverted" style="position: absolute; top: 0; left: 0;"></div>
                <!-- Ornament Bottom -->
                <div class="gigi-balang-top" style="position: absolute; bottom: 0; left: 0;"></div>

                <!-- Floral Background (Subtle) -->
                <img src="https://bitwave.my.id/wp-content/uploads/2025/03/Betawi-Couple-Belakang-1.png"
                    style="position: absolute; top: 10%; right: -50px; width: 200px; opacity: 0.15; transform: rotate(-15deg); z-index: 1;">

                <!-- Betawi Icon (Pending custom SVG, using FontAwesome placeholder stylized) -->
                <div
                    style="position: absolute; top: 60px; left: 50%; transform: translateX(-50%); z-index: 4; color: var(--primary);">
                    <i class="fas fa-star-and-crescent" style="font-size: 32px; opacity: 0.8;"></i>
                </div>

                <!-- Content -->
                <div id="intro-content"
                    style="position: relative; z-index: 10; padding: 120px 24px 80px; color: white;">
                    <p class="font-cormorant"
                        style="font-weight: 700; text-transform: uppercase; margin-bottom: 8px; color: white;">
                        The Wedding of</p>
                    <h2 class="font-pinyon" style="font-size: 48px; color: var(--primary); margin-bottom: 8px;">
                        {{ $couple->bride_nickname ?? 'Elyana' }}
                    </h2>
                    <span class="font-alex"
                        style="font-size: 36px; display: block; margin: 8px 0; color: white;">&</span>
                    <h2 class="font-pinyon" style="font-size: 48px; color: var(--primary); margin-bottom: 24px;">
                        {{ $couple->groom_nickname ?? 'Syahril' }}
                    </h2>
                    <p class="font-cormorant"
                        style="font-size: 20px; font-weight: 700; letter-spacing: 4px; color: white;">
                        {{ $events->akad_date ? \Carbon\Carbon::parse($events->akad_date)->format('d . m . y') : '31 . 12 . 25' }}
                    </p>

                    <!-- Scroll Indicator -->
                    <div style="margin-top: 48px;">
                        <i class="fas fa-chevron-down scroll-indicator"
                            style="font-size: 24px; color: var(--primary);"></i>
                        <p class="font-poppins" style="font-size: 10px; margin-top: 8px; color: rgba(255,255,255,0.8);">
                            Scroll ke bawah
                        </p>
                    </div>
                </div>
            </article>

            <!-- 3. QUOTE -->
            <article
                style="position: relative; padding: 64px 24px; background: #1B1B1B; text-align: center; overflow: hidden;">
                <!-- Background Ornament -->
                <!-- Background Ornament (Batik) -->
                <div class="bg-batik" style="position: absolute; inset: 0; opacity: 0.1;"></div>
                <!-- Top/Bottom Border -->
                <div class="gigi-balang-top inverted"
                    style="position: absolute; top: 0; left: 0; height: 20px; background-size: 10px 20px;"></div>
                <div class="gigi-balang-top"
                    style="position: absolute; bottom: 0; left: 0; height: 20px; background-size: 10px 20px;"></div>

                <!-- Corner Florals (Reusing Couple Assets) -->
                <img src="https://bitwave.my.id/wp-content/uploads/2025/03/Betawi-Couple-Depan-2.png"
                    class="ornament-left"
                    style="position: absolute; top: -20px; left: -20px; width: 100px; opacity: 0.4; transform: rotate(-45deg);">
                <img src="https://bitwave.my.id/wp-content/uploads/2025/03/Betawi-Couple-Depan-2.png"
                    class="ornament-right"
                    style="position: absolute; bottom: -20px; right: -20px; width: 100px; opacity: 0.4; transform: rotate(135deg);">

                <div style="position: relative; z-index: 10;" data-aos="fade-up">
                    <!-- Quote Card -->
                    <div
                        style="background: #FFFCF3; color: black; border-radius: 24px; padding: 40px 24px; position: relative; overflow: hidden; border: 2px solid var(--primary); box-shadow: 0 20px 40px rgba(0,0,0,0.3);">
                        <!-- Inner Patterns -->
                        <img src="https://bitwave.my.id/wp-content/uploads/2025/03/Melayu-Motif-Atas.png"
                            style="position: absolute; top: 0; left: 0; width: 100%; opacity: 0.4;">
                        <img src="https://bitwave.my.id/wp-content/uploads/2025/03/Melayu-Motif-Bawah.png"
                            style="position: absolute; bottom: 0; left: 0; width: 100%; opacity: 0.4;">

                        <div style="position: relative; z-index: 10;">
                            <!-- Dayak Icon -->
                            <!-- Icon -->
                            <div style="text-align: center; margin-bottom: 16px; color: var(--primary);">
                                <i class="fas fa-quote-right" style="font-size: 24px;"></i>
                            </div>

                            <!-- Couple Initials -->
                            <div class="font-cormorant"
                                style="font-size: 32px; font-weight: 700; color: var(--primary); margin-bottom: 20px;">
                                {{ substr($couple->bride_nickname ?? 'E', 0, 1) }}
                                <span class="font-pinyon" style="font-size: 24px; color: #333;">&</span>
                                {{ substr($couple->groom_nickname ?? 'S', 0, 1) }}
                            </div>

                            <!-- Quote Text from Database -->
                            <p class="font-cormorant"
                                style="font-style: italic; font-weight: 600; font-size: 16px; margin-bottom: 16px; line-height: 1.7; color: #333;">
                                "{{ $couple->quote_text ?? 'Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya.' }}"
                            </p>

                            <!-- Quote Author from Database -->
                            <p class="font-cormorant" style="font-weight: 700; font-size: 14px; color: var(--primary);">
                                - {{ $couple->quote_author ?? 'QS. Ar-Rum : 21' }} -
                            </p>
                        </div>
                    </div>
                </div>
            </article>

            <!-- 4. COUPLE PROFILES -->
            <article
                style="background: #FFFCF3; padding: 64px 24px; text-align: center; position: relative; overflow: hidden;">
                <!-- Bg Patterns -->
                <!-- Bg Patterns -->
                <div class="bg-batik" style="position: absolute; inset: 0; opacity: 0.05;"></div>

                <div style="position: relative; z-index: 10; border: 4px solid var(--primary); border-radius: 100px; padding: 48px 16px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); background: rgba(255,255,255,0.5); backdrop-filter: blur(4px);"
                    data-aos="zoom-in-up">
                    <div style="margin-bottom: 24px; color: var(--primary);">
                        <i class="fas fa-heart" style="font-size: 48px; opacity: 0.8;"></i>
                    </div>
                    <h2 class="font-pinyon" style="font-size: 36px; color: black; margin-bottom: 16px;">We
                        are<br>Getting Married!</h2>

                    <!-- Bride -->
                    <div style="margin-top: 48px; margin-bottom: 32px; position: relative;" data-aos="fade-up">
                        <div style="width: 180px; height: 180px; margin: 0 auto 16px; position: relative;">
                            <!-- Left Floral Ornament -->
                            <img src="https://bitwave.my.id/wp-content/uploads/2025/03/Betawi-Couple-Belakang-2.png"
                                class="ornament-left"
                                style="position: absolute; top: 50%; left: -60px; width: 100px; max-width: none; opacity: 0.9; transform-origin: center; z-index: 1;">

                            <div class="frame-betawi"
                                style="width: 100%; height: 100%; position: relative; z-index: 10;">
                                <!-- Photo -->
                                <img src="{{ $couple->bride_photo ?? 'https://bitwave.my.id/wp-content/uploads/2024/12/Heritage-cpw.jpeg' }}"
                                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                            </div>

                            <!-- Right Floral Ornament -->
                            <img src="https://bitwave.my.id/wp-content/uploads/2025/03/Betawi-Couple-Depan-2.png"
                                class="ornament-right"
                                style="position: absolute; top: 40%; right: -50px; width: 90px; z-index: 15; opacity: 1; transform-origin: center;">
                        </div>
                        <h3 class="font-pinyon" style="font-size: 36px; color: var(--primary);">
                            {{ $couple->bride_nickname ?? 'Elyana' }}
                        </h3>
                        <p class="font-cormorant" style="font-size: 20px; font-weight: 700; text-transform: uppercase;">
                            {{ $couple->bride_name ?? 'Elyana Azkiya Nur' }}
                        </p>
                        <p class="font-poppins" style="font-size: 12px; margin-top: 8px; color: #4B5563;">Putri dari
                            Bpk. {{ $couple->bride_father ?? '...' }} & Ibu {{ $couple->bride_mother ?? '...' }}</p>
                        @if(!empty($couple->bride_instagram))
                            <a href="{{ $couple->bride_instagram }}" target="_blank" class="btn-gradient"
                                style="margin-top: 16px; padding: 8px 16px; font-size: 12px;"><i
                                    class="fab fa-instagram"></i> Instagram</a>
                        @endif
                    </div>

                    <div class="font-cormorant"
                        style="font-size: 36px; font-weight: 700; color: black; margin: 16px 0;">&</div>

                    <!-- Groom -->
                    <div style="margin-bottom: 32px; position: relative;" data-aos="fade-up">
                        <div style="width: 180px; height: 180px; margin: 0 auto 16px; position: relative;">
                            <!-- Left Floral Ornament -->
                            <img src="https://bitwave.my.id/wp-content/uploads/2025/03/Betawi-Couple-Depan-1.png"
                                class="ornament-left"
                                style="position: absolute; top: 40%; left: -50px; width: 90px; z-index: 15; opacity: 1; transform-origin: center;">

                            <div class="frame-betawi"
                                style="width: 100%; height: 100%; position: relative; z-index: 10;">
                                <!-- Photo -->
                                <img src="{{ $couple->groom_photo ?? 'https://bitwave.my.id/wp-content/uploads/2024/12/Heritage-cpp.jpeg' }}"
                                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                            </div>

                            <!-- Right Floral Ornament -->
                            <img src="https://bitwave.my.id/wp-content/uploads/2025/03/Betawi-Couple-Belakang-1.png"
                                class="ornament-right"
                                style="position: absolute; top: 50%; right: -60px; width: 100px; max-width: none; opacity: 0.9; transform-origin: center; z-index: 1;">
                        </div>
                        <h3 class="font-pinyon" style="font-size: 36px; color: var(--primary);">
                            {{ $couple->groom_nickname ?? 'Syahril' }}
                        </h3>
                        <p class="font-cormorant" style="font-size: 20px; font-weight: 700; text-transform: uppercase;">
                            {{ $couple->groom_name ?? 'Syahril Rendra' }}
                        </p>
                        <p class="font-poppins" style="font-size: 12px; margin-top: 8px; color: #4B5563;">Putra dari
                            Bpk. {{ $couple->groom_father ?? '...' }} & Ibu {{ $couple->groom_mother ?? '...' }}</p>
                        @if(!empty($couple->groom_instagram))
                            <a href="{{ $couple->groom_instagram }}" target="_blank" class="btn-gradient"
                                style="margin-top: 16px; padding: 8px 16px; font-size: 12px;"><i
                                    class="fab fa-instagram"></i> Instagram</a>
                        @endif
                    </div>
                </div>
            </article>

            <!-- 5. LOVE STORY -->
            @php
                $loveStories = [];
                if (!empty($couple->love_stories)) {
                    $loveStories = is_string($couple->love_stories) ? json_decode($couple->love_stories, true) : $couple->love_stories;
                }
            @endphp
            @if(!empty($loveStories) && count($loveStories) > 0)
                <article style="padding: 64px 24px 80px; background: #f6f6f0; position: relative;" data-aos="fade-up">
                    <div style="text-align: center; margin-bottom: 40px; position: relative;">
                        <!-- Floral Accent -->
                        <img src="https://bitwave.my.id/wp-content/uploads/2025/03/Betawi-Couple-Depan-2.png"
                            style="position: absolute; top: -30px; left: 10px; width: 60px; opacity: 0.8; transform: rotate(-20deg);">

                        <h2 class="font-pinyon" style="font-size: 36px; margin-bottom: 8px;">Love Story</h2>
                        <div style="width: 60px; height: 2px; background: var(--primary); margin: 8px auto;"></div>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 24px;">
                        @foreach($loveStories as $index => $story)
                            <div style="background: #FFFCF3; border: 2px solid var(--primary); border-radius: 12px; padding: 24px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); position: relative;"
                                data-aos="{{ $index % 2 == 0 ? 'fade-left' : 'fade-right' }}">
                                <span
                                    style="position: absolute; top: -16px; {{ $index % 2 == 0 ? 'left: 24px' : 'right: 24px' }}; background: var(--primary); color: white; padding: 4px 16px; font-family: 'Cormorant Garamond', serif; font-weight: 700;">
                                    {{ $story['year'] ?? '' }}
                                </span>
                                <p class="font-poppins" style="margin-top: 8px; font-size: 14px; text-align: justify;">
                                    {{ $story['story'] ?? '' }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </article>
            @endif

            <!-- Smooth Gradient Transition from Love Story to Our Moments -->
            <div style="height: 40px; background: linear-gradient(to bottom, #f6f6f0 0%, rgba(0,0,0,0.3) 100%);"></div>

            <!-- 6. PHOTO GALLERY SLIDESHOW (Our Moments) -->
            @php
                $galleryPhotos = [];

                // 1. Gunakan gallery_photos dari database (sumber utama)
                if (!empty($couple->gallery_photos)) {
                    $galleryPhotos = is_string($couple->gallery_photos) ? json_decode($couple->gallery_photos, true) : $couple->gallery_photos;
                }
                // 2. Fallback ke $gallery dari InvitationDataBuilderService
                elseif (!empty($gallery) && is_array($gallery)) {
                    $galleryPhotos = $gallery;
                }

                // Fallback to default images if empty
                if (empty($galleryPhotos)) {
                    $galleryPhotos = [
                        ['url' => 'https://bitwave.my.id/wp-content/uploads/2024/12/Heritage-1.jpeg'],
                        ['url' => 'https://bitwave.my.id/wp-content/uploads/2024/12/Heritage-2.jpeg'],
                        ['url' => 'https://bitwave.my.id/wp-content/uploads/2024/12/Heritage-3.jpeg'],
                        ['url' => 'https://bitwave.my.id/wp-content/uploads/2024/12/Heritage-15.jpeg'],
                    ];
                }

                // Get first 4 photos only for "Our Moments" section
                $galleryPhotos = array_slice($galleryPhotos, 0, 4);
            @endphp
            <article id="moments-section" style="position: relative; height: 400px; overflow: hidden;">
                <!-- Slideshow Images -->
                @foreach($galleryPhotos as $index => $photo)
                    <div class="slide-image"
                        style="position: absolute; inset: 0; opacity: {{ $index === 0 ? '1' : '0' }}; transition: opacity 1s ease-in-out;">
                        <img src="{{ is_array($photo) ? ($photo['url'] ?? $photo) : $photo }}"
                            style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                @endforeach

                <!-- Gradient Overlay -->
                <div
                    style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.2) 40%, rgba(0,0,0,0.2) 60%, rgba(0,0,0,0.6) 100%); z-index: 5;">
                </div>

                <!-- Content -->
                <div
                    style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; z-index: 10;">
                    <h2 class="font-pinyon"
                        style="font-size: 48px; color: white; text-shadow: 0 4px 20px rgba(0,0,0,0.5);"
                        data-aos="zoom-in">Our Moments</h2>
                </div>

                <!-- Slide Indicators -->
                <div
                    style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); display: flex; gap: 8px; z-index: 10;">
                    @foreach($galleryPhotos as $index => $photo)
                        <span class="slide-dot"
                            style="width: 10px; height: 10px; border-radius: 50%; background: {{ $index === 0 ? 'var(--primary)' : 'rgba(255,255,255,0.5)' }}; transition: background 0.3s;"></span>
                    @endforeach
                </div>
            </article>

            <!-- Ornamental Divider between Our Moments and Events -->
            <div class="ornament-divider"
                style="background: linear-gradient(to bottom, rgba(0,0,0,0.8), #FFFCF3); padding: 40px 0;">
                <div class="pattern-gigi-balang" style="width: 100%;"></div>
            </div>

            <!-- 7. EVENT DETAILS -->
            <article
                style="padding: 40px 24px 64px; background: linear-gradient(to bottom, #FFFCF3, #F5E6C4); position: relative; overflow: hidden;">
                <!-- Ornaments -->
                <!-- Ornaments -->
                <div class="bg-batik" style="position: absolute; inset: 0; opacity: 0.05;"></div>
                <div class="gigi-balang-top inverted" style="position: absolute; top: 0; left: 0;"></div>
                <div class="gigi-balang-top" style="position: absolute; bottom: 0; left: 0;"></div>

                <div style="text-align: center; margin-bottom: 40px; position: relative; z-index: 10;"
                    data-aos="fade-down">
                    <div style="margin-bottom: 16px; color: var(--primary);">
                        <i class="far fa-calendar-alt" style="font-size: 36px;"></i>
                    </div>
                    <h2 class="font-pinyon" style="font-size: 48px; color: #333;">Save the Date</h2>
                    <p class="font-poppins" style="font-size: 12px; margin-top: 16px; padding: 0 16px; color: #666;">
                        Dengan memohon
                        rahmat dan ridho Allah SWT, kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri:</p>
                </div>

                <!-- Akad -->
                <div style="background: white; color: black; border-radius: 24px; padding: 32px 24px; text-align: center; margin-bottom: 32px; border: 2px solid var(--primary); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); position: relative; z-index: 10;"
                    data-aos="fade-up">
                    <h3 class="font-pinyon" style="font-size: 36px; margin-bottom: 8px;">Akad Nikah</h3>
                    <div
                        style="border-top: 1px solid rgba(215, 187, 131, 0.3); border-bottom: 1px solid rgba(215, 187, 131, 0.3); padding: 16px 0; margin: 16px 0;">
                        <p class="font-cormorant" style="font-size: 24px; font-weight: 700; text-transform: uppercase;">
                            {{ $events->akad_date ? \Carbon\Carbon::parse($events->akad_date)->translatedFormat('l') : 'Minggu' }}
                        </p>
                        <p class="font-cormorant" style="font-size: 24px; font-weight: 700; color: var(--primary);">
                            {{ $events->akad_date ? \Carbon\Carbon::parse($events->akad_date)->translatedFormat('d F Y') : '31 Des 2025' }}
                        </p>
                        <p class="font-poppins" style="font-size: 14px; margin-top: 4px;">
                            {{ $events->akad_time ?? '08:00 WIB' }}
                        </p>
                    </div>
                    <p class="font-cormorant" style="font-weight: 700; font-size: 18px; margin-bottom: 4px;">
                        {{ $events->akad_location ?? 'Masjid Agung' }}
                    </p>
                    <p class="font-poppins" style="font-size: 12px; margin-bottom: 16px; color: #4B5563;">
                        {{ $events->akad_address ?? 'Jalan Raya No. 1' }}
                    </p>
                    <a href="{{ $events->akad_map_link ?? '#' }}" target="_blank"
                        style="display: inline-block; background: var(--primary); color: white; padding: 12px 32px; border-radius: 8px; font-size: 14px; text-decoration: none; font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-map-marker-alt" style="margin-right: 8px;"></i>Google Maps
                    </a>
                </div>

                <!-- Resepsi -->
                <div style="background: white; color: black; border-radius: 24px; padding: 32px 24px; text-align: center; border: 2px solid var(--primary); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); position: relative; z-index: 10;"
                    data-aos="fade-up" data-aos-delay="200">
                    <h3 class="font-pinyon" style="font-size: 36px; margin-bottom: 8px;">Resepsi</h3>
                    <div
                        style="border-top: 1px solid rgba(215, 187, 131, 0.3); border-bottom: 1px solid rgba(215, 187, 131, 0.3); padding: 16px 0; margin: 16px 0;">
                        <p class="font-cormorant" style="font-size: 24px; font-weight: 700; text-transform: uppercase;">
                            {{ $events->resepsi_date ? \Carbon\Carbon::parse($events->resepsi_date)->translatedFormat('l') : 'Minggu' }}
                        </p>
                        <p class="font-cormorant" style="font-size: 24px; font-weight: 700; color: var(--primary);">
                            {{ $events->resepsi_date ? \Carbon\Carbon::parse($events->resepsi_date)->translatedFormat('d F Y') : '31 Des 2025' }}
                        </p>
                        <p class="font-poppins" style="font-size: 14px; margin-top: 4px;">
                            {{ $events->resepsi_time ?? '11:00 - 13:00 WIB' }}
                        </p>
                    </div>
                    <p class="font-cormorant" style="font-weight: 700; font-size: 18px; margin-bottom: 4px;">
                        {{ $events->resepsi_location ?? 'Gedung Serbaguna' }}
                    </p>
                    <p class="font-poppins" style="font-size: 12px; margin-bottom: 16px; color: #4B5563;">
                        {{ $events->resepsi_address ?? 'Jalan Raya No. 1' }}
                    </p>
                    <a href="{{ $events->resepsi_map_link ?? '#' }}" target="_blank"
                        style="display: inline-block; background: var(--primary); color: white; padding: 12px 32px; border-radius: 8px; font-size: 14px; text-decoration: none; font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-map-marker-alt" style="margin-right: 8px;"></i>Google Maps
                    </a>
                </div>
            </article>

            <!-- 8. COUNTDOWN -->
            <article
                style="padding: 48px 24px; background: linear-gradient(to bottom, #F5E6C4, #D7BB83); text-align: center;">
                <h3 class="font-cormorant" style="font-size: 24px; margin-bottom: 24px; font-weight: 700; color: #333;"
                    data-aos="fade-up">Menuju Hari Bahagia</h3>
                <div id="countdown" style="display: flex; justify-content: center; gap: 12px;" data-aos="zoom-in">
                    <div
                        style="background: white; border: 2px solid var(--primary); padding: 12px; border-radius: 12px; width: 64px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                        <span id="days"
                            style="display: block; font-family: 'Cormorant Garamond', serif; font-size: 30px; font-weight: 700; color: var(--primary);">00</span>
                        <span
                            style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.05em; color: #666;">Hari</span>
                    </div>
                    <div
                        style="background: white; border: 2px solid var(--primary); padding: 12px; border-radius: 12px; width: 64px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                        <span id="hours"
                            style="display: block; font-family: 'Cormorant Garamond', serif; font-size: 30px; font-weight: 700; color: var(--primary);">00</span>
                        <span
                            style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.05em; color: #666;">Jam</span>
                    </div>
                    <div
                        style="background: white; border: 2px solid var(--primary); padding: 12px; border-radius: 12px; width: 64px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                        <span id="minutes"
                            style="display: block; font-family: 'Cormorant Garamond', serif; font-size: 30px; font-weight: 700; color: var(--primary);">00</span>
                        <span
                            style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.05em; color: #666;">Menit</span>
                    </div>
                    <div
                        style="background: white; border: 2px solid var(--primary); padding: 12px; border-radius: 12px; width: 64px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                        <span id="seconds"
                            style="display: block; font-family: 'Cormorant Garamond', serif; font-size: 30px; font-weight: 700; color: var(--primary);">00</span>
                        <span
                            style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.05em; color: #666;">Detik</span>
                    </div>
                </div>
            </article>

            <!-- 9. GALLERY (GRID) - Shows photo 5 onwards (skips first 4 used in "Our Moments") -->
            @php
                $galleryGrid = [];

                // 1. Try to get from $gallery (proper contract data)
                if (!empty($gallery) && is_array($gallery)) {
                    $galleryGrid = $gallery;
                }
                // 2. Fallback to $couple->gallery_photos (legacy support)
                elseif (!empty($couple->gallery_photos)) {
                    $galleryGrid = is_string($couple->gallery_photos) ? json_decode($couple->gallery_photos, true) : $couple->gallery_photos;
                }
                // 3. Fallback to $couple->gallery (alternative legacy)
                elseif (!empty($couple->gallery)) {
                    $galleryGrid = is_string($couple->gallery) ? json_decode($couple->gallery, true) : $couple->gallery;
                }

                // Take the last 5 photos from user's uploaded gallery
                if (!empty($galleryGrid)) {
                    $totalPhotos = count($galleryGrid);
                    // If more than 5 photos, take the last 5
                    if ($totalPhotos > 5) {
                        $galleryGrid = array_slice($galleryGrid, -5);
                    }
                    // Otherwise, just use all available photos (up to 5)
                }

                // Fallback to default images if empty after slicing
                if (empty($galleryGrid)) {
                    $galleryGrid = [
                        ['url' => 'https://bitwave.my.id/wp-content/uploads/2024/12/Heritage-5.jpeg'],
                        ['url' => 'https://bitwave.my.id/wp-content/uploads/2024/12/Heritage-12.jpeg'],
                        ['url' => 'https://bitwave.my.id/wp-content/uploads/2024/12/Heritage-9.jpeg'],
                        ['url' => 'https://bitwave.my.id/wp-content/uploads/2024/12/Heritage-11.jpeg'],
                        ['url' => 'https://bitwave.my.id/wp-content/uploads/2024/12/Heritage-7.jpeg'],
                    ];
                }
            @endphp

            <!-- Smooth Transition to Gallery -->
            <div style="background: linear-gradient(to bottom, #F5E6C4, #1B1B1B); height: 60px; position: relative;">
                <div class="shimmer-line" style="position: absolute; top: 50%; width: 100%;"></div>
            </div>

            <article style="padding: 48px 16px 64px; background: #1B1B1B;">
                <h2 class="font-pinyon"
                    style="font-size: 36px; text-align: center; color: var(--primary); margin-bottom: 32px;"
                    data-aos="fade-up">Our Gallery</h2>

                {{-- Gallery Layout: 2 photos top, 1 large middle, 2 photos bottom --}}
                <div style="display: flex; flex-direction: column; gap: 8px; padding: 0 8px;" data-aos="fade-up">

                    {{-- Row 1: 2 photos side by side --}}
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                        @foreach(array_slice($galleryGrid, 0, 2) as $index => $photo)
                            @php
                                $photoUrl = is_array($photo) ? ($photo['url'] ?? $photo) : $photo;
                                $photoUrl = Str::startsWith($photoUrl, ['http', 'https']) ? $photoUrl : asset('storage/' . $photoUrl);
                            @endphp
                            <div style="aspect-ratio: 1/1; overflow: hidden; border-radius: 12px;">
                                <img src="{{ $photoUrl }}"
                                    style="width: 100%; height: 100%; object-fit: cover; object-position: center; transition: transform 0.3s ease;"
                                    onmouseover="this.style.transform='scale(1.05)'"
                                    onmouseout="this.style.transform='scale(1)'">
                            </div>
                        @endforeach
                    </div>

                    {{-- Row 2: 1 large photo (full width) --}}
                    @if(isset($galleryGrid[2]))
                        @php
                            $photo = $galleryGrid[2];
                            $photoUrl = is_array($photo) ? ($photo['url'] ?? $photo) : $photo;
                            $photoUrl = Str::startsWith($photoUrl, ['http', 'https']) ? $photoUrl : asset('storage/' . $photoUrl);
                        @endphp
                        <div style="width: 100%; aspect-ratio: 16/10; overflow: hidden; border-radius: 12px;">
                            <img src="{{ $photoUrl }}"
                                style="width: 100%; height: 100%; object-fit: cover; object-position: center; transition: transform 0.3s ease;"
                                onmouseover="this.style.transform='scale(1.05)'"
                                onmouseout="this.style.transform='scale(1)'">
                        </div>
                    @endif

                    {{-- Row 3: 2 photos side by side --}}
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                        @foreach(array_slice($galleryGrid, 3, 2) as $index => $photo)
                            @php
                                $photoUrl = is_array($photo) ? ($photo['url'] ?? $photo) : $photo;
                                $photoUrl = Str::startsWith($photoUrl, ['http', 'https']) ? $photoUrl : asset('storage/' . $photoUrl);
                            @endphp
                            <div style="aspect-ratio: 1/1; overflow: hidden; border-radius: 12px;">
                                <img src="{{ $photoUrl }}"
                                    style="width: 100%; height: 100%; object-fit: cover; object-position: center; transition: transform 0.3s ease;"
                                    onmouseover="this.style.transform='scale(1.05)'"
                                    onmouseout="this.style.transform='scale(1)'">
                            </div>
                        @endforeach
                    </div>

                </div>
            </article>

            <!-- 10. RSVP -->
            <article style="padding: 48px 24px; background: #FFFCF3; text-align: center;" data-aos="fade-up">
                <h2 class="font-pinyon" style="font-size: 36px; margin-bottom: 24px;">RSVP</h2>
                <p class="font-poppins" style="font-size: 12px; margin-bottom: 24px;">Konfirmasi kehadiran Anda sangat
                    berarti bagi kami.</p>

                <form id="rsvp-form" method="POST" action="{{ route('public.rsvp.store') }}"
                    style="background: white; padding: 24px; border-radius: 16px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border: 1px solid rgba(215, 187, 131, 0.2);">
                    @csrf
                    <input type="hidden" name="invitation_id" value="{{ $couple->id ?? '' }}">
                    <input type="text" name="name" class="form-input" placeholder="Nama Tamu"
                        value="{{ $guest_name ?? '' }}" required>
                    <input type="number" name="amount" class="form-input" placeholder="Jumlah Orang" value="1" min="1"
                        required>
                    <input type="hidden" name="status" id="rsvp-status" value="hadir">
                    <div class="attendance-buttons">
                        <button type="button" class="attendance-btn active" data-status="hadir">Hadir</button>
                        <button type="button" class="attendance-btn" data-status="tidak_hadir">Maaf, Tidak Bisa</button>
                    </div>
                    <textarea name="message" class="form-textarea" placeholder="Ucapan & Doa (opsional)"
                        style="margin-bottom: 16px; min-height: 80px;"></textarea>
                    <button type="submit" class="btn-gradient" style="width: 100%;">Kirim Konfirmasi</button>
                </form>
            </article>

            <!-- 11. WEDDING GIFT -->
            @php
                $bankAccounts = [];
                if (!empty($couple->bank_accounts)) {
                    $bankAccounts = is_string($couple->bank_accounts) ? json_decode($couple->bank_accounts, true) : $couple->bank_accounts;
                }
                $giftAddress = $couple->gift_address ?? 'Alamat belum diisi';
            @endphp
            <article
                style="padding: 64px 24px; background: #1B1B1B; color: white; text-align: center; position: relative; overflow: hidden;">
                <div class="bg-batik" style="position: absolute; inset: 0; opacity: 0.05;"></div>
                <div class="gigi-balang-top inverted" style="position: absolute; top: 0; left: 0; height: 20px;"></div>
                <div style="position: relative; z-index: 10;" data-aos="zoom-in">
                    <i class="fas fa-gift" style="font-size: 36px; color: var(--primary); margin-bottom: 16px;"></i>
                    <h2 class="font-pinyon" style="font-size: 36px; margin-bottom: 8px;">Wedding Gift</h2>
                    <p class="font-poppins" style="font-size: 12px; margin-bottom: 32px; color: rgba(255,255,255,0.7);">
                        Wujud tanda kasih untuk kedua mempelai</p>

                    @if(!empty($bankAccounts))
                        @foreach($bankAccounts as $bank)
                            <div
                                style="background: white; color: black; padding: 24px; border-radius: 16px; margin-bottom: 16px;">
                                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px;">
                                    <i class="fas fa-university" style="font-size: 32px; color: var(--primary);"></i>
                                    <div style="text-align: left;">
                                        <p style="font-weight: 700; font-size: 14px;">{{ $bank['bank_name'] ?? 'Bank' }}</p>
                                        <p style="font-size: 12px;" id="account-{{ $loop->index }}">
                                            {{ $bank['account_number'] ?? '-' }}
                                        </p>
                                        <p style="font-size: 12px;">a.n {{ $bank['account_holder'] ?? '-' }}</p>
                                    </div>
                                </div>
                                <button onclick="copyToClipboard('{{ $bank['account_number'] ?? '' }}')"
                                    style="width: 100%; border: 1px solid var(--primary); color: var(--primary); padding: 8px; border-radius: 4px; font-size: 12px; background: none; cursor: pointer;">
                                    <i class="fas fa-copy" style="margin-right: 4px;"></i> Salin Rekening
                                </button>
                            </div>
                        @endforeach
                    @else
                        <div
                            style="background: white; color: black; padding: 24px; border-radius: 16px; margin-bottom: 16px;">
                            <p style="font-size: 14px; color: #666;">Tidak ada rekening yang tersedia.</p>
                        </div>
                    @endif

                    @if(!empty($couple->gift_address))
                        <div style="background: white; color: black; padding: 24px; border-radius: 16px;">
                            <div style="text-align: left; margin-bottom: 16px;">
                                <p style="font-weight: 700; font-size: 14px;"><i class="fas fa-home"
                                        style="color: var(--primary); margin-right: 8px;"></i> Kirim Kado</p>
                                <p style="font-size: 12px; margin-top: 4px;">{{ $couple->gift_address }}</p>
                            </div>
                            <button onclick="copyToClipboard('{{ $couple->gift_address }}')"
                                style="width: 100%; border: 1px solid var(--primary); color: var(--primary); padding: 8px; border-radius: 4px; font-size: 12px; background: none; cursor: pointer;">
                                <i class="fas fa-copy" style="margin-right: 4px;"></i> Salin Alamat
                            </button>
                        </div>
                    @endif
                </div>
            </article>

            <!-- 12. WISHES -->
            <article style="padding: 64px 24px; background: #FFFCF3; text-align: center;">
                <h2 class="font-pinyon" style="font-size: 36px; margin-bottom: 24px;" data-aos="fade-up">Ucapan & Doa
                </h2>

                <div style="height: 320px; overflow-y: auto; text-align: left; padding: 16px; background: white; border-radius: 12px; box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);"
                    data-aos="fade-up">
                    @if(!empty($rsvps) && count($rsvps) > 0)
                        @foreach($rsvps as $rsvp)
                            @if(!empty($rsvp->message))
                                <div style="border-bottom: 1px solid #f3f4f6; padding-bottom: 12px; margin-bottom: 12px;">
                                    <div
                                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                        <p style="font-weight: 700; font-size: 14px; color: var(--primary);">{{ $rsvp->name }}</p>
                                        <span
                                            style="font-size: 10px; color: #9CA3AF;">{{ $rsvp->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p style="font-size: 12px; color: #4B5563;">{{ $rsvp->message }}</p>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div style="text-align: center; padding: 40px 20px; color: #9CA3AF;">
                            <i class="fas fa-heart" style="font-size: 32px; margin-bottom: 12px; opacity: 0.5;"></i>
                            <p style="font-size: 14px;">Belum ada ucapan.</p>
                            <p style="font-size: 12px;">Jadilah yang pertama memberikan doa!</p>
                        </div>
                    @endif
                </div>
            </article>

            <!-- 13. THANK YOU -->
            @php
                $footerImage = $coverImage; // Use the same cover image from top
                if (!empty($galleryGrid) && count($galleryGrid) > 0) {
                    $lastPhoto = end($galleryGrid);
                    $footerImage = is_array($lastPhoto) ? ($lastPhoto['url'] ?? $lastPhoto) : $lastPhoto;
                    $footerImage = Str::startsWith($footerImage, ['http', 'https']) ? $footerImage : asset('storage/' . $footerImage);
                }
            @endphp
            <article
                style="position: relative; padding: 80px 24px; text-align: center; color: white; display: flex; flex-direction: column; justify-content: flex-end; min-height: 500px; background: url('{{ $footerImage }}') center center/cover no-repeat;">
                <div
                    style="position: absolute; inset: 0; background: linear-gradient(to top, black, rgba(0,0,0,0.5), transparent);">
                </div>
                <div style="position: relative; z-index: 10;" data-aos="fade-up">
                    <p class="font-poppins" style="font-size: 12px; margin-bottom: 24px; opacity: 0.9;">
                        Suatu kehormatan & kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir memberikan
                        doa restu.
                    </p>
                    <h3 class="font-pinyon" style="font-size: 36px; margin-bottom: 32px;">
                        {{ $couple->bride_nickname ?? 'Bride' }} & {{ $couple->groom_nickname ?? 'Groom' }}
                    </h3>
                    <div style="font-size: 10px; opacity: 0.6;">
                        Designed by <b>Langitara</b>
                    </div>
                </div>
            </article>

        </section>
    </main>

    <!-- Music Player (Langitara Standard) -->
    @if($invitation->music)
        <!-- Case 1: Custom Music (Spotify/YouTube/SoundCloud Embed) -->
        <div id="custom-music-player" class="music-player"
            style="box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); cursor: pointer;" onclick="toggleCustomPlayer()">
            @if($invitation->music->provider === 'spotify')
                <i class="fab fa-spotify" style="font-size: 24px; color: #1DB954;"></i>
            @elseif($invitation->music->provider === 'youtube')
                <i class="fab fa-youtube" style="font-size: 24px; color: #FF0000;"></i>
            @else
                <i class="fab fa-soundcloud" style="font-size: 24px; color: #ff5500;"></i>
            @endif
        </div>
        <div id="custom-music-embed"
            style="display: none; position: fixed; bottom: 80px; right: 16px; z-index: 9999; 
                     background: white; border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); overflow: hidden; width: 320px;">
            <div
                style="display: flex; justify-content: space-between; align-items: center; padding: 8px 12px; background: #f3f4f6;">
                <span style="font-size: 10px; font-weight: bold; text-transform: uppercase; color: #6b7280;">Music
                    Player</span>
                <button onclick="toggleCustomPlayer()"
                    style="background: none; border: none; color: #9ca3af; cursor: pointer;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @if($invitation->music->provider === 'spotify')
                <iframe src="{{ $invitation->music->embed_url }}" width="100%" height="152" frameBorder="0"
                    allow="autoplay; clipboard-write; encrypted-media" loading="lazy"></iframe>
            @elseif($invitation->music->provider === 'soundcloud')
                <iframe width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay"
                    src="{{ $invitation->music->embed_url }}"></iframe>
            @else
                <div style="aspect-ratio: 16/9;">
                    <iframe src="{{ $invitation->music->embed_url }}" width="100%" height="100%" frameborder="0"
                        allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>
            @endif
        </div>
        <script>
            function toggleCustomPlayer() {
                const embed = document.getElementById('custom-music-embed');
                embed.style.display = embed.style.display === 'none' ? 'block' : 'none';
            }
        </script>
    @else
        <!-- Case 2: Library Music (Standard Audio) -->
        @php
            $musicUrl = !empty($invitation->music_path)
                ? asset($invitation->music_path)
                : asset('assets/music/romantic.mp3');
        @endphp
        <div id="btn-music" class="music-player" style="box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
            <img src="{{ asset('favicon.png') }}" alt="Music" class="music-icon"
                style="width: 28px; height: 28px; object-fit: contain;">
        </div>
        <audio id="music-audio" loop>
            <source src="{{ $musicUrl }}" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    @endif

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Init AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 50
        });

        // Elements
        const btnOpen = document.getElementById('btn-open');
        const coverSection = document.getElementById('cover-section');
        const openingVideo = document.getElementById('opening-video');

        // Music elements (may not exist if custom music is used)
        const musicBtn = document.getElementById('btn-music');
        const musicIcon = musicBtn ? musicBtn.querySelector('.music-icon') : null;
        const audio = document.getElementById('music-audio');
        const customMusicPlayer = document.getElementById('custom-music-player');
        let isPlaying = false;

        // Open Invitation Logic
        btnOpen.addEventListener('click', () => {
            // 1. Animate Cover Exit
            coverSection.classList.add('cover-exit');

            // 2. After cover animation, show opening intro
            setTimeout(() => {
                coverSection.style.display = 'none';

                // Show Opening Video with animation
                openingVideo.style.display = 'flex';
                openingVideo.classList.add('intro-enter');

                // Animate content elements
                const introContent = document.getElementById('intro-content');
                if (introContent) {
                    introContent.classList.add('intro-content-enter');
                }

                // 3. Play Music (if library music) or show custom player
                if (audio) {
                    audio.play().then(() => {
                        isPlaying = true;
                    }).catch(e => console.log("Audio autoplay failed", e));
                } else if (customMusicPlayer) {
                    // Show custom music player button
                    customMusicPlayer.style.display = 'flex';
                }

                // 4. Enable Scroll after animation
                setTimeout(() => {
                    document.body.classList.remove('overflow-hidden');
                    document.body.style.overflow = 'auto';
                }, 800);
            }, 600);
        });

        // Music Toggle (only if library music elements exist)
        if (musicBtn && audio && musicIcon) {
            musicBtn.addEventListener('click', () => {
                if (isPlaying) {
                    audio.pause();
                    musicIcon.classList.add('paused');
                } else {
                    audio.play();
                    musicIcon.classList.remove('paused');
                }
                isPlaying = !isPlaying;
            });
        }

        // Countdown
        const targetDate = new Date("{{ $events->akad_date ?? '2025-12-31' }}").getTime();
        setInterval(() => {
            const now = new Date().getTime();
            const dist = targetDate - now;

            if (dist < 0) return;

            document.getElementById('days').innerText = Math.floor(dist / (1000 * 60 * 60 * 24));
            document.getElementById('hours').innerText = Math.floor((dist % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            document.getElementById('minutes').innerText = Math.floor((dist % (1000 * 60 * 60)) / (1000 * 60));
            document.getElementById('seconds').innerText = Math.floor((dist % (1000 * 60)) / 1000);
        }, 1000);

        // Slideshow for Our Moments
        const slides = document.querySelectorAll('.slide-image');
        const dots = document.querySelectorAll('.slide-dot');
        let currentSlide = 0;

        if (slides.length > 0) {
            setInterval(() => {
                // Hide current slide
                slides[currentSlide].style.opacity = '0';
                dots[currentSlide].style.background = 'rgba(255,255,255,0.5)';

                // Move to next slide
                currentSlide = (currentSlide + 1) % slides.length;

                // Show next slide
                slides[currentSlide].style.opacity = '1';
                dots[currentSlide].style.background = 'var(--primary)';
            }, 4000); // Change every 4 seconds
        }

        // RSVP Attendance Buttons
        const attendanceBtns = document.querySelectorAll('.attendance-btn');
        const rsvpStatus = document.getElementById('rsvp-status');

        attendanceBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                attendanceBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                if (rsvpStatus) {
                    rsvpStatus.value = btn.dataset.status;
                }
            });
        });

        // Copy to Clipboard Function
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Berhasil disalin: ' + text);
            }).catch(err => {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                alert('Berhasil disalin: ' + text);
            });
        }

        // ========================================
        // SMOOTH SCROLL & REVEAL EFFECTS
        // ========================================

        // Intersection Observer for Reveal Animations
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    // Unobserve after reveal for performance
                    revealObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.15,
            rootMargin: '0px 0px -50px 0px'
        });

        // Observe all reveal elements
        document.querySelectorAll('.reveal-section, .reveal-scale, .stagger-children').forEach(el => {
            revealObserver.observe(el);
        });

        // Smooth Parallax Effect on Our Moments Section
        const momentsSection = document.getElementById('moments-section');
        const mainScroll = document.getElementById('main-scroll');

        if (momentsSection && mainScroll) {
            mainScroll.addEventListener('scroll', () => {
                const rect = momentsSection.getBoundingClientRect();
                const scrollProgress = (window.innerHeight - rect.top) / (window.innerHeight + rect.height);

                if (scrollProgress > 0 && scrollProgress < 1) {
                    const slideImages = momentsSection.querySelectorAll('.slide-image img');
                    slideImages.forEach(img => {
                        // Subtle parallax: move image slower than scroll
                        const offset = (scrollProgress - 0.5) * 30;
                        img.style.transform = `translateY(${offset}px) scale(1.05)`;
                    });
                }
            }, { passive: true });
        }

        // Smooth Scroll Snap Enhancement
        const articles = document.querySelectorAll('article');
        articles.forEach((article, index) => {
            // Add subtle entrance animation delay based on position
            article.style.animationDelay = `${index * 0.1}s`;
        });

    </script>
</body>

</html>