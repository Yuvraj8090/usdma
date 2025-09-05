<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Roles Management
            </h2>
        </div>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                <i class="fas fa-user-shield mr-1"></i> Manage your roles
            </div>
            <a href="{{ route('admin.roles.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest hover:from-indigo-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl">
                <i class="fas fa-plus-circle mr-2"></i> Create New Role
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
                    <i class="fas fa-user-shield mr-2"></i> All Roles
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Created At</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($roles as $role)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $role->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-400">{{ $role->description ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-400">{{ $role->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="{{ route('admin.roles.edit', $role->id) }}" 
                                   class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-yellow-400 to-yellow-500 border border-transparent rounded-lg font-medium text-white hover:from-yellow-500 hover:to-yellow-600 transition-all duration-200 shadow">
                                    <i class="fas fa-edit mr-1 text-xs"></i> Edit
                                </a>
                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-red-500 to-red-600 border border-transparent rounded-lg font-medium text-white hover:from-red-600 hover:to-red-700 transition-all duration-200 shadow"
                                            onclick="return confirm('Are you sure you want to delete this role?')">
                                        <i class="fas fa-trash mr-1 text-xs"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center px-6 py-4 text-gray-500 dark:text-gray-400">No roles found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                {{ $roles->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</x-app-layout>
