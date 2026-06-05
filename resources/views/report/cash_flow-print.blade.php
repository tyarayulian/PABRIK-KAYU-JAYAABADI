<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Arus Kas</title>
    <style>
        @page {
            size: A4;
            margin: 15mm 10mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            color: #000;
            background: white;
        }

        /* HEADER LAPORAN */
        .report-header {
            text-align: center;
            margin-bottom: 8mm;
            padding-bottom: 5mm;
            border-bottom: 2pt solid #000;
        }

        .report-header h1 {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 2mm;
            text-transform: uppercase;
            letter-spacing: 1pt;
        }

        .report-header .company-name {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 2mm;
            text-transform: uppercase;
        }

        .report-header .period {
            font-size: 9pt;
            color: #333;
        }

        /* TABEL ARUS KAS */
        .cashflow-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5mm;
        }

        .cashflow-table thead th {
            background: #f5f5f5;
            border: 1pt solid #000;
            padding: 2mm;
            font-size: 8pt;
            font-weight: bold;
            text-align: left;
            text-transform: uppercase;
        }

        .cashflow-table thead th.text-right {
            text-align: right;
        }

        .cashflow-table tbody tr.section-header td {
            background: #1e2a78;
            color: white;
            border: 1pt solid #000;
            padding: 2mm;
            font-size: 10pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .cashflow-table tbody tr.item-row td {
            border: 0.5pt solid #999;
            padding: 1.5mm 2mm 1.5mm 10mm;
            font-size: 9pt;
        }

        .cashflow-table tbody tr.item-row td.text-right {
            text-align: right;
            font-family: 'Courier New', monospace;
        }

        .cashflow-table tbody tr.total-row td {
            background: #f5f5f5;
            border: 1pt solid #000;
            border-top: 2pt solid #000;
            padding: 2mm;
            font-size: 10pt;
            font-weight: bold;
        }

        .cashflow-table tbody tr.total-row td.text-right {
            text-align: right;
            font-family: 'Courier New', monospace;
        }

        .cashflow-table tbody tr.grand-total-row td {
            background: #1e2a78;
            color: white;
            border: 2pt solid #000;
            padding: 3mm 2mm;
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .cashflow-table tbody tr.grand-total-row td.text-right {
            text-align: right;
            font-family: 'Courier New', monospace;
        }

        .cashflow-table tbody tr.spacer td {
            border: none;
            padding: 2mm;
        }

        /* PAGE BREAKS */
        thead {
            display: table-header-group;
        }

        tr {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <div class="report-header">
        <h1>LAPORAN ARUS KAS</h1>
        <div class="company-name">Pabrik Kayu Jaya Abadi</div>
        <div class="period">Periode: {{ request('month') ? date('F Y', strtotime(request('month'))) : (request('start_date') && request('end_date') ? date('d/m/Y', strtotime(request('start_date'))).' - '.date('d/m/Y', strtotime(request('end_date'))) : 'Semua Data') }}</div>
    </div>

    <!-- TABEL -->
    <table class="cashflow-table">
        <thead>
            <tr>
                <th style="width: 70%;">Deskripsi</th>
                <th style="width: 30%;" class="text-right">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <!-- ARUS KAS MASUK -->
            <tr class="section-header">
                <td colspan="2">1. ARUS KAS MASUK</td>
            </tr>
            @forelse($inByAccount ?? [] as $name => $amount)
                <tr class="item-row">
                    <td>{{ $name }}</td>
                    <td class="text-right">{{ number_format($amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr class="item-row">
                    <td colspan="2" style="text-align: center; color: #666;">Tidak ada arus kas masuk</td>
                </tr>
            @endforelse
            <tr class="total-row">
                <td>TOTAL ARUS KAS MASUK</td>
                <td class="text-right">{{ number_format($totalIn, 0, ',', '.') }}</td>
            </tr>

            <!-- SPACER -->
            <tr class="spacer"><td colspan="2"></td></tr>

            <!-- ARUS KAS KELUAR -->
            <tr class="section-header">
                <td colspan="2">2. ARUS KAS KELUAR</td>
            </tr>
            @forelse($outByAccount ?? [] as $name => $amount)
                <tr class="item-row">
                    <td>{{ $name }}</td>
                    <td class="text-right">{{ number_format($amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr class="item-row">
                    <td colspan="2" style="text-align: center; color: #666;">Tidak ada arus kas keluar</td>
                </tr>
            @endforelse
            <tr class="total-row">
                <td>TOTAL ARUS KAS KELUAR</td>
                <td class="text-right">{{ number_format($totalOut, 0, ',', '.') }}</td>
            </tr>

            <!-- SPACER -->
            <tr class="spacer"><td colspan="2"></td></tr>

            <!-- GRAND TOTAL -->
            <tr class="grand-total-row">
                <td>KENAIKAN (PENURUNAN) BERSIH KAS</td>
                <td class="text-right">{{ number_format($totalIn - $totalOut, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Auto print on load -->
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
