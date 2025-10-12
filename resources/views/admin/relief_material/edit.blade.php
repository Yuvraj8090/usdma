<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Relief Material
        </h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <form action="{{ route('admin.relief_material.update', $reliefMaterial->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Item Name -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium">Item Name</label>
                    <input type="text" name="item_name" value="{{ old('item_name', $reliefMaterial->item_name) }}"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100" required>
                    @error('item_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- District -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium">District</label>
                    <select name="district_id" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                        <option value="">-- Select District --</option>
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ (old('district_id', $reliefMaterial->district_id) == $district->id) ? 'selected' : '' }}>
                                {{ $district->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('district_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Stock Quantity -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium">Stock Quantity</label>
                    <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $reliefMaterial->stock_quantity) }}"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                    @error('stock_quantity') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Unit -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium">Unit</label>
                    <input type="text" name="unit" value="{{ old('unit', $reliefMaterial->unit) }}"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                    @error('unit') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Remarks -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium">Remarks</label>
                    <textarea name="remarks" rows="3"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">{{ old('remarks', $reliefMaterial->remarks) }}</textarea>
                    @error('remarks') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.relief_material.index') }}" 
                        class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit" 
                        class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-semibold rounded-lg shadow hover:from-indigo-600 hover:to-purple-600">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
