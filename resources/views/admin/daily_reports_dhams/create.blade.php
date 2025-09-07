<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                Add Daily Reports (Dhams)
            </h2>
            <!-- Back Button -->
            <a href="{{ route('admin.daily_reports_dhams.index') }}"
               class="px-6 py-2 bg-gray-500 text-white font-medium rounded-lg shadow hover:bg-gray-600 transition">
                       ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-8 container mx-auto px-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <form action="{{ route('admin.daily_reports_dhams.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Report Date -->
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-200 mb-2">
                        Report Date:
                    </label>
                    <input type="date" name="report_date"
                           value="{{ now()->toDateString() }}"   
                           required
                           class="w-full sm:w-1/3 border border-gray-300 dark:border-gray-600 
                                  dark:bg-gray-900 dark:text-white rounded-lg px-3 py-2 
                                  focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <!-- Matrix Table -->
                <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="bg-gradient-to-r from-green-200 to-green-400 text-gray-800 font-semibold">
                                <th class="border border-gray-300 dark:border-gray-600 p-2">Dham</th>
                                @foreach($parents as $parent)
                                    <th colspan="{{ $parent->children->count() }}" 
                                        class="border border-gray-300 dark:border-gray-600 text-center p-2 bg-green-100">
                                        {{ $parent->name }}
                                    </th>
                                @endforeach
                            </tr>
                            <tr class="bg-green-50 dark:bg-green-900 text-gray-700 dark:text-gray-200">
                                <th class="border border-gray-300 dark:border-gray-600 p-2"></th>
                                @foreach($parents as $parent)
                                    @foreach($parent->children as $child)
                                        <th class="border border-gray-300 dark:border-gray-600 text-center p-2">
                                            {{ $child->name }}
                                        </th>
                                    @endforeach
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dhams as $dham)
                                <tr class="hover:bg-green-50 dark:hover:bg-gray-700 transition">
                                    <td class="border border-gray-300 dark:border-gray-600 p-2 font-semibold bg-gray-50 dark:bg-gray-900">
                                        {{ $dham->name }}
                                    </td>
                                    @foreach($parents as $parent)
                                        @foreach($parent->children as $child)
                                            <td class="border border-gray-300 dark:border-gray-600 p-2 text-center">
                                                <input 
                                                    type="number"
                                                    name="reports[{{ $dham->id }}][{{ $child->id }}]"
                                                    class="w-20 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white
                                                           rounded-lg text-center focus:ring-1 focus:ring-green-400"
                                                    min="0" value="0">
                                            </td>
                                        @endforeach
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between items-center">
                    <a href="{{ route('admin.daily_reports_dhams.index') }}"
                       class="px-6 py-2 bg-gray-500 text-white font-medium rounded-lg shadow hover:bg-gray-600 transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-gradient-to-r from-green-500 to-teal-500 text-white font-semibold rounded-lg shadow-lg hover:from-green-600 hover:to-teal-600 transition">
                        Save Reports
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
