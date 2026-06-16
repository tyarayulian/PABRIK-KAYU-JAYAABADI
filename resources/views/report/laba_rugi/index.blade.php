@extends('layouts.app')

@section('title', 'Laporan Laba Rugi')
@section('breadcrumb', 'Laporan > Laba Rugi')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/print-report.css') }}?v={{ time() }}">
<style>
    * {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    html {
        scrollbar-gutter: stable;
    }

    .page-header {
        margin-bottom: 24px;
    }

    .page-header h1 {
        font-size: 24px;
        font-weight: 800;
        color: #1e2a78;
        margin: 0 0 4px 0;
        letter-spacing: -0.5px;
    }

    .page-header p {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }

    .statement-row.sub-total {
        font-weight: 800;
        font-size: 14px;
        color: #1e2a78;
        background: #f1f5f9;
        border-top: 1px solid #1e2a78;
        border-bottom: 1px solid #1e2a78;
        padding: 16px 32px;
        margin: 12px -32px;
    }

    .report-section {
        background: white;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .report-header-centered {
        text-align: center;
        padding: 50px 0 30px 0;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 20px;
    }

    .report-header-centered h1 {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .report-header-centered h1 span {
        color: #1e293b;
    }

    .report-header-centered .company-name {
        font-size: 15px;
        font-weight: 500;
        color: #475569;
        margin: 4px 0 2px 0;
    }

    .report-header-centered .period {
        font-size: 12px;
        color: #94a3b8;
        font-weight: 400;
    }

    .statement-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }

    .statement-table th {
        border-top: 2px solid #333;
        border-bottom: 1px solid #333;
        padding: 12px 0;
        text-align: left;
        font-weight: 700;
        color: #000;
    }

    .statement-row {
        border-bottom: 1px solid #eee;
    }

    .statement-row.main-category {
        font-weight: 700;
        background: #fff;
    }

    .statement-row.main-category td {
        padding: 12px 0 8px 0;
        font-size: 14px;
    }

    .statement-row.item td {
        padding: 8px 0 8px 30px;
        font-size: 14px;
        color: #333;
    }

    .statement-row.total-row {
        font-weight: 700;
        border-top: 1px solid #333;
    }

    .statement-row.total-row td {
        padding: 10px 0;
        font-size: 14px;
    }

    .statement-row.summary-bar {
        background: #f3f4f6;
        font-weight: 700;
        border-top: 1px solid #333;
        border-bottom: 1px solid #333;
    }

    .statement-row.summary-bar td {
        padding: 12px 10px;
        font-size: 14px;
        text-transform: uppercase;
    }

    .amount-cell {
        text-align: right;
    }

    .report-content {
        padding: 0 60px 40px 60px;
    }

    .filter-container {
        padding: 20px 60px;
        background: #ffffff;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .filter-group { display: flex; flex-direction: column; gap: 6px; }
    .filter-group label { font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-left: 2px; }
    .filter-group input { 
        padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; 
        font-weight: 500; color: #1e293b; background: #f8fafc; height: 36px; outline: none; 
    }

    .btn-reset-filter {
        background: #ffffff; color: #64748b; border: 1px solid #e2e8f0; padding: 0 16px; 
        height: 36px; border-radius: 8px; font-weight: 600; font-size: 13px; 
        cursor: pointer; display: flex; align-items: center; text-decoration: none;
    }

    .btn-outline {
        background: #fff; color: #1e2a78; border: 1px solid #e2e8f0; padding: 8px 16px; 
        border-radius: 8px; font-weight: 700; font-size: 12px; display: inline-flex; 
        align-items: center; gap: 8px; text-decoration: none;
        transition: all 0.2s;
    }

    .btn-outline:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .btn-outline i {
        font-size: 14px;
        color: #1e2a78;
    }

    .btn-filter-submit {
        background: #0f172a;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-filter-submit:hover {
        background: #1e293b; color: white;
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

        /* Hide filters and buttons */
        .filter-container {
            display: none !important;
        }

        .report-section {
            border: none;
            box-shadow: none;
            border-radius: 0;
        }

        /* Header */
        .report-header-centered {
            padding: 0 0 8mm 0 !important;
            margin-bottom: 5mm !important;
            border-bottom: 2px solid #000 !important;
        }

        .report-header-centered h1 {
            font-size: 16pt !important;
        }

        /* Content padding */
        .report-content {
            padding: 0 !important;
        }

        /* Table */
        .statement-table {
            font-size: 10pt;
        }

        .statement-table th {
            font-size: 9pt !important;
            padding: 3mm 0 !important;
            border-top: 2px solid #000 !important;
            border-bottom: 1px solid #000 !important;
            color: #000 !important;
        }

        .statement-row.main-category td {
            font-size: 10pt !important;
            font-weight: 700 !important;
            padding: 4mm 0 2mm 0 !important;
            color: #000 !important;
        }

        .statement-row.item td {
            font-size: 9pt !important;
            padding: 2mm 0 2mm 8mm !important;
            color: #000 !important;
        }

        .statement-row.summary-bar {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            background: #f3f4f6 !important;
            padding: 3mm 3mm !important;
        }

        .statement-row.summary-bar td {
            font-size: 11pt !important;
            font-weight: 700 !important;
            padding: 3mm !important;
        }

        /* Grand total dengan background hitam */
        .statement-row.summary-bar[style*="background: #1e2a78"] {
            background: #000 !important;
            color: #fff !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .statement-row.summary-bar[style*="background: #1e2a78"] td {
            color: #fff !important;
            font-size: 12pt !important;
            font-weight: 800 !important;
        }

        /* Amount alignment */
        .amount-cell {
            font-family: 'Courier New', monospace !important;
            text-align: right !important;
            font-weight: 600 !important;
        }

        /* Page break control */
        .statement-row {
            page-break-inside: avoid;
        }

        .statement-row.main-category {
            page-break-after: avoid;
        }
    }

    .empty-state {
        padding: 80px 48px;
        text-align: center;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 56px;
        margin-bottom: 20px;
        display: block;
        color: #e2e8f0;
    }


</style>
@endsection

@section('content')
    <div class="report-section">
        <!-- FILTER CONTAINER -->
        <div class="filter-container">
            <form method="GET" action="{{ route('report.income-statement') }}" style="display: flex; align-items: flex-end; gap: 12px; flex: 1; flex-wrap: wrap;">
                <input type="hidden" name="filter_type" value="custom">
                
                <div class="filter-group">
                    <label>MULAI</label>
                    <input type="date" name="start_date" value="{{ $startDate ? \Carbon\Carbon::parse($startDate)->format('Y-m-d') : '' }}" class="form-control" style="height: 36px; padding: 0 12px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 13px;">
                </div>

                <div class="filter-group">
                    <label>HINGGA</label>
                    <input type="date" name="end_date" value="{{ $endDate ? \Carbon\Carbon::parse($endDate)->format('Y-m-d') : '' }}" class="form-control" style="height: 36px; padding: 0 12px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 13px;">
                </div>

                <div style="display: flex; gap: 8px;">
                    <button type="submit" class="btn-filter-submit" style="height: 36px; padding: 0 20px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-filter"></i> Terapkan
                    </button>
                    <a href="{{ route('report.income-statement') }}" class="btn-reset-filter" style="height: 36px; padding: 0 20px; display: flex; align-items: center;">Reset</a>
                </div>
            </form>
            <div style="display: flex; gap: 8px; margin-left: 12px;">
                <button type="button" onclick="window.print()" class="btn-outline" style="height: 36px; padding: 0 16px; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-print"></i> PDF
                </button>
                <a href="{{ route('report.income-statement', array_merge(request()->all(), ['export' => 'excel'])) }}" class="btn-outline" style="height: 36px; padding: 0 16px; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-file-excel"></i> Excel
                </a>
            </div>
        </div>

        <div class="report-header-centered">
            <h1>LABA RUGI</h1>
            <div class="company-name" style="font-size: 18px; font-weight: 800; color: #1e293b; text-transform: uppercase; margin-top: 5px;">Pabrik Kayu Jaya Abadi</div>
            <div class="period" style="font-size: 14px; color: #64748b; font-weight: 500; margin-top: 8px;">
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

        <div class="report-content">
            @if(count($revenue_details) > 0 || count($hpp_details) > 0 || count($expense_details) > 0)
                <table class="statement-table">
                    <thead>
                        <tr>
                            <th>KETERANGAN</th>
                            <th style="text-align: right;">JUMLAH (RP)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- PENDAPATAN -->
                        <tr class="statement-row main-category">
                            <td colspan="2">PENDAPATAN</td>
                        </tr>
                        @foreach($revenue_details as $item)
                        <tr class="statement-row item">
                            <td>{{ $item['name'] }}</td>
                            <td class="amount-cell">{{ number_format($item['amount'], 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                        <tr class="statement-row item" style="font-weight: 700;">
                            <td style="padding-left: 60px;">TOTAL PENDAPATAN</td>
                            <td class="amount-cell" style="border-top: 1px solid #333; border-bottom: 2px double #333;">{{ number_format($total_revenue, 0, ',', '.') }}</td>
                        </tr>

                        <!-- HPP -->
                        <tr class="statement-row main-category" style="padding-top: 20px;">
                            <td colspan="2">HARGA POKOK PENJUALAN (HPP)</td>
                        </tr>
                        @foreach($hpp_details as $item)
                        <tr class="statement-row item">
                            <td>{{ $item['name'] }}</td>
                            <td class="amount-cell">{{ number_format($item['amount'], 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                        <tr class="statement-row item" style="font-weight: 700;">
                            <td style="padding-left: 60px;">TOTAL HPP</td>
                            <td class="amount-cell" style="border-top: 1px solid #333; border-bottom: 2px double #333;">{{ number_format($total_hpp, 0, ',', '.') }}</td>
                        </tr>

                        <!-- LABA KOTOR -->
                        <tr class="statement-row summary-bar">
                            <td>LABA KOTOR (PENDAPATAN - HPP)</td>
                            <td class="amount-cell">{{ number_format($gross_profit, 0, ',', '.') }}</td>
                        </tr>

                        <!-- BIAYA OPERASIONAL -->
                        <tr class="statement-row main-category" style="padding-top: 20px;">
                            <td colspan="2">BIAYA OPERASIONAL</td>
                        </tr>
                        @foreach($expense_details as $item)
                        <tr class="statement-row item">
                            <td>{{ $item['name'] }}</td>
                            <td class="amount-cell">{{ number_format($item['amount'], 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                        <tr class="statement-row item" style="font-weight: 700;">
                            <td style="padding-left: 60px;">TOTAL BIAYA OPERASIONAL</td>
                            <td class="amount-cell" style="border-top: 1px solid #333; border-bottom: 2px double #333;">{{ number_format($total_expenses, 0, ',', '.') }}</td>
                        </tr>

                        <!-- LABA BERSIH -->
                        <tr class="statement-row summary-bar" style="background: #1e2a78; color: white;">
                            <td>LABA BERSIH</td>
                            <td class="amount-cell" style="color: white;">{{ number_format($net_income, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <h3>Tidak ada data untuk periode ini</h3>
                    <p>Silakan pilih periode lain atau pastikan sudah ada transaksi yang tercatat.</p>
                </div>
            @endif
        </div>
    </div>

@endsection
