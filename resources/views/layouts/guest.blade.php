<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ allsettings('site.title') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/uttarakhand_logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('main/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('main/css/style.css') }}">
</head>

<body class="antialiased bg-light">
    <!-- Navbar -->
    <x-navbar-user />

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <x-footer-user />

    <!-- Scripts -->
    <script src="{{ asset('main/js/bootstrap.js') }}"></script>
    <script src="{{ asset('main/js/chart.js') }}"></script>
    <script src="{{ asset('main/js/charts.js') }}"></script>

    <!-- Chart Initialization -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            if (typeof Chart !== 'undefined') {
                // Register plugin
                Chart.register(ChartDataLabels);

                // Pie Chart
                const pieCtx = document.getElementById('pieChart')?.getContext('2d');
                if (pieCtx) {
                    new Chart(pieCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Badrinath', 'Kedarnath', 'Gangotri', 'Yamnotri', 'Hemkund'],
                            datasets: [{
                                data: [1242463, 1453380, 669214, 585461, 237290],
                                backgroundColor: ['#ff7675', '#1e90ff', '#ffd43b', '#ff6b6b', '#6c5ce7']
                            }]
                        },
                        options: {
                            cutout: '55%',
                            plugins: {
                                legend: { position: 'right', labels: { usePointStyle: true } },
                                datalabels: {
                                    color: '#fff',
                                    formatter: (value, ctx) => {
                                        const total = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                        return Math.round((value / total) * 100) + '%';
                                    },
                                    font: { weight: '600', size: 11 }
                                }
                            }
                        }
                    });
                }

                // Helper to create charts
                function createChart(ctxId, type, labels, datasets, options = {}) {
                    const ctx = document.getElementById(ctxId)?.getContext('2d');
                    if (!ctx) return;
                    new Chart(ctx, { type, data: { labels, datasets }, options });
                }

                // Bar Chart 2024
                createChart('bar2024', 'bar',
                    ['May', 'June', 'July', 'August', 'September', 'October', 'November'],
                    [
                        { label: 'Badrinath', data: [250000, 520000, 40000, 18000, 12000, 90000, 150000], backgroundColor: '#ff7675' },
                        { label: 'Gangotri', data: [70000, 120000, 25000, 15000, 11000, 40000, 90000], backgroundColor: '#ffd43b' },
                        { label: 'Hemkund', data: [20000, 80000, 15000, 9000, 7000, 30000, 60000], backgroundColor: '#6c5ce7' },
                        { label: 'Kedarnath', data: [120000, 450000, 90000, 26000, 20000, 120000, 350000], backgroundColor: '#1e90ff' },
                        { label: 'Yamnotri', data: [40000, 130000, 25000, 12000, 8000, 50000, 90000], backgroundColor: '#ff6b6b' }
                    ],
                    { responsive: true, plugins: { legend: { position: 'bottom' } }, scales: { y: { beginAtZero: true } } }
                );

                // Bar Chart 2025
                createChart('bar2025', 'bar',
                    ['April', 'May', 'June', 'July'],
                    [
                        { label: 'Badrinath', data: [20000, 500000, 60000, 20000], backgroundColor: '#ff7675' },
                        { label: 'Gangotri', data: [10000, 300000, 20000, 10000], backgroundColor: '#ffd43b' },
                        { label: 'Hemkund', data: [5000, 200000, 12000, 7000], backgroundColor: '#6c5ce7' },
                        { label: 'Kedarnath', data: [30000, 680000, 72000, 22000], backgroundColor: '#1e90ff' },
                        { label: 'Yamnotri', data: [8000, 400000, 50000, 15000], backgroundColor: '#ff6b6b' }
                    ],
                    { responsive: true, plugins: { legend: { position: 'bottom' } }, scales: { y: { beginAtZero: true } } }
                );

                // Line Chart 2024
                createChart('line2024', 'line',
                    ['May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov'],
                    [
                        { label: 'Badrinath', data: [520000, 210000, 90000, 40000, 30000, 120000, 340000], borderColor: '#ff7675', fill: false, tension: .35 },
                        { label: 'Kedarnath', data: [610000, 260000, 130000, 60000, 50000, 160000, 360000], borderColor: '#1e90ff', fill: false, tension: .35 },
                        { label: 'Gangotri', data: [120000, 80000, 40000, 30000, 28000, 60000, 90000], borderColor: '#ffd43b', fill: false, tension: .35 },
                        { label: 'Yamnotri', data: [90000, 60000, 31000, 24000, 20000, 50000, 70000], borderColor: '#ff6b6b', fill: false, tension: .35 },
                        { label: 'Hemkund', data: [30000, 28000, 18000, 15000, 12000, 25000, 35000], borderColor: '#6c5ce7', fill: false, tension: .35 }
                    ],
                    { responsive: true, plugins: { legend: { position: 'bottom' } }, scales: { y: { beginAtZero: false } } }
                );

                // Line Chart 2025
                createChart('line2025', 'line',
                    ['April', 'May', 'June', 'July'],
                    [
                        { label: 'Badrinath', data: [320000, 650000, 270000, 60000], borderColor: '#ff7675', fill: false, tension: .35 },
                        { label: 'Kedarnath', data: [400000, 700000, 310000, 90000], borderColor: '#1e90ff', fill: false, tension: .35 },
                        { label: 'Gangotri', data: [140000, 200000, 110000, 40000], borderColor: '#ffd43b', fill: false, tension: .35 },
                        { label: 'Yamnotri', data: [90000, 120000, 80000, 35000], borderColor: '#ff6b6b', fill: false, tension: .35 },
                        { label: 'Hemkund', data: [50000, 70000, 60000, 25000], borderColor: '#6c5ce7', fill: false, tension: .35 }
                    ],
                    { responsive: true, plugins: { legend: { position: 'bottom' } }, scales: { y: { beginAtZero: false } } }
                );
            }
        });
    </script>
</body>
</html>
