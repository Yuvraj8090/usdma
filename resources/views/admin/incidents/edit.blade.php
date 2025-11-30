<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Incident Record
            </h2>
        </div>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between items-center mb-6">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                <i class="fas fa-flag mr-1"></i> Update the incident details
            </div>
            <a href="{{ route('admin.incidents.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-gray-500 to-gray-700 border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest hover:from-gray-600 hover:to-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        @if (session('success'))
            <div
                class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-800 dark:border-green-600 dark:text-green-100">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">

            <form action="{{ route('admin.incidents.update', $incident->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- INCIDENT BASIC INFO -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium mb-1">Incident Type</label>
                        <select name="incident_type_id" class="w-full rounded-md">
                            <option value="">Select Type</option>
                            @foreach($incidentTypes as $type)
                                <option value="{{ $type->id }}" {{ $incident->incident_type_id == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Date</label>
                        <input type="date" name="date" value="{{ $incident->date }}" class="w-full rounded-md">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Time</label>
                        <input type="time" name="time" value="{{ $incident->time }}" class="w-full rounded-md">
                    </div>
                </div>

                <!-- LOCATION -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium mb-1">Address</label>
                        <input type="text" name="address" value="{{ $incident->address }}" class="w-full rounded-md">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">State</label>
                        <input type="text" name="state" value="{{ $incident->state }}" class="w-full rounded-md">
                    </div>
                </div>

                <!-- LOSS TYPE -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-1">Loss Type</label>
                    <select name="loss_type" class="w-full rounded-md">
                        <option value="human" {{ $incident->loss_type == 'human' ? 'selected' : '' }}>Human</option>
                        <option value="animal" {{ $incident->loss_type == 'animal' ? 'selected' : '' }}>Animal</option>
                        <option value="property" {{ $incident->loss_type == 'property' ? 'selected' : '' }}>Property</option>
                    </select>
                </div>

                <!-- HUMAN LOSS SECTION -->
                <div id="human_section" class="{{ $incident->loss_type == 'human' ? '' : 'hidden' }} mb-6">
                    <h3 class="text-lg font-semibold mb-2">Human Loss Details</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Name</label>
                            <input type="text" name="human[name]" value="{{ $incident->human['name'] ?? '' }}" class="w-full rounded-md">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Age</label>
                            <input type="number" name="human[age]" value="{{ $incident->human['age'] ?? '' }}" class="w-full rounded-md">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium mb-1">Loss Reason</label>
                        <textarea name="reason" class="w-full rounded-md">{{ $incident->reason }}</textarea>
                    </div>
                </div>

                <!-- ANIMAL LOSS -->
                <div id="animal_section" class="{{ $incident->loss_type == 'animal' ? '' : 'hidden' }} mb-6">
                    <h3 class="text-lg font-semibold mb-2">Animal Loss</h3>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Big Animals</label>
                            <input type="number" name="animal[big]" value="{{ $incident->animal['big'] ?? '' }}" class="w-full rounded-md">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Small Animals</label>
                            <input type="number" name="animal[small]" value="{{ $incident->animal['small'] ?? '' }}" class="w-full rounded-md">
                        </div>
                    </div>
                </div>

                <!-- PROPERTY LOSS -->
                <div id="property_section" class="{{ $incident->loss_type == 'property' ? '' : 'hidden' }} mb-6">
                    <h3 class="text-lg font-semibold mb-2">Property Loss</h3>

                    <div>
                        <label class="block text-sm font-medium mb-1">Property Type</label>
                        <select name="property_type_id" class="w-full rounded-md">
                            @foreach($propertyTypes as $pt)
                                <option value="{{ $pt->id }}" {{ $incident->property_type_id == $pt->id ? 'selected' : '' }}>
                                    {{ $pt->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- NOMINEE SECTION -->
                <h3 class="text-lg font-semibold mt-6 mb-2">Nominee</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium mb-1">Nominee Name</label>
                        <input type="text" name="nominee[name]" value="{{ $incident->nominee['name'] ?? '' }}" class="w-full rounded-md">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Relation</label>
                        <input type="text" name="nominee[relation]" value="{{ $incident->nominee['relation'] ?? '' }}" class="w-full rounded-md">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Address</label>
                        <input type="text" name="nominee[address]" value="{{ $incident->nominee['address'] ?? '' }}" class="w-full rounded-md">
                    </div>
                </div>

                <!-- COMPENSATION -->
                <h3 class="text-lg font-semibold mt-6 mb-2">Compensation</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium mb-1">Compensation Type</label>
                        <select name="compensation_type" class="w-full rounded-md">
                            <option value="">Select</option>
                            <option value="death" {{ $incident->compensation_type == 'death' ? 'selected' : '' }}>Death</option>
                            <option value="injured" {{ $incident->compensation_type == 'injured' ? 'selected' : '' }}>Injured</option>
                            <option value="missing" {{ $incident->compensation_type == 'missing' ? 'selected' : '' }}>Missing</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Status</label>
                        <input type="text" name="compensation_status" value="{{ $incident->compensation_status }}" class="w-full rounded-md">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Release Date</label>
                        <input type="date" name="compensation_date" value="{{ $incident->compensation_date }}" class="w-full rounded-md">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-1">Amount</label>
                    <input type="number" name="compensation_amount" value="{{ $incident->compensation_amount }}" class="w-full rounded-md">
                </div>

                <!-- SUBMIT BUTTON -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg shadow hover:shadow-xl font-semibold">
                        <i class="fas fa-save mr-1"></i> Update Incident
                    </button>
                </div>

            </form>

        </div>

    </div>

</x-app-layout>
