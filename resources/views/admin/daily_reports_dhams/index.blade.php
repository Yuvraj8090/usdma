<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Daily Reports (Dhams)
        </h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- 🔹 Filters + Create Button -->
        <div class="mb-6 flex flex-wrap justify-between items-end gap-4">
            <!-- Filters -->
            <form method="GET" class="flex flex-wrap gap-4 items-end">
                <!-- Dham Filter -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Dham</label>
                    <select name="dham_id" class="rounded-lg border px-3 py-2 dark:bg-gray-900 dark:text-white">
                        <option value="">All</option>
                        @foreach($dhams as $dham)
                            <option value="{{ $dham->id }}" {{ request('dham_id') == $dham->id ? 'selected' : '' }}>
                                {{ $dham->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Fillable Filter -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Fillable</label>
                    <select name="fillable_id" class="rounded-lg border px-3 py-2 dark:bg-gray-900 dark:text-white">
                        <option value="">All</option>
                        @foreach($fillables as $fillable)
                            <option value="{{ $fillable->id }}" {{ request('fillable_id') == $fillable->id ? 'selected' : '' }}>
                                {{ $fillable->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Report Date Filter -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Report Date</label>
                    <input type="date" name="report_date" value="{{ request('report_date') }}"
                           class="rounded-lg border px-3 py-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- Filter Button -->
                <div>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                        Filter
                    </button>
                </div>
            </form>

            <!-- Create Report Button -->
            <div>
                <a href="{{ route('admin.daily_reports_dhams.create') }}"
                   class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">
                    + Create Report
                </a>
            </div>
        </div>

        <!-- 🔹 Download PDF Form -->
        <form action="{{ route('admin.daily_reports_dhams.pdf') }}" method="GET" class="mb-6 flex flex-wrap gap-4 items-end">
            <!-- Report Date (to specify end date) -->
            <div>
                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Report Date (End)</label>
                <input type="date" name="report_date" required class="rounded-lg border px-3 py-2 dark:bg-gray-900 dark:text-white">
            </div>

            <!-- Financial Year -->
            <div>
                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Financial Year</label>
                <input type="number" name="year" value="{{ now()->year }}" 
                       class="rounded-lg border px-3 py-2 dark:bg-gray-900 dark:text-white">
            </div>

            <!-- Submit -->
            <div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg shadow hover:bg-green-600">
                    Download PDF
                </button>
            </div>
        </form>

        <!-- 🔹 Reports Table -->
        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 border border-gray-200 dark:border-gray-700">
            <table class="min-w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                        <th class="border border-gray-300 p-3 text-left">Dham</th>
                        <th class="border border-gray-300 p-3 text-left">Fillable</th>
                        <th class="border border-gray-300 p-3 text-center">Count</th>
                        <th class="border border-gray-300 p-3 text-center">Report Date</th>
                        <th class="border border-gray-300 p-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900 transition">
                            <td class="border border-gray-300 p-3">{{ $report->dham->name }}</td>
                            <td class="border border-gray-300 p-3">{{ $report->fillableCategory->name }}</td>
                            <td class="border border-gray-300 p-3 text-center">{{ $report->count }}</td>
                            <td class="border border-gray-300 p-3 text-center">{{ $report->report_date->format('Y-m-d') }}</td>
                            <td class="border border-gray-300 p-3 text-center">
                                <div class="flex justify-center gap-2">
                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.daily_reports_dhams.edit', $report) }}"
                                       class="px-3 py-1 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600">
                                        Edit
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.daily_reports_dhams.forceDestroy', $report) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this report?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1 bg-red-600 text-white rounded-lg shadow hover:bg-red-700">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="border border-gray-300 p-6 text-center text-gray-500">
                                No reports found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $reports->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
