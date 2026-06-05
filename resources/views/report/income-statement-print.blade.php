<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Laba Rugi - {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : '' }} s/d {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : '' }}</title>
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

        /* TABEL LABA RUGI */
        .statement-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5mm;
        }

        .statement-table thead th {
            border-top: 2pt solid #000;
            border-bottom: 1pt solid #000;
            padding: 2mm 0;
            font-size: 9pt;
            font-weight: bold;
            text-align: left;
        }

        .statement-table thead th.text-right {
            text-align: right;
        }

        .statement-table tbody tr.section-header td {
            padding: 3mm 0 2mm 0;
            font-size: 10pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .statement-table tbody tr.item-row td {
            padding: 1.5mm 0 1.5mm 8mm;
            font-size: 9pt;
        }

        .statement-table tbody tr.item-row td.account-code {
            font-weight: bold;
            padding-left: 12mm;
        }

        .statement-table tbody tr.total-row td {
            padding: 2mm 0 2mm 12mm;
            font-size: 9pt;
            font-weight: bold;
            border-top: 1pt solid #000;
        }

        .statement-table tbody tr.subtotal-row td {
            padding: 3mm 0;
            font-size: 10pt;
            font-weight: bold;
            background: #f5f5f5;
            border-top: 1pt solid #000;
            border-bottom: 1pt solid #000;
            text-transform: uppercase;
        }

        .statement-table tbody tr.grand-total-row td {
            padding: 4mm 0;
            font-size: 11pt;
            font-weight: bold;
            background: #000;
            color: white;
            border-top: 2pt solid #000;
            border-bottom: 2pt solid #000;
            text-transform: uppercase;
        }

        .text-right {
            text-align: right;
            font-family: 'Courier New', monospace;
        }

        /* PAGE BREAKS */
        tr {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <div class="report-header">
        <h1>LAPORAN LABA RUGI</h1>
        <div class="company-name">Pabrik Kayu Jaya Abadi</div>
        <div class="period">
            @if($filterType === 'per_bulan' && !$monthInput)
                Periode: {{ \Carbon\Carbon::now()->startOfMonth()->format('d/m/Y') }} - {{ \Carbon\Carbon::now()->endOfMonth()->format('d/m/Y') }}
            @elseif($filterType === 'per_bulan' && $monthInput)
                Periode: {{ \Carbon\Carbon::create($year, $month, 1)->startOfMonth()->format('d/m/Y') }} - {{ \Carbon\Carbon::create($year, $month, 1)->endOfMonth()->format('d/m/Y') }}
            @elseif($filterType === 'per_tahun')
                Periode: 01/01/{{ $year }} - 31/12/{{ $year }}
            @elseif($startDate && $endDate)
                Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
            @else
                Periode: Semua Data
            @endif
        </div>
    </div>

    <!-- TABEL -->
    <table class="statement-table">
        <thead>
            <tr>
                <th>KETERANGAN</th>
                <th class="text-right" style="width: 35%;">JUMLAH (RP)</th>
            </tr>
        </thead>
        <tbody>
            <!-- PENDAPATAN -->
            <tr class="section-header">
                <td colspan="2">PENDAPATAN</td>
            </tr>
            @foreach($revenue_details as $item)
            <tr class="item-row">
                <td class="account-code">{{ $item['name'] }}</td>
                <td class="text-right">{{ number_format($item['amount'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td>TOTAL PENDAPATAN</td>
                <td class="text-right" style="border-bottom: 2pt double #000;">{{ number_format($total_revenue, 0, ',', '.') }}</td>
            </tr>

            <tr><td colspan="2" style="padding: 2mm;"></td></tr>

            <!-- HPP -->
            <tr class="section-header">
                <td colspan="2">HARGA POKOK PENJUALAN (HPP)</td>
            </tr>
            @foreach($hpp_details as $item)
            <tr class="item-row">
                <td class="account-code">{{ $item['name'] }}</td>
                <td class="text-right">{{ number_format($item['amount'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td>TOTAL HPP</td>
                <td class="text-right" style="border-bottom: 2pt double #000;">{{ number_format($total_hpp, 0, ',', '.') }}</td>
            </tr>

            <tr><td colspan="2" style="padding: 2mm;"></td></tr>

            <!-- LABA KOTOR -->
            <tr class="subtotal-row">
                <td>LABA KOTOR (PENDAPATAN - HPP)</td>
                <td class="text-right">{{ number_format($gross_profit, 0, ',', '.') }}</td>
            </tr>

            <tr><td colspan="2" style="padding: 2mm;"></td></tr>

            <!-- BIAYA OPERASIONAL -->
            <tr class="section-header">
                <td colspan="2">BIAYA OPERASIONAL</td>
            </tr>
            @forelse($expense_details as $item)
            <tr class="item-row">
                <td class="account-code">{{ $item['name'] }}</td>
                <td class="text-right">{{ number_format($item['amount'], 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr class="item-row">
                <td colspan="2" style="text-align: center; padding: 5mm;">Tidak ada biaya operasional</td>
            </tr>
            @endforelse
            <tr class="total-row">
                <td>TOTAL BIAYA OPERASIONAL</td>
                <td class="text-right" style="border-bottom: 2pt double #000;">{{ number_format($total_expenses, 0, ',', '.') }}</td>
            </tr>

            <tr><td colspan="2" style="padding: 3mm;"></td></tr>

            <!-- LABA BERSIH -->
            <tr class="grand-total-row">
                <td>LABA BERSIH</td>
                <td class="text-right">{{ number_format($net_income, 0, ',', '.') }}</td>
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
