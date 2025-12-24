<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Tehsil
        </h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <form action="{{ route('admin.tehsils.update',$tehsil->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tehsil Name</label>
                    <input type="text" name="name" value="{{ old('name',$tehsil->name) }}"
                           class="mt-1 block w-full border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white">
                    @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">District</label>
                    <select name="district_id"
                            class="mt-1 block w-full border-gray-300 rounded-lg dark:bg-gray-700 dark:text-white">
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ old('district_id',$tehsil->district_id)==$district->id ? 'selected':'' }}>
                                {{ $district->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('district_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center space-x-3">
                    <input type="checkbox" name="is_active" value="1" 
                           {{ old('is_active',$tehsil->is_active) ? 'checked':'' }}
                           class="h-4 w-4 text-gray-700 border-gray-300 rounded">
                    <label class="text-sm text-gray-700 dark:text-gray-300">Active</label>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.tehsils.index') }}"
                       class="px-4 py-2 bg-gray-300 rounded-lg">Cancel</a>

                    <button type="submit"
                            class="px-4 py-2 bg-indigo-500 text-white rounded-lg">
                        Update
                    </button>
                </div>

            </form>
        </div>

    </div>
</x-app-layout>
