<div class="mt-10 bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-300 dark:border-gray-700 p-6">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Existing Human Loss Records</h3>

    @if ($humanLosses->count() == 0)
        <p class="text-gray-600 dark:text-gray-400">No records yet.</p>
    @else
        <table class="w-full border-collapse text-left">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                    <th class="p-3 border">Name</th>
                    <th class="p-3 border">Loss Type</th>
                    <th class="p-3 border">Compensation</th>
                    <th class="p-3 border">Nominees</th>
                    <th class="p-3 border">Date</th>
                    <th class="p-3 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($humanLosses as $hl)
                    <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900">
                        <td class="p-3 text-gray-800 dark:text-gray-200">{{ $hl->name }}</td>
                        <td class="p-3">{{ ucwords(str_replace('_', ' ', $hl->loss_type)) }}</td>

                        <td class="p-3">
                            {{ $hl->compensation_amount ?? '—' }}
                            <br>
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $hl->compensation_status }}</span>
                        </td>
                        <td class="p-3">
                            @if (is_array($hl->nominee) && count($hl->nominee) > 0)
                                @foreach ($hl->nominee as $n)
                                    <div class="text-sm">
                                        <strong>{{ $n['name'] }}</strong> ({{ $n['relation'] }})
                                        <br><span class="text-gray-500 dark:text-gray-400">{{ $n['number'] }}</span>
                                    </div>
                                @endforeach
                            @else
                                —
                            @endif
                        </td>

                        <td class="p-3">{{ $hl->created_at->format('d M Y') }}</td>
                        <td class="p-3">
                            <button data-id="{{ $hl->id }}" data-name="{{ $hl->name }}"
                                data-age="{{ $hl->age }}" data-sex="{{ $hl->sex }}"
                                data-loss_type="{{ $hl->loss_type }}" data-address="{{ $hl->address }}"
                                data-state="{{ $hl->state }}" data-district="{{ $hl->district }}"
                                data-compensation_amount="{{ $hl->compensation_amount }}"
                                data-compensation_received_date="{{ $hl->compensation_received_date }}"
                                data-compensation_status="{{ $hl->compensation_status }}"
                                data-nominee='@json($hl->nominee)'
                                class="edit-btn px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                Edit
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl w-11/12 md:w-3/4 lg:w-2/3 max-h-[75vh] flex flex-col overflow-hidden shadow-lg">

        <!-- Modal Header -->
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Human Loss</h2>
            <button id="closeModal" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-200">
                <i class="fa-solid fa-xmark text-2xl"></i>
            </button>
        </div>

        <!-- Modal Body (Scrollable) -->
        <div class="p-6 overflow-y-auto flex-1 space-y-4 scrollbar-thin scrollbar-thumb-gray-400 dark:scrollbar-thumb-gray-600 scrollbar-track-gray-100 dark:scrollbar-track-gray-700">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="input-custom" id="edit_name" required>
                    </div>
                    <div>
                        <label class="form-label">Age</label>
                        <input type="number" name="age" class="input-custom" id="edit_age">
                    </div>
                    <div>
                        <label class="form-label">Sex</label>
                        <select name="sex" class="input-custom" id="edit_sex">
                            <option value="">Select</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Loss Type</label>
                        <select name="loss_type" class="input-custom" id="edit_loss_type" required>
                            <option value="">Select</option>
                            <option value="died">Died</option>
                            <option value="missing">Missing</option>
                            <option value="normal_damage">Normal Damage</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="form-label">Address</label>
                        <textarea name="address" rows="2" class="input-custom" id="edit_address"></textarea>
                    </div>
                    <div>
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="input-custom" id="edit_state">
                    </div>
                    <div>
                        <label class="form-label">District</label>
                        <input type="text" name="district" class="input-custom" id="edit_district">
                    </div>
                    <div>
                        <label class="form-label">Compensation Amount</label>
                        <input type="number" name="compensation_amount" class="input-custom" id="edit_compensation_amount">
                    </div>
                    <div>
                        <label class="form-label">Compensation Date</label>
                        <input type="date" name="compensation_received_date" class="input-custom" id="edit_compensation_received_date">
                    </div>
                    <div>
                        <label class="form-label">Compensation Status</label>
                        <select name="compensation_status" class="input-custom" id="edit_compensation_status">
                            <option value="">Select</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6" id="editNomineeContainer"></div>
            </form>
        </div>

        <!-- Modal Footer (Fixed) -->
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3 bg-white dark:bg-gray-800">
            <button type="button" id="closeModalBtn" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancel</button>
            <button type="submit" form="editForm" class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700">Update</button>
        </div>
    </div>
</div>


<script>
    const editModal = document.getElementById('editModal');
    const closeModal = document.getElementById('closeModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const editForm = document.getElementById('editForm');
    const editNomineeContainer = document.getElementById('editNomineeContainer');

    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            editForm.action = '/admin/human-loss/' + id; // Update route
            document.getElementById('edit_name').value = this.dataset.name;
            document.getElementById('edit_age').value = this.dataset.age;
            document.getElementById('edit_sex').value = this.dataset.sex;
            document.getElementById('edit_loss_type').value = this.dataset.loss_type;
            document.getElementById('edit_address').value = this.dataset.address;
            document.getElementById('edit_state').value = this.dataset.state;
            document.getElementById('edit_district').value = this.dataset.district;
            document.getElementById('edit_compensation_amount').value = this.dataset
                .compensation_amount;
            document.getElementById('edit_compensation_received_date').value = this.dataset
                .compensation_received_date;
            document.getElementById('edit_compensation_status').value = this.dataset
                .compensation_status;

            // Render nominees dynamically in edit modal
            const nominees = JSON.parse(this.dataset.nominee);
            editNomineeContainer.innerHTML = '';
            nominees.forEach((n, i) => {
                fetch(
                        `{{ route('admin.human_loss.nominee_row') }}?i=${i}&nominee=${encodeURIComponent(JSON.stringify(n))}`
                        )
                    .then(res => res.text())
                    .then(html => editNomineeContainer.insertAdjacentHTML('beforeend', html));
            });


            editModal.classList.remove('hidden');
        });
    });

    closeModal.addEventListener('click', () => editModal.classList.add('hidden'));
    closeModalBtn.addEventListener('click', () => editModal.classList.add('hidden'));
</script>
