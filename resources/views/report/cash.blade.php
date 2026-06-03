@extends('layouts.app')

@section('title', 'Laporan Kas')

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    :root {
        --primary-navy: #1e2a78;
        --secondary-navy: #2a3bb1;
        --bg-light: #f8fafc;
        --border-color: #e2e8f0;
        --text-main: #1e293b;
        --text-muted: #64748b;
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
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        min-width: 160px;
    }

    .form-control:focus {
        border-color: var(--primary-navy);
        box-shadow: 0 0 0 4px rgba(30, 42, 120, 0.08);
        outline: none;
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

    .btn-navy:hover {
        background: var(--secondary-navy);
        transform: translateY(-1px);
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

    .btn-outline-navy:hover {
        background: rgba(30, 42, 120, 0.04);
        transform: translateY(-1px);
    }

    .table-section {
        background: white;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        margin-bottom: 24px;
        overflow: hidden;
    }

    .cash-table {
        width: 100%;
        border-collapse: collapse;
    }

    .cash-table th {
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

    .cash-table td {
        padding: 16px 32px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
        color: var(--text-main);
    }

    .category-row {
        background: var(--primary-navy) !important;
    }

    .category-row td {
        color: white !important;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        padding: 12px 32px !important;
        font-size: 11px;
    }

    .amount {
        text-align: right;
        font-weight: 700;
    }

    .amount-in { color: #10b981; }
    .amount-out { color: #f43f5e; }

    .type-badge {
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .type-income { background: #dcfce7; color: #15803d; }
    .type-expense { background: #fee2e2; color: #b91c1c; }

    @media print {
        @page { size: landscape; margin: 10mm; }
        .header-section, .btn-navy, .btn-outline-navy, .sidebar { display: none !important; }
        .table-section { box-shadow: none !important; border: 1.5px solid #000 !important; border-radius: 0 !important; }
    }
</style>
@endsection

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon icon-in"><i class="fas fa-arrow-down"></i></div>
        <div>
            <div class="stat-label">Total Pemasukan</div>
            <div class="stat-value" style="color: #10b981;">Rp {{ number_format($totalIn, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-out"><i class="fas fa-arrow-up"></i></div>
        <div>
            <div class="stat-label">Total Pengeluaran</div>
            <div class="stat-value" style="color: #f43f5e;">Rp {{ number_format($totalOut, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-net"><i class="fas fa-wallet"></i></div>
        <div>
            <div class="stat-label">Saldo Bersih</div>
            <div class="stat-value">Rp {{ number_format($netBalance, 0, ',', '.') }}</div>
        </div>
    </div>
</div>

<div class="header-section">
    <div class="table-title-section">
        <div>
            <h1 class="report-title">LAPORAN ARUS KAS</h1>
            <p class="report-subtitle">PABRIK KAYU JAYA ABADI • 
                @if($filterType === 'per_bulan' && !request('month'))
                    Periode: {{ \Carbon\Carbon::now()->startOfMonth()->format('d/m/Y') }} - {{ \Carbon\Carbon::now()->endOfMonth()->format('d/m/Y') }}
                @elseif($filterType === 'per_bulan' && request('month'))
                    @php 
                        $dt = \Carbon\Carbon::parse(request('month')); 
                    @endphp
                    Periode: {{ $dt->startOfMonth()->format('d/m/Y') }} - {{ $dt->endOfMonth()->format('d/m/Y') }}
                @elseif($filterType === 'per_tahun')
                    Periode: 01/01/{{ $year }} - 31/12/{{ $year }}
                @elseif($startDate && $endDate)
                    Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
                @else
                    Semua Data
                @endif
            </p>
        </div>
        <div style="display: flex; gap: 12px;">
            <button onclick="window.print()" class="btn-outline-navy">
                <i class="fas fa-print"></i> CETAK PDF
            </button>
            <a href="{{ route('report.cash.export', request()->all()) }}" class="btn-navy">
                <i class="fas fa-file-excel"></i> EXPORT EXCEL
            </a>
        </div>
    </div>

    <div class="filter-panel">
        <form method="GET" action="{{ route('report.cash') }}">
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

                <div class="form-group" style="flex: 1; min-width: 200px;">
                    <label class="form-label">Cari Transaksi</label>
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Cari keterangan...">
                </div>

                <div style="display: flex; gap: 12px;">
                    <button type="submit" class="btn-navy" style="height: 46px;">FILTER</button>
                    <a href="{{ route('report.cash') }}" class="btn-outline-navy" style="height: 46px; border-color: #e2e8f0; color: var(--text-muted);">RESET</a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="table-section">
    @if(count($groupedTransactions) > 0)
        <table class="cash-table">
            <thead>
                <tr>
                    <th style="width: 120px;">Tanggal</th>
                    <th style="width: 140px;">No. Bukti</th>
                    <th>Keterangan</th>
                    <th style="width: 120px;">Tipe</th>
                    <th style="width: 180px; text-align: right;">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($groupedTransactions as $categoryName => $transactions)
                    <tr class="category-row">
                        <td colspan="5">KATEGORI: {{ $categoryName }}</td>
                    </tr>
                    @foreach($transactions as $trx)
                        <tr>
                            <td style="font-weight: 600;">{{ \Carbon\Carbon::parse($trx->date)->format('d/m/Y') }}</td>
                            <td style="font-size: 11px; font-weight: 700; color: var(--text-muted);">{{ $trx->reference }}</td>
                            <td>{{ $trx->description }}</td>
                            <td>
                                <span class="type-badge {{ $trx->type === 'in' ? 'type-income' : 'type-expense' }}">
                                    {{ $trx->type === 'in' ? 'Masuk' : 'Keluar' }}
                                </span>
                            </td>
                            <td class="amount {{ $trx->type === 'in' ? 'amount-in' : 'amount-out' }}">
                                {{ number_format($trx->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                    <tr style="background: #f8fafc; font-weight: 800;">
                        <td colspan="4" style="text-align: right; font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em;">TOTAL {{ $categoryName }}</td>
                        <td class="amount" style="color: var(--primary-navy);">
                            Rp {{ number_format($transactions->sum('amount'), 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="padding: 100px 40px; text-align: center;">
            <i class="fas fa-folder-open" style="font-size: 40px; color: #e2e8f0; margin-bottom: 16px; display: block;"></i>
            <h3 style="font-weight: 700; color: var(--text-main); margin-bottom: 8px;">Data Kosong</h3>
            <p style="color: var(--text-muted);">Tidak ada transaksi kas yang ditemukan untuk kriteria pencarian ini.</p>
        </div>
    @endif
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
