<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Besar - {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : '' }} s/d {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : '' }}</title>
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

        /* ACCOUNT SECTION */
        .account-section {
            margin-bottom: 8mm;
            page-break-inside: avoid;
        }

        .account-header {
            background: #1e2a78;
            color: white;
            padding: 2mm 3mm;
            margin-bottom: 2mm;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .account-info {
            font-size: 10pt;
            font-weight: bold;
        }

        .account-type {
            font-size: 8pt;
            text-transform: uppercase;
        }

        /* TABEL BUKU BESAR */
        .ledger-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2mm;
        }

        .ledger-table thead th {
            background: #f5f5f5;
            border: 1pt solid #000;
            padding: 2mm;
            font-size: 8pt;
            font-weight: bold;
            text-align: left;
            text-transform: uppercase;
        }

        .ledger-table thead th.text-right {
            text-align: right;
        }

        .ledger-table tbody td {
            border: 0.5pt solid #999;
            padding: 1.5mm 2mm;
            font-size: 9pt;
            vertical-align: top;
        }

        .ledger-table tbody td.text-right {
            text-align: right;
            font-family: 'Courier New', monospace;
        }

        .ledger-table tbody tr.beginning-balance td {
            font-weight: bold;
            background: #f9f9f9;
        }

        .ledger-table tfoot td {
            background: #f5f5f5;
            border: 1pt solid #000;
            padding: 2mm;
            font-size: 9pt;
            font-weight: bold;
        }

        .ledger-table tfoot td.text-right {
            text-align: right;
            font-family: 'Courier New', monospace;
        }

        .ledger-table tfoot tr.final-balance td {
            background: #1e2a78;
            color: white;
            font-weight: bold;
        }

        /* PAGE BREAKS */
        .account-section {
            page-break-after: always;
        }

        .account-section:last-child {
            page-break-after: auto;
        }

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
        <h1>BUKU BESAR</h1>
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

    <!-- ACCOUNT SECTIONS -->
    @forelse($ledgerData as $data)
        <div class="account-section">
            <div class="account-header">
                <div class="account-info">
                    {{ $data['account']->code }} - {{ $data['account']->name }}
                </div>
                <div class="account-type">
                    {{ $data['account']->type }}
                </div>
            </div>

            <table class="ledger-table">
                <thead>
                    <tr>
                        <th style="width: 12%;">Tanggal</th>
                        <th style="width: 38%;">Keterangan</th>
                        <th style="width: 10%;">Ref</th>
                        <th style="width: 13%;" class="text-right">Debit (Rp)</th>
                        <th style="width: 13%;" class="text-right">Kredit (Rp)</th>
                        <th style="width: 14%;" class="text-right">Saldo (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- SALDO AWAL -->
                    <tr class="beginning-balance">
                        <td>
                            @if($startDate)
                                {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }}
                            @elseif(count($data['transactions']) > 0)
                                {{ $data['transactions'][0]['journal']->journal_date->format('d/m/Y') }}
                            @endif
                        </td>
                        <td><strong>Saldo Awal</strong></td>
                        <td>-</td>
                        <td class="text-right">-</td>
                        <td class="text-right">-</td>
                        <td class="text-right"><strong>{{ number_format($data['beginning_balance'], 0, ',', '.') }}</strong></td>
                    </tr>

                    <!-- TRANSACTIONS -->
                    @foreach($data['transactions'] as $transaction)
                        <tr>
                            <td>{{ $transaction['journal']->journal_date->format('d/m/Y') }}</td>
                            <td>{{ $transaction['journal']->description ?: $data['account']->name }}</td>
                            <td style="font-size: 8pt;">{{ $transaction['journal']->reference ?? '-' }}</td>
                            <td class="text-right">
                                @if($transaction['journal']->type === 'debit')
                                    {{ number_format($transaction['journal']->amount, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-right">
                                @if($transaction['journal']->type === 'credit')
                                    {{ number_format($transaction['journal']->amount, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-right">{{ number_format($transaction['balance'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <!-- TOTAL MUTASI -->
                    <tr>
                        <td colspan="3" style="text-align: right; text-transform: uppercase;">Total Mutasi</td>
                        <td class="text-right">{{ number_format($data['debit_total'], 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($data['credit_total'], 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                    <!-- SALDO AKHIR -->
                    <tr class="final-balance">
                        <td colspan="5" style="text-align: right; text-transform: uppercase;">Saldo Akhir</td>
                        <td class="text-right">{{ number_format($data['final_balance'], 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @empty
        <div style="text-align: center; padding: 20mm;">
            Tidak ada data buku besar untuk periode ini
        </div>
    @endforelse

    <!-- Auto print on load -->
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
