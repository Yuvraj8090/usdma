<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                Create Incident
            </h2>
        </div>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-300 dark:border-gray-700">

            <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-t-xl">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-plus-circle mr-2"></i> Add New Incident
                </h3>
            </div>

            <form action="{{ route('admin.incidents.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- INCIDENT TYPE -->
                <div>
                    <label class="text-gray-700 dark:text-gray-300 font-medium">Incident Type</label>
                    <select name="incident_type" id="incident_type"
                        class="w-full mt-1 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                        onchange="toggleTypeSections()">
                        <option value="">Select Type</option>
                        <option value="human">Human Loss</option>
                        <option value="animal">Animal Loss</option>
                        <option value="property">Property Loss</option>
                    </select>
                </div>

                <!-- BASIC INFORMATION -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-gray-700 dark:text-gray-300">Name</label>
                        <input type="text" name="name"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    </div>

                    <div>
                        <label class="text-gray-700 dark:text-gray-300">Gender</label>
                        <select name="gender"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-gray-700 dark:text-gray-300">Age</label>
                        <input type="number" name="age"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    </div>

                    <div>
                        <label class="text-gray-700 dark:text-gray-300">State</label>
                        <input type="text" name="state"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    </div>

                    <div>
                        <label class="text-gray-700 dark:text-gray-300">Date</label>
                        <input type="date" name="date"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    </div>

                    <div>
                        <label class="text-gray-700 dark:text-gray-300">Time</label>
                        <input type="time" name="time"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    </div>
                </div>

                <div>
                    <label class="text-gray-700 dark:text-gray-300">Address</label>
                    <textarea name="address" rows="2"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white"></textarea>
                </div>

                <div>
                    <label class="text-gray-700 dark:text-gray-300">Reason / Description</label>
                    <textarea name="reason" rows="2"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white"></textarea>
                </div>

                <!-- HUMAN LOSS (NOMINEE) -->
                <div id="human_section" class="hidden space-y-4">
                    <h3 class="text-lg font-semibold text-indigo-600 dark:text-indigo-400">Nominee Details</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-gray-700 dark:text-gray-300">Nominee Name</label>
                            <input type="text" name="nominee_name"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        </div>

                        <div>
                            <label class="text-gray-700 dark:text-gray-300">Relation</label>
                            <input type="text" name="nominee_relation"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        </div>
                    </div>

                    <div>
                        <label class="text-gray-700 dark:text-gray-300">Nominee Address</label>
                        <textarea name="nominee_address" rows="2"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white"></textarea>
                    </div>
                </div>

                <!-- ANIMAL LOSS -->
                <div id="animal_section" class="hidden space-y-4">
                    <h3 class="text-lg font-semibold text-indigo-600 dark:text-indigo-400">Animal Loss</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-gray-700 dark:text-gray-300">Big Animals</label>
                            <input type="number" name="big_animals"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        </div>

                        <div>
                            <label class="text-gray-700 dark:text-gray-300">Small Animals</label>
                            <input type="number" name="small_animals"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        </div>
                    </div>
                </div>

                <!-- PROPERTY LOSS -->
                <div id="property_section" class="hidden space-y-4">
                    <h3 class="text-lg font-semibold text-indigo-600 dark:text-indigo-400">Property Loss</h3>

                    <div>
                        <label class="text-gray-700 dark:text-gray-300">Property Type</label>
                        <select name="property_type_id"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            @foreach ($propertyTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-gray-700 dark:text-gray-300">Loss Type</label>
                        <input type="text" name="loss_type"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    </div>

                    <div>
                        <label class="text-gray-700 dark:text-gray-300">Description</label>
                        <textarea name="description" rows="2"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white"></textarea>
                    </div>
                </div>

                <!-- COMPENSATION -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-indigo-600 dark:text-indigo-400">Compensation</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-gray-700 dark:text-gray-300">Compensation Type</label>
                            <select name="compensation_type"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                <option value="">Select</option>
                                <option value="death">Death</option>
                                <option value="injured">Injured</option>
                                <option value="property_loss">Property Loss</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-gray-700 dark:text-gray-300">Status</label>
                            <select name="status"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="released">Released</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-gray-700 dark:text-gray-300">Release Date</label>
                            <input type="date" name="release_date"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        </div>

                        <div>
                            <label class="text-gray-700 dark:text-gray-300">Amount</label>
                            <input type="number" name="amount"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        </div>
                    </div>
                </div>

                <!-- SUBMIT -->
                <div class="pt-4">
                    <button
                        class="px-6 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg text-white font-semibold shadow hover:shadow-xl transition">
                        Save Incident
                    </button>

                    <a href="{{ route('admin.incidents.index') }}"
                        class="ml-3 px-6 py-2 bg-gray-300 dark:bg-gray-700 rounded-lg text-gray-800 dark:text-gray-200">
                        Cancel
                    </a>
                </div>

            </form>
        </div>

    </div>

    <script>
        function toggleTypeSections() {
            let t = document.getElementById('incident_type').value;

            document.getElementById('human_section').classList.add('hidden');
            document.getElementById('animal_section').classList.add('hidden');
            document.getElementById('property_section').classList.add('hidden');

            if (t === 'human') document.getElementById('human_section').classList.remove('hidden');
            if (t === 'animal') document.getElementById('animal_section').classList.remove('hidden');
            if (t === 'property') document.getElementById('property_section').classList.remove('hidden');
        }
    </script>
</x-app-layout>
