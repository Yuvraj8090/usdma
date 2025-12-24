<x-app-layout>
    <div class="min-h-screen p-6 ">
        <div class="w-full">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">

                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <i class="fas fa-layer-group text-green-500"></i>
                        Resource Types
                    </h2>

                    <button id="addResourceTypeBtn"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center gap-2 transition">
                        <i class="fas fa-plus"></i> Add Resource Type
                    </button>
                </div>

                <!-- Table -->
                <div class="p-6 overflow-x-auto">
                    <table id="resource-types-table"
                        class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 table-auto border border-gray-300 dark:border-gray-600">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr class="text-gray-700 dark:text-gray-200 text-left text-sm font-semibold">
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Resource Type</th>
                                <th class="px-4 py-2 text-center">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="resourceTypeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg w-96 p-6 shadow-lg relative">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200" id="modalTitle">Add Resource Type</h3>
            <form id="resourceTypeForm">
                @csrf
                <input type="hidden" id="resource_type_id" name="resource_type_id">
                <div class="mb-4">
                    <label for="resource_type" class="block text-gray-700 dark:text-gray-300 font-semibold">Resource Type *</label>
                    <input type="text" id="resource_type" name="resource_type"
                           class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 dark:focus:ring-green-600" required>
                    <p class="text-red-500 text-sm mt-1 hidden" id="resourceTypeError"></p>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" id="closeModal" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        <i class="fas fa-save mr-2"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {

            // Initialize DataTable
            var table = $('#resource-types-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.resource-types.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false },
                    { data: 'resource_type', name: 'resource_type' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[1, 'asc']],
                pageLength: 10,
                createdRow: function(row) {
                    $(row).addClass('hover:bg-gray-100 dark:hover:bg-gray-700 transition');
                }
            });

            // Open Add Modal
            $('#addResourceTypeBtn').click(function() {
                $('#modalTitle').text('Add Resource Type');
                $('#resourceTypeForm')[0].reset();
                $('#resource_type_id').val('');
                $('#resourceTypeError').addClass('hidden').text('');
                $('#resourceTypeModal').removeClass('hidden');
            });

            // Close Modal
            $('#closeModal').click(function() {
                $('#resourceTypeModal').addClass('hidden');
            });

            // Submit Form (Add or Update)
            $('#resourceTypeForm').submit(function(e) {
                e.preventDefault();
                let resourceTypeId = $('#resource_type_id').val();
                let url = resourceTypeId ? `/admin/resource-types/${resourceTypeId}` : "{{ route('admin.resource-types.store') }}";
                let method = resourceTypeId ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: $(this).serialize(),
                    success: function(res) {
                        $('#resourceTypeModal').addClass('hidden');
                        table.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: res.success,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        let err = xhr.responseJSON.errors.resource_type ? xhr.responseJSON.errors.resource_type[0] : 'Something went wrong';
                        $('#resourceTypeError').removeClass('hidden').text(err);
                    }
                });
            });

            // Edit Resource Type
            $(document).on('click', '.editResourceType', function() {
                let id = $(this).data('id');
                $.get(`/admin/resource-types/${id}/edit`, function(data) {
                    $('#modalTitle').text('Edit Resource Type');
                    $('#resource_type_id').val(data.id);
                    $('#resource_type').val(data.resource_type);
                    $('#resourceTypeError').addClass('hidden').text('');
                    $('#resourceTypeModal').removeClass('hidden');
                });
            });

            // Delete Resource Type
            $(document).on('click', '.deleteResourceType', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will delete the resource type!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if(result.isConfirmed){
                        $.ajax({
                            url: `/admin/resource-types/${id}`,
                            type: 'DELETE',
                            data: {_token: "{{ csrf_token() }}"},
                            success: function(res) {
                                table.ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: res.success,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }
                        });
                    }
                });
            });

        });
    </script>

</x-app-layout>
