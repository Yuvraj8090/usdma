<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit District Assignment
        </h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <form action="{{ route('admin.district-users.update', $districtUser->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="district_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Select District
                    </label>
                    <select name="district_id" id="district_id"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}"
                                {{ $districtUser->district_id == $district->id ? 'selected' : '' }}>
                                {{ $district->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Select Users (Multiple)
                    </label>
                    <select name="user_id[]" id="user_id" multiple
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ in_array($user->id, old('user_id', $assignedUserIds)) ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('admin.district-users.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Cancel</a>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
