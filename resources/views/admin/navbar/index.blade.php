<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Navigation Menu
            </h2>
        </div>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                <i class="fas fa-info-circle mr-1"></i> Drag items to reorder
            </div>
            <a href="{{ route('admin.navbar-items.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest hover:from-indigo-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl">
                <i class="fas fa-plus-circle mr-2"></i> Add New Item
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 bg-gray-700">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-bars mr-2"></i> Navigation Items
                </h3>
            </div>
            <div class="p-4">
                <ul id="sortable" class="space-y-2">
                    @foreach($navbarItems as $item)
                        @include('admin.navbar.partials.item', ['item' => $item])
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

 
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#sortable").sortable({
                handle: ".drag-handle",
                opacity: 0.7,
                placeholder: "sortable-placeholder",
                tolerance: "pointer",
                update: function(event, ui) {
                    var order = $(this).sortable('toArray', {attribute: 'data-id'});
                    $.post("{{ route('admin.navbar-items.update-order') }}", {
                        order: order,
                        _token: "{{ csrf_token() }}"
                    }).fail(function() {
                        showToast({
                            type: 'error',
                            title: 'Error',
                            message: 'Failed to save new order'
                        });
                    });
                }
            });
        });

        function showToast(toast) {
            const container = document.getElementById('toast-container') || createToastContainer();
            const toastId = 'toast-' + Date.now();
            
            const toastElement = document.createElement('div');
            toastElement.id = toastId;
            toastElement.className = `flex items-center w-full max-w-md p-4 mb-2 rounded-lg shadow-lg text-white transform transition-all duration-300 ${toast.type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
            toastElement.innerHTML = `
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg ${toast.type === 'success' ? 'bg-green-700' : 'bg-red-700'}">
                    ${toast.type === 'success' ? 
                        '<i class="fas fa-check text-white"></i>' : 
                        '<i class="fas fa-exclamation-triangle text-white"></i>'}
                </div>
                <div class="ml-3">
                    <div class="text-sm font-semibold">${toast.title}</div>
                    <div class="text-sm font-normal">${toast.message}</div>
                </div>
                <button type="button" onclick="document.getElementById('${toastId}').remove()" 
                    class="ml-auto -mx-1.5 -my-1.5 bg-white/20 rounded-lg p-1.5 inline-flex h-8 w-8 hover:bg-white/30 transition-colors">
                    <span class="sr-only">Close</span>
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            container.appendChild(toastElement);
            setTimeout(() => {
                toastElement.classList.add('opacity-0');
                setTimeout(() => toastElement.remove(), 300);
            }, 5000);
        }

        function createToastContainer() {
            const container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'fixed top-4 right-4 z-[9999] space-y-2 w-full max-w-md';
            document.body.appendChild(container);
            return container;
        }
    </script>

</x-app-layout>