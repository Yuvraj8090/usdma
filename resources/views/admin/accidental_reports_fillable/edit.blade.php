<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Accidental Report Category
        </h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <form action="{{ route('admin.accidental-reports-fillable.update', $accidentalReportsFillable->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Name</label>
                    <input type="text" name="name" value="{{ old('name', $accidentalReportsFillable->name) }}"
                           class="w-full rounded-lg border px-3 py-2 dark:bg-gray-900 dark:text-white"
                           placeholder="Enter category name" required>
                    @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Description</label>
                    <textarea name="description" rows="3"
                              class="w-full rounded-lg border px-3 py-2 dark:bg-gray-900 dark:text-white">{{ old('description', $accidentalReportsFillable->description) }}</textarea>
                </div>

                <!-- Parent -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Parent</label>
                    <select name="parent_id" class="w-full rounded-lg border px-3 py-2 dark:bg-gray-900 dark:text-white">
                        <option value="">None</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}"
                                {{ old('parent_id', $accidentalReportsFillable->parent_id) == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div class="mb-6">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $accidentalReportsFillable->is_active) ? 'checked' : '' }}
                               class="rounded border-gray-300 dark:border-gray-700">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Active</span>
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.accidental-reports-fillable.index') }}"
                       class="px-4 py-2 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-gray-700 text-white rounded-lg shadow hover:from-indigo-600 hover:to-purple-600">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
