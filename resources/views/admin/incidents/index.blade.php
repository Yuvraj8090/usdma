<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <i class="fas fa-exclamation-triangle text-gray-700 text-xl"></i>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                Incidents Management
            </h2>
        </div>
    </x-slot>

    <div class="p-6  min-h-screen">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- Header --}}
            <div class="flex justify-between items-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    <i class="fas fa-exclamation-triangle mr-1"></i> Manage all incident records
                </p>

                <a href="{{ route('admin.incidents.create') }}"
                   class="inline-flex items-center px-4 py-2 rounded-lg bg-gray-700 text-white font-semibold shadow hover:shadow-lg transition">
                    <i class="fas fa-plus mr-2"></i> New Incident
                </a>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="flex items-center gap-2 p-4 rounded-lg bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-100">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="flex items-center gap-2 p-4 rounded-lg bg-red-100 dark:bg-red-800 text-red-700 dark:text-red-100">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Table --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 bg-gray-700 rounded-t-xl">
                    <h3 class="text-white font-semibold flex items-center gap-2">
                        <i class="fas fa-table"></i> Incidents List
                    </h3>
                </div>

                <div class="p-6 overflow-x-auto">
                    <table id="incidents-table" class="w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">Type</th>
                                <th class="px-4 py-3">Incident</th>
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3">State</th>
                                <th class="px-4 py-3">Big Animals</th>
                                <th class="px-4 py-3">Small Animals</th>
                                <th class="px-4 py-3">Partial House</th>
                                <th class="px-4 py-3">Severe House</th>
                                <th class="px-4 py-3">Full House</th>
                                <th class="px-4 py-3">Cowshed</th>
                                <th class="px-4 py-3">Deaths</th>
                                <th class="px-4 py-3">Missing</th>
                                <th class="px-4 py-3">Injured</th>
                                <th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- DataTables --}}
    <script>
        $(function () {
            $('#incidents-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('admin.incidents.index') }}",
                columns: [
                    { data: 'incident_type', name: 'incident_type' },
                    { data: 'incident_name', name: 'incident_name' },
                    { data: 'incident_date', name: 'incident_date' },
                    { data: 'state', name: 'state' },
                    { data: 'big_animals_died', name: 'big_animals_died' },
                    { data: 'small_animals_died', name: 'small_animals_died' },
                    { data: 'partially_house', name: 'partially_house' },
                    { data: 'severely_house', name: 'severely_house' },
                    { data: 'fully_house', name: 'fully_house' },
                    { data: 'cowshed_house', name: 'cowshed_house' },
                    { data: 'died', name: 'died', orderable: false, searchable: false },
                    { data: 'missing', name: 'missing', orderable: false, searchable: false },
                    { data: 'injured', name: 'injured', orderable: false, searchable: false },
                    { data: 'actions', orderable: false, searchable: false, className: 'text-right' },
                ],
                order: [[2, 'desc']],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    paginate: { previous: "←", next: "→" }
                },
                createdRow: function (row) {
                    $(row).addClass('hover:bg-gray-50 dark:hover:bg-gray-700 transition');
                }
            });
        });
    </script>
</x-app-layout>
