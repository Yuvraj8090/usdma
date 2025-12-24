<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            Add Daily Reports
        </h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4">
        <form action="{{ route('admin.daily_reports.store') }}" method="POST">
            @csrf

            <!-- Date Inputs -->
            <div class="flex flex-wrap gap-6 mb-6">
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-200 mb-2">From Date:</label>
                    <input type="date" name="from_date" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-200 mb-2">Report Date:</label>
                    <input type="date" name="report_date" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Matrix Table -->
            <div class="overflow-x-auto shadow-lg rounded-lg border border-gray-200">
                <table class="min-w-full border-collapse">
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-200 to-blue-400 text-gray-800 font-semibold">
                            <th class="border border-gray-300 p-2">District</th>
                            @foreach($parents as $parent)
                                <th colspan="{{ $parent->children->count() }}" 
                                    class="border border-gray-300 text-center p-2 bg-blue-100">
                                    {{ $parent->name }}
                                </th>
                            @endforeach
                        </tr>
                        <tr class="bg-blue-50 text-gray-700">
                            <th class="border border-gray-300 p-2"></th>
                            @foreach($parents as $parent)
                                @foreach($parent->children as $child)
                                    <th class="border border-gray-300 text-center p-2">
                                        {{ $child->name }}
                                    </th>
                                @endforeach
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($districts as $district)
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="border border-gray-300 p-2 font-semibold bg-gray-50">{{ $district->name }}</td>
                                @foreach($parents as $parent)
                                    @foreach($parent->children as $child)
                                        <td class="border border-gray-300 p-2 text-center">
                                            <input 
                                                type="number"
                                                name="reports[{{ $district->id }}][{{ $child->id }}]"
                                                class="w-20 border-gray-300 rounded-lg text-center focus:ring-1 focus:ring-blue-400"
                                                min="0" value="0">
                                        </td>
                                    @endforeach
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Submit Button -->
            <div class="mt-6 flex justify-end">
                <button type="submit"
                        class="px-6 py-2 bg-gray-700 text-white font-semibold rounded-lg shadow-lg hover:from-indigo-600 hover:to-purple-600 transition-colors">
                    Save Reports
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
