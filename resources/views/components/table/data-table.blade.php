@props([
    'id' => 'data-table',
    'headers' => [],
    'excel' => true,
    'print' => true,
    'pageLength' => 10,
    'lengthMenu' => [5, 10, 25, 50, -1],
    'lengthMenuLabels' => ['5', '10', '25', '50', 'All'],
    'title' => 'Data Export',
    'searchPlaceholder' => 'Search...',
    'resourceName' => 'entries',
])

<div class="w-full overflow-x-auto">
    <table id="{{ $id }}" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-center">
        <thead class="bg-indigo-500 text-white  ">
            <tr>
                @foreach($headers as $header)
                    <th class="px-4 py-3 text-center text-sm font-semibold whitespace-nowrap uppercase tracking-wider">
                        {{ $header }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700 text-center">
            {{ $slot }}
        </tbody>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tableId = "{{ $id }}";
    const table = $('#' + tableId);

    let actionColumnIndex = -1;
    table.find('thead th').each(function(index) {
        if ($(this).text().trim().toLowerCase() === 'actions') actionColumnIndex = index;
    });

    const buttons = [];

    @if($excel)
    buttons.push({
        extend: 'excel',
        text: '<i class="fas fa-file-excel mr-1"></i> Excel',
        className: 'bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded shadow',
        title: '{{ $title }}',
        exportOptions: {
            columns: actionColumnIndex === -1 ? ':visible' : ':not(:eq(' + actionColumnIndex + '))'
        }
    });
    @endif

    @if($print)
    buttons.push({
        extend: 'print',
        text: '<i class="fas fa-print mr-1"></i> Print',
        className: 'bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded shadow',
        title: '{{ $title }}',
        exportOptions: {
            columns: actionColumnIndex === -1 ? ':visible' : ':not(:eq(' + actionColumnIndex + '))'
        },
        customize: function(win) {
            $(win.document.body).find('table')
                .addClass('min-w-full divide-y divide-gray-200 text-center')
                .css('font-size', 'inherit');
        }
    });
    @endif

    // Tailwind renderer for pagination
    $.fn.dataTable.ext.renderer.pageButton.tailwind = function(settings, host, idx, buttons, page, pages) {
        var api = new $.fn.dataTable.Api(settings);
        var container = $(host).empty();

        const btnClass = 'px-3 py-1 rounded shadow text-gray-700 hover:bg-gray-200';
        const activeClass = 'bg-indigo-500 text-white shadow-md';
        const disabledClass = 'opacity-50 cursor-not-allowed';

        const createButton = (label, pageNum, disabled, active) => {
            const btn = $('<button/>').addClass(btnClass).text(label).attr('type', 'button');
            if(disabled) btn.addClass(disabledClass).prop('disabled', true);
            if(active) btn.addClass(activeClass).prop('disabled', true);
            btn.on('click', () => api.page(pageNum).draw('page'));
            return btn;
        };

        container.append(createButton('«', 0, page === 0, false));
        container.append(createButton('‹', page - 1, page === 0, false));

        for(let i=0;i<pages;i++) container.append(createButton(i+1, i, false, page===i));

        container.append(createButton('›', page + 1, page === pages-1, false));
        container.append(createButton('»', pages-1, page === pages-1, false));
    };

    // Initialize DataTable
    table.DataTable({
        dom: '<"flex justify-between mb-4"<"flex space-x-2"B><"flex space-x-2"f>>' +
            '<"overflow-x-auto"t>' +
            '<"flex justify-between mt-4"<"text-sm text-gray-500"i><"flex space-x-2"p>>',
        buttons,
        responsive: true,
        pageLength: {{ $pageLength }},
        lengthMenu: [@json($lengthMenu), @json($lengthMenuLabels)],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "{{ $searchPlaceholder }}",
            lengthMenu: "Show _MENU_ {{ $resourceName }}",
            info: "Showing _START_ to _END_ of _TOTAL_ {{ $resourceName }}",
            infoEmpty: "No {{ $resourceName }} available",
            emptyTable: "No data available",
            zeroRecords: "No matching records found",
            paginate: { previous: '‹', next: '›' }
        },
        columnDefs: [
            { orderable: false, targets: actionColumnIndex, className: 'text-center' },
            { targets: '_all', className: 'align-middle text-center' }
        ],
        renderer: 'tailwind',
        initComplete: function() {
            $('.dataTables_filter input')
                .removeClass()
                .addClass('border rounded px-2 py-1 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none');
            $('.dataTables_length select')
                .removeClass()
                .addClass('border rounded px-2 py-1 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none');
            $('.dt-buttons button')
                .removeClass('dt-button')
                .addClass('px-3 py-1 rounded shadow text-white');
        }
    });
});
</script>
