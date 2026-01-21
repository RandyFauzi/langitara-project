<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Konfirmasi Kehadiran - {{ $invitation->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="h-full bg-gray-50">

    <!-- Navigation Header -->
    <header class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('editor.edit', $invitation->slug) }}" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">Konfirmasi Kehadiran</h1>
                        <p class="text-xs text-gray-500">{{ $invitation->title }}</p>
                    </div>
                </div>

                <!-- Navigation Tabs -->
                <nav class="flex space-x-1 bg-gray-100 rounded-lg p-1">
                    <a href="{{ route('editor.guests.index', $invitation->slug) }}"
                        class="px-4 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900">
                        Daftar Tamu
                    </a>
                    <a href="{{ route('editor.stats', $invitation->slug) }}"
                        class="px-4 py-2 text-sm font-medium rounded-md bg-white text-gray-900 shadow-sm">
                        Konfirmasi
                    </a>
                    <a href="{{ route('editor.wishes.index', $invitation->slug) }}"
                        class="px-4 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900">
                        Ucapan
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Summary Cards -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
            <!-- Total Undangan -->
            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_guests'] }}</p>
                        <p class="text-sm text-gray-500 mt-1">Total Undangan</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Respon -->
            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-3xl font-bold text-purple-600">{{ $stats['total'] }}</p>
                        <p class="text-sm text-gray-500 mt-1">Total Respon</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Hadir -->
            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-3xl font-bold text-green-600">{{ $stats['hadir'] }}</p>
                        <p class="text-sm text-gray-500 mt-1">Hadir</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Tidak Hadir -->
            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-3xl font-bold text-red-600">{{ $stats['tidak_hadir'] }}</p>
                        <p class="text-sm text-gray-500 mt-1">Tidak Hadir</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Ragu-ragu -->
            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-3xl font-bold text-amber-600">{{ $stats['ragu'] }}</p>
                        <p class="text-sm text-gray-500 mt-1">Ragu-ragu</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Chart Section -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik Kehadiran</h3>

                @if($stats['total'] > 0)
                    <div class="flex items-center justify-center">
                        <div class="relative" style="width: 280px; height: 280px;">
                            <canvas id="attendanceChart"></canvas>
                            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                <p class="text-4xl font-bold text-gray-900">{{ $stats['total_attendees'] }}</p>
                                <p class="text-sm text-gray-500">Total Tamu</p>
                            </div>
                        </div>
                    </div>

                    <!-- Legend -->
                    <div class="flex justify-center space-x-6 mt-6">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-green-500 mr-2"></div>
                            <span class="text-sm text-gray-600">Hadir ({{ $stats['hadir'] }})</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-red-500 mr-2"></div>
                            <span class="text-sm text-gray-600">Tidak ({{ $stats['tidak_hadir'] }})</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-amber-500 mr-2"></div>
                            <span class="text-sm text-gray-600">Ragu ({{ $stats['ragu'] }})</span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                        </svg>
                        <p class="text-gray-500">Belum ada respons RSVP</p>
                    </div>
                @endif
            </div>

            <!-- Recent RSVPs -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">RSVP Terbaru</h3>

                @if($recentRsvps->isEmpty())
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        <p class="text-gray-500">Belum ada RSVP diterima</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($recentRsvps as $rsvp)
                            <div
                                class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-medium text-sm">
                                        {{ strtoupper(substr($rsvp->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $rsvp->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $rsvp->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if($rsvp->amount > 1)
                                        <span class="text-xs text-gray-500">{{ $rsvp->amount }} orang</span>
                                    @endif
                                    @php
                                        $statusColors = [
                                            'hadir' => 'bg-green-100 text-green-800',
                                            'tidak_hadir' => 'bg-red-100 text-red-800',
                                            'ragu' => 'bg-amber-100 text-amber-800',
                                        ];
                                        $statusLabels = [
                                            'hadir' => 'Hadir',
                                            'tidak_hadir' => 'Tidak Hadir',
                                            'ragu' => 'Ragu-ragu',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$rsvp->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $statusLabels[$rsvp->status] ?? ucfirst($rsvp->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </main>

    @if($stats['total'] > 0)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('attendanceChart').getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($chartData['labels']) !!},
                        datasets: [{
                            data: {!! json_encode($chartData['data']) !!},
                            backgroundColor: {!! json_encode($chartData['colors']) !!},
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            });
        </script>
    @endif
</body>

</html>