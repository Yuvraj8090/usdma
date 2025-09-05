<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Create State
        </h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <form action="{{ route('admin.states.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">State Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center space-x-3">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    <label class="text-sm text-gray-700 dark:text-gray-300">Active</label>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.states.index') }}"
                        class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg shadow hover:bg-gray-400 dark:hover:bg-gray-500 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-semibold rounded-lg shadow hover:from-indigo-600 hover:to-purple-600 transition">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
