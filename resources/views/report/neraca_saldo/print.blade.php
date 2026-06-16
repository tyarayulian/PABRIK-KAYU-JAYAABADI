<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neraca Saldo - {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : '' }} s/d {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : '' }}</title>
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

        /* TABEL NERACA SALDO */
        .trial-balance-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5mm;
        }

        .trial-balance-table thead th {
            background: #f5f5f5;
            border: 1pt solid #000;
            padding: 2mm;
            font-size: 8pt;
            font-weight: bold;
            text-align: left;
            text-transform: uppercase;
        }

        .trial-balance-table thead th.text-right {
            text-align: right;
        }

        .trial-balance-table tbody td {
            border: 0.5pt solid #999;
            padding: 1.5mm 2mm;
            font-size: 9pt;
            vertical-align: top;
        }

        .trial-balance-table tbody td.account-code {
            font-weight: bold;
        }

        .trial-balance-table tbody td.text-right {
            text-align: right;
            font-family: 'Courier New', monospace;
        }

        .trial-balance-table tfoot td {
            background: #f5f5f5;
            border: 1pt solid #000;
            border-top: 2pt solid #000;
            padding: 3mm 2mm;
            font-size: 10pt;
            font-weight: bold;
        }

        .trial-balance-table tfoot td.text-right {
            text-align: right;
            font-family: 'Courier New', monospace;
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
        <h1>NERACA SALDO</h1>
        <div class="company-name">Pabrik Kayu Jaya Abadi</div>
        <div class="period">
            @if($filterType === 'per_bulan' && !request('month'))
                Periode: {{ \Carbon\Carbon::now()->startOfMonth()->format('d/m/Y') }} - {{ \Carbon\Carbon::now()->endOfMonth()->format('d/m/Y') }}
            @elseif($filterType === 'per_bulan' && request('month'))
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
    @if(count($trialBalance) > 0)
        <table class="trial-balance-table">
            <thead>
                <tr>
                    <th style="width: 15%;">Kode Akun</th>
                    <th style="width: 45%;">Nama Akun</th>
                    <th style="width: 20%;" class="text-right">Debit (Rp)</th>
                    <th style="width: 20%;" class="text-right">Kredit (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trialBalance as $category => $accounts)
                    @foreach($accounts as $account)
                        <tr>
                            <td class="account-code">{{ $account['code'] }}</td>
                            <td>{{ $account['name'] }}</td>
                            <td class="text-right">
                                {{ $account['debit'] > 0 ? number_format($account['debit'], 0, ',', '.') : '-' }}
                            </td>
                            <td class="text-right">
                                {{ $account['credit'] > 0 ? number_format($account['credit'], 0, ',', '.') : '-' }}
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="text-align: right; text-transform: uppercase;">TOTAL</td>
                    <td class="text-right">{{ number_format($totalDebit, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($totalCredit, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- STATUS -->
        <div class="status-bar">
            @if(abs($totalDebit - $totalCredit) < 0.01)
                STATUS: ✓ BALANCE (Debit = Kredit)
            @else
                STATUS: ✗ UNBALANCED (Selisih: Rp {{ number_format(abs($totalDebit - $totalCredit), 0, ',', '.') }})
            @endif
        </div>
    @else
        <div style="text-align: center; padding: 20mm;">
            Tidak ada data neraca saldo untuk periode ini
        </div>
    @endif

    <!-- Auto print on load -->
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
