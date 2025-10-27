<div class="title-box">
    <h2>🕉️ डेली रिपोर्ट्स (धाम्स)</h2>
    <p>रिपोर्ट तिथि: {{ $reportDate ?? '-' }}</p>
</div>

<table>
    <thead>
        <tr>
            <th>धाम</th>
            @foreach ($dhamParents as $parent)
                <th class="sub-header" colspan="{{ $parent->children->count() }}">{{ $parent->name }}</th>
            @endforeach
        </tr>
        <tr>
            <th></th>
            @foreach ($dhamParents as $parent)
                @foreach ($parent->children as $child)
                    <th>{{ $child->name }}</th>
                @endforeach
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($dhams as $dham)
            <tr>
                <td>
                    {{ $dham->name }}
                    @if (!empty($firstEntries[$dham->id]))
                        <br>
                        ({{ \Carbon\Carbon::parse($firstEntries[$dham->id])->translatedFormat('d F Y') }} से)
                    @endif
                </td>
                @foreach ($dhamParents as $parent)
                    @foreach ($parent->children as $child)
                        @php
                            $key = $dham->id . '_' . $child->id;
                            $count = $reports[$key]->total_count ?? 0;
                        @endphp
                        <td>{{ $count }}</td>
                    @endforeach
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
