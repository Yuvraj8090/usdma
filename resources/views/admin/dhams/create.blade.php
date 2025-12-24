<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($dham) ? 'Edit Dham' : 'Create Dham' }}
        </h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">

            <form action="{{ isset($dham) ? route('admin.dhams.update', $dham->id) : route('admin.dhams.store') }}" 
                  method="POST">
                @csrf
                @if(isset($dham))
                    @method('PUT')
                @endif

                {{-- Name --}}
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300" for="name">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $dham->name ?? '') }}"
                           class="w-full mt-1 px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" required>
                    @error('name') 
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                    @enderror
                </div>

                {{-- State --}}
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300" for="state_id">State</label>
                    <select name="state_id" id="state_id" 
                            class="w-full mt-1 px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" required>
                        <option value="">-- Select State --</option>
                        @foreach($states as $state)
                            <option value="{{ $state->id }}" 
                                {{ old('state_id', $dham->state_id ?? '') == $state->id ? 'selected' : '' }}>
                                {{ $state->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('state_id') 
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                    @enderror
                </div>

                {{-- District --}}
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300" for="district_id">District</label>
                    <select name="district_id" id="district_id" 
                            class="w-full mt-1 px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" required>
                        <option value="">-- Select District --</option>
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" 
                                {{ old('district_id', $dham->district_id ?? '') == $district->id ? 'selected' : '' }}>
                                {{ $district->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('district_id') 
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                    @enderror
                </div>

                {{-- Coordinates and Height --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300" for="latitude">Latitude</label>
                        <input type="text" name="latitude" id="latitude" value="{{ old('latitude', $dham->latitude ?? '') }}"
                               class="w-full mt-1 px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                        @error('latitude') 
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300" for="longitude">Longitude</label>
                        <input type="text" name="longitude" id="longitude" value="{{ old('longitude', $dham->longitude ?? '') }}"
                               class="w-full mt-1 px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                        @error('longitude') 
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300" for="height">Height</label>
                        <input type="number" name="height" id="height" value="{{ old('height', $dham->height ?? '') }}"
                               class="w-full mt-1 px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                        @error('height') 
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                        @enderror
                    </div>
                </div>

                {{-- Checkboxes --}}
                <div class="mt-4 flex space-x-4 mb-4">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $dham->is_active ?? false) ? 'checked' : '' }}>
                        <span class="text-gray-700 dark:text-gray-300">Active</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="is_winter" value="1" {{ old('is_winter', $dham->is_winter ?? false) ? 'checked' : '' }}>
                        <span class="text-gray-700 dark:text-gray-300">Winter</span>
                    </label>
                </div>

                {{-- Submit --}}
                <div class="mt-6">
                    <button type="submit"
                            class="px-6 py-2 bg-gray-700 text-white rounded-lg shadow hover:from-indigo-600 hover:to-purple-700">
                        {{ isset($dham) ? 'Update' : 'Save' }}
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
