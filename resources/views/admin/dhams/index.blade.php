<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <i class="fas fa-landmark text-indigo-600 text-xl"></i>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                Dhams
            </h2>
        </div>
    </x-slot>

    <div class="min-h-screen p-6 bg-gray-100 dark:bg-gray-900">
        <div class="w-full">

            <!-- Page Header -->
            <div class="flex justify-between items-center mb-6">
                <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1">
                    <i class="fas fa-landmark"></i> Manage your Dhams
                </div>
                <a href="{{ route('admin.dhams.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest hover:from-indigo-600 hover:to-purple-600 transition-all duration-200 shadow-lg hover:shadow-xl gap-2">
                    <i class="fas fa-plus-circle"></i> Create New Dham
                </a>
            </div>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-800 dark:border-green-600 dark:text-green-100 rounded flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Table Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">

                <!-- Table Header -->
                <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600">
                    <h3 class="text-lg font-medium text-white flex items-center gap-2">
                        <i class="fas fa-landmark"></i> All Dhams
                    </h3>
                </div>

                <!-- Dhams Table -->
                <div class="overflow-x-auto p-6">
                    <table id="dhams-table" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 table-auto">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr class="text-gray-700 dark:text-gray-200 text-left text-sm font-semibold uppercase tracking-wider">
                                <th class="px-6 py-3">Name</th>
                                <th class="px-6 py-3">Latitude</th>
                                <th class="px-6 py-3">Longitude</th>
                                <th class="px-6 py-3">Height</th>
                                <th class="px-6 py-3">Winter</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <!-- DataTables AJAX will populate rows -->
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- DataTables JS -->
    <script>
        $(function() {
            $('#dhams-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('admin.dhams.index') }}",
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'latitude', name: 'latitude' },
                    { data: 'longitude', name: 'longitude' },
                    { data: 'height', name: 'height' },
                    { data: 'is_winter_text', name: 'is_winter' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-right' }
                ],
                order: [[0, 'asc']],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                language: {
                    search: "<span class='text-gray-700 dark:text-gray-200'>Search:</span>",
                    lengthMenu: "Show _MENU_ entries",
                    paginate: { previous: "<", next: ">" }
                },
                createdRow: function(row) {
                    $(row).addClass('hover:bg-gray-50 dark:hover:bg-gray-700 transition');
                }
            });
        });
    </script>
</x-app-layout>
