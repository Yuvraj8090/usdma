<div class="title-box" style="text-align: center; margin-bottom:20px">
    <h3>Natural Disaster Report (Districtwise)</h3>
    <h4>as latest update by the districts</h4>

    <div class="summary-line">
        Summary (Date 
        {{ \Carbon\Carbon::parse($fromDate)->format('d-m-Y') }}
        to Till date )
    </div>
</div>

<table border="1" cellspacing="0" cellpadding="4" width="100%">
    <thead>
        <tr>
            <th>Sl. No.</th>
            <th>जिला</th>
            @foreach ($accidentalParents as $parent)
                <th colspan="{{ $parent->children->count() }}" style="text-align:center">
                    {{ $parent->name }}
                </th>
            @endforeach
        </tr>
        <tr>
            <th></th>
            <th></th>
            @foreach ($accidentalParents as $parent)
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
                <td style="text-align:center;">{{ $sl++ }}</td>
                <td>
                    {{ $district->name }}
                    @if ($firstAccidentalEntries->has($district->id))
                       
                       
                    @endif
                </td>

                @foreach ($accidentalParents as $parent)
                    @foreach ($parent->children as $child)
                        @php
                            $districtReports = $accidentalReports[$district->id] ?? collect();
                            $report = $districtReports->firstWhere('fillable_id', $child->id);
                            $count = $report->total_count ?? 0;

                            $columnTotals[$child->id] = ($columnTotals[$child->id] ?? 0) + $count;
                        @endphp
                        <td style="text-align:center">{{ $count }}</td>
                    @endforeach
                @endforeach
            </tr>
        @endforeach

       
    </tbody>
</table>
