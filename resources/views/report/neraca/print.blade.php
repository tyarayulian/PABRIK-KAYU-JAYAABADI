<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neraca - Per {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d F Y') : '' }}</title>
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

        /* TABEL NERACA */
        .balance-sheet-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5mm;
        }

        .balance-sheet-table thead th {
            background: #f5f5f5;
            border: 1pt solid #000;
            padding: 2mm;
            font-size: 8pt;
            font-weight: bold;
            text-align: left;
            text-transform: uppercase;
        }

        .balance-sheet-table thead th.text-right {
            text-align: right;
        }

        .balance-sheet-table tbody tr.section-header td {
            background: #1e2a78;
            color: white;
            border: 1pt solid #000;
            padding: 2mm;
            font-size: 10pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .balance-sheet-table tbody tr.subsection-header td {
            background: #f0f0f0;
            border: 0.5pt solid #999;
            padding: 2mm;
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .balance-sheet-table tbody tr.item-row td {
            border: 0.5pt solid #999;
            padding: 1.5mm 2mm 1.5mm 8mm;
            font-size: 9pt;
        }

        .balance-sheet-table tbody tr.item-row td.account-code {
            font-weight: bold;
        }

        .balance-sheet-table tbody tr.item-row td.text-right {
            text-align: right;
            font-family: 'Courier New', monospace;
        }

        .balance-sheet-table tbody tr.total-row td {
            background: #f5f5f5;
            border: 1pt solid #000;
            border-top: 2pt solid #000;
            padding: 2mm;
            font-size: 10pt;
            font-weight: bold;
        }

        .balance-sheet-table tbody tr.total-row td.text-right {
            text-align: right;
            font-family: 'Courier New', monospace;
        }

        .balance-sheet-table tbody tr.grand-total-row td {
            background: #1e2a78;
            color: white;
            border: 2pt solid #000;
            padding: 3mm 2mm;
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .balance-sheet-table tbody tr.grand-total-row td.text-right {
            text-align: right;
            font-family: 'Courier New', monospace;
        }

        .balance-sheet-table tbody tr.spacer td {
            border: none;
            padding: 2mm;
        }

        /* STATUS BAR */
        .status-bar {
            margin-top: 5mm;
            padding-top: 3mm;
            border-top: 2pt solid #000;
            text-align: center;
            font-size: 10pt;
            font-weight: bold;
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
        <h1>NERACA</h1>
        <div class="company-name">Pabrik Kayu Jaya Abadi</div>
        <div class="period">
            Per Tanggal: {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}
        </div>
    </div>

    <!-- TABEL -->
    <table class="balance-sheet-table">
        <thead>
            <tr>
                <th style="width: 15%;">Kode</th>
                <th style="width: 55%;">Nama Akun</th>
                <th style="width: 30%;" class="text-right">Saldo (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <!-- AKTIVA -->
            <tr class="section-header">
                <td colspan="3">AKTIVA</td>
            </tr>
            @forelse($assets as $asset)
                <tr class="item-row">
                    <td class="account-code">{{ $asset['code'] }}</td>
                    <td>{{ $asset['name'] }}</td>
                    <td class="text-right">{{ number_format($asset['balance'], 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr class="item-row">
                    <td colspan="3" style="text-align: center; color: #666;">Tidak ada data aktiva</td>
                </tr>
            @endforelse
            <tr class="total-row">
                <td colspan="2" style="text-align: right;">TOTAL AKTIVA</td>
                <td class="text-right">{{ number_format($totalAssets, 0, ',', '.') }}</td>
            </tr>

            <!-- SPACER -->
            <tr class="spacer"><td colspan="3"></td></tr>

            <!-- KEWAJIBAN & EKUITAS -->
            <tr class="section-header">
                <td colspan="3">KEWAJIBAN & EKUITAS</td>
            </tr>

            <!-- KEWAJIBAN -->
            <tr class="subsection-header">
                <td colspan="3">KEWAJIBAN</td>
            </tr>
            @forelse($liabilities as $liability)
                <tr class="item-row">
                    <td class="account-code">{{ $liability['code'] }}</td>
                    <td>{{ $liability['name'] }}</td>
                    <td class="text-right">{{ number_format($liability['balance'], 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr class="item-row">
                    <td colspan="3" style="text-align: center; color: #666;">Tidak ada data kewajiban</td>
                </tr>
            @endforelse
            <tr class="total-row">
                <td colspan="2" style="text-align: right;">TOTAL KEWAJIBAN</td>
                <td class="text-right">{{ number_format($totalLiabilities, 0, ',', '.') }}</td>
            </tr>

            <!-- EKUITAS -->
            <tr class="subsection-header">
                <td colspan="3">EKUITAS</td>
            </tr>
            @forelse($equity as $eq)
                <tr class="item-row">
                    <td class="account-code">{{ $eq['code'] }}</td>
                    <td>{{ $eq['name'] }}</td>
                    <td class="text-right">{{ number_format($eq['balance'], 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr class="item-row">
                    <td colspan="3" style="text-align: center; color: #666;">Tidak ada data ekuitas</td>
                </tr>
            @endforelse
            <tr class="item-row">
                <td class="account-code">-</td>
                <td>Laba Tahun Berjalan</td>
                <td class="text-right">{{ number_format($currentYearProfit, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="2" style="text-align: right;">TOTAL EKUITAS</td>
                <td class="text-right">{{ number_format($totalEquity, 0, ',', '.') }}</td>
            </tr>

            <!-- GRAND TOTAL -->
            <tr class="grand-total-row">
                <td colspan="2">TOTAL KEWAJIBAN & EKUITAS</td>
                <td class="text-right">{{ number_format($totalLiabilitiesAndEquity, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <!-- STATUS -->
    <div class="status-bar">
        @if(abs($totalAssets - $totalLiabilitiesAndEquity) < 0.01)
            STATUS: ✓ BALANCE (Aktiva = Kewajiban + Ekuitas)
        @else
            STATUS: ✗ UNBALANCED (Selisih: Rp {{ number_format(abs($totalAssets - $totalLiabilitiesAndEquity), 0, ',', '.') }})
        @endif
    </div>

    <!-- Auto print on load -->
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
