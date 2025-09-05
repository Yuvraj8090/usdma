<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Accidental Report Categories
            </h2>
        </div>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                <i class="fas fa-car-crash mr-1"></i> Manage Categories (Human, Vehicle, Property…)
            </div>
            <a href="{{ route('admin.accidental-reports-fillable.create') }}"
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest hover:from-indigo-600 hover:to-purple-600 transition-all duration-200 shadow-lg">
                <i class="fas fa-plus-circle mr-2"></i> Create Category
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-800">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-list mr-2"></i> All Categories
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Parent</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Active</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                        @forelse($fillables as $fillable)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4">{{ $fillable->name }}</td>
                                <td class="px-6 py-4">{{ $fillable->parent?->name ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    @if($fillable->is_active)
                                        <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Active</span>
                                    @else
                                        <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.accidental-reports-fillable.edit', $fillable->id) }}"
                                       class="px-3 py-1 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.accidental-reports-fillable.destroy', $fillable->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Delete this category?')" class="px-3 py-1 bg-red-600 text-white rounded-lg shadow hover:bg-red-700">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center px-6 py-4 text-gray-500">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t">
                {{ $fillables->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
