<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Equipment
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">

                <!-- Card Header -->
                <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600">
                    <h3 class="text-lg font-medium text-white flex items-center">
                        <i class="fas fa-edit mr-2"></i> Update Equipment
                    </h3>
                </div>

                <!-- Form -->
                <div class="p-6">
                    <form action="{{ route('admin.equipment.update', $equipment->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300 font-semibold">
                                Name *
                            </label>
                            <input type="text" name="name"
                                   value="{{ old('name', $equipment->name) }}"
                                   class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-600"
                                   required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Code -->
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300 font-semibold">
                                Code *
                            </label>
                            <input type="text" name="code"
                                   value="{{ old('code', $equipment->code) }}"
                                   class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-600"
                                   required>
                            @error('code')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300 font-semibold">
                                Category
                            </label>
                            <select name="category_id"
                                    class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-600">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $equipment->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- District -->
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300 font-semibold">
                                District
                            </label>
                            <select name="district_id"
                                    class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-600">
                                <option value="">Select District</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}"
                                        {{ old('district_id', $equipment->district_id) == $district->id ? 'selected' : '' }}>
                                        {{ $district->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('district_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quantity -->
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300 font-semibold">
                                Quantity *
                            </label>
                            <input type="number" name="quantity" min="0"
                                   value="{{ old('quantity', $equipment->quantity) }}"
                                   class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-600"
                                   required>
                            @error('quantity')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remarks -->
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300 font-semibold">
                                Remarks
                            </label>
                            <textarea name="remarks" rows="3"
                                      class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-600">{{ old('remarks', $equipment->remarks) }}</textarea>
                            @error('remarks')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Active -->
                         <div class="mb-4">
                            <label for="activity_id"
                                class="block text-gray-700 dark:text-gray-300 font-semibold">Activity</label>
                            <select name="activity_id" id="activity_id"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-600">
                                <option value="">Select Activity</option>
                                @foreach ($activities as $activity)
                                    <option value="{{ $activity->id }}"
                                        {{ old('activity_id', $equipment->activity_id ?? '') == $activity->id ? 'selected' : '' }}>
                                        {{ $activity->activity_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('activity_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Resource Type -->
                        <div class="mb-4">
                            <label for="resource_type_id"
                                class="block text-gray-700 dark:text-gray-300 font-semibold">Resource Type</label>
                            <select name="resource_type_id" id="resource_type_id"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-600">
                                <option value="">Select Resource Type</option>
                                @foreach ($resourceTypes as $type)
                                    <option value="{{ $type->id }}"
                                        {{ old('resource_type_id', $equipment->resource_type_id ?? '') == $type->id ? 'selected' : '' }}>
                                        {{ $type->resource_type }}
                                    </option>
                                @endforeach
                            </select>
                            @error('resource_type_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Active Checkbox -->
                        <div class="mb-6 flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                {{ old('is_active', true) ? 'checked' : '' }}
                                class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500">
                            <label for="is_active" class="ml-2 text-gray-700 dark:text-gray-300">Active</label>
                        </div>


                        <!-- Buttons -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.equipment.index') }}"
                               class="px-5 py-2.5 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-600 transition">
                                Cancel
                            </a>

                            <button type="submit"
                                    class="px-5 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-lg shadow hover:from-indigo-600 hover:to-purple-600 transition">
                                <i class="fas fa-save mr-2"></i> Update Equipment
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
