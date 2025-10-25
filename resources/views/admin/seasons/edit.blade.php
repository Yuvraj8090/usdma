<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Season
        </h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <form method="POST" action="{{ route('admin.seasons.update', $season->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="season_type" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Season Type</label>
                    <input id="season_type" type="text" name="season_type" value="{{ old('season_type', $season->season_type) }}" required
                           class="w-full px-4 py-2 border rounded-lg dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700 focus:ring focus:ring-indigo-300">
                </div>

                <div class="mb-4">
                    <label for="start_date" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Start Date</label>
                    <input id="start_date" type="date" name="start_date" value="{{ old('start_date', $season->start_date->format('Y-m-d')) }}" required
                           class="w-full px-4 py-2 border rounded-lg dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700 focus:ring focus:ring-indigo-300">
                </div>

                <div class="mb-4">
                    <label for="end_date" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">End Date</label>
                    <input id="end_date" type="date" name="end_date" value="{{ old('end_date', $season->end_date->format('Y-m-d')) }}" required
                           class="w-full px-4 py-2 border rounded-lg dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700 focus:ring focus:ring-indigo-300">
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.seasons.index') }}"
                       class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">Cancel</a>
                    <button type="submit"
                            class="px-4 py-2 bg-gradient-to-r from-yellow-400 to-yellow-500 text-white rounded-lg font-semibold hover:from-yellow-500 hover:to-yellow-600 transition">
                        Update Season
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
