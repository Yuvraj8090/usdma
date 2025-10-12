<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Manpower Management
            </h2>
        </div>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Top bar -->
        <div class="flex justify-between items-center mb-6">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                <i class="fas fa-users mr-1"></i> Manage manpower resources across districts
            </div>
            <a href="{{ route('admin.manpower.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest hover:from-indigo-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl">
                <i class="fas fa-plus-circle mr-2"></i> Add Manpower
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-800 dark:border-green-600 dark:text-green-100 rounded">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 dark:bg-red-800 dark:border-red-600 dark:text-red-100 rounded">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-circle mr-2 mt-1"></i>
                    <ul class="list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Manpower Table Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <!-- Card Header -->
            <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-users mr-2"></i> All Manpower
                </h3>
            </div>

            <!-- DataTable Component -->
            <div class="overflow-x-auto p-4">
                <x-table.data-table
                    :id="'manpower-table'"
                    :headers="['Category', 'District', 'Count', 'Remarks', 'Actions']"
                    :page-length="10"
                    :length-menu="[5, 10, 25, 50, -1]"
                    :length-menu-labels="['5', '10', '25', '50', 'All']"
                    title="Manpower Export"
                    search-placeholder="Search Manpower..."
                    resource-name="manpower"
                >
                    @forelse($manpower as $person)
                        <tr>
                            <td class="font-semibold text-gray-700 dark:text-gray-200">{{ $person->category }}</td>
                            <td>{{ $person->district?->name ?? 'N/A' }}</td>
                            <td>
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100 rounded text-sm font-semibold">
                                    {{ $person->count }}
                                </span>
                            </td>
                            <td>{{ $person->remarks ?? '-' }}</td>
                            <td class="text-center space-x-2">
                                <!-- Edit Button -->
                                <a href="{{ route('admin.manpower.edit', $person->id) }}" 
                                   class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded text-white shadow hover:from-yellow-500 hover:to-yellow-600">
                                    <i class="fas fa-edit mr-1 text-xs"></i> Edit
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('admin.manpower.destroy', $person->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-red-500 to-red-600 rounded text-white shadow hover:from-red-600 hover:to-red-700"
                                            onclick="return confirm('Are you sure you want to delete this manpower record?')">
                                        <i class="fas fa-trash mr-1 text-xs"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        
                    @endforelse
                </x-table.data-table>
            </div>
        </div>
    </div>
</x-app-layout>
