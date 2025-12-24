<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <i class="fas fa-layer-group text-indigo-600 text-xl"></i>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                Daily Report Categories
            </h2>
        </div>
    </x-slot>

    <div class="min-h-screen p-6 ">
        <div class="w-full">

            <!-- Page Header -->
            <div class="flex justify-between items-center mb-6">
                <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1">
                    <i class="fas fa-layer-group"></i> Manage Categories
                </div>

                <a href="{{ route('admin.daily_reports_fillable.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-700 rounded-lg font-semibold text-white shadow-lg hover:shadow-xl gap-2">
                    <i class="fas fa-plus-circle"></i> Create Category
                </a>
            </div>

            <!-- Flash -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Table Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border">

                <div class="px-6 py-4 bg-gray-700">
                    <h3 class="text-lg font-medium text-white flex items-center gap-2">
                        <i class="fas fa-list"></i> All Categories
                    </h3>
                </div>

                <div class="overflow-x-auto p-6">
                    <table id="categories-table"
                        class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr class="text-sm uppercase tracking-wider">
                                <th class="px-6 py-3">Name</th>
                                <th class="px-6 py-3">Parent</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- DataTable -->
    <script>
        $(function () {
            $('#categories-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.daily_reports_fillable.index') }}",
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'parent_name', name: 'parent.name' },
                    { data: 'status', name: 'is_active', orderable: false, searchable: false },
                    { data: 'actions', orderable: false, searchable: false, className: 'text-right' }
                ],
                order: [[0, 'asc']],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                createdRow: function(row) {
                    $(row).addClass('hover:bg-gray-50 dark:hover:bg-gray-700');
                }
            });
        });
    </script>
</x-app-layout>
