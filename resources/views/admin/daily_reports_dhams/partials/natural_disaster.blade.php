<div class="title-box" style="text-align:center; margin-bottom:10px;">
    <h3 style="margin:0; font-size:12px;">Natural Disaster Report (Districtwise)</h3>
    <h4 style="margin:2px 0; font-size:10px; font-weight:normal;">
        as latest update by the districts
    </h4>

    <div class="summary-line" style="margin-top:4px; font-size:10px;">
        Summary (Date {{ \Carbon\Carbon::parse($fromDate)->format('d-m-Y') }} to Till date)
    </div>
</div>

<table class="report-table">
    <thead>
        <tr>
            <th>Sl. No.</th>
            <th>जिला</th>
            @foreach ($disasterParents as $parent)
                <th colspan="{{ $parent->children->count() }}">
                    {{ $parent->name }}
                </th>
            @endforeach
        </tr>
        <tr>
            <th></th>
            <th></th>
            @foreach ($disasterParents as $parent)
                @foreach ($parent->children as $child)
                    <th>{{ $child->name }}</th>
                @endforeach
            @endforeach
        </tr>
    </thead>

    <tbody>
        @php
            $columnTotals = [];
            $sl = 1;
        @endphp

        @foreach ($districts as $district)
            <tr>
                <td>{{ $sl++ }}</td>
                <td style="text-align:left;">
                    {{ $district->name }}
                    @if ($firstDisasterEntries->has($district->id))
                        <br>
                        <small>First entry: {{ \Carbon\Carbon::parse($firstDisasterEntries[$district->id])->format('d-m-Y') }}</small>
                    @endif
                </td>

                @foreach ($disasterParents as $parent)
                    @foreach ($parent->children as $child)
                        @php
                            $districtReports = $disasterReports[$district->id] ?? collect();
                            $report = $districtReports->firstWhere('fillable_id', $child->id);
                            $count = $report->total_count ?? 0;

                            $columnTotals[$child->id] = ($columnTotals[$child->id] ?? 0) + $count;
                        @endphp
                        <td>{{ $count }}</td>
                    @endforeach
                @endforeach
            </tr>
        @endforeach
    </tbody>

    <tfoot>
        <tr>
            <td colspan="2" style="font-weight:bold;">कुल योग (Total)</td>
            @foreach ($disasterParents as $parent)
                @foreach ($parent->children as $child)
                    <td style="font-weight:bold;">{{ $columnTotals[$child->id] ?? 0 }}</td>
                @endforeach
            @endforeach
        </tr>
    </tfoot>
</table>
