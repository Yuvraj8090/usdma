<!DOCTYPE html>
<html lang="hi">

<head>
    <meta charset="utf-8">
    <title>Daily Reports PDF</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            line-height: 1.4;
        }

        h2 {
            text-align: center;
            margin: 0;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .header-table td {
            vertical-align: top;
            padding: 2px 5px;
            font-size: 11px;
        }

        .right-box {
            border: 1px solid #000;
            padding: 4px;
            display: inline-block;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 3px 5px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            background-color: #d4f0d4;
        }

        .sub-header {
            background-color: #e0f7e0;
        }

        tr {
            page-break-inside: avoid;
        }

        #downloadBtn {
            background-color: #22c55e;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <button id="downloadBtn">डाउनलोड रिपोर्ट (PDF)</button>

    <div id="reportContent">

        <!-- Header Info -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
            
            <!-- Left Side -->
            <div style="font-size: 11px; line-height: 1.6;">
                <br>
                दूरभाष नं – (Toll Free - 1070) <br>
                0135-2710335/34 <br><br>
                मोबाइल – 8218867005, 9058441404
            </div>
<div style="text-align:center">
                <strong>राज्य आपातकालीन संचालन केन्द्र</strong><br>
                (यू०एस०डी०एम०ए०) आई०टी० पार्क देहरादून, उत्तराखण्ड <br>
            </div>
            <!-- Right Side -->
            <div style="text-align: right; font-size: 11px; line-height: 1.6;">
                <div style="border: 1px solid #000; display: inline-block; padding: 4px 8px; margin-bottom: 6px;">
                    दिनांक – {{ now()->format('d-m-Y') }} <br>
                    सायं – {{ now()->format('H:i') }} बजे
                </div>
                <br>
                संख्या – &nbsp; &nbsp; &nbsp; &nbsp;/SEOC/27(2023-24)
            </div>
        </div>


        <!-- Title -->
        <h2>डेली रिपोर्ट्स (धाम्स)</h2>
        <p>Report Date: {{ $reportDate ?? '-' }}</p>

        <!-- Main Table -->
        <table>
            <thead>
                <tr>
                    <th>धाम</th>
                    @foreach ($parents as $parent)
                        <th class="sub-header" colspan="{{ $parent->children->count() }}">{{ $parent->name }}</th>
                    @endforeach
                </tr>
                <tr>
                    <th></th>
                    @foreach ($parents as $parent)
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
                        @foreach ($parents as $parent)
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

        <p>Generated on: {{ now()->format('d-m-Y H:i') }}</p>
    </div>

    <!-- JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("downloadBtn").addEventListener("click", function() {
                const element = document.getElementById("reportContent");

                const opt = {
                    margin: [10, 10, 10, 10], // mm
                    filename: 'daily_reports.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 2,
                        useCORS: true
                    },
                    jsPDF: {
                        unit: 'mm',
                        format: 'a4',
                        orientation: 'portrait'
                    },
                    pagebreak: {
                        mode: ['css', 'legacy']
                    }
                };

                html2pdf().set(opt).from(element).save();
            });
        });
    </script>
</body>

</html>
