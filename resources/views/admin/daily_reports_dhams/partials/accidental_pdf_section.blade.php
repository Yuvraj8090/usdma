<div class="title-box">
    <h2>🚑 आकस्मिक रिपोर्ट्स (जिलावार)</h2>
    <p>रिपोर्ट तिथि: {{ $reportDate ?? '-' }}</p>
</div>

<table>
    <thead>
        <tr>
            <th>जिला</th>
            @foreach ($accidentalParents as $parent)
                <th class="sub-header" colspan="{{ $parent->children->count() }}">{{ $parent->name }}</th>
            @endforeach
        </tr>
        <tr>
            <th></th>
            @foreach ($accidentalParents as $parent)
                @foreach ($parent->children as $child)
                    <th>{{ $child->name }}</th>
                @endforeach
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($districts as $district)
            <tr>
                <td>
                    {{ $district->name }}
                    @if ($firstAccidentalEntries->has($district->id))
                        <br>
                        <small>पहली प्रविष्टि:
                            {{ \Carbon\Carbon::parse($firstAccidentalEntries[$district->id])->format('d-m-Y') }}</small>
                    @endif
                </td>

                @foreach ($accidentalParents as $parent)
                    @foreach ($parent->children as $child)
                        @php
                            // ✅ Safe check — handle if no report exists for this district
                            $districtReports = $accidentalReports[$district->id] ?? collect();
                            $count = optional($districtReports->where('fillable_id', $child->id)->first())->count ?? 0;
                        @endphp
                        <td>{{ $count }}</td>
                    @endforeach
                @endforeach
            </tr>
        @endforeach

    </tbody>
</table>
