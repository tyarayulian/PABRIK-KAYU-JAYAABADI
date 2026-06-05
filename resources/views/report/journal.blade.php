@extends('layouts.app')

@section('title', 'Jurnal Umum')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/print-report.css') }}?v={{ time() }}">
<style>
    * {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .main-content {
        background-color: transparent !important;
        box-shadow: none !important;
        border: none !important;
    }

    .journal-container {
        max-width: 1100px;
        margin: 0 auto;
        width: 100%;
        padding: 20px 0;
    }

    .table-section {
        background: white;
        border-radius: 12px;
        border: 1px solid #f0f0f0;
        overflow: hidden;
        margin-bottom: 30px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
    }

    .table-header-content {
        padding: 20px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #f8fafc;
    }

    .table-header-content h2 { font-size: 18px; font-weight: 800; color: #1e293b; margin: 0; }
    .table-header-content p { font-size: 12px; color: #64748b; margin: 2px 0 0 0; }

    .filter-row {
        display: flex;
        gap: 12px;
        align-items: flex-end;
        padding: 16px 24px;
        border-bottom: 1px solid #f8fafc;
        background: white;
    }

    .filter-group { display: flex; flex-direction: column; gap: 6px; }
    .filter-group label { font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-left: 2px; }
    .filter-group input { 
        padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; 
        font-weight: 500; color: #1e293b; background: #f8fafc; height: 36px; outline: none; 
    }

    .btn-filter {
        background: #1e2a78; color: white; border: none; padding: 0 16px; height: 36px; 
        border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; 
        display: flex; align-items: center; gap: 6px;
    }

    .btn-reset-filter {
        background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; padding: 0 12px; 
        height: 36px; border-radius: 8px; font-weight: 600; font-size: 13px; 
        cursor: pointer; display: flex; align-items: center; text-decoration: none;
    }

    .search-group { flex: 1; margin-left: auto; position: relative; }
    .search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 12px; }
    .search-input { 
        width: 100%; padding: 8px 12px 8px 36px; border: 1px solid #e2e8f0; border-radius: 8px; 
        font-size: 13px; font-weight: 500; background: #f8fafc; height: 36px; outline: none; 
    }

    .journal-table { width: 100%; border-collapse: collapse; }
    .journal-table th { 
        padding: 12px 20px; text-align: left; font-weight: 800; color: #475569; 
        font-size: 10px; text-transform: uppercase; background: white; border-bottom: 1px solid #f1f5f9; 
        letter-spacing: 0.05em;
    }
    .journal-table td { padding: 14px 20px; border-bottom: 1px solid #f8fafc; font-size: 13px; vertical-align: top; }

    .amount { 
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700; 
        text-align: right; 
        font-size: 14px;
        letter-spacing: -0.01em;
    }

    .text-debit { color: #059669; }
    .text-credit { color: #e11d48; }
    .text-null { color: #f1f5f9; }

    .status-bar .amount-value {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 16px;
        letter-spacing: -0.01em;
    }

    .btn-outline {
        background: #fff; color: #1e2a78; border: 1px solid #e2e8f0; padding: 8px 16px; 
        border-radius: 8px; font-weight: 700; font-size: 12px; display: inline-flex; 
        align-items: center; gap: 8px; text-decoration: none;
    }

    .status-bar {
        padding: 20px 24px; background: #ffffff; border-top: 1px solid #f1f5f9; 
        display: flex; justify-content: space-between; align-items: center;
    }

    /* ========================================
       PRINT STYLES - FORMAT JURNAL UMUM
       ======================================== */
    @media print {
        @page {
            size: A4 landscape;
            margin: 15mm 10mm;
        }

        * {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        body {
            background: white !important;
            overflow: hidden !important;
        }

        /* Hide non-essential elements */
        .filter-row,
        .pagination-container,
        .btn-outline,
        .btn-filter,
        .btn-reset-filter {
            display: none !important;
        }

        .journal-container {
            max-width: 100%;
            padding: 0;
            margin: 0;
        }

        .table-section {
            border: none;
            border-radius: 0;
            box-shadow: none;
            page-break-inside: avoid;
        }

        /* Header Laporan */
        .table-section > div:first-child {
            padding: 0 0 10mm 0 !important;
            margin-bottom: 5mm !important;
            border-bottom: 2px solid #000 !important;
        }

        .table-section h1 {
            font-size: 16pt !important;
            margin-bottom: 2mm !important;
        }

        /* Table Styling with clear borders */
        .journal-table {
            width: 100%;
            border-collapse: collapse !important;
            font-size: 9pt;
        }

        .journal-table thead {
            border-bottom: 2px solid #000;
        }

        .journal-table th {
            padding: 3mm 2mm !important;
            font-size: 8pt !important;
            font-weight: 700 !important;
            color: #000 !important;
            background: #f0f0f0 !important;
            border: 1px solid #000 !important;
        }

        .journal-table tbody tr {
            border-bottom: 1px solid #666 !important;
        }

        .journal-table td {
            padding: 2mm !important;
            font-size: 9pt !important;
            border-left: 1px solid #666 !important;
            border-right: 1px solid #666 !important;
            color: #000 !important;
        }

        /* First and last cell borders */
        .journal-table td:first-child {
            border-left: 1px solid #000 !important;
        }

        .journal-table td:last-child {
            border-right: 1px solid #000 !important;
        }

        /* Amounts in monospace for alignment */
        .amount {
            font-family: 'Courier New', monospace !important;
            font-size: 9pt !important;
            font-weight: 600 !important;
            color: #000 !important;
        }

        /* Status Bar - Show totals */
        .status-bar {
            padding: 5mm 0 !important;
            margin-top: 5mm !important;
            border-top: 2px solid #000 !important;
            background: white !important;
        }

        .status-bar .amount-value {
            font-family: 'Courier New', monospace !important;
            font-size: 11pt !important;
            color: #000 !important;
            font-weight: 700 !important;
        }

        /* Remove colors in print */
        .text-debit,
        .text-credit,
        .text-null {
            color: #000 !important;
        }

        /* Page breaks */
        tr {
            page-break-inside: avoid;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
        }

        /* Hide scrollbar */
        ::-webkit-scrollbar {
            display: none !important;
        }
    }
</style>
@endsection

@section('content')
<div class="journal-container">
    <div class="table-section">
        <div style="text-align: center; padding: 50px 24px 30px 24px; border-bottom: 1px solid #f1f5f9; margin-bottom: 20px;">
            <h1 style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0; letter-spacing: -0.5px;">JURNAL UMUM</h1>
            <div style="font-size: 18px; font-weight: 800; color: #1e293b; text-transform: uppercase; margin-top: 5px;">Pabrik Kayu Jaya Abadi</div>
            <div style="font-size: 14px; color: #64748b; font-weight: 500; margin-top: 8px;">
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

        <div class="filter-row">
            <form method="GET" action="{{ route('report.journal') }}" style="display: flex; gap: 12px; flex: 1; align-items: flex-end;">
                <input type="hidden" name="filter_type" value="custom">
                <div class="filter-group">
                    <label>MULAI</label>
                    <input type="date" name="start_date" value="{{ $startDate ? $startDate->format('Y-m-d') : '' }}">
                </div>
                <div class="filter-group">
                    <label>AKHIR</label>
                    <input type="date" name="end_date" value="{{ $endDate ? $endDate->format('Y-m-d') : '' }}">
                </div>
                <div style="display: flex; gap: 8px;">
                    <button type="submit" class="btn-filter" style="height: 36px; padding: 0 20px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter"></i> Terapkan
                    </button>
                    <a href="{{ route('report.journal') }}" class="btn-reset-filter" style="height: 36px; padding: 0 20px; display: flex; align-items: center;">Reset</a>
                </div>
            </form>
            <div style="display: flex; gap: 8px; margin-left: 12px;">
                <button type="button" onclick="window.print()" class="btn-outline" style="height: 36px; padding: 0 16px; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-print"></i> PDF
                </button>
                <a href="{{ route('report.journal.export', request()->all()) }}" class="btn-outline" style="height: 36px; padding: 0 16px; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-file-excel"></i> Excel
                </a>
            </div>
        </div>

        <table class="journal-table">
            <thead>
                <tr>
                    <th style="width: 60px; text-align: center;">NO</th>
                    <th style="width: 120px;">TANGGAL</th>
                    <th>AKUN</th>
                    <th style="width: 110px;">REF</th>
                    <th style="width: 160px; text-align: right;">DEBIT (RP)</th>
                    <th style="width: 160px; text-align: right;">KREDIT (RP)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($journals as $group)
                    @foreach($group['entries'] as $entry)
                        <tr>
                            @if($loop->first)
                                <td style="text-align: center; font-weight: 700; color: #1e293b;">{{ ($journals->currentPage() - 1) * $journals->perPage() + $loop->parent->iteration }}</td>
                                <td style="color: #64748b; font-weight: 500;">
                                    {{ $group['date']->format('d M Y') }}
                                    <div style="font-size: 11px; color: #94a3b8; margin-top: 2px;">{{ $group['date']->format('H:i') }}</div>
                                </td>
                            @else
                                <td></td><td></td>
                            @endif
                            <td>
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-weight: 600; color: #1e293b;">{{ $entry->account->name }}</span>
                                    <span style="font-size: 11px; color: #94a3b8;">{{ $entry->account->code }}</span>
                                </div>
                            </td>
                            @if($loop->first)
                                <td style="font-weight: 700; color: #1e293b;">{{ $group['reference'] ?? '-' }}</td>
                            @else
                                <td></td>
                            @endif
                            <td class="amount {{ $entry->type == 'debit' ? 'text-debit' : 'text-null' }}">
                                {{ $entry->type == 'debit' ? number_format($entry->amount, 0, ',', '.') : '-' }}
                            </td>
                            <td class="amount {{ $entry->type == 'credit' ? 'text-credit' : 'text-null' }}">
                                {{ $entry->type == 'credit' ? number_format($entry->amount, 0, ',', '.') : '-' }}
                            </td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="6" style="padding: 100px 0; text-align: center;">
                            <div style="color: #94a3b8;">
                                <i class="fas fa-folder-open" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3;"></i>
                                <p>Tidak ada data jurnal untuk periode ini.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="status-bar">
            <div>
                <div style="font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 4px;">STATUS</div>
                @if($totalDebit == $totalCredit)
                    <div style="color: #059669; font-weight: 800; font-size: 14px; display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-check-circle"></i> BALANCE
                    </div>
                @else
                    <div style="color: #e11d48; font-weight: 800; font-size: 14px; display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-times-circle"></i> UNBALANCED
                    </div>
                @endif
            </div>
            <div style="display: flex; gap: 40px;">
                <div style="display: flex; flex-direction: column; align-items: flex-end;">
                    <span style="font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 4px;">TOTAL DEBIT</span>
                    <span class="amount-value" style="color: #059669;">{{ number_format($totalDebit, 0, ',', '.') }}</span>
                </div>
                <div style="display: flex; flex-direction: column; align-items: flex-end;">
                    <span style="font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 4px;">TOTAL KREDIT</span>
                    <span class="amount-value" style="color: #e11d48;">{{ number_format($totalCredit, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        @if($journals->hasPages())
            <div class="pagination-container" style="padding: 30px; border-top: 1px solid #f1f5f9;">
                {{ $journals->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
</div>
@endsection
