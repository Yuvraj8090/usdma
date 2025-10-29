<div class="title-box" style="text-align:center; margin-bottom:20px;">
    <h2>
        (चारधाम यात्रा से संबंधित सूचना-आंकड़े
        विगत दिवस साँय: 07:00 बजे तक के हैं।)
        <br>
        <span class="eng">As latest update by the districts</span>
    </h2>
</div>

<table border="1" cellspacing="0" cellpadding="4" width="100%" style="border-collapse:collapse; text-align:center;">
    <thead>
        <tr>
            <th>Sl. No.</th>
            <th>धाम</th>
            @foreach ($dhamParents as $parent)
                <th class="sub-header" colspan="{{ $parent->children->count() }}">
                    {{ $parent->name }}
                </th>
            @endforeach
        </tr>
        <tr>
            <th></th>
            <th></th>
            @foreach ($dhamParents as $parent)
                @foreach ($parent->children as $child)
                    <th>{{ $child->name }}</th>
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
                <td>{{ $sl++ }}</td>
                <td style="text-align:left;">
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
                        <td>{{ $count }}</td>
                    @endforeach
                @endforeach
            </tr>
        @endforeach
    </tbody>

    <tfoot>
        <tr style="font-weight:bold; background:#f2f2f2;">
            <td colspan="2">कुल योग (Total)</td>
            @foreach ($dhamParents as $parent)
                @foreach ($parent->children as $child)
                    <td>{{ $columnTotals[$child->id] ?? 0 }}</td>
                @endforeach
            @endforeach
        </tr>
    </tfoot>
</table>
