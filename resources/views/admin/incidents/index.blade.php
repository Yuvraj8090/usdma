<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Incidents
            </h2>
        </div>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between items-center mb-6">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                <i class="fas fa-exclamation-triangle mr-1"></i> All Recorded Incidents
            </div>
            <a href="{{ route('admin.incidents.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest hover:from-indigo-600 hover:to-purple-600 shadow-lg hover:shadow-xl transition-all duration-200">
                <i class="fas fa-plus-circle mr-2"></i> Add Incident
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-600 text-green-800 dark:bg-green-800 dark:text-green-100">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-clipboard-list mr-2"></i> Incident List
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">State</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($incidents as $incident)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <td class="px-6 py-3 text-sm text-gray-900 dark:text-gray-100 capitalize">
                                    {{ $incident->incident_type }}
                                </td>

                                <td class="px-6 py-3 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $incident->name }}
                                </td>

                                <td class="px-6 py-3 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $incident->date }}
                                </td>

                                <td class="px-6 py-3 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $incident->state }}
                                </td>

                                <td class="px-6 py-3 text-right text-sm space-x-2">

                                    <a href="{{ route('admin.incidents.edit', $incident->id) }}"
                                        class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-lg text-white font-medium shadow hover:from-yellow-500 hover:to-yellow-600 transition">
                                        <i class="fas fa-edit mr-1 text-xs"></i> Edit
                                    </a>

                                    <form action="{{ route('admin.incidents.destroy', $incident->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Delete this incident?')" type="submit"
                                            class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-red-500 to-red-600 rounded-lg text-white font-medium shadow hover:from-red-600 hover:to-red-700 transition">
                                            <i class="fas fa-trash mr-1 text-xs"></i> Delete
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500 dark:text-gray-400">No incidents found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</x-app-layout>
