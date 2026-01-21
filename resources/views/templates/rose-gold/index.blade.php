<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Wedding of {{ $invitation->bride_nickname }} & {{ $invitation->groom_nickname }}</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ $__template['asset_path'] }}/css/style.css?v=2.2">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen overflow-hidden lg:block">

    <!-- DESKTOP LEFT SECTION (Hero) -->
    <section
        class="hidden lg:flex w-[calc(100%-480px)] fixed inset-y-0 left-0 bg-[#FDF5F2] flex-col justify-center items-center text-center p-12 z-0 overflow-hidden">
        <!-- Background Asset -->
        <div class="absolute inset-0 opacity-50">
            <img src="{{ $__template['asset_path'] }}/assets/bg_cover.png" alt="Background"
                class="w-full h-full object-cover">
        </div>

        <div class="relative z-10 fade-in">
            <p class="text-rose-900 uppercase tracking-[0.3em] text-sm font-serif mb-6">The Wedding Of</p>
            <h1 class="font-guest text-8xl text-[#8D6E63] drop-shadow-sm mb-4">
                {{ $invitation->groom_nickname }} <span class="font-serif italic text-4xl">&</span>
                {{ $invitation->bride_nickname }}
            </h1>
            <div class="w-24 h-0.5 bg-[#8D6E63] mx-auto my-8 opacity-50"></div>
            <p class="text-rose-900 text-xl font-serif tracking-widest">
                {{ \Carbon\Carbon::parse($invitation->akad_date)->format('d . m . Y') }}
            </p>
        </div>

        <!-- Florals -->
        <img src="{{ $__template['asset_path'] }}/assets/flower_top_right.png"
            class="absolute top-0 right-0 w-64 opacity-60">
        <img src="{{ $__template['asset_path'] }}/assets/flower_bottom_left.png"
            class="absolute bottom-0 left-0 w-64 opacity-60">
    </section>

    <!-- RIGHT SECTION (Mobile Container) -->
    <!-- Removed 'flex items-center justify-center' from body context, moved logic to wrapper -->
    <div id="mobile-wrapper"
        class="relative w-full lg:max-w-[480px] ml-auto h-screen max-h-none overflow-hidden bg-[#FDF5F2] shadow-2xl">

        <!-- Cover Section -->
        <section id="cover-section" class="w-full h-full relative flex items-center justify-center overflow-hidden">

            <!-- Background Asset -->
            <div class="absolute inset-0 z-0">
                <img src="{{ $__template['asset_path'] }}/assets/bg_cover.png" alt="Background"
                    class="w-full h-full object-cover opacity-80">
            </div>

            <!-- Frame/Container -->
            <div class="relative z-50 w-full h-full flex flex-col items-center justify-center pb-32">

                <!-- Custom Border/Frame Div (Optional, kept from original if needed, or removed if not in new design. Keeping for safety but making subtle) -->
                <div
                    class="absolute inset-6 border-[1px] border-[#E0C097] rounded-t-full pointer-events-none z-10 opacity-70">
                </div>

                <!-- Content -->
                <div class="relative z-50 text-center flex flex-col items-center justify-center space-y-6">

                    <!-- Title -->
                    <p class="text-rose-900 uppercase tracking-[0.3em] text-xs font-serif fade-in">The Wedding Of</p>

                    <!-- Names -->
                    <div class="flex flex-col items-center leading-none fade-in delay-100 my-6">
                        <h1 class="font-guest text-6xl md:text-7xl text-[#8D6E63] drop-shadow-sm mb-2">
                            {{ $invitation->bride_nickname }}
                        </h1>
                        <span class="font-serif text-xl italic text-[#8D6E63] my-2">and</span>
                        <h1 class="font-guest text-6xl md:text-7xl text-[#8D6E63] drop-shadow-sm mt-2">
                            {{ $invitation->groom_nickname }}
                        </h1>
                    </div>

                    <!-- Date -->
                    <div class="text-rose-900 text-sm font-serif mb-8 fade-in delay-200 tracking-widest">
                        {{ \Carbon\Carbon::parse($invitation->akad_date)->format('d . m . Y') }}
                    </div>

                    <!-- Button -->
                    <button id="open-invitation"
                        class="flex items-center gap-2 bg-gradient-to-r from-[#D4AF37] to-[#C5A028] text-white px-8 py-3 rounded-full shadow-xl hover:scale-105 transition-transform duration-300 animate-pulse-slow fade-in delay-300 cursor-pointer z-50">
                        <i class="fas fa-envelope-open mr-2"></i>
                        <span class="font-semibold tracking-wide text-sm uppercase">Buka Undangan</span>
                    </button>
                </div>
            </div>

            <!-- Top Asset -->
            <img src="{{ $__template['asset_path'] }}/assets/flower_top_right.png"
                class="absolute top-0 right-0 w-1/2 z-10 flower-sway pointer-events-none" alt="Flower Top">

            <!-- Bottom Composition (The Bouquet Strategy) -->

            <!-- Layer 1 (Sides - Back) -->
            <img src="{{ $__template['asset_path'] }}/assets/flower_bottom_left.png"
                class="absolute bottom-0 left-0 w-5/12 z-20 flower-rise-left pointer-events-none"
                alt="Flower Bottom Left">

            <img src="{{ $__template['asset_path'] }}/assets/flower_bottom_right.png"
                class="absolute bottom-0 right-0 w-5/12 z-20 flower-rise-right pointer-events-none"
                alt="Flower Bottom Right">

            <!-- Layer 2 (Center Body - Middle) -->
            <div
                class="absolute bottom-10 left-1/2 -translate-x-1/2 w-2/3 z-30 zoom-in-up delay-200 pointer-events-none">
                <img src="{{ $__template['asset_path'] }}/assets/flower_bottom_center.png" class="w-full object-contain"
                    alt="Flower Bottom Center">
            </div>

            <!-- Layer 3 (The Anchor - Front) -->
            <div
                class="absolute bottom-0 left-1/2 -translate-x-1/2 w-1/2 z-40 flower-rise delay-300 pointer-events-none">
                <img src="{{ $__template['asset_path'] }}/assets/flower-bottom.png" class="w-full object-contain"
                    alt="Flower Anchor">
            </div>

        </section>

    </div>
    </div> <!-- End Mobile Wrapper -->

    <script src="{{ $__template['asset_path'] }}/js/script.js?v=2.2"></script>
</body>

</html>