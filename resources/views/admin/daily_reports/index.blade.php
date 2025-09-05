<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Daily Reports
            </h2>
        </div>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                <i class="fas fa-chart-bar mr-1"></i> Track daily disaster reports
            </div>
            <a href="{{ route('admin.daily_reports.create') }}"
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-lg font-semibold text-white hover:from-indigo-600 hover:to-purple-600 shadow-lg">
                <i class="fas fa-plus-circle mr-2"></i> Add Report
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border">
            <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-database mr-2"></i> All Reports
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">District</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Count</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                        @forelse($reports as $report)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4">{{ $report->district->name ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $report->fillableCategory->name ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $report->count }}</td>
                                <td class="px-6 py-4">{{ $report->report_date->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.daily_reports.edit', $report->id) }}"
                                       class="px-3 py-1 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.daily_reports.destroy', $report->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Delete this report?')" class="px-3 py-1 bg-red-600 text-white rounded-lg shadow hover:bg-red-700">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center px-6 py-4 text-gray-500">No reports found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t">
                {{ $reports->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
