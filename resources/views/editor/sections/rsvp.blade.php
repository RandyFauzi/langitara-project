<div class="space-y-6">
    <div class="flex justify-between items-center border-b border-gray-100 pb-4">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Konfirmasi Kehadiran</h3>
            <p class="text-xs text-gray-500">Statistik real-time kehadiran tamu undangan Anda.</p>
        </div>
        <button onclick="window.location.reload()" class="p-2 text-gray-400 hover:text-violet-600 transition-colors"
            title="Refresh Data">
            <i class="fas fa-sync-alt text-sm"></i>
        </button>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div
            class="bg-violet-50 p-4 rounded-2xl border border-violet-100 flex flex-col justify-between group hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <p class="text-[10px] font-bold text-violet-600 uppercase tracking-wider">Total</p>
                <div class="p-1.5 bg-white rounded-lg text-violet-600 shadow-sm"><i class="fas fa-users text-xs"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-800 mt-2 group-hover:scale-110 origin-left transition-transform">
                {{ $stats['total_responses'] }}</p>
        </div>
        <div
            class="bg-emerald-50 p-4 rounded-2xl border border-emerald-100 flex flex-col justify-between group hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider">Hadir</p>
                <div class="p-1.5 bg-white rounded-lg text-emerald-600 shadow-sm"><i class="fas fa-check text-xs"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-800 mt-2 group-hover:scale-110 origin-left transition-transform">
                {{ $stats['hadir'] }}</p>
        </div>
        <div
            class="bg-rose-50 p-4 rounded-2xl border border-rose-100 flex flex-col justify-between group hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <p class="text-[10px] font-bold text-rose-600 uppercase tracking-wider">Tidak</p>
                <div class="p-1.5 bg-white rounded-lg text-rose-600 shadow-sm"><i class="fas fa-times text-xs"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-800 mt-2 group-hover:scale-110 origin-left transition-transform">
                {{ $stats['tidak_hadir'] }}</p>
        </div>
        <div
            class="bg-amber-50 p-4 rounded-2xl border border-amber-100 flex flex-col justify-between group hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <p class="text-[10px] font-bold text-amber-600 uppercase tracking-wider">Ragu</p>
                <div class="p-1.5 bg-white rounded-lg text-amber-600 shadow-sm"><i class="fas fa-question text-xs"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-800 mt-2 group-hover:scale-110 origin-left transition-transform">
                {{ $stats['ragu'] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Chart -->
        <div
            class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col items-center justify-center relative">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider absolute top-6 left-6">Visualisasi</h3>
            @if($stats['total_responses'] > 0)
                <div class="relative w-56 h-56 mt-6">
                    <canvas id="rsvpChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-4xl font-bold text-gray-800">{{ $stats['total_attendees'] }}</span>
                        <span class="text-[10px] uppercase font-bold text-gray-400 tracking-widest">Tamu</span>
                    </div>
                </div>
            @else
                <div class="py-12 flex flex-col items-center justify-center text-gray-300">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                        <i class="fas fa-chart-pie text-2xl"></i>
                    </div>
                    <p class="text-sm font-medium">Belum ada data visual</p>
                </div>
            @endif
        </div>

        <!-- Recent Log -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Aktivitas Terbaru</h3>

            <div class="flex-1 overflow-y-auto max-h-[250px] custom-scrollbar pr-2">
                @if($recentRsvps->isEmpty())
                    <div class="h-full flex flex-col items-center justify-center text-gray-300">
                        <i class="far fa-clock text-2xl mb-2 opacity-50"></i>
                        <p class="text-sm">Belum ada aktivitas</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($recentRsvps as $rsvp)
                            <div
                                class="flex items-center p-3 rounded-xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100 group">
                                <div class="flex-shrink-0 mr-3">
                                    <div
                                        class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-sm
                                                {{ $rsvp->status == 'hadir' ? 'bg-emerald-500 shadow-emerald-200' : ($rsvp->status == 'tidak_hadir' ? 'bg-rose-500 shadow-rose-200' : 'bg-amber-500 shadow-amber-200') }}">
                                        {{ strtoupper(substr($rsvp->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-800 truncate">{{ $rsvp->name }}</p>
                                    <p class="text-[10px] text-gray-400 flex items-center gap-1.5">
                                        <i class="far fa-clock"></i> {{ $rsvp->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded text-[10px] font-bold border
                                                {{ $rsvp->status == 'hadir' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : ($rsvp->status == 'tidak_hadir' ? 'bg-rose-50 text-rose-600 border-rose-100' : 'bg-amber-50 text-amber-600 border-amber-100') }}">
                                        {{ $rsvp->amount }} Pax
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('alpine:initialized', () => {
        const ctx = document.getElementById('rsvpChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($chartData['labels']) !!},
                    datasets: [{
                        data: {!! json_encode($chartData['data']) !!},
                        backgroundColor: {!! json_encode($chartData['colors']) !!},
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '80%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: {
                                    size: 10,
                                    family: "'Inter', sans-serif"
                                }
                            }
                        }
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            });
        }
    });
</script>