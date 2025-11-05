<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Tourist Visitor Details
            </h2>
        </div>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Top bar -->
        <div class="flex justify-between items-center mb-6">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                <i class="fas fa-users mr-1"></i> Manage daily tourist visitor details
            </div>
            <a href="{{ route('admin.tourist-visitor-details.create') }}"
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest hover:from-indigo-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl">
                <i class="fas fa-plus-circle mr-2"></i> Add New Entry
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-800 dark:border-green-600 dark:text-green-100">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Table Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-database mr-2"></i> All Visitor Entries
                </h3>
            </div>

            <div class="overflow-x-auto p-4">
                <x-table.data-table
                    :id="'visitor-table'"
                    :headers="['Date', 'Dham', 'Pilgrims', 'Vehicles', 'Dead', 'Missing', 'Actions']"
                    :page-length="10"
                    title="Tourist Visitors Export"
                    search-placeholder="Search by Dham or Date..."
                    resource-name="tourist-visitor-details"
                >
                    @forelse($visitorDetails as $detail)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($detail->date)->format('d-m-Y') }}</td>
                            <td>{{ $detail->dham->name ?? '-' }}</td>
                            <td>{{ $detail->no_of_pilgrims ?? 0 }}</td>
                            <td>{{ $detail->no_of_vehicles ?? 0 }}</td>
                            <td>{{ $detail->dead_today ?? 0 }}</td>
                            <td>{{ $detail->missing_today ?? 0 }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.tourist-visitor-details.edit', $detail->id) }}"
                                   class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded text-white shadow hover:from-yellow-500 hover:to-yellow-600">
                                    <i class="fas fa-edit mr-1 text-xs"></i> Edit
                                </a>
                                <form action="{{ route('admin.tourist-visitor-details.destroy', $detail->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-red-500 to-red-600 rounded text-white shadow hover:from-red-600 hover:to-red-700"
                                            onclick="return confirm('Are you sure you want to delete this record?')">
                                        <i class="fas fa-trash mr-1 text-xs"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-500 dark:text-gray-400">No visitor entries found.</td>
                        </tr>
                    @endforelse
                </x-table.data-table>
            </div>
        </div>
    </div>
</x-app-layout>
