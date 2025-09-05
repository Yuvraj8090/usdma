<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Accidental Reports
            </h2>
        </div>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                <i class="fas fa-car-crash mr-1"></i> Manage accident reports (counts grouped by category)
            </div>
            <a href="{{ route('admin.accidental_reports.create') }}"
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-lg font-semibold text-white hover:from-indigo-600 hover:to-purple-600 shadow-lg">
                <i class="fas fa-plus-circle mr-2"></i> Add Report
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border">
            <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-database mr-2"></i> All Reports
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">District</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            @foreach($parents as $parent)
                                @foreach($parent->children as $child)
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                        {{ $child->name }}
                                    </th>
                                @endforeach
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                        @php
                            $totals = [];
                        @endphp

                        @foreach($reports->groupBy(['district_id','report_date']) as $districtReports)
                            @foreach($districtReports as $date => $rows)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4">
                                        {{ $rows->first()->district->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}
                                    </td>
                                    @foreach($parents as $parent)
                                        @foreach($parent->children as $child)
                                            @php
                                                $count = $rows->where('fillable_id', $child->id)->sum('total_count');
                                                $totals[$child->id] = ($totals[$child->id] ?? 0) + $count;
                                            @endphp
                                            <td class="px-6 py-4 text-center">
                                                {{ $count > 0 ? $count : '-' }}
                                            </td>
                                        @endforeach
                                    @endforeach
                                </tr>
                            @endforeach
                        @endforeach

                        {{-- Totals Row --}}
                        <tr class="bg-gray-100 dark:bg-gray-700 font-semibold">
                            <td colspan="2" class="px-6 py-4 text-right">Total:</td>
                            @foreach($parents as $parent)
                                @foreach($parent->children as $child)
                                    <td class="px-6 py-4 text-center">
                                        {{ $totals[$child->id] ?? 0 }}
                                    </td>
                                @endforeach
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t">
                {{ $reports->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
