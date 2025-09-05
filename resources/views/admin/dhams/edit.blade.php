<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Dham
        </h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
            <form action="{{ route('admin.dhams.update', $dham->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                    <input type="text" name="name" value="{{ old('name', $dham->name) }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 
                               dark:bg-gray-900 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Coordinates --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Latitude</label>
                        <input type="text" name="latitude" value="{{ old('latitude', $dham->latitude) }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 
                                   dark:bg-gray-900 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('latitude')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Longitude</label>
                        <input type="text" name="longitude" value="{{ old('longitude', $dham->longitude) }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 
                                   dark:bg-gray-900 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('longitude')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Height --}}
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Height</label>
                    <input type="number" name="height" value="{{ old('height', $dham->height) }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 
                               dark:bg-gray-900 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('height')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Checkboxes --}}
                <div class="mt-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" value="1"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            {{ old('is_active', $dham->is_active) ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Active</span>
                    </label>


                </div>
                <div class="mt-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_winter" value="1"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            {{ old('is_winter', $dham->is_winter) ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Winter Dham</span>
                    </label>
                </div>
                {{-- Buttons --}}
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('admin.dhams.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-600 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-lg shadow hover:from-indigo-600 hover:to-purple-600 transition">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
