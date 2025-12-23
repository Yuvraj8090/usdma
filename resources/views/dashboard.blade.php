<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <i class="fas fa-chart-line text-blue-600 text-xl"></i>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                Analytics Dashboard
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- STATS CARDS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">

            {{-- Total Users --}}
            <div class="stat-card">
                <div class="stat-icon bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <p class="stat-label">Total Users</p>
                    <h3 class="stat-value">{{ $totalUsers }}</h3>
                </div>
            </div>

            {{-- Total Deaths --}}
            <div class="stat-card">
                <div class="stat-icon bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-300">
                    <i class="fas fa-skull-crossbones"></i>
                </div>
                <div>
                    <p class="stat-label">Total Deaths</p>
                    <h3 class="stat-value">{{ $totalHumanLoss }}</h3>
                </div>
            </div>

            {{-- Total Incidents --}}
            <div class="stat-card">
                <div class="stat-icon bg-orange-100 dark:bg-orange-900 text-orange-600 dark:text-orange-300">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div>
                    <p class="stat-label">Total Incidents</p>
                    <h3 class="stat-value">{{ $totalIncidents }}</h3>
                </div>
            </div>

            {{-- Active Sessions --}}
            <div class="stat-card">
                <div class="stat-icon bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300">
                    <i class="fas fa-signal"></i>
                </div>
                <div>
                    <p class="stat-label">Active Sessions</p>
                    <h3 class="stat-value">{{ $activeSessions }}</h3>
                </div>
            </div>

            {{-- Recent Visitors --}}
            <div class="stat-card">
                <div class="stat-icon bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300">
                    <i class="fas fa-user-clock"></i>
                </div>
                <div>
                    <p class="stat-label">Recent Visitors</p>
                    <h3 class="stat-value">{{ $visitorData->count() }}</h3>
                </div>
            </div>

        </div>


        {{-- TRAFFIC CHART --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md">
            <div class="flex items-center gap-3 px-6 py-4 border-b dark:border-gray-700">
                <i class="fas fa-chart-area text-teal-500"></i>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                    Daily Traffic Overview
                </h3>
            </div>
            <div class="p-6">
                <canvas id="trafficChart" class="w-full h-72"></canvas>
            </div>
        </div>

        {{-- RECENT VISITORS --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md">
            <div class="flex items-center gap-3 px-6 py-4 border-b dark:border-gray-700">
                <i class="fas fa-users text-indigo-500"></i>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                    Recent Visitors
                </h3>
            </div>

            <div class="divide-y dark:divide-gray-700">
                @forelse ($visitorData as $visitor)
                    <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <div class="flex justify-between">
                            <div class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                                <p><strong>User Agent:</strong> {{ Str::limit($visitor->user_agent, 80) }}</p>
                                <p>
                                    <strong>Location:</strong>
                                    {{ $visitor->location['city'] ?? 'N/A' }},
                                    {{ $visitor->location['region'] ?? 'N/A' }},
                                    {{ $visitor->location['country'] ?? 'N/A' }}
                                </p>
                            </div>

                            <span class="text-xs text-gray-400 whitespace-nowrap">
                                {{ \Carbon\Carbon::createFromTimestamp($visitor->last_activity)->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="px-6 py-4 text-gray-500">No visitors found.</p>
                @endforelse
            </div>
        </div>

    </div>

    {{-- CHART JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('trafficChart').getContext('2d');
        const trafficData = @json($dailyTraffic);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: trafficData.map(d => d.date),
                datasets: [{
                    label: 'Sessions',
                    data: trafficData.map(d => d.session_count),
                    borderWidth: 2,
                    borderColor: '#14b8a6',
                    backgroundColor: 'rgba(20, 184, 166, 0.15)',
                    fill: true,
                    tension: 0.35
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>


</x-app-layout>
