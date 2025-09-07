<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Daily Reports Calendar
        </h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Upload Form --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 mb-6">
            @if(session('success'))
                <div class="mb-4 px-4 py-2 bg-green-200 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Report File</label>
                    <input type="file" name="file" class="w-full rounded-lg border px-3 py-2 dark:bg-gray-900 dark:text-white" required>
                </div>

                <div>
                    <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Submit Date</label>
                    <input type="date" name="submit_date" class="w-full rounded-lg border px-3 py-2 dark:bg-gray-900 dark:text-white" required>
                </div>

                <div>
                    <label class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Submit Time</label>
                    <input type="time" name="submit_time" class="w-full rounded-lg border px-3 py-2 dark:bg-gray-900 dark:text-white" required>
                </div>

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                    Upload
                </button>
            </form>
        </div>

        {{-- Calendar --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Reports Calendar</h3>
            <div id="calendar"></div>
        </div>
    </div>

        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">
   
        {{-- FullCalendar JS --}}
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    height: 600,
                    events: @json($events),
                    eventClick: function(info) {
                        if(info.event.url) {
                            window.open(info.event.url, '_blank');
                            info.jsEvent.preventDefault();
                        }
                    },
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    }
                });

                calendar.render();
            });
        </script>
   
</x-app-layout>
