<x-app-layout>
    <div class="min-h-screen p-6 bg-gray-100 dark:bg-gray-900">
        <div class="w-full">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">

                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <i class="fas fa-tasks text-indigo-500"></i>
                        Activities
                    </h2>

                    <button id="addActivityBtn"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center gap-2 transition">
                        <i class="fas fa-plus"></i> Add Activity
                    </button>
                </div>

                <!-- Table -->
                <div class="p-6 overflow-x-auto">
                    <table id="activities-table"
                        class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 table-auto border border-gray-300 dark:border-gray-600">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr class="text-gray-700 dark:text-gray-200 text-left text-sm font-semibold">
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Activity Name</th>
                                <th class="px-4 py-2 text-center">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <script>
        $(function () {
            $('#activities-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.activities.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false },
                    { data: 'activity_name', name: 'activity_name' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[1, 'asc']],
                pageLength: 10,
                createdRow: function(row) {
                    $(row).addClass('hover:bg-gray-100 dark:hover:bg-gray-700 transition');
                }
            });
        });
    </script>
</x-app-layout>
