<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <i class="fas fa-exclamation-triangle text-yellow-500 text-xl"></i>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
               Add Incidents
            </h2>
        </div>
    </x-slot>

    <div class="min-h-screen p-6 bg-gray-100 dark:bg-gray-900">
        <div class="w-full">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">

                <!-- Page Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                        Incidents
                    </h2>

                    <a href="{{ route('admin.incidents.create') }}"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center gap-2 transition">
                        <i class="fas fa-plus"></i> Add Incident
                    </a>
                </div>

                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="m-6 p-4 bg-green-500 text-white rounded flex items-center gap-2">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="m-6 p-4 bg-red-500 text-white rounded flex items-center gap-2">
                        <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
                    </div>
                @endif

                <!-- Incidents Table -->
                <div class="p-6 overflow-x-auto">
                    <table id="incidents-table"
                        class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 table-auto border border-gray-300 dark:border-gray-600">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr class="text-gray-700 dark:text-gray-200 text-left text-sm font-semibold uppercase tracking-wider">
                                <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">Type</th>
                                <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">Incident Name</th>
                                <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">Date</th>
                                <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">State</th>
                                <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">Big Animals Died</th>
                                <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">Small Animals Died</th>
                                <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">Partially House</th>
                                <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">Severely House</th>
                                <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">Fully House</th>
                                <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">Cowshed Damaged</th>
                                <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">Human Died</th>
                                <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">Human Missing</th>
                                <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">Human Injured</th>
                                <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <!-- DataTables will populate rows here -->
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- DataTables JS -->
    <script>
        $(function() {
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
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-center' },
                ],
                order: [[2, 'desc']],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                language: {
                    search: "<span class='text-gray-700 dark:text-gray-200'>Search:</span>",
                    lengthMenu: "Show _MENU_ entries",
                    paginate: { previous: "<", next: ">" }
                },
                createdRow: function(row) {
                    $(row).addClass('hover:bg-gray-100 dark:hover:bg-gray-700 transition');
                }
            });
        });
    </script>
</x-app-layout>
