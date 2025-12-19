<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Incident
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-6 border border-gray-300 dark:border-gray-700">

                <h3 class="text-lg font-bold mb-6 bg-gradient-to-r from-blue-500 to-purple-500 text-white px-4 py-2 rounded-lg inline-block">
                    Incident Details
                </h3>

                <form action="{{ route('admin.incidents.update', $incident->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Incident Name --}}
                        <div>
                            <label class="block mb-1 font-semibold dark:text-gray-200">Incident Name</label>
                            <input type="text" name="incident_name"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200"
                                value="{{ $incident->incident_name }}" required>
                        </div>

                        {{-- Incident Type --}}
                        <div>
                            <label class="block mb-1 font-semibold dark:text-gray-200">Incident Type</label>
                            <select name="incident_type_id"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200">

                                @foreach($incidentTypes as $type)
                                    <option value="{{ $type->id }}"
                                        {{ $incident->incident_type_id == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        {{-- State --}}
                        <div>
                            <label class="block mb-1 font-semibold dark:text-gray-200">State</label>
                            <input type="text" name="state"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200"
                                value="{{ $incident->state }}" required>
                        </div>

                        {{-- District --}}
                        <div>
                            <label class="block mb-1 font-semibold dark:text-gray-200">District</label>
                            <input type="text" name="district"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200"
                                value="{{ $incident->district }}" required>
                        </div>

                        {{-- Village --}}
                        <div>
                            <label class="block mb-1 font-semibold dark:text-gray-200">Village</label>
                            <input type="text" name="village"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200"
                                value="{{ $incident->village }}" required>
                        </div>

                        {{-- Latitude --}}
                        <div>
                            <label class="block mb-1 font-semibold dark:text-gray-200">Latitude</label>
                            <input type="text" name="latitude"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200"
                                value="{{ $incident->latitude }}" required>
                        </div>

                        {{-- Longitude --}}
                        <div>
                            <label class="block mb-1 font-semibold dark:text-gray-200">Longitude</label>
                            <input type="text" name="longitude"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200"
                                value="{{ $incident->longitude }}" required>
                        </div>

                        {{-- Date --}}
                        <div>
                            <label class="block mb-1 font-semibold dark:text-gray-200">Incident Date</label>
                            <input type="date" name="incident_date"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200"
                                value="{{ $incident->incident_date }}" required>
                        </div>

                        {{-- Time --}}
                        <div>
                            <label class="block mb-1 font-semibold dark:text-gray-200">Incident Time</label>
                            <input type="time" name="incident_time"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200"
                                value="{{ $incident->incident_time }}" required>
                        </div>

                        {{-- Big Animals --}}
                        <div>
                            <label class="block mb-1 font-semibold dark:text-gray-200">Big Animals Died</label>
                            <input type="number" name="big_animals_died"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200"
                                value="{{ $incident->big_animals_died }}" required>
                        </div>

                        {{-- Small Animals --}}
                        <div>
                            <label class="block mb-1 font-semibold dark:text-gray-200">Small Animals Died</label>
                            <input type="number" name="small_animals_died"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200"
                                value="{{ $incident->small_animals_died }}" required>
                        </div>

                    </div>

                    <div class="mt-8 text-right">
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700 transition">
                            Update Incident
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
