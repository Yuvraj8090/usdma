<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="utf-8">
    <title>संयुक्त रिपोर्ट (धाम + आकस्मिक)</title>
    <style>
        @page { size: A4 portrait; margin: 15mm; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; line-height: 1.4; }
        h2 { text-align: center; margin: 0; }

        .header-table, table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .header-table td { vertical-align: top; padding: 2px 5px; font-size: 11px; }
        th, td { border: 1px solid #000; padding: 3px 5px; text-align: center; vertical-align: middle; }
        th { background-color: #d4f0d4; }
        .sub-header { background-color: #e0f7e0; }

        tr { page-break-inside: avoid; }

        #downloadBtn {
            background-color: #22c55e; color: white;
            padding: 6px 12px; border: none; border-radius: 4px;
            cursor: pointer; margin-bottom: 10px;
        }

        .section-divider {
            margin: 25px 0;
            border-top: 2px dashed #000;
            page-break-before: always;
        }
    </style>
</head>

<body>
    <button id="downloadBtn">डाउनलोड रिपोर्ट (PDF)</button>

    <div id="reportContent">
        <!-- HEADER -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
            <!-- Left -->
            <div style="font-size: 11px; line-height: 1.6;">
                <br>
                दूरभाष नं – (Toll Free - 1070) <br>
                0135-2710335/34 <br><br>
                मोबाइल – 8218867005, 9058441404
            </div>

            <!-- Center -->
            <div style="text-align:center">
                <strong>राज्य आपातकालीन संचालन केन्द्र</strong><br>
                (यू०एस०डी०एम०ए०) आई०टी० पार्क देहरादून, उत्तराखण्ड <br>
            </div>

            <!-- Right -->
            <div style="text-align: right; font-size: 11px; line-height: 1.6;">
                <div style="border: 1px solid #000; display: inline-block; padding: 4px 8px; margin-bottom: 6px;">
                    दिनांक – {{ now()->format('d-m-Y') }} <br>
                    सायं – {{ now()->format('H:i') }} बजे
                </div>
                <br>
                संख्या – &nbsp;&nbsp;&nbsp;&nbsp;/SEOC/27(2023-24)
            </div>
        </div>

        <!-- 🕉️ DHAM REPORT SECTION -->
        @include('admin.daily_reports_dhams.partials.dham_pdf_section')

        <!-- Divider -->
       
        <!-- 🚑 ACCIDENTAL REPORT SECTION -->
        @include('admin.daily_reports_dhams.partials.accidental_pdf_section')

        <p>Generated on: {{ now()->format('d-m-Y H:i') }}</p>
    </div>

    <!-- JS: html2pdf -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("downloadBtn").addEventListener("click", function() {
                const element = document.getElementById("reportContent");
                const opt = {
                    margin: [10, 10, 10, 10],
                    filename: 'combined_daily_accidental_report.pdf',
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 2, useCORS: true },
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
                    pagebreak: { mode: ['css', 'legacy'] }
                };
                html2pdf().set(opt).from(element).save();
            });
        });
    </script>
</body>
</html>
