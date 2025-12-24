<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Disaster Type
        </h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <form action="{{ route('admin.disaster-types.update', $disasterType->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Disaster Type Name</label>
                    <input type="text" name="name" value="{{ old('name', $disasterType->name) }}" class="mt-1 block w-full border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-indigo-500">
                    @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Incident Type</label>
                    <select name="incident_type_id" class="mt-1 block w-full border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-indigo-500">
                        <option value="">-- Select Incident Type --</option>
                        @foreach($incidentTypes as $type)
                            <option value="{{ $type->id }}" {{ old('incident_type_id', $disasterType->incident_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                    @error('incident_type_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center space-x-3">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $disasterType->is_active) ? 'checked' : '' }} class="h-4 w-4 text-gray-700 border-gray-300 rounded">
                    <label class="text-sm text-gray-700 dark:text-gray-300">Active</label>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.disaster-types.index') }}" class="px-4 py-2 bg-gray-300 rounded-lg">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-indigo-500 text-white rounded-lg">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
