<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <i class="fas fa-car-crash text-indigo-600 text-xl"></i>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                Accidental Reports
            </h2>
        </div>
    </x-slot>

    <div class="min-h-screen p-6 bg-gray-100 dark:bg-gray-900">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border">

            <div class="px-6 py-4 bg-gray-700">
                <h3 class="text-lg font-medium text-white">
                    Accident Summary (District × Date)
                </h3>
            </div>

            <div class="overflow-x-auto p-6">
                <table id="accident-table" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th>District</th>
                            <th>Date</th>
                            @foreach ($parents as $parent)
                                @foreach ($parent->children as $child)
                                    <th class="text-center">{{ $child->name }}</th>
                                @endforeach
                            @endforeach
                        </tr>
                    </thead>
                    <tfoot class="bg-gray-100 font-semibold">
                        <tr>
                            <th colspan="2" class="text-right">Total:</th>
                            @foreach ($parents as $parent)
                                @foreach ($parent->children as $child)
                                    <th id="total_{{ $child->id }}" class="text-center">0</th>
                                @endforeach
                            @endforeach
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>

    <script>
        $(function() {

            let columns = [{
                    data: 'district',
                    name: 'district'
                },
                {
                    data: 'date',
                    name: 'date'
                },
            ];

            @foreach ($parents as $parent)
                @foreach ($parent->children as $child)
                    columns.push({
                        data: 'child_{{ $child->id }}',
                        name: 'child_{{ $child->id }}',
                        className: 'text-center'
                    });
                @endforeach
            @endforeach

            $('#accident-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.accidental_reports.index') }}",
                columns: columns,
                pageLength: 10,
                drawCallback: function(settings) {

                    let api = this.api();

                    @foreach ($parents as $parent)
                        @foreach ($parent->children as $child)
                            let total{{ $child->id }} = 0;

                            api.column('{{ loop->parent->index + 2 + $loop->index }}')
                                .data()
                                .each(function(value) {
                                    if (value !== '-') {
                                        total{{ $child->id }} += parseInt(value);
                                    }
                                });

                            $('#total_{{ $child->id }}').html(total{{ $child->id }});
                        @endforeach
                    @endforeach
                }
            });
        });
    </script>
</x-app-layout>
