<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <i class="fas fa-users text-gray-700 text-xl"></i>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                Users Management
            </h2>
        </div>
    </x-slot>

    <div class="p-6  min-h-screen">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- Header --}}
            <div class="flex justify-between items-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    <i class="fas fa-users mr-1"></i> Manage all registered users
                </p>

                <a href="{{ route('admin.users.create') }}"
                   class="inline-flex items-center px-4 py-2 rounded-lg bg-gray-700 text-white font-semibold shadow hover:shadow-lg transition">
                    <i class="fas fa-plus mr-2"></i> New User
                </a>
            </div>

            {{-- Flash Message --}}
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
                        <i class="fas fa-table"></i> Users List
                    </h3>
                </div>

                <div class="p-6 overflow-x-auto">
                    <table id="users-table" class="w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Role</th>
                                
                                <th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- DataTable Script --}}
    <script>
        $(function () {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('admin.users.index') }}",
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'role', name: 'role.name', orderable: false },
                    
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
