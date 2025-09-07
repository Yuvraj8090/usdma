<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Daily Report (Dham)
            </h2>
            <!-- Back Button -->
            <a href="{{ route('admin.daily_reports_dhams.index') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-lg shadow hover:bg-gray-700 transition">
                ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-8 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <form action="{{ route('admin.daily_reports_dhams.update', $dailyReportDham->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Date Inputs -->
                <div class="flex flex-wrap gap-6">
                    

                    <div class="flex-1">
                        <label class="block font-semibold text-gray-700 dark:text-gray-200 mb-2">Report Date:</label>
                        <input type="date" name="report_date"
                               value="{{ $dailyReportDham->report_date->format('Y-m-d') }}"
                               class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white 
                                      rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               required>
                    </div>
                </div>

                <!-- Dham -->
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-200 mb-2">Dham</label>
                    <select name="dham_id"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-600 
                                   px-3 py-2 dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-green-500"
                            required>
                        @foreach($dhams as $dham)
                            <option value="{{ $dham->id }}" {{ $dailyReportDham->dham_id == $dham->id ? 'selected' : '' }}>
                                {{ $dham->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Fillable -->
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-200 mb-2">Fillable</label>
                    <select name="fillable_id"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-600 
                                   px-3 py-2 dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-green-500"
                            required>
                        @foreach($fillables as $fillable)
                            <option value="{{ $fillable->id }}" {{ $dailyReportDham->fillable_id == $fillable->id ? 'selected' : '' }}>
                                {{ $fillable->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Count -->
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-200 mb-2">Count</label>
                    <input type="number" name="count" value="{{ $dailyReportDham->count }}"
                           class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white 
                                  rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500"
                           required>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between items-center">
                    <a href="{{ route('admin.daily_reports_dhams.index') }}"
                       class="px-5 py-2 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-600 transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-gradient-to-r from-green-500 to-teal-500 text-white font-semibold rounded-lg shadow-lg hover:from-green-600 hover:to-teal-600 transition">
                        Update Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
