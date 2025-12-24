<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Road Closed Reports
            </h2>
        </div>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                <i class="fas fa-road mr-1"></i> Manage road closed data (grouped by district)
            </div>
            <a href="{{ route('admin.road-closed-reports.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-700 rounded-lg font-semibold text-white hover:from-green-600 hover:to-emerald-600 shadow-lg">
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
            <div class="px-6 py-4 bg-gradient-to-r from-green-500 to-emerald-600">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-database mr-2"></i> All Reports
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">District</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Date</th>

                            <!-- Dynamic parent/child headers -->
                            @foreach ($parents as $parent)
                                @if ($parent->children->count() > 0)
                                    @foreach ($parent->children as $child)
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase">
                                            {{ $child->name }}
                                        </th>
                                    @endforeach
                                @else
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase">
                                        {{ $parent->name }}
                                    </th>
                                @endif
                            @endforeach
                        </tr>
                    </thead>

                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                        @php
                            $totals = [];
                        @endphp

                        @foreach ($reports->groupBy(['district_id', 'report_date']) as $districtReports)
                            @foreach ($districtReports as $date => $rows)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4">
                                        {{ $rows->first()->district->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}
                                    </td>

                                    @foreach ($parents as $parent)
                                        @if ($parent->children->count() > 0)
                                            @foreach ($parent->children as $child)
                                                @php
                                                    // Get concatenated "data" strings for this child
                                                    $allData = $rows
                                                        ->where('fillable_id', $child->id)
                                                        ->pluck('all_data')
                                                        ->join(', ');
                                                    $values = array_filter(array_map('trim', explode(',', $allData)));

                                                    // Determine if all are numeric or textual
                                                    $isAllNumeric =
                                                        !empty($values) &&
                                                        collect($values)->every(fn($v) => is_numeric($v));

                                                    // For totals (only numeric values contribute)
                                                    if ($isAllNumeric) {
                                                        $totals[$child->id] =
                                                            ($totals[$child->id] ?? 0) + array_sum($values);
                                                    }
                                                @endphp

                                                <td class="px-6 py-4 {{ $isAllNumeric ? 'text-center' : 'text-left' }}">
                                                    @if (empty($values))
                                                        -
                                                    @elseif($isAllNumeric)
                                                        {{ array_sum($values) }}
                                                    @else
                                                        <div
                                                            class="whitespace-pre-wrap text-gray-700 dark:text-gray-300">
                                                            {{ implode(', ', $values) }}
                                                        </div>
                                                    @endif
                                                </td>
                                            @endforeach
                                        @else
                                            @php
                                                $allData = $rows
                                                    ->where('fillable_id', $parent->id)
                                                    ->pluck('all_data')
                                                    ->join(', ');
                                                $values = array_filter(array_map('trim', explode(',', $allData)));
                                                $isAllNumeric =
                                                    !empty($values) &&
                                                    collect($values)->every(fn($v) => is_numeric($v));
                                                if ($isAllNumeric) {
                                                    $totals[$parent->id] =
                                                        ($totals[$parent->id] ?? 0) + array_sum($values);
                                                }
                                            @endphp

                                            <td class="px-6 py-4 {{ $isAllNumeric ? 'text-center' : 'text-left' }}">
                                                @if (empty($values))
                                                    -
                                                @elseif($isAllNumeric)
                                                    {{ array_sum($values) }}
                                                @else
                                                    <div class="whitespace-pre-wrap text-gray-700 dark:text-gray-300">
                                                        {{ implode(', ', $values) }}
                                                    </div>
                                                @endif
                                            </td>
                                        @endif
                                    @endforeach

                                </tr>
                            @endforeach
                        @endforeach

                        <!-- Totals row -->
                        <tr class="bg-gray-100 dark:bg-gray-700 font-semibold">
                            <td colspan="2" class="px-6 py-4 text-right">Total:</td>
                            @foreach ($parents as $parent)
                                @if ($parent->children->count() > 0)
                                    @foreach ($parent->children as $child)
                                        @php
                                            // Get concatenated "data" strings for this child
                                            $allData = $rows
                                                ->where('fillable_id', $child->id)
                                                ->pluck('all_data')
                                                ->join(', ');
                                            $values = array_filter(array_map('trim', explode(',', $allData)));

                                            // Determine if all are numeric or textual
                                            $isAllNumeric =
                                                !empty($values) && collect($values)->every(fn($v) => is_numeric($v));

                                            // For totals (only numeric values contribute)
                                            if ($isAllNumeric) {
                                                $totals[$child->id] = ($totals[$child->id] ?? 0) + array_sum($values);
                                            }
                                        @endphp

                                        <td class="px-6 py-4 {{ $isAllNumeric ? 'text-center' : 'text-left' }}">
                                            @if (empty($values))
                                                -
                                            @elseif($isAllNumeric)
                                                {{ array_sum($values) }}
                                            @else
                                                <div class="whitespace-pre-wrap text-gray-700 dark:text-gray-300">
                                                    {{ implode(', ', $values) }}
                                                </div>
                                            @endif
                                        </td>
                                    @endforeach
                                @else
                                    @php
                                        $allData = $rows
                                            ->where('fillable_id', $parent->id)
                                            ->pluck('all_data')
                                            ->join(', ');
                                        $values = array_filter(array_map('trim', explode(',', $allData)));
                                        $isAllNumeric =
                                            !empty($values) && collect($values)->every(fn($v) => is_numeric($v));
                                        if ($isAllNumeric) {
                                            $totals[$parent->id] = ($totals[$parent->id] ?? 0) + array_sum($values);
                                        }
                                    @endphp

                                    <td class="px-6 py-4 {{ $isAllNumeric ? 'text-center' : 'text-left' }}">
                                        @if (empty($values))
                                            -
                                        @elseif($isAllNumeric)
                                            {{ array_sum($values) }}
                                        @else
                                            <div class="whitespace-pre-wrap text-gray-700 dark:text-gray-300">
                                                {{ implode(', ', $values) }}
                                            </div>
                                        @endif
                                    </td>
                                @endif
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
