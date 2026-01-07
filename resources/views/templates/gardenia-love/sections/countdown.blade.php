<section id="countdown" class="py-20 px-6 bg-slate-900 text-white relative overflow-hidden">
    <!-- Overlay image -->
    <div class="absolute inset-0 z-0 opacity-20">
        <img src="https://images.unsplash.com/photo-1511285560982-1356c11d460e?auto=format&fit=crop&q=80&w=2000"
            class="w-full h-full object-cover">
    </div>

    <div class="relative z-10 text-center">
        <h2 class="font-script text-5xl text-amber-400 mb-10">Counting Down</h2>

        <div class="flex justify-center gap-4 md:gap-8" id="timer">
            <div class="flex flex-col items-center">
                <div
                    class="w-16 h-16 md:w-20 md:h-20 border border-white/20 rounded-xl flex items-center justify-center bg-white/10 backdrop-blur">
                    <span class="text-2xl md:text-3xl font-bold" id="days">00</span>
                </div>
                <span class="text-xs mt-2 uppercase tracking-wide text-slate-400">Days</span>
            </div>
            <div class="flex flex-col items-center">
                <div
                    class="w-16 h-16 md:w-20 md:h-20 border border-white/20 rounded-xl flex items-center justify-center bg-white/10 backdrop-blur">
                    <span class="text-2xl md:text-3xl font-bold" id="hours">00</span>
                </div>
                <span class="text-xs mt-2 uppercase tracking-wide text-slate-400">Hours</span>
            </div>
            <div class="flex flex-col items-center">
                <div
                    class="w-16 h-16 md:w-20 md:h-20 border border-white/20 rounded-xl flex items-center justify-center bg-white/10 backdrop-blur">
                    <span class="text-2xl md:text-3xl font-bold" id="minutes">00</span>
                </div>
                <span class="text-xs mt-2 uppercase tracking-wide text-slate-400">Mins</span>
            </div>
            <div class="flex flex-col items-center">
                <div
                    class="w-16 h-16 md:w-20 md:h-20 border border-white/20 rounded-xl flex items-center justify-center bg-white/10 backdrop-blur">
                    <span class="text-2xl md:text-3xl font-bold" id="seconds">00</span>
                </div>
                <span class="text-xs mt-2 uppercase tracking-wide text-slate-400">Secs</span>
            </div>
        </div>

        <div class="mt-10">
            <a href="#"
                class="inline-flex items-center gap-2 px-6 py-3 bg-amber-600 hover:bg-amber-700 rounded-full text-white text-sm font-bold transition shadow-lg hover:shadow-amber-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                Remind Me
            </a>
        </div>
    </div>

    <script>
        // Simple Countdown Logic
        // In a real implementation, '{{ $event_date }}' would be parsed to a JS Date.
        // Assuming format is passable to Date.parse() or passing a timestamp.
        const targetDate = new Date("{{ $event_date ?? '2026-01-01' }}").getTime();

        const timer = setInterval(function () {
            const now = new Date().getTime();
            const distance = targetDate - now;

            if (distance < 0) {
                clearInterval(timer);
                document.getElementById("timer").innerHTML = "<div class='text-2xl font-bold'>The Event Has Started!</div>";
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("days").innerText = days;
            document.getElementById("hours").innerText = hours;
            document.getElementById("minutes").innerText = minutes;
            document.getElementById("seconds").innerText = seconds;
        }, 1000);
    </script>
</section>