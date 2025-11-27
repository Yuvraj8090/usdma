<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Create Incident Type
        </h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <form action="{{ route('admin.incident-types.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Incident Type Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-indigo-500">
                    @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center space-x-3">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    <label class="text-sm text-gray-700 dark:text-gray-300">Active</label>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.incident-types.index') }}" class="px-4 py-2 bg-gray-300 rounded-lg">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-indigo-500 text-white rounded-lg">Save</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
