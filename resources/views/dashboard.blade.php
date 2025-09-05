<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Analytics Dashboard
        </h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            {{-- Total Users --}}
            <div class="bg-white dark:bg-gray-700 rounded-xl shadow-lg p-6 hover:shadow-xl transition duration-200">
                <div class="flex items-center space-x-4">
                    <div class="p-4 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-200">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-300 font-medium">Total Users</p>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalUsers }}</h3>
                    </div>
                </div>
            </div>

            {{-- Active Sessions --}}
            <div class="bg-white dark:bg-gray-700 rounded-xl shadow-lg p-6 hover:shadow-xl transition duration-200">
                <div class="flex items-center space-x-4">
                    <div class="p-4 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-200">
                        <i class="fas fa-signal text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-300 font-medium">Active Sessions</p>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $activeSessions }}</h3>
                    </div>
                </div>
            </div>

            {{-- Recent Visitors --}}
            <div class="bg-white dark:bg-gray-700 rounded-xl shadow-lg p-6 hover:shadow-xl transition duration-200">
                <div class="flex items-center space-x-4">
                    <div class="p-4 rounded-full bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-200">
                        <i class="fas fa-user-clock text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-300 font-medium">Recent Visitors</p>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $visitorData->count() }}</h3>
                    </div>
                </div>
            </div>

        </div>

        {{-- Daily Traffic Chart --}}
        <div class="bg-white dark:bg-gray-700 rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Daily Traffic Overview</h3>
            </div>
            <div class="p-6">
                <canvas id="trafficChart" class="w-full h-64"></canvas>
            </div>
        </div>

        {{-- Recent Visitors List --}}
        <div class="bg-white dark:bg-gray-700 rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recent Visitors</h3>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-600">
                @foreach ($visitorData as $visitor)
                    <div class="px-6 py-4 hover:bg-gray-100 dark:hover:bg-gray-800 transition duration-150">
                        <p class="text-gray-600 dark:text-gray-300">
                            <strong>User Agent:</strong> {{ $visitor->user_agent }} <br>
                            <strong>Location:</strong> {{ $visitor->location['city'] ?? 'N/A' }}, {{ $visitor->location['region'] ?? 'N/A' }}, {{ $visitor->location['country'] ?? 'N/A' }} <br>
                            <strong>Last Activity:</strong> {{ \Carbon\Carbon::createFromTimestamp($visitor->last_activity)->diffForHumans() }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('trafficChart').getContext('2d');
        const trafficData = @json($dailyTraffic);

        const labels = trafficData.map(item => item.date);
        const data = trafficData.map(item => item.session_count);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Daily Traffic',
                    data: data,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.1)',
                    fill: true,
                    tension: 0.2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    </script>
</x-app-layout>
