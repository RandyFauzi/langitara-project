@props(['promo'])

@if($promo)
<div id="promo-popup" 
     class="fixed inset-0 z-[9999] hidden items-center justify-center flex bg-slate-900/60 backdrop-blur-sm p-4 transition-opacity duration-300 opacity-0"
     role="dialog" 
     aria-modal="true">
    
    <div class="relative w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-slate-900/5 transition-all transform scale-95 opacity-0 duration-300" id="promo-content">
        
        <!-- Close Button -->
        <button onclick="closePromoPopup()" class="absolute right-4 top-4 z-10 rounded-full bg-white/80 p-1 text-slate-500 hover:bg-white hover:text-slate-800 transition backdrop-blur-sm">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        <!-- Image Banner -->
        <div class="h-40 w-full bg-gradient-to-r from-blue-600 to-indigo-600 relative overflow-hidden">
             <div class="absolute inset-0 opacity-20 pattern-dots"></div>
             @if($promo->image_path)
                <img src="{{ Storage::url($promo->image_path) }}" class="absolute inset-0 h-full w-full object-cover">
             @endif
             <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-6">
                 <div>
                    <span class="inline-flex items-center rounded-full bg-white/20 px-2.5 py-0.5 text-xs font-bold text-white backdrop-blur-md border border-white/30 mb-2">
                        SPECIAL OFFER
                    </span>
                 </div>
             </div>
        </div>

        <!-- Content -->
        <div class="p-8 pt-6">
            <h3 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 leading-tight">
                {{ $promo->title }}
            </h3>
            <p class="mt-3 text-slate-600">
                {{ $promo->description }}
            </p>

            <!-- Voucher & Action -->
            <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center">
                @if($promo->code)
                    <div class="flex-1 rounded-xl bg-blue-50 border border-dashed border-blue-200 p-4 text-center">
                        <p class="text-xs font-semibold uppercase tracking-wide text-blue-800 mb-1">Kode Voucher</p>
                        <div class="flex items-center justify-center gap-2 cursor-pointer group" onclick="navigator.clipboard.writeText('{{ $promo->code }}'); alert('Code copied!')">
                            <span class="font-mono text-xl font-bold text-blue-600 tracking-wider">{{ $promo->code }}</span>
                            <svg class="h-4 w-4 text-blue-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </div>
                    </div>
                @endif
                
                <div class="flex-1">
                     <a href="/pricing" class="flex w-full items-center justify-center rounded-xl bg-blue-600 px-6 py-4 text-sm font-bold text-white shadow-xl shadow-blue-200 transition hover:bg-blue-700 hover:shadow-2xl hover:-translate-y-0.5">
                        Gunakan Promo
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>

            <!-- Countdown Timer -->
            @if($promo->end_date)
            <div class="mt-6 border-t border-slate-100 pt-4">
                <p class="text-center text-xs font-medium text-slate-500 mb-2">Berakhir dalam:</p>
                <div class="flex justify-center gap-3 text-center" id="countdown-timer">
                     <div class="bg-slate-50 rounded-lg p-2 min-w-[50px]">
                         <span class="block text-lg font-bold text-slate-800" id="days">00</span>
                         <span class="text-[10px] text-slate-400 uppercase">Hari</span>
                     </div>
                     <span class="text-slate-300 font-bold py-2">:</span>
                     <div class="bg-slate-50 rounded-lg p-2 min-w-[50px]">
                         <span class="block text-lg font-bold text-slate-800" id="hours">00</span>
                         <span class="text-[10px] text-slate-400 uppercase">Jam</span>
                     </div>
                     <span class="text-slate-300 font-bold py-2">:</span>
                     <div class="bg-slate-50 rounded-lg p-2 min-w-[50px]">
                         <span class="block text-lg font-bold text-slate-800" id="minutes">00</span>
                         <span class="text-[10px] text-slate-400 uppercase">Min</span>
                     </div>
                     <span class="text-slate-300 font-bold py-2">:</span>
                     <div class="bg-slate-50 rounded-lg p-2 min-w-[50px]">
                         <span class="block text-lg font-bold text-rose-600" id="seconds">00</span>
                         <span class="text-[10px] text-slate-400 uppercase">Det</span>
                     </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const promoId = "{{ $promo->id }}";
        const storageKey = 'closed_promo_' + promoId;
        const endDate = new Date("{{ $promo->end_date }}").getTime();
        
        // Check localStorage
        if (!localStorage.getItem(storageKey)) {
            setTimeout(showPromoPopup, 3000); // 3 seconds delay
        }

        function showPromoPopup() {
            const popup = document.getElementById('promo-popup');
            const content = document.getElementById('promo-content');
            
            popup.classList.remove('hidden');
            // Allow render before opacity transition
            setTimeout(() => {
                popup.classList.remove('opacity-0');
                content.classList.remove('opacity-0', 'scale-95');
                content.classList.add('scale-100');
            }, 10);
            
            // Start Timer
            if (endDate) {
                updateTimer();
                setInterval(updateTimer, 1000);
            }
        }

        window.closePromoPopup = function() {
            const popup = document.getElementById('promo-popup');
            const content = document.getElementById('promo-content');
            
            popup.classList.add('opacity-0');
            content.classList.remove('scale-100');
            content.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                popup.classList.add('hidden');
            }, 300);

            // Save to localStorage
            localStorage.setItem(storageKey, 'true');
        }

        function updateTimer() {
            const now = new Date().getTime();
            const distance = endDate - now;

            if (distance < 0) {
                 document.getElementById('countdown-timer').innerHTML = '<span class="text-rose-600 font-bold">Promo Expired</span>';
                 return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('days').innerText = String(days).padStart(2, '0');
            document.getElementById('hours').innerText = String(hours).padStart(2, '0');
            document.getElementById('minutes').innerText = String(minutes).padStart(2, '0');
            document.getElementById('seconds').innerText = String(seconds).padStart(2, '0');
        }
    });
</script>
@endif
