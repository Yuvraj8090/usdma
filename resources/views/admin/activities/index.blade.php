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

    <!-- Modal -->
    <div id="activityModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg w-96 p-6 shadow-lg relative">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200" id="modalTitle">Add Activity</h3>
            <form id="activityForm">
                @csrf
                <input type="hidden" id="activity_id" name="activity_id">
                <div class="mb-4">
                    <label for="activity_name" class="block text-gray-700 dark:text-gray-300 font-semibold">Activity Name *</label>
                    <input type="text" id="activity_name" name="activity_name" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-600" required>
                    <p class="text-red-500 text-sm mt-1 hidden" id="activityError"></p>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" id="closeModal" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        <i class="fas fa-save mr-2"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {

            // Initialize DataTable
            var table = $('#activities-table').DataTable({
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

            // Open Add Modal
            $('#addActivityBtn').click(function() {
                $('#modalTitle').text('Add Activity');
                $('#activityForm')[0].reset();
                $('#activity_id').val('');
                $('#activityError').addClass('hidden').text('');
                $('#activityModal').removeClass('hidden');
            });

            // Close Modal
            $('#closeModal').click(function() {
                $('#activityModal').addClass('hidden');
            });

            // Submit Form (Add or Update)
            $('#activityForm').submit(function(e) {
                e.preventDefault();
                let activityId = $('#activity_id').val();
                let url = activityId ? `/admin/activities/${activityId}` : "{{ route('admin.activities.store') }}";
                let method = activityId ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: $(this).serialize(),
                    success: function(res) {
                        $('#activityModal').addClass('hidden');
                        table.ajax.reload();
                        alert(res.success);
                    },
                    error: function(xhr) {
                        let err = xhr.responseJSON.errors.activity_name ? xhr.responseJSON.errors.activity_name[0] : 'Something went wrong';
                        $('#activityError').removeClass('hidden').text(err);
                    }
                });
            });

            // Edit Activity
            $(document).on('click', '.editActivity', function() {
                let id = $(this).data('id');
                $.get(`/admin/activities/${id}/edit`, function(data) {
                    $('#modalTitle').text('Edit Activity');
                    $('#activity_id').val(data.id);
                    $('#activity_name').val(data.activity_name);
                    $('#activityError').addClass('hidden').text('');
                    $('#activityModal').removeClass('hidden');
                });
            });

            // Delete Activity
            $(document).on('click', '.deleteActivity', function() {
                if(!confirm('Are you sure you want to delete this activity?')) return;
                let id = $(this).data('id');
                $.ajax({
                    url: `/admin/activities/${id}`,
                    type: 'DELETE',
                    data: {_token: "{{ csrf_token() }}"},
                    success: function(res) {
                        table.ajax.reload();
                        alert(res.success);
                    }
                });
            });

        });
    </script>
   
</x-app-layout>
