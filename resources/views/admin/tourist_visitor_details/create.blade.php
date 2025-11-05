<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Add Tourist Visitor Detail
        </h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <form action="{{ route('admin.tourist-visitor-details.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="location_id" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Select Dham</label>
                        <select name="location_id" id="location_id" class="form-select w-full rounded">
                            <option value="">-- Select Dham --</option>
                            @foreach($dhams as $dham)
                                <option value="{{ $dham->id }}">{{ $dham->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="date" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Date</label>
                        <input type="date" name="date" class="form-input w-full rounded" required>
                    </div>

                    <div>
                        <label for="reporting_time" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Reporting Time</label>
                        <input type="time" name="reporting_time" class="form-input w-full rounded">
                    </div>

                    <div>
                        <label for="no_of_pilgrims" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">No. of Pilgrims</label>
                        <input type="number" name="no_of_pilgrims" class="form-input w-full rounded" value="0">
                    </div>

                    <div>
                        <label for="no_of_vehicles" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">No. of Vehicles</label>
                        <input type="number" name="no_of_vehicles" class="form-input w-full rounded" value="0">
                    </div>

                    <div>
                        <label for="dead_today" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Dead Today</label>
                        <input type="number" name="dead_today" class="form-input w-full rounded" value="0">
                    </div>

                    <div>
                        <label for="missing_today" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Missing Today</label>
                        <input type="number" name="missing_today" class="form-input w-full rounded" value="0">
                    </div>

                    <div>
                        <label for="entry_date" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Entry Date & Time</label>
                        <input type="datetime-local" name="entry_date" class="form-input w-full rounded" required>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-2">
                    <a href="{{ route('admin.tourist-visitor-details.index') }}"
                       class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded shadow">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded shadow hover:from-indigo-600 hover:to-purple-600">
                        <i class="fas fa-save mr-1"></i> Save Entry
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
