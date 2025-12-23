 <form action="{{ route('admin.human_loss.store', $incidentId) }}" method="POST">
                @csrf

                {{-- Human Loss Fields --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="input-custom" value="{{ old('name') }}" required>
                    </div>
                    <div>
                        <label class="form-label">Age</label>
                        <input type="number" name="age" class="input-custom" value="{{ old('age') }}">
                    </div>
                    <div>
                        <label class="form-label">Sex</label>
                        <select name="sex" class="input-custom">
                            <option value="">Select</option>
                            <option value="male" {{ old('sex')=='male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('sex')=='female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('sex')=='other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Loss Type</label>
                        <select name="loss_type" id="lossType" class="input-custom" required>
                            <option value="">Select</option>
                            <option value="died" {{ old('loss_type')=='died' ? 'selected' : '' }}>Died</option>
                            <option value="missing" {{ old('loss_type')=='missing' ? 'selected' : '' }}>Missing</option>
                            <option value="normal_damage" {{ old('loss_type')=='normal_damage' ? 'selected' : '' }}>Normal Damage</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="form-label">Address</label>
                        <textarea name="address" rows="2" class="input-custom">{{ old('address') }}</textarea>
                    </div>

                    <div>
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="input-custom" value="{{ old('state') }}">
                    </div>
                    <div>
                        <label class="form-label">District</label>
                        <input type="text" name="district" class="input-custom" value="{{ old('district') }}">
                    </div>
                    <div>
                        <label class="form-label">Compensation Amount</label>
                        <input type="number" name="compensation_amount" class="input-custom" value="{{ old('compensation_amount') }}">
                    </div>
                    <div>
                        <label class="form-label">Compensation Date</label>
                        <input type="date" name="compensation_received_date" class="input-custom" value="{{ old('compensation_received_date') }}">
                    </div>
                    <div>
                        <label class="form-label">Compensation Status</label>
                        <select name="compensation_status" class="input-custom">
                            <option value="">Select</option>
                            <option value="pending" {{ old('compensation_status')=='pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ old('compensation_status')=='approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ old('compensation_status')=='rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                </div>

                {{-- Nominees Section --}}
                <div class="mt-8">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Nominees</h3>
                        <button type="button" id="addNomineeRow" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            + Add Nominee
                        </button>
                    </div>

                    <div id="nominee-container" class="space-y-4">
                        @php
                            $oldNominees = old('nominees', [['name'=>'','relation'=>'','age'=>'','number'=>'','address'=>'']]);
                        @endphp
                        @foreach($oldNominees as $i => $nominee)
                            @include('admin.human_loss.partials.nominee-row', ['i'=>$i, 'nominee'=>$nominee])
                        @endforeach
                    </div>
                </div>

                {{-- Submit --}}
                <div class="mt-6">
                    <button type="submit" class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Submit
                    </button>
                </div>
            </form>
            <script>
        let nomineeIndex = {{ count($oldNominees) }};

        const lossTypeSelect = document.getElementById('lossType');

        document.getElementById('addNomineeRow').addEventListener('click', function() {
            fetch("{{ route('admin.human_loss.nominee_row') }}?i=" + nomineeIndex)
                .then(res => res.text())
                .then(html => {
                    const container = document.getElementById('nominee-container');
                    container.insertAdjacentHTML('beforeend', html);

                    // If loss type is 'died', make nominee fields required
                    const isDied = lossTypeSelect.value === 'died';
                    container.querySelectorAll('.nominee-box:last-child .nominee-field').forEach(input => {
                        if (isDied) input.setAttribute('required', 'required');
                    });
                });

            nomineeIndex++;
        });

        // Remove nominee
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-nominee')) {
                e.target.closest('.nominee-box').remove();
            }
        });

        // Toggle nominee required based on loss type
        lossTypeSelect.addEventListener('change', function() {
            const isDied = this.value === 'died';
            document.querySelectorAll('.nominee-box .nominee-field').forEach(input => {
                if (isDied) input.setAttribute('required', 'required');
                else input.removeAttribute('required');
            });
        });
    </script>