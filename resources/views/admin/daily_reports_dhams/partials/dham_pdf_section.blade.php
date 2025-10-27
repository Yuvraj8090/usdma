<div class="title-box" style="text-align:center; margin-bottom:20px;">
    <h2>🕉️ डेली रिपोर्ट्स (धाम्स)</h2>
    <p>रिपोर्ट तिथि: {{ $reportDate ?? '-' }}</p>
</div>

<table border="1" cellspacing="0" cellpadding="4" width="100%">
    <thead>
        <tr>
            <th>Sl. No.</th>
            <th>धाम</th>
            @foreach ($dhamParents as $parent)
                <th class="sub-header" colspan="{{ $parent->children->count() }}" style="text-align:center;">
                    {{ $parent->name }}
                </th>
            @endforeach
        </tr>
        <tr>
            <th></th>
            <th></th>
            @foreach ($dhamParents as $parent)
                @foreach ($parent->children as $child)
                    <th style="text-align:center;">{{ $child->name }}</th>
                @endforeach
            @endforeach
        </tr>
    </thead>
    <tbody>
        @php
            $sl = 1;
            $columnTotals = [];
        @endphp

        @foreach ($dhams as $dham)
            <tr>
                <td style="text-align:center;">{{ $sl++ }}</td>
                <td>
                    {{ $dham->name }}
                    @if (!empty($firstEntries[$dham->id]))
                        <br>
                        <small>
                            ({{ \Carbon\Carbon::parse($firstEntries[$dham->id])->translatedFormat('d-m-Y') }} से)
                        </small>
                    @endif
                </td>

                @foreach ($dhamParents as $parent)
                    @foreach ($parent->children as $child)
                        @php
                            $key = $dham->id . '_' . $child->id;
                            $count = $reports[$key]->total_count ?? 0;

                            // Add to column totals
                            $columnTotals[$child->id] = ($columnTotals[$child->id] ?? 0) + $count;
                        @endphp
                        <td style="text-align:center;">{{ $count }}</td>
                    @endforeach
                @endforeach
            </tr>
        @endforeach

   
    </tbody>
</table>
