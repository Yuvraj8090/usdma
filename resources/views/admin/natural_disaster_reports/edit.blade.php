<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Natural Disaster Report
        </h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <form action="{{ route('admin.natural-disaster-reports.update', $naturalDisasterReport->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- District -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">District</label>
                    <select name="district_id" class="w-full rounded-lg border px-3 py-2 dark:bg-gray-900 dark:text-white" required>
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ $naturalDisasterReport->district_id == $district->id ? 'selected' : '' }}>
                                {{ $district->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Category</label>
                    <select name="fillable_id" class="w-full rounded-lg border px-3 py-2 dark:bg-gray-900 dark:text-white" required>
                        @foreach($fillables as $fillable)
                            <option value="{{ $fillable->id }}" {{ $naturalDisasterReport->fillable_id == $fillable->id ? 'selected' : '' }}>
                                {{ $fillable->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Affected Count -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Affected Count</label>
                    <input type="number" name="affected_count" value="{{ $naturalDisasterReport->affected_count }}"
                           class="w-full rounded-lg border px-3 py-2 dark:bg-gray-900 dark:text-white" required>
                </div>

                <!-- Damaged Property -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Damaged Property Value</label>
                    <input type="text" name="property_damage" value="{{ $naturalDisasterReport->property_damage }}"
                           class="w-full rounded-lg border px-3 py-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Description</label>
                    <textarea name="description" class="w-full rounded-lg border px-3 py-2 dark:bg-gray-900 dark:text-white">{{ $naturalDisasterReport->description }}</textarea>
                </div>

                <!-- Date -->
                <div class="mb-6">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Date</label>
                    <input type="date" name="report_date" value="{{ $naturalDisasterReport->report_date->format('Y-m-d') }}"
                           class="w-full rounded-lg border px-3 py-2 dark:bg-gray-900 dark:text-white" required>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.natural-disaster-reports.index') }}"
                       class="px-4 py-2 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-lg shadow hover:from-green-600 hover:to-teal-600">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
