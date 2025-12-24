<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Equipment Management
            </h2>
            <a href="{{ route('admin.equipment.create') }}"
               class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg hover:from-indigo-600 hover:to-purple-700 transition flex items-center gap-2">
                <i class="fas fa-plus"></i> Add Equipment
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Alerts -->
            @foreach (['success', 'error'] as $msg)
                @if(session($msg))
                    <div class="p-4 rounded-lg {{ $msg === 'success' ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700' }}">
                        {{ session($msg) }}
                    </div>
                @endif
            @endforeach

            <!-- Equipment Table -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr class="text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider text-left">
                                <th class="px-6 py-3">Code</th>
                                <th class="px-6 py-3">Name</th>
                                <th class="px-6 py-3">Category</th>
                                <th class="px-6 py-3">District</th>
                                <th class="px-6 py-3">Activity</th>
                                <th class="px-6 py-3">Resource Type</th>
                                <th class="px-6 py-3">Quantity</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($equipments as $equipment)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-6 py-4 font-mono text-sm bg-gray-100 dark:bg-gray-700 rounded">{{ $equipment->code }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $equipment->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $equipment->category?->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $equipment->district?->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $equipment->activity?->activity_name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $equipment->resourceType?->resource_type ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full
                                            {{ $equipment->quantity > 10 ? 'bg-green-100 text-green-800' : ($equipment->quantity > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ $equipment->quantity }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full
                                            {{ $equipment->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $equipment->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center flex justify-center gap-2">
                                       
                                        <a href="{{ route('admin.equipment.edit', $equipment) }}"
                                           class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.equipment.destroy', $equipment) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this equipment?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No equipment found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $equipments->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
