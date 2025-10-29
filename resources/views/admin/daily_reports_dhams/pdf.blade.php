<!DOCTYPE html>
<html lang="hi">

<head>
    <meta charset="utf-8">
    <title>संयुक्त रिपोर्ट (धाम + आकस्मिक)</title>
    <style>
        /* ==== A4 PDF SETTINGS ==== */
        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        /* Main printable container width (A4 = 210mm → 210 - 15 - 15 = 180mm safe zone) */
        #reportContent {
            width: 100%;
            max-width: 180mm;
            margin: 0 auto;
            box-sizing: border-box;
        }

        /* ==== GLOBAL STYLES ==== */
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            line-height: 1.5;
            color: #000;
            margin: 0;
            padding: 0;
        }

        h2,
        h3 {
            text-align: center;
            margin: 10px 0;
            font-weight: bold;
        }

        p {
            margin: 4px 0;
        }

        /* ==== TABLE STYLES ==== */
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 15px;
            word-wrap: break-word;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: center;
            vertical-align: middle;
        }

        .header-table td {
            vertical-align: top;
            padding: 3px 5px;
            font-size: 11px;
            border: none;
            /* no border for header info tables */
        }

        tr {
            page-break-inside: avoid;
        }

        /* ==== HEADER SECTION ==== */
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .header-left,
        .header-center,
        .header-right {
            font-size: 11px;
            line-height: 1.6;
        }

        .header-center {
            text-align: center;
            font-weight: bold;
        }

        .date-box {
            border: 1px solid #000;
            display: inline-block;
            padding: 4px 8px;
            margin-bottom: 6px;
        }

        /* ==== DOWNLOAD BUTTON ==== */
        #downloadBtn {
            background-color: #22c55e;
            color: #fff;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 10px;
            font-size: 12px;
        }

        #downloadBtn:hover {
            background-color: #16a34a;
        }

        /* ==== DIVIDERS & FOOTER ==== */

        .footer {
            margin-top: 25px;
            font-size: 10px;
            text-align: left;
        }
    </style>

</head>

<body>
    <button id="downloadBtn">डाउनलोड रिपोर्ट (PDF)</button>

    <div id="reportContent">

        <!-- HEADER -->
        <div class="header-container">
            <!-- Left -->
            <div class="header-left">
                दूरभाष नं – (Toll Free - 1070)<br>
                0135-2710335/34<br><br>
                मोबाइल – 8218867005, 9058441404
            </div>

            <!-- Center -->
            <div class="header-center">
                राज्य आपातकालीन संचालन केन्द्र<br>
                (यू०एस०डी०एम०ए०) आई०टी० पार्क देहरादून, उत्तराखण्ड
            </div>

            <!-- Right -->
            <div class="header-right" style="text-align: right;">
                <div class="date-box">
                    दिनांक – {{ now()->format('d-m-Y') }}<br>
                    सायं – {{ now()->format('H:i') }} बजे
                </div><br>
                संख्या – &nbsp;&nbsp;&nbsp;&nbsp;/SEOC/27(2023-24)
            </div>
        </div>

        @include('admin.daily_reports_dhams.partials.dham_pdf_section')
        @include('admin.daily_reports_dhams.partials.natural_disaster')
        @include('admin.daily_reports_dhams.partials.accidental_pdf_section')

        <div class="footer">
            रिपोर्ट जनरेट की गई तिथि: {{ now()->format('d-m-Y H:i') }}
        </div>
    </div>

    <!-- html2pdf.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const downloadBtn = document.getElementById("downloadBtn");
            downloadBtn.addEventListener("click", function() {
                const element = document.getElementById("reportContent");
                const opt = {
                    margin: [10, 10, 10, 10],
                    filename: 'combined_daily_accidental_report.pdf',
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
                        mode: ['avoid-all', 'css', 'legacy']
                    }
                };
                html2pdf().set(opt).from(element).save();
            });
        });
    </script>
</body>

</html>
