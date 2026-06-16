@extends('layouts.app')

@section('title', 'Laporan Arus Kas')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/print-report.css') }}?v={{ time() }}">
<style>
    :root {
        --primary-navy: #1e2a78;
        --secondary-navy: #2a3bb1;
        --bg-light: #f8fafc;
        --border-color: #e2e8f0;
        --text-main: #1e293b;
        --text-muted: #64748b;
    }

    * {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: var(--bg-light);
        color: var(--text-main);
    }

    .header-section {
        background: white;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        margin-bottom: 24px;
        overflow: hidden;
    }

    .table-title-section {
        padding: 32px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: white;
        border-bottom: 1px solid var(--border-color);
    }

    .report-title {
        font-size: 24px;
        font-weight: 800;
        color: var(--primary-navy);
        margin: 0;
        letter-spacing: -0.02em;
    }

    .report-subtitle {
        font-size: 13px;
        color: var(--text-muted);
        margin-top: 4px;
        font-weight: 500;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: white;
        padding: 32px;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .stat-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .icon-in { background: #dcfce7; color: #15803d; }
    .icon-out { background: #fee2e2; color: #b91c1c; }
    .icon-net { background: #e0e7ff; color: #3730a3; }

    .stat-label {
        font-size: 11px;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 4px;
    }

    .stat-value {
        font-size: 24px;
        font-weight: 800;
        color: var(--primary-navy);
    }

    .filter-panel {
        padding: 32px 40px;
        background: #fcfcfc;
    }

    .filter-row {
        display: flex;
        gap: 20px;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-label {
        font-size: 11px;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .form-control {
        padding: 12px 16px;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
        color: var(--text-main);
        background: white;
        transition: all 0.2s;
    }

    .btn-navy {
        background: var(--primary-navy);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-outline-navy {
        background: white;
        color: var(--primary-navy);
        border: 1.5px solid var(--primary-navy);
        padding: 12px 20px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .table-section {
        background: white;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        margin-bottom: 24px;
        overflow: hidden;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
    }

    .report-table th {
        padding: 16px 32px;
        text-align: left;
        font-weight: 700;
        color: var(--text-muted);
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        background: #f8fafc;
        border-bottom: 1.5px solid var(--border-color);
    }

    .report-table td {
        padding: 16px 32px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
        color: var(--text-main);
    }

    .section-header {
        background: var(--primary-navy) !important;
    }

    .section-header td {
        color: white !important;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        padding: 12px 32px !important;
        font-size: 11px;
    }

    .total-row {
        background: #f8fafc;
        font-weight: 800;
    }

    .grand-total-row {
        background: var(--primary-navy) !important;
    }

    .grand-total-row td {
        color: white !important;
        font-weight: 800;
        font-size: 15px !important;
        padding: 20px 32px !important;
    }

    .amount {
        text-align: right;
        font-weight: 700;
    }

    .amount-in { color: #10b981; }
    .amount-out { color: #f43f5e; }

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

        /* Hide non-essential elements */
        .stats-grid,
        .filter-panel,
        .btn-outline-navy,
        .page-actions {
            display: none !important;
        }

        .cashflow-container {
            max-width: 100%;
            padding: 0;
        }

        .report-card {
            border: none;
            box-shadow: none;
            border-radius: 0;
        }

        /* Header */
        .report-header {
            padding: 0 0 8mm 0 !important;
            margin-bottom: 5mm !important;
            border-bottom: 2px solid #000 !important;
        }

        .report-header h1 {
            font-size: 16pt !important;
        }

        /* Table */
        .cashflow-table {
            font-size: 9pt !important;
        }

        .cashflow-table th {
            font-size: 8pt !important;
            padding: 3mm 2mm !important;
            background: #f5f5f5 !important;
            border: 1px solid #000 !important;
            color: #000 !important;
            -webkit-print-color-adjust: exact !important;
        }

        .cashflow-table td {
            padding: 2mm !important;
            font-size: 9pt !important;
            border: 1px solid #ddd !important;
            color: #000 !important;
        }

        /* Section headers (Arus Masuk, Arus Keluar) */
        .section-header {
            background: #000 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            border-top: 2px solid #000 !important;
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

        /* Grand total (Kenaikan/Penurunan Bersih) */
        .grand-total-row {
            background: #000 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            border-top: 2px solid #000 !important;
            border-bottom: 2px double #000 !important;
        }
        
        .grand-total-row td {
            color: white !important;
            font-weight: 800 !important;
            padding: 3mm !important;
            font-size: 11pt !important;
        }

        /* Amount alignment */
        .amount-cell {
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
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon icon-in"><i class="fas fa-arrow-down"></i></div>
        <div>
            <div class="stat-label">Arus Masuk</div>
            <div class="stat-value" style="color: #10b981;">Rp {{ number_format($totalIn, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-out"><i class="fas fa-arrow-up"></i></div>
        <div>
            <div class="stat-label">Arus Keluar</div>
            <div class="stat-value" style="color: #f43f5e;">Rp {{ number_format($totalOut, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-net"><i class="fas fa-wallet"></i></div>
        <div>
            <div class="stat-label">Saldo Bersih</div>
            <div class="stat-value">Rp {{ number_format($totalIn - $totalOut, 0, ',', '.') }}</div>
        </div>
    </div>
</div>

<div class="header-section">
    <div class="table-title-section">
        <div>
            <h1 class="report-title">LAPORAN ARUS KAS</h1>
            <p class="report-subtitle">PABRIK KAYU JAYA ABADI • Ringkasan Mutasi Kas Periode Ini</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <button type="button" onclick="window.print()" class="btn-outline-navy">
                <i class="fas fa-print"></i> CETAK PDF
            </button>
            <a href="{{ route('report.cash-flow.export', request()->all()) }}" class="btn-navy">
                <i class="fas fa-file-excel"></i> EXPORT EXCEL
            </a>
        </div>
    </div>

    <div class="filter-panel">
        <form method="GET" action="{{ route('report.cash-flow') }}">
            <div class="filter-row">
                <div class="form-group">
                    <label class="form-label">Tipe Filter</label>
                    <select name="filter_type" id="filterType" class="form-control" onchange="handleFilterTypeChange(this.value)">
                        <option value="all" {{ $filterType === 'all' ? 'selected' : '' }}>Semua Data</option>
                        <option value="per_bulan" {{ $filterType === 'per_bulan' ? 'selected' : '' }}>Per Bulan</option>
                        <option value="per_tahun" {{ $filterType === 'per_tahun' ? 'selected' : '' }}>Per Tahun</option>
                        <option value="custom" {{ $filterType === 'custom' ? 'selected' : '' }}>Custom Tanggal</option>
                    </select>
                </div>

                <div id="monthGroup" class="form-group" style="display: {{ $filterType === 'per_bulan' ? 'flex' : 'none' }};">
                    <label class="form-label">Pilih Bulan</label>
                    <input type="month" name="month" class="form-control" value="{{ $month ?: date('Y-m') }}">
                </div>

                <div id="yearGroup" class="form-group" style="display: {{ $filterType === 'per_tahun' ? 'flex' : 'none' }};">
                    <label class="form-label">Pilih Tahun</label>
                    <input type="number" name="year" class="form-control" placeholder="{{ date('Y') }}" value="{{ $year ?? date('Y') }}">
                </div>

                <div id="startDateGroup" class="form-group" style="display: {{ $filterType === 'custom' ? 'flex' : 'none' }};">
                    <label class="form-label">Dari</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                </div>

                <div id="endDateGroup" class="form-group" style="display: {{ $filterType === 'custom' ? 'flex' : 'none' }};">
                    <label class="form-label">Hingga</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                </div>

                <div style="display: flex; gap: 12px;">
                    <button type="submit" class="btn-navy" style="height: 46px;">FILTER DATA</button>
                    <a href="{{ route('report.cash-flow') }}" class="btn-outline-navy" style="height: 46px; border-color: #e2e8f0; color: var(--text-muted);">RESET</a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="table-section">
    <table class="report-table">
        <thead>
            <tr>
                <th>Deskripsi Laporan</th>
                <th style="width: 300px; text-align: right;">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr class="section-header">
                <td colspan="2">1. ARUS KAS MASUK</td>
            </tr>
            @forelse($inByAccount ?? [] as $name => $amount)
                <tr>
                    <td style="padding-left: 64px;">{{ $name }}</td>
                    <td class="amount amount-in">{{ number_format($amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" style="text-align: center; color: var(--text-muted); padding: 32px;">Tidak ada data arus kas masuk</td>
                </tr>
            @endforelse
            <tr class="total-row">
                <td style="padding-left: 32px;">TOTAL ARUS KAS MASUK</td>
                <td class="amount amount-in">Rp {{ number_format($totalIn, 0, ',', '.') }}</td>
            </tr>

            <tr class="section-header">
                <td colspan="2">2. ARUS KAS KELUAR</td>
            </tr>
            @forelse($outByAccount ?? [] as $name => $amount)
                <tr>
                    <td style="padding-left: 64px;">{{ $name }}</td>
                    <td class="amount amount-out">{{ number_format($amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" style="text-align: center; color: var(--text-muted); padding: 32px;">Tidak ada data arus kas keluar</td>
                </tr>
            @endforelse
            <tr class="total-row">
                <td style="padding-left: 32px;">TOTAL ARUS KAS KELUAR</td>
                <td class="amount amount-out">Rp {{ number_format($totalOut, 0, ',', '.') }}</td>
            </tr>

            <tr class="grand-total-row">
                <td>KENAIKAN (PENURUNAN) BERSIH KAS</td>
                <td class="amount">Rp {{ number_format($totalIn - $totalOut, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    function handleFilterTypeChange(type) {
        document.getElementById('monthGroup').style.display = type === 'per_bulan' ? 'flex' : 'none';
        document.getElementById('yearGroup').style.display = type === 'per_tahun' ? 'flex' : 'none';
        document.getElementById('startDateGroup').style.display = type === 'custom' ? 'flex' : 'none';
        document.getElementById('endDateGroup').style.display = type === 'custom' ? 'flex' : 'none';
    }
</script>
@endsection
