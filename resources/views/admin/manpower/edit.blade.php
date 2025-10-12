<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Manpower
            </h2>
        </div>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-t-xl">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-user-edit mr-2"></i> Update Manpower
                </h3>
            </div>

            <div class="p-6">
                <form action="{{ route('admin.manpower.update', $manpower->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                        <input type="text" name="category" id="category" value="{{ old('category', $manpower->category) }}"
                               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        @error('category')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- District -->
                    <div>
                        <label for="district_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">District</label>
                        <select name="district_id" id="district_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @foreach($districts as $district)
                                <option value="{{ $district->id }}" {{ old('district_id', $manpower->district_id) == $district->id ? 'selected' : '' }}>
                                    {{ $district->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('district_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Count -->
                    <div>
                        <label for="count" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Count</label>
                        <input type="number" name="count" id="count" value="{{ old('count', $manpower->count) }}"
                               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        @error('count')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remarks -->
                    <div>
                        <label for="remarks" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Remarks</label>
                        <textarea name="remarks" id="remarks" rows="3" 
                                  class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('remarks', $manpower->remarks) }}</textarea>
                        @error('remarks')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.manpower.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 rounded-lg text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-500 transition">
                            Cancel
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-yellow-400 to-yellow-500 text-white rounded-lg shadow hover:from-yellow-500 hover:to-yellow-600 transition">
                            <i class="fas fa-save mr-2"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
