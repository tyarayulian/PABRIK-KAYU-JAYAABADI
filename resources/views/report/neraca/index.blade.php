@extends('layouts.app')

@section('title', 'Neraca')

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

    .neraca-container {
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
        background: #0f172a; color: white; border: none; padding: 0 16px; height: 36px; 
        border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; 
        display: flex; align-items: center; gap: 6px;
    }

    .btn-reset-filter {
        background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; padding: 0 12px; 
        height: 36px; border-radius: 8px; font-weight: 600; font-size: 13px; 
        cursor: pointer; display: flex; align-items: center; text-decoration: none;
    }

    .btn-outline {
        background: #fff; color: #1e2a78; border: 1px solid #e2e8f0; padding: 8px 16px; 
        border-radius: 8px; font-weight: 700; font-size: 12px; display: inline-flex; 
        align-items: center; gap: 8px; text-decoration: none;
    }

    .neraca-table { width: 100%; border-collapse: collapse; }
    .neraca-table th { 
        padding: 12px 20px; text-align: left; font-weight: 800; color: #475569; 
        font-size: 10px; text-transform: uppercase; background: white; border-bottom: 1px solid #f1f5f9; 
        letter-spacing: 0.05em;
    }
    .neraca-table td { padding: 14px 20px; border-bottom: 1px solid #f8fafc; font-size: 13px; vertical-align: top; }

    .section-header {
        background: #1e2a78 !important;
        font-weight: 800;
        text-transform: uppercase;
    }

    .section-header td {
        color: white !important;
        font-size: 11px;
        letter-spacing: 0.1em;
        padding: 12px 20px !important;
    }

    .subsection-header {
        background: #f1f5f9 !important;
        font-weight: 700;
    }

    .subsection-header td {
        font-size: 12px;
        letter-spacing: 0.05em;
        padding: 10px 20px !important;
        color: #1e293b;
    }

    .item-row td {
        padding-left: 40px !important;
    }

    .total-row {
        background: #f8fafc;
        font-weight: 800;
    }

    .total-row td {
        border-top: 2px solid #1e2a78 !important;
        padding: 14px 20px !important;
        font-size: 14px;
    }

    .grand-total-row {
        background: #1e2a78 !important;
        font-weight: 800;
    }

    .grand-total-row td {
        color: white !important;
        border-top: 3px double #1e2a78 !important;
        padding: 16px 20px !important;
        font-size: 15px;
        letter-spacing: 0.02em;
    }

    .amount { 
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700; 
        text-align: right; 
        font-size: 14px;
        letter-spacing: -0.01em;
    }

    .balance-status {
        padding: 20px 24px; 
        background: #ffffff; 
        border-top: 1px solid #f1f5f9; 
        display: flex; 
        justify-content: center; 
        align-items: center;
        gap: 12px;
    }

    .balance-status .status-label {
        font-size: 10px;
        font-weight: 800;
        color: #94a3b8;
        text-transform: uppercase;
    }

    .balance-status .status-value {
        font-weight: 800;
        font-size: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Additional print customizations beyond the standard print-report.css */
    @media print {
        @page {
            size: A4 portrait;
            margin: 15mm 10mm;
        }

        body {
            background: white !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Hide filters */
        .filter-row {
            display: none !important;
        }

        .neraca-container {
            max-width: 100%;
            padding: 0;
        }

        .table-section {
            border: none;
            box-shadow: none;
            border-radius: 0;
        }

        /* Header */
        .table-section > div:first-child {
            padding: 0 0 8mm 0 !important;
            margin-bottom: 5mm !important;
            border-bottom: 2px solid #000 !important;
        }

        .table-section h1 {
            font-size: 16pt !important;
        }

        /* Table */
        .neraca-table {
            font-size: 9pt !important;
        }

        .neraca-table th {
            font-size: 8pt !important;
            padding: 3mm 2mm !important;
            background: #f5f5f5 !important;
            border: 1px solid #000 !important;
            color: #000 !important;
            -webkit-print-color-adjust: exact !important;
        }

        .neraca-table td {
            padding: 2mm !important;
            font-size: 9pt !important;
            border: 1px solid #ddd !important;
            color: #000 !important;
        }

        /* Section headers (Aktiva, Kewajiban, Ekuitas) */
        .section-header {
            background: #000 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            border-top: 2px solid #000 !important;
            border-bottom: 1px solid #000 !important;
        }
        
        .section-header td {
            color: white !important;
            font-weight: 800 !important;
            padding: 3mm !important;
            font-size: 10pt !important;
        }

        /* Subtotal rows */
        .subtotal-row {
            background: #f5f5f5 !important;
            -webkit-print-color-adjust: exact !important;
            font-weight: 700 !important;
            border-top: 1px solid #000 !important;
        }

        /* Grand total */
        .grand-total-row {
            background: #000 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            border-top: 2px solid #000 !important;
            border-bottom: 2px solid #000 !important;
        }
        
        .grand-total-row td {
            color: white !important;
            font-weight: 800 !important;
            padding: 3mm !important;
            font-size: 11pt !important;
        }

        /* Amount alignment */
        .amount {
            font-family: 'Courier New', monospace !important;
            text-align: right !important;
            font-weight: 600 !important;
        }

        /* Page breaks */
        .section-header {
            page-break-after: avoid;
        }

        tr {
            page-break-inside: avoid;
        }

        /* Remove colors */
        .text-positive,
        .text-negative {
            color: #000 !important;
        }
    }
</style>
@endsection

@section('content')
<div class="neraca-container">
    <div class="table-section">
        <div style="text-align: center; padding: 50px 24px 30px 24px; border-bottom: 1px solid #f1f5f9; margin-bottom: 20px;">
            <h1 style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0; letter-spacing: -0.5px;">NERACA</h1>
            <div style="font-size: 18px; font-weight: 800; color: #1e293b; text-transform: uppercase; margin-top: 5px;">Pabrik Kayu Jaya Abadi</div>
            <div style="font-size: 14px; color: #64748b; font-weight: 500; margin-top: 8px;">
                Per Tanggal: {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}
            </div>
        </div>

        <div class="filter-row">
            <form method="GET" action="{{ route('report.neraca') }}" style="display: flex; gap: 12px; flex: 1; align-items: flex-end;">
                <div class="filter-group">
                    <label>TANGGAL NERACA</label>
                    <input type="date" name="end_date" value="{{ $endDate ? \Carbon\Carbon::parse($endDate)->format('Y-m-d') : '' }}">
                </div>
                <div style="display: flex; gap: 8px;">
                    <button type="submit" class="btn-filter" style="height: 36px; padding: 0 20px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter"></i> Terapkan
                    </button>
                    <a href="{{ route('report.neraca') }}" class="btn-reset-filter" style="height: 36px; padding: 0 20px; display: flex; align-items: center;">Reset</a>
                </div>
            </form>
            <div style="display: flex; gap: 8px; margin-left: 12px;">
                <button type="button" onclick="window.print()" class="btn-outline" style="height: 36px; padding: 0 16px; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-print"></i> PDF
                </button>
                <a href="{{ route('report.neraca.export', request()->all()) }}" class="btn-outline" style="height: 36px; padding: 0 16px; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-file-excel"></i> Excel
                </a>
            </div>
        </div>

        <table class="neraca-table">
            <thead>
                <tr>
                    <th style="width: 150px;">KODE</th>
                    <th>NAMA AKUN</th>
                    <th style="width: 220px; text-align: right;">SALDO (RP)</th>
                </tr>
            </thead>
            <tbody>
                <!-- AKTIVA (ASSETS) -->
                <tr class="section-header">
                    <td colspan="3">AKTIVA</td>
                </tr>
                @forelse($assets as $asset)
                    <tr class="item-row">
                        <td style="font-weight: 700;">{{ $asset['code'] }}</td>
                        <td>{{ $asset['name'] }}</td>
                        <td class="amount">{{ number_format($asset['balance'], 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr class="item-row">
                        <td colspan="3" style="text-align: center; color: #94a3b8; padding: 32px;">Tidak ada data aktiva</td>
                    </tr>
                @endforelse
                <tr class="total-row">
                    <td colspan="2">TOTAL AKTIVA</td>
                    <td class="amount">Rp {{ number_format($totalAssets, 0, ',', '.') }}</td>
                </tr>

                <!-- Spacer row -->
                <tr style="height: 16px; border: none;">
                    <td colspan="3" style="border: none;"></td>
                </tr>

                <!-- KEWAJIBAN & EKUITAS -->
                <tr class="section-header">
                    <td colspan="3">KEWAJIBAN & EKUITAS</td>
                </tr>

                <!-- KEWAJIBAN (LIABILITIES) -->
                <tr class="subsection-header">
                    <td colspan="3">KEWAJIBAN</td>
                </tr>
                @forelse($liabilities as $liability)
                    <tr class="item-row">
                        <td style="font-weight: 700;">{{ $liability['code'] }}</td>
                        <td>{{ $liability['name'] }}</td>
                        <td class="amount">{{ number_format($liability['balance'], 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr class="item-row">
                        <td colspan="3" style="text-align: center; color: #94a3b8; padding: 32px;">Tidak ada data kewajiban</td>
                    </tr>
                @endforelse
                <tr class="total-row">
                    <td colspan="2">TOTAL KEWAJIBAN</td>
                    <td class="amount">Rp {{ number_format($totalLiabilities, 0, ',', '.') }}</td>
                </tr>

                <!-- EKUITAS (EQUITY) -->
                <tr class="subsection-header">
                    <td colspan="3">EKUITAS</td>
                </tr>
                @forelse($equity as $eq)
                    <tr class="item-row">
                        <td style="font-weight: 700;">{{ $eq['code'] }}</td>
                        <td>{{ $eq['name'] }}</td>
                        <td class="amount">{{ number_format($eq['balance'], 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr class="item-row">
                        <td colspan="3" style="text-align: center; color: #94a3b8; padding: 32px;">Tidak ada data ekuitas</td>
                    </tr>
                @endforelse
                <tr class="item-row">
                    <td style="font-weight: 700;">-</td>
                    <td>Laba Tahun Berjalan</td>
                    <td class="amount">{{ number_format($currentYearProfit, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="2">TOTAL EKUITAS</td>
                    <td class="amount">Rp {{ number_format($totalEquity, 0, ',', '.') }}</td>
                </tr>

                <!-- GRAND TOTAL -->
                <tr class="grand-total-row">
                    <td colspan="2">TOTAL KEWAJIBAN & EKUITAS</td>
                    <td class="amount">Rp {{ number_format($totalLiabilitiesAndEquity, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="balance-status">
            <div class="status-label">STATUS NERACA:</div>
            @if(abs($totalAssets - $totalLiabilitiesAndEquity) < 0.01)
                <div class="status-value" style="color: #059669;">
                    <i class="fas fa-check-circle"></i> BALANCE (Aktiva = Kewajiban + Ekuitas)
                </div>
            @else
                <div class="status-value" style="color: #e11d48;">
                    <i class="fas fa-times-circle"></i> UNBALANCED (Selisih: Rp {{ number_format(abs($totalAssets - $totalLiabilitiesAndEquity), 0, ',', '.') }})
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
