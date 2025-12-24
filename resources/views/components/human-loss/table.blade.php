@props(['incident' => null])

@php
    $existingRows = [];

    if ($incident && $incident->humanLosses->count() > 0) {
        foreach ($incident->humanLosses as $loss) {
            $existingRows[] = [
                'name'        => $loss->name,
                'age'         => $loss->age,
                'sex'         => $loss->sex,
                'loss_type'   => $loss->loss_type,
                'address'     => $loss->address,
                'state'       => $loss->state,
                'district'    => $loss->district,
                'compensation_amount'        => $loss->compensation_amount,
                'compensation_received_date' => $loss->compensation_received_date,
                'compensation_status'        => $loss->compensation_status,
                'nominee_name'               => $loss->nominee['name'] ?? '',
                'nominee_relation'           => $loss->nominee['relation'] ?? '',
                'nominee_age'                => $loss->nominee['age'] ?? '',
                'nominee_address'            => $loss->nominee['address'] ?? '',
                'nominee_number'             => $loss->nominee['number'] ?? '',
            ];
        }
    }
@endphp

<div 
x-data="{
    rows: {{ json_encode($existingRows ?: [[]]) }},
    blankRow: {
        name: '',
        age: '',
        sex: '',
        loss_type: '',
        address: '',
        state: '',
        district: '',
        compensation_amount: '',
        compensation_received_date: '',
        compensation_status: '',
        nominee_name: '',
        nominee_relation: '',
        nominee_age: '',
        nominee_address: '',
        nominee_number: ''
    },
    addRow(){
        this.rows.push(JSON.parse(JSON.stringify(this.blankRow)));
    },
    removeRow(i){
        this.rows.splice(i,1);
    }
}"
>
    
    <!-- TITLE -->
    <h3 class="text-lg font-bold bg-gradient-to-r from-green-500 to-teal-500 text-white px-4 py-2 rounded-md inline-block mt-4 shadow">
        Human Loss Records
    </h3>

    <template x-for="(row, index) in rows" :key="index">
        <div class="mt-5 p-4 bg-white dark:bg-gray-900 border rounded-xl shadow-lg">
            
            <!-- ROW HEADER -->
            <div class="flex justify-between items-center mb-3">
                <p class="font-semibold text-gray-700 dark:text-gray-200">
                    Record #<span x-text="index + 1"></span>
                </p>

                <button 
                    type="button" 
                    @click="removeRow(index)" 
                    x-show="rows.length > 1"
                    class="text-red-600 font-bold px-3 py-1 rounded hover:bg-red-200 dark:hover:bg-red-800">
                    Remove
                </button>
            </div>

            <!-- GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="font-semibold">Name</label>
                    <input type="text" class="input w-full" x-model="row.name" :name="'loss['+index+'][name]'">
                </div>

                <div>
                    <label class="font-semibold">Age</label>
                    <input type="number" class="input w-full" x-model="row.age" :name="'loss['+index+'][age]'">
                </div>

                <div>
                    <label class="font-semibold">Sex</label>
                    <select class="input w-full" x-model="row.sex" :name="'loss['+index+'][sex]'">
                        <option value="">Select</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div>
                    <label class="font-semibold">Loss Type</label>
                    <select class="input w-full" x-model="row.loss_type" :name="'loss['+index+'][loss_type]'">
                        <option value="died">Died</option>
                        <option value="missing">Missing</option>
                        <option value="injured">Injured</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="font-semibold">Address</label>
                    <input type="text" class="input w-full" x-model="row.address" :name="'loss['+index+'][address]'">
                </div>

                <div>
                    <label class="font-semibold">State</label>
                    <input type="text" class="input w-full" x-model="row.state" :name="'loss['+index+'][state]'">
                </div>

                <div>
                    <label class="font-semibold">District</label>
                    <input type="text" class="input w-full" x-model="row.district" :name="'loss['+index+'][district]'">
                </div>

                <div>
                    <label class="font-semibold">Compensation Amount</label>
                    <input type="number" class="input w-full" x-model="row.compensation_amount" :name="'loss['+index+'][compensation_amount]'">
                </div>

                <div>
                    <label class="font-semibold">Compensation Date</label>
                    <input type="date" class="input w-full" x-model="row.compensation_received_date" :name="'loss['+index+'][compensation_received_date]'">
                </div>

                <div>
                    <label class="font-semibold">Status</label>
                    <select class="input w-full" x-model="row.compensation_status" :name="'loss['+index+'][compensation_status]'">
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>

            </div>

            <!-- NOMINEE DROPDOWN -->
            <details class="mt-4">
                <summary class="cursor-pointer font-semibold text-blue-600">Nominee Details</summary>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3 p-3 bg-gray-100 dark:bg-gray-700 rounded-lg">

                    <div>
                        <label class="font-semibold">Name</label>
                        <input type="text" class="input w-full" x-model="row.nominee_name" :name="'loss['+index+'][nominee_name]'">
                    </div>

                    <div>
                        <label class="font-semibold">Relation</label>
                        <input type="text" class="input w-full" x-model="row.nominee_relation" :name="'loss['+index+'][nominee_relation]'">
                    </div>

                    <div>
                        <label class="font-semibold">Age</label>
                        <input type="number" class="input w-full" x-model="row.nominee_age" :name="'loss['+index+'][nominee_age]'">
                    </div>

                    <div>
                        <label class="font-semibold">Number</label>
                        <input type="text" class="input w-full" x-model="row.nominee_number" :name="'loss['+index+'][nominee_number]'">
                    </div>

                    <div class="md:col-span-2">
                        <label class="font-semibold">Address</label>
                        <input type="text" class="input w-full" x-model="row.nominee_address" :name="'loss['+index+'][nominee_address]'">
                    </div>

                </div>
            </details>
        </div>
    </template>

    <!-- ADD MORE BUTTON -->
    <button type="button" 
        class="mt-4 px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded shadow hover:opacity-90"
        @click="addRow()">
        + Add More Human Loss
    </button>

</div>
