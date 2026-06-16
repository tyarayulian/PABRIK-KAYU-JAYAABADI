<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal Umum - {{ $startDate ? $startDate->format('d/m/Y') : '' }} s/d {{ $endDate ? $endDate->format('d/m/Y') : '' }}</title>
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

        /* TABEL JURNAL */
        .journal-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5mm;
        }

        .journal-table thead th {
            background: #f5f5f5;
            border: 1pt solid #000;
            padding: 2mm;
            font-size: 8pt;
            font-weight: bold;
            text-align: left;
            text-transform: uppercase;
        }

        .journal-table thead th.text-center {
            text-align: center;
        }

        .journal-table thead th.text-right {
            text-align: right;
        }

        .journal-table tbody td {
            border: 0.5pt solid #999;
            padding: 1.5mm 2mm;
            font-size: 9pt;
            vertical-align: top;
        }

        .journal-table tbody td.text-center {
            text-align: center;
            font-weight: bold;
        }

        .journal-table tbody td.text-right {
            text-align: right;
            font-family: 'Courier New', monospace;
        }

        .journal-table tbody td.account-code {
            font-size: 8pt;
            color: #666;
        }

        /* FOOTER TOTALS */
        .totals-section {
            margin-top: 5mm;
            padding-top: 3mm;
            border-top: 2pt solid #000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .totals-section .status {
            font-size: 9pt;
            font-weight: bold;
        }

        .totals-section .status.balanced {
            color: #000;
        }

        .totals-section .amounts {
            display: flex;
            gap: 8mm;
        }

        .totals-section .amount-item {
            text-align: right;
        }

        .totals-section .amount-label {
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 1mm;
        }

        .totals-section .amount-value {
            font-size: 11pt;
            font-weight: bold;
            font-family: 'Courier New', monospace;
        }

        /* PAGE BREAKS */
        thead {
            display: table-header-group;
        }

        tr {
            page-break-inside: avoid;
        }

        /* EMPTY ROW for spacing */
        .journal-table tbody tr.empty-row td {
            border: none;
            padding: 1mm;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <div class="report-header">
        <h1>JURNAL UMUM</h1>
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
    <table class="journal-table">
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">No</th>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 35%;">Nama Akun</th>
                <th style="width: 10%;">Ref</th>
                <th style="width: 19%;" class="text-right">Debit (Rp)</th>
                <th style="width: 19%;" class="text-right">Kredit (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($journals as $group)
                @foreach($group['entries'] as $entry)
                    <tr>
                        @if($loop->first)
                            <td class="text-center">{{ ($journals->currentPage() - 1) * $journals->perPage() + $loop->parent->iteration }}</td>
                            <td>
                                {{ $group['date']->format('d/m/Y') }}<br>
                                <span style="font-size: 8pt; color: #666;">{{ $group['date']->format('H:i') }}</span>
                            </td>
                        @else
                            <td></td>
                            <td></td>
                        @endif
                        <td>
                            <strong>{{ $entry->account->name }}</strong><br>
                            <span class="account-code">{{ $entry->account->code }}</span>
                        </td>
                        @if($loop->first)
                            <td style="font-weight: bold;">{{ $group['reference'] ?? '-' }}</td>
                        @else
                            <td></td>
                        @endif
                        <td class="text-right">
                            {{ $entry->type == 'debit' ? number_format($entry->amount, 0, ',', '.') : '-' }}
                        </td>
                        <td class="text-right">
                            {{ $entry->type == 'credit' ? number_format($entry->amount, 0, ',', '.') : '-' }}
                        </td>
                    </tr>
                @endforeach
                <!-- Spacing between transactions -->
                @if(!$loop->last)
                    <tr class="empty-row">
                        <td colspan="6"></td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 10mm;">
                        Tidak ada data jurnal untuk periode ini
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TOTALS -->
    <div class="totals-section">
        <div class="status {{ $totalDebit == $totalCredit ? 'balanced' : 'unbalanced' }}">
            STATUS: {{ $totalDebit == $totalCredit ? '✓ BALANCE' : '✗ UNBALANCED' }}
        </div>
        <div class="amounts">
            <div class="amount-item">
                <div class="amount-label">Total Debit</div>
                <div class="amount-value">{{ number_format($totalDebit, 0, ',', '.') }}</div>
            </div>
            <div class="amount-item">
                <div class="amount-label">Total Kredit</div>
                <div class="amount-value">{{ number_format($totalCredit, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <!-- Auto print on load -->
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
