<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <i class="fas fa-cogs text-gray-700 text-xl"></i>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                Equipment Management
            </h2>
        </div>
    </x-slot>

    <div class="min-h-screen p-6 ">

        <div class="w-full">

            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">

                <!-- Page Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                        Equipment Management
                    </h2>

                    <a href="{{ route('admin.equipment.create') }}"
                        class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:from-indigo-600 hover:to-purple-700 transition flex items-center gap-2">
                        <i class="fas fa-plus"></i> Add Equipment
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

                <!-- Equipment Table -->
                <div class="p-6 overflow-x-auto">
                    <table id="equipment-table"
                        class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 table-auto border border-gray-300 dark:border-gray-600">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr class="text-gray-700 dark:text-gray-200 text-left text-sm font-semibold uppercase tracking-wider">
                                <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">Code</th>
                                <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">Name</th>
                                <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">Category</th>
                                <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">District</th>
                                <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">Activity</th>
                                <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">Resource Type</th>
                                <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">Quantity</th>
                                <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">Status</th>
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
            $('#equipment-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('admin.equipment.index') }}",
                columns: [
                    { data: 'code', name: 'code' },
                    { data: 'name', name: 'name' },
                    { data: 'category', name: 'category.name' },
                    { data: 'district', name: 'district.name' },
                    { data: 'activity', name: 'activity.activity_name' },
                    { data: 'resource_type', name: 'resourceType.resource_type' },
                    { data: 'quantity', name: 'quantity', orderable: false, searchable: false },
                    { data: 'status', name: 'is_active', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' },
                ],
                order: [[0, 'desc']],
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
