<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Add Daily Reports
        </h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4">
        <form action="{{ route('admin.daily_reports.store') }}" method="POST">
            @csrf

            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse border border-gray-300">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 p-2 bg-gray-200">District</th>
                            @foreach($parents as $parent)
                                <th colspan="{{ $parent->children->count() }}" 
                                    class="border border-gray-300 p-2 text-center bg-gray-100 font-semibold">
                                    {{ $parent->name }}
                                </th>
                            @endforeach
                        </tr>
                        <tr>
                            <th class="border border-gray-300 p-2"></th>
                            @foreach($parents as $parent)
                                @foreach($parent->children as $child)
                                    <th class="border border-gray-300 p-2 text-center bg-gray-50">
                                        {{ $child->name }}
                                    </th>
                                @endforeach
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($districts as $district)
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold bg-gray-50">
                                    {{ $district->name }}
                                </td>
                                @foreach($parents as $parent)
                                    @foreach($parent->children as $child)
                                        <td class="border border-gray-300 p-2 text-center">
                                            <input 
                                                type="number" 
                                                name="reports[{{ $district->id }}][{{ $child->id }}]" 
                                                class="w-20 border-gray-300 rounded p-1 text-center"
                                                min="0"
                                                value="0"
                                            >
                                        </td>
                                    @endforeach
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <label class="font-semibold">Report Date:</label>
                <input type="date" name="report_date" class="border rounded p-2" required>
            </div>

            <div class="mt-6">
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Save Reports
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
