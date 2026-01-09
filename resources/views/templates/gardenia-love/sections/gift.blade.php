<section id="gift" class="py-20 px-6 bg-white text-center">
    <div class="mb-10">
        <h2 class="font-script text-5xl text-amber-600 mb-2">Wedding Gift</h2>
        <p class="text-slate-500 text-sm px-6 leading-relaxed">
            Your presence is present enough, but if you wish to give a gift, we appreciate it appropriately.
        </p>
    </div>

    <div
        class="max-w-sm mx-auto bg-slate-50 rounded-2xl p-6 border border-slate-100 shadow-sm relative overflow-hidden">
        <!-- Bank Logo Placeholder -->
        <div class="text-xl font-bold text-slate-800 mb-4 tracking-tight uppercase">
            {{ $data['gift']['bank_name'] ?? 'BANK TRANSFER' }}
        </div>

        <p class="text-sm text-slate-500 mb-1">Account Number</p>
        <div class="flex items-center justify-center gap-2 mb-4">
            <span id="account-number" class="text-2xl font-mono text-slate-800 tracking-wide font-bold">
                {{ $data['gift']['account_number'] ?? '0000 0000 0000' }}
            </span>
            <button onclick="copyToClipboard('{{ $data['gift']['account_number'] ?? '' }}')"
                class="p-2 text-slate-400 hover:text-amber-600 transition" title="Copy">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                    </path>
                </svg>
            </button>
        </div>

        <p class="text-sm text-slate-500">Account Holder</p>
        <p class="font-bold text-slate-800 text-lg">{{ $data['gift']['account_holder'] ?? 'Couple Name' }}</p>

        <!-- Decorative Pattern -->
        <div class="absolute top-0 right-0 p-4 opacity-10">
            <svg class="w-16 h-16 text-amber-600" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z" />
            </svg>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            if (!text) text = document.getElementById('account-number').innerText.trim();
            navigator.clipboard.writeText(text).then(() => {
                // Call global showToast function from layout
                if (typeof showToast === 'function') {
                    showToast('Nomor Rekening Berhasil Disalin!');
                } else {
                    alert('Account number copied!');
                }
            });
        }
    </script>
</section>