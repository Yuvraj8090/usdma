<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <i class="fas fa-user-shield text-gray-700 text-xl"></i>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                Roles Management
            </h2>
        </div>
    </x-slot>

    <div class="p-6  min-h-screen">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- Header --}}
            <div class="flex justify-between items-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    <i class="fas fa-user-shield mr-1"></i> Manage application roles
                </p>

                <a href="{{ route('admin.roles.create') }}"
                   class="inline-flex items-center px-4 py-2 rounded-lg bg-gray-700 text-white font-semibold shadow hover:shadow-lg transition">
                    <i class="fas fa-plus mr-2"></i> New Role
                </a>
            </div>

            {{-- Flash --}}
            @if(session('success'))
                <div class="flex items-center gap-2 p-4 rounded-lg bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-100">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Table --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 bg-gray-700 rounded-t-xl">
                    <h3 class="text-white font-semibold flex items-center gap-2">
                        <i class="fas fa-table"></i> Roles List
                    </h3>
                </div>

                <div class="p-6 overflow-x-auto">
                    <table id="roles-table" class="w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Description</th>
                                <th class="px-4 py-3">Created</th>
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
            $('#roles-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('admin.roles.index') }}",
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'description', name: 'description', defaultContent: '-' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'actions', orderable: false, searchable: false, className: 'text-right' }
                ],
                order: [[0, 'asc']],
                pageLength: 10,
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
