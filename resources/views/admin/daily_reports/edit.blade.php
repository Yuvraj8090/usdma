<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Daily Report
        </h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <form action="{{ route('admin.daily_reports.update', $report->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- District -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">District</label>
                    <select name="district_id" class="w-full rounded-lg border px-3 py-2 dark:bg-gray-900 dark:text-white" required>
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ $report->district_id == $district->id ? 'selected' : '' }}>
                                {{ $district->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Fillable -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Fillable</label>
                    <select name="fillable_id" class="w-full rounded-lg border px-3 py-2 dark:bg-gray-900 dark:text-white" required>
                        @foreach($fillables as $fillable)
                            <option value="{{ $fillable->id }}" {{ $report->fillable_id == $fillable->id ? 'selected' : '' }}>
                                {{ $fillable->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Count -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Count</label>
                    <input type="number" name="count" value="{{ $report->count }}"
                           class="w-full rounded-lg border px-3 py-2 dark:bg-gray-900 dark:text-white" required>
                </div>

                <!-- Date -->
                <div class="mb-6">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Date</label>
                    <input type="date" name="report_date" value="{{ $report->report_date }}"
                           class="w-full rounded-lg border px-3 py-2 dark:bg-gray-900 dark:text-white" required>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.daily_reports.index') }}"
                       class="px-4 py-2 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-lg shadow hover:from-indigo-600 hover:to-purple-600">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
