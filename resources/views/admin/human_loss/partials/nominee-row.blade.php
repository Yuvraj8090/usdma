<div class="nominee-box bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 p-4 rounded-lg shadow">
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div>
            <label class="form-label">Name</label>
            <input type="text" name="nominees[{{ $i }}][name]" class="input-custom nominee-field" value="{{ $nominee['name'] ?? '' }}">
        </div>
        <div>
            <label class="form-label">Relation</label>
            <select name="nominees[{{ $i }}][relation]" class="input-custom nominee-field">
                <option value="">Select Relation</option>
                @foreach(['Child','Spouse','Parent','Sibling','Relative','Guardian','Other'] as $relation)
                    <option value="{{ $relation }}" {{ ($nominee['relation'] ?? '') == $relation ? 'selected' : '' }}>{{ $relation }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="form-label">Age</label>
            <input type="number" name="nominees[{{ $i }}][age]" class="input-custom nominee-field" value="{{ $nominee['age'] ?? '' }}">
        </div>
        <div>
            <label class="form-label">Phone</label>
            <input type="text" name="nominees[{{ $i }}][number]" class="input-custom nominee-field" value="{{ $nominee['number'] ?? '' }}">
        </div>
        <div>
            <label class="form-label">Address</label>
            <input type="text" name="nominees[{{ $i }}][address]" class="input-custom nominee-field" value="{{ $nominee['address'] ?? '' }}">
        </div>
    </div>
    <button type="button" class="remove-nominee mt-4 px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700">
        Remove Nominee
    </button>
</div>
