<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Tourist Visitor Detail
        </h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <form action="{{ route('admin.tourist-visitor-details.update', $visitorDetail->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="location_id" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Select Dham</label>
                        <select name="location_id" id="location_id" class="form-select w-full rounded">
                            @foreach($dhams as $dham)
                                <option value="{{ $dham->id }}" {{ $visitorDetail->location_id == $dham->id ? 'selected' : '' }}>
                                    {{ $dham->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="date" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Date</label>
                        <input type="date" name="date" class="form-input w-full rounded"
                               value="{{ $visitorDetail->date->format('Y-m-d') }}">
                    </div>

                    <div>
                        <label for="no_of_pilgrims" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">No. of Pilgrims</label>
                        <input type="number" name="no_of_pilgrims" class="form-input w-full rounded"
                               value="{{ $visitorDetail->no_of_pilgrims }}">
                    </div>

                    <div>
                        <label for="no_of_vehicles" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">No. of Vehicles</label>
                        <input type="number" name="no_of_vehicles" class="form-input w-full rounded"
                               value="{{ $visitorDetail->no_of_vehicles }}">
                    </div>

                    <div>
                        <label for="dead_today" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Dead Today</label>
                        <input type="number" name="dead_today" class="form-input w-full rounded"
                               value="{{ $visitorDetail->dead_today }}">
                    </div>

                    <div>
                        <label for="missing_today" class="block font-medium text-gray-700 dark:text-gray-300 mb-1">Missing Today</label>
                        <input type="number" name="missing_today" class="form-input w-full rounded"
                               value="{{ $visitorDetail->missing_today }}">
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-2">
                    <a href="{{ route('admin.tourist-visitor-details.index') }}"
                       class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded shadow">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded shadow hover:from-yellow-600 hover:to-yellow-700">
                        <i class="fas fa-save mr-1"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
