<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Pages
            </h2>
        </div>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                <i class="fas fa-file-alt mr-1"></i> Manage your website pages
            </div>
            <a href="{{ route('admin.pages.create.form') }}" 
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest hover:from-indigo-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl">
                <i class="fas fa-plus-circle mr-2"></i> Create New Page
            </a>
        </div>

        @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-800 dark:border-green-600 dark:text-green-100">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-file-alt mr-2"></i> All Pages
                </h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Slug</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($pages as $page)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $page->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $page->slug }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $page->status ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                    {{ $page->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="{{ route('admin.pages.edit.form', $page->id) }}" 
                                   class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-yellow-400 to-yellow-500 border border-transparent rounded-lg font-medium text-white hover:from-yellow-500 hover:to-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all duration-200 shadow">
                                    <i class="fas fa-edit mr-1 text-xs"></i> Edit
                                </a>
                                <form action="{{ route('admin.pages.delete', $page->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-red-500 to-red-600 border border-transparent rounded-lg font-medium text-white hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 shadow"
                                            onclick="return confirm('Are you sure you want to delete this page?')">
                                        <i class="fas fa-trash mr-1 text-xs"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                {{ $pages->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
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
    @endpush
</x-app-layout>