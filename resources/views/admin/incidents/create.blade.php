<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Create Incident
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-6 border border-gray-200 dark:border-gray-700">

                <form action="{{ route('admin.incidents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- INCIDENT DETAILS --}}
                    <h3 class="section-title">Incident Details</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="label">Incident Name</label>
                            <input type="text" name="incident_name" class="input" required>
                        </div>

                        <div>
                            <label class="label">Incident Type</label>
                            <select name="incident_type_id" class="input" required>
                                <option value="">Select Incident Type</option>
                                @foreach ($incidentTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="label">Incident Date</label>
                            <input type="date" name="incident_date" class="input" required>
                        </div>

                        <div>
                            <label class="label">Incident Time</label>
                            <input type="time" name="incident_time" class="input" required>
                        </div>
                    </div>

                    {{-- LOCATION DETAILS --}}
                    {{-- LOCATION DETAILS --}}
<h3 class="section-title mt-6">Location Details</h3>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    {{-- STATE --}}
    <div>
        <label class="label">State</label>
        <select id="state_id" class="input" required>
            <option value="">Select State</option>
            @foreach($states as $state)
                <option value="{{ $state->id }}">{{ $state->name }}</option>
            @endforeach
        </select>

        {{-- hidden field to store state name --}}
        <input type="hidden" name="state" id="state_name">
    </div>

    {{-- DISTRICT --}}
    <div>
        <label class="label">District</label>
        <select id="district_id" class="input" required disabled>
            <option value="">Select District</option>
        </select>

        {{-- hidden field to store district name --}}
        <input type="hidden" name="district" id="district_name">
    </div>

    <input type="text" name="village" placeholder="Village" class="input">
    <input type="text" name="latitude" placeholder="Latitude" class="input">
    <input type="text" name="longitude" placeholder="Longitude" class="input">
</div>
<script>
document.getElementById('state_id').addEventListener('change', function () {
    const stateId = this.value;
    const stateName = this.options[this.selectedIndex].text;

    document.getElementById('state_name').value = stateName;

    const districtSelect = document.getElementById('district_id');
    districtSelect.innerHTML = '<option value="">Loading...</option>';
    districtSelect.disabled = true;

    if (!stateId) return;

    fetch(`/admin/get-districts/${stateId}`)
        .then(res => res.json())
        .then(data => {
            districtSelect.innerHTML = '<option value="">Select District</option>';
            data.forEach(d => {
                districtSelect.innerHTML += `<option value="${d.id}">${d.name}</option>`;
            });
            districtSelect.disabled = false;
        });
});

document.getElementById('district_id').addEventListener('change', function () {
    const districtName = this.options[this.selectedIndex].text;
    document.getElementById('district_name').value = districtName;
});
</script>


                    {{-- ANIMAL LOSS --}}
                    <h3 class="section-title mt-6">Animal Loss</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="number" min="0" name="big_animals_died" placeholder="Big Animals Died"
                            class="input">
                        <input type="number" min="0" name="small_animals_died" placeholder="Small Animals Died"
                            class="input">
                        <input type="number" min="0" name="hen_count" placeholder="Hen Count" class="input">
                        <input type="number" min="0" name="other_animal_count" placeholder="Other Animal Count"
                            class="input">
                    </div>

                    {{-- HOUSE DAMAGE --}}
                    <h3 class="section-title mt-6">House Damage</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="number" min="0" name="partially_house"
                            placeholder="Partially Damaged Houses" class="input">
                        <input type="number" min="0" name="severely_house" placeholder="Severely Damaged Houses"
                            class="input">
                        <input type="number" min="0" name="fully_house" placeholder="Fully Damaged Houses"
                            class="input">
                        <input type="number" min="0" name="cowshed_house" placeholder="Cowshed Damage"
                            class="input">
                        <input type="number" min="0" name="hut_count" placeholder="Hut Count" class="input">
                    </div>

                    {{-- AGRICULTURE & INFRASTRUCTURE --}}
                    <h3 class="section-title mt-6">Agriculture & Infrastructure</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="number" step="0.01" name="agriculture_land_loss_hectare"
                            placeholder="Agriculture Land Loss (Hectare)" class="input">

                        <input type="number" min="0" name="helicopter_sorties"
                            placeholder="Helicopter Sorties" class="input">


                    </div>
                    {{-- INFRASTRUCTURE DAMAGE COUNTS --}}
                    <h3 class="section-title mt-6">Infrastructure Damage (Count)</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="number" min="0" name="electricity_line_damage"
                            placeholder="Electricity Line Damage Count" class="input">

                        <input type="number" min="0" name="water_pipeline_damage"
                            placeholder="Water Pipeline Damage Count" class="input">

                        <input type="number" min="0" name="road_damage" placeholder="Road Damage Count"
                            class="input">
                    </div>

                    {{-- REHABILITATION --}}
                    <h3 class="section-title mt-6">Rehabilitation (Punha Sthapanna)</h3>

                    <textarea name="punha_sthapanna_road" rows="3" placeholder="Rehabilitation details" class="input w-full"></textarea>

                    {{-- FILE UPLOAD --}}
                    <h3 class="section-title mt-6">Upload Document</h3>

                    <input type="file" name="file" class="input w-full">

                    {{-- SUBMIT --}}
                    <div class="mt-6 text-right">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Save Incident
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- SIMPLE UTIL CLASSES --}}

</x-app-layout>
