<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.seasons.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-all duration-200 shadow">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Create Season
            </h2>
        </div>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <form method="POST" action="{{ route('admin.seasons.store') }}">
                @csrf

                <!-- Season Type Selection -->
                <div class="mb-4">
                    <label for="season_type_select" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">
                        Season Type
                    </label>
                    <select id="season_type_select" name="season_type_select" required
                            class="w-full px-4 py-2 border rounded-lg dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700 focus:ring focus:ring-indigo-300">
                        <option value="">-- Select Season Type --</option>
                        <option value="Winter" {{ old('season_type_select') == 'Winter' ? 'selected' : '' }}>Winter</option>
                        <option value="Summer" {{ old('season_type_select') == 'Summer' ? 'selected' : '' }}>Summer</option>
                        <option value="Other" {{ old('season_type_select') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <!-- If Other Selected -->
                <div id="custom_season_type_wrapper" class="mb-4 hidden">
                    <label for="season_type" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">
                        Season Type
                    </label>
                    <input id="season_type" type="text" name="season_type" value="{{ old('season_type') }}"
                           placeholder="Enter custom season name"
                           class="w-full px-4 py-2 border rounded-lg dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700 focus:ring focus:ring-indigo-300">
                </div>

                <!-- Start Date -->
                <div class="mb-4">
                    <label for="start_date" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">
                        Start Date
                    </label>
                    <input id="start_date" type="date" name="start_date" value="{{ old('start_date') }}" required
                           class="w-full px-4 py-2 border rounded-lg dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700 focus:ring focus:ring-indigo-300">
                </div>

                <!-- End Date -->
                <div class="mb-4">
                    <label for="end_date" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">
                        End Date
                    </label>
                    <input id="end_date" type="date" name="end_date" value="{{ old('end_date') }}" 
                           class="w-full px-4 py-2 border rounded-lg dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700 focus:ring focus:ring-indigo-300">
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3 mt-6">
                    

                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg font-semibold hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 shadow">
                        <i class="fas fa-save mr-2"></i> Save Season
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const select = document.getElementById('season_type_select');
            const customWrapper = document.getElementById('custom_season_type_wrapper');
            const input = document.getElementById('season_type');

            function toggleCustomInput() {
                if (select.value === 'Other') {
                    customWrapper.classList.remove('hidden');
                    input.required = true;
                } else {
                    customWrapper.classList.add('hidden');
                    input.required = false;
                    input.value = select.value || '';
                }
            }

            select.addEventListener('change', toggleCustomInput);
            toggleCustomInput(); // Initialize on load (in case of validation errors)
        });
    </script>
</x-app-layout>
