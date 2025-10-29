<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Add Road Closed Reports
        </h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4">
        <form action="{{ route('admin.road-closed-reports.store') }}" method="POST">
            @csrf

            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse border border-gray-300 text-sm">
                    <thead>
                        <tr>
                            <!-- District Column -->
                            <th class="border border-gray-300 p-2 bg-gray-200 text-left">
                                District
                            </th>

                            <!-- Parent Headers -->
                            @foreach($parents as $parent)
                                @php
                                    $childCount = $parent->children->count();
                                @endphp
                                <th colspan="{{ $childCount > 0 ? $childCount : 1 }}" 
                                    class="border border-gray-300 p-2 text-center bg-gray-100 font-semibold">
                                    {{ $parent->name }}
                                </th>
                            @endforeach
                        </tr>

                        <tr>
                            <th class="border border-gray-300 p-2 bg-gray-50"></th>
                            <!-- Child headers (or parent if no children) -->
                            @foreach($parents as $parent)
                                @if($parent->children->count() > 0)
                                    @foreach($parent->children as $child)
                                        <th class="border border-gray-300 p-2 text-center bg-gray-50">
                                            {{ $child->name }}
                                        </th>
                                    @endforeach
                                @else
                                    <th class="border border-gray-300 p-2 text-center bg-gray-50">
                                        {{ $parent->name }}
                                    </th>
                                @endif
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($districts as $district)
                            <tr>
                                <!-- District Name -->
                                <td class="border border-gray-300 p-2 font-semibold bg-gray-50">
                                    {{ $district->name }}
                                </td>

                                <!-- Inputs -->
                                @foreach($parents as $parent)
                                    @if($parent->children->count() > 0)
                                        @foreach($parent->children as $child)
                                            <td class="border border-gray-300 p-2">
                                                <input 
                                                    type="text"
                                                    name="reports[{{ $district->id }}][{{ $child->id }}][data]" 
                                                    placeholder="Details"
                                                    class="w-full border-gray-300 rounded p-1 text-center focus:ring focus:ring-green-200">
                                            </td>
                                        @endforeach
                                    @else
                                        <td class="border border-gray-300 p-2">
                                            <input 
                                                type="text"
                                                name="reports[{{ $district->id }}][{{ $parent->id }}][data]" 
                                                placeholder="Details"
                                                class="w-full border-gray-300 rounded p-1 text-center focus:ring focus:ring-green-200">
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Report Date -->
            <div class="mt-4 flex items-center gap-4">
                <label class="font-semibold text-gray-800 dark:text-gray-200">Report Date:</label>
                <input type="date" 
                       name="report_date" 
                       value="{{ old('report_date', date('Y-m-d')) }}" 
                       class="border rounded p-2 dark:bg-gray-900 dark:text-white" 
                       required>
            </div>

            <!-- Buttons -->
            <div class="mt-6 flex justify-end">
                <button type="submit" 
                        class="px-5 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                    Save Reports
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
