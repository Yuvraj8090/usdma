<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Create Dham
        </h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
            <form action="{{ route('admin.dhams.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full mt-1 px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" required>
                    @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">State</label>
                    <select name="state_id" class="w-full mt-1 px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" required>
                        <option value="">-- Select State --</option>
                        @foreach($states as $state)
                            <option value="{{ $state->id }}" {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                {{ $state->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('state_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">District</label>
                    <select name="district_id" class="w-full mt-1 px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" required>
                        <option value="">-- Select District --</option>
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>
                                {{ $district->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('district_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">Latitude</label>
                        <input type="text" name="latitude" value="{{ old('latitude') }}"
                               class="w-full mt-1 px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">Longitude</label>
                        <input type="text" name="longitude" value="{{ old('longitude') }}"
                               class="w-full mt-1 px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">Height</label>
                        <input type="number" name="height" value="{{ old('height') }}"
                               class="w-full mt-1 px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>
                </div>

                <div class="mt-4 flex space-x-4">
                    <label><input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}> Active</label>
                    <label><input type="checkbox" name="is_winter" value="1" {{ old('is_winter') ? 'checked' : '' }}> Winter</label>
                </div>

                <div class="mt-6">
                    <button type="submit"
                            class="px-6 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg shadow hover:from-indigo-600 hover:to-purple-700">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
