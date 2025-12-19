<x-app-layout>
    <div class="min-h-screen p-6 bg-gray-100 dark:bg-gray-900">

        <div class="w-full">

            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">

                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                        Incidents
                    </h2>

                    <a href="{{ route('admin.incidents.create') }}"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center gap-2">
                        <i class="fas fa-plus"></i> Add Incident
                    </a>
                </div>

                <!-- Success -->
                @if (session('success'))
                    <div class="m-6 p-4 bg-green-500 text-white rounded flex items-center gap-2">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif
                <div class="p-6 overflow-x-auto">
    <table id="incidents-table" class="min-w-full">
        <thead>
            <tr>
                <th>Type</th>
                <th>Incident Name</th>
                <th>Date</th>
                <th>State</th>

                <th>Big Animals Died</th>
                <th>Small Animals Died</th>

                <th>Partially House</th>
                <th>Severely House</th>
                <th>Fully House</th>
                <th>Cowshed Damaged</th>

                <th>Human Died</th>
                <th>Human Missing</th>
                <th>Human Injured</th>

                <th>Actions</th>
            </tr>
        </thead>
    </table>
</div>



            </div>

        </div>
    </div>

    <!-- DataTables Script -->
  <script>
$(function () {
    $('#incidents-table').DataTable({
        processing: true,
        serverSide: true,
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

            { data: 'actions', name: 'actions', orderable: false, searchable: false },
        ],

        order: [[2, 'desc']]
    });
});
</script>


</x-app-layout>
