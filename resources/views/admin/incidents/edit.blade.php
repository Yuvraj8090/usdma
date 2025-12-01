<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Incident
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3
                    class="text-lg font-bold mb-4 bg-gradient-to-r from-blue-500 to-purple-500 text-white px-3 py-2 rounded-md inline-block">
                    Incident Details
                </h3>

                <form action="{{ route('admin.incidents.update', $incident->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1 font-semibold">Incident Name</label>
                            <input type="text" name="incident_name" class="w-full rounded-md"
                                value="{{ $incident->incident_name }}" required>
                        </div>

                        <div>
                            <label class="block mb-1 font-semibold">Location Details</label>
                            <input type="text" name="location_details" class="w-full rounded-md"
                                value="{{ $incident->location_details }}" required>
                        </div>

                        <div>
                            <label class="block mb-1 font-semibold">State</label>
                            <input type="text" name="state" class="w-full rounded-md"
                                value="{{ $incident->state }}" required>
                        </div>

                        <div>
                            <label class="block mb-1 font-semibold">District</label>
                            <input type="text" name="district" class="w-full rounded-md"
                                value="{{ $incident->district }}" required>
                        </div>

                        <div>
                            <label class="block mb-1 font-semibold">Village</label>
                            <input type="text" name="village" class="w-full rounded-md"
                                value="{{ $incident->village }}" required>
                        </div>

                        <div>
                            <label class="block mb-1 font-semibold">Latitude</label>
                            <input type="text" name="lat" class="w-full rounded-md" value="{{ $incident->lat }}"
                                required>
                        </div>

                        <div>
                            <label class="block mb-1 font-semibold">Longitude</label>
                            <input type="text" name="lng" class="w-full rounded-md"
                                value="{{ $incident->lng }}" required>
                        </div>

                        <div>
                            <label class="block mb-1 font-semibold">Incident Date</label>
                            <input type="date" name="incident_date" class="w-full rounded-md"
                                value="{{ $incident->incident_date }}" required>
                        </div>

                        <div>
                            <label class="block mb-1 font-semibold">Incident Time</label>
                            <input type="time" name="incident_time" class="w-full rounded-md"
                                value="{{ $incident->incident_time }}" required>
                        </div>

                        <div>
                            <label class="block mb-1 font-semibold">Big Animal Died</label>
                            <input type="number" name="big_animal_died" class="w-full rounded-md"
                                value="{{ $incident->big_animal_died }}" required>
                        </div>

                        <div>
                            <label class="block mb-1 font-semibold">Small Animal Died</label>
                            <input type="number" name="small_animal_died" class="w-full rounded-md"
                                value="{{ $incident->small_animal_died }}" required>
                        </div>
                    </div>

                    <hr class="my-6 border-gray-300">

                    <h3
                        class="text-lg font-bold mb-4 bg-gradient-to-r from-green-500 to-emerald-500 text-white px-3 py-2 rounded-md inline-block">
                        Human Loss Records (Dynamic Component)
                    </h3>

<x-human-loss.table :incident="$incident"/>
                    <div class="mt-6 text-right">
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700">Update
                            Incident</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
