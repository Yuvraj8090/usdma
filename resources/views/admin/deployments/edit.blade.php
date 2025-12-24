<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Deployment</h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <form action="{{ route('admin.deployments.update', $deployment) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200">Deployable Type & Resource</label>
                    <select name="deployable_type_id" class="w-full border rounded px-3 py-2">
                        <optgroup label="Manpower">
                            @foreach($manpowers as $manpower)
                                <option value="App\Models\Manpower:{{ $manpower->id }}" 
                                    {{ $deployment->deployable_type == 'App\Models\Manpower' && $deployment->deployable_id == $manpower->id ? 'selected' : '' }}>
                                    {{ $manpower->category }} (Manpower)
                                </option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Relief Materials">
                            @foreach($reliefMaterials as $item)
                                <option value="App\Models\ReliefMaterial:{{ $item->id }}" 
                                    {{ $deployment->deployable_type == 'App\Models\ReliefMaterial' && $deployment->deployable_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->item_name }} (Relief)
                                </option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200">District</label>
                    <select name="district_id" class="w-full border rounded px-3 py-2">
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ $deployment->district_id == $district->id ? 'selected' : '' }}>
                                {{ $district->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200">Location</label>
                    <input type="text" name="location" value="{{ $deployment->location }}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200">Deployed At</label>
                    <input type="datetime-local" name="deployed_at" value="{{ $deployment->deployed_at?->format('Y-m-d\TH:i') }}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200">Returned At</label>
                    <input type="datetime-local" name="returned_at" value="{{ $deployment->returned_at?->format('Y-m-d\TH:i') }}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200">Remarks</label>
                    <textarea name="remarks" class="w-full border rounded px-3 py-2" rows="3">{{ $deployment->remarks }}</textarea>
                </div>

                <button type="submit" class="px-4 py-2 bg-indigo-500 text-white rounded shadow hover:bg-gray-700">Update Deployment</button>
            </form>
        </div>
    </div>
</x-app-layout>
