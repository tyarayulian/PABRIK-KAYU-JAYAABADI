@extends('layouts.app')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    * {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .welcome-card {
        background: #000;
        color: #fff;
        border-radius: 25px;
        padding: 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }

    .welcome-text h1 {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 10px;
        letter-spacing: -0.02em;
    }

    .welcome-text p {
        color: rgba(255, 255, 255, 0.6);
        font-size: 16px;
        max-width: 500px;
    }

    .welcome-img {
        width: 150px;
        height: 150px;
        background: url('https://illustrations.popsy.co/white/waving.svg') no-repeat center;
        background-size: contain;
        opacity: 0.9;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: #fff;
        padding: 24px;
        border-radius: 25px;
        border: 1px solid #f0f0f0;
        display: flex;
        flex-direction: column;
        gap: 8px;
        transition: all 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    }

    .stat-label {
        font-size: 11px;
        font-weight: 700;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .stat-value {
        font-family: 'JetBrains Mono', monospace;
        font-size: 24px;
        font-weight: 800;
        color: #000;
    }

    .stat-footer {
        font-size: 12px;
        color: #666;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .stat-icon {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: #f8f8f8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: #000;
        margin-bottom: 8px;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 24px;
    }

    .section-card {
        background: #fff;
        border-radius: 25px;
        border: 1px solid #f0f0f0;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .section-header {
        padding: 24px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #f8f8f8;
    }

    .section-header h2 {
        font-size: 18px;
        font-weight: 800;
        color: #000;
        margin: 0;
    }

    .btn-outline {
        padding: 8px 16px;
        border-radius: 10px;
        border: 1px solid #f0f0f0;
        background: #fff;
        color: #000;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-outline:hover {
        background: #000;
        color: #fff;
        border-color: #000;
    }

    .table-container {
        padding: 0 10px;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    th {
        padding: 16px 20px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #f8f8f8;
    }

    td {
        padding: 18px 20px;
        font-size: 14px;
        color: #333;
        border-bottom: 1px solid #f8f8f8;
    }

    .amount-in {
        color: #10b981;
        font-weight: 700;
        font-family: 'JetBrains Mono', monospace;
    }

    .amount-out {
        color: #ef4444;
        font-weight: 700;
        font-family: 'JetBrains Mono', monospace;
    }

    .chart-container {
        padding: 30px;
        height: 350px;
    }

    .badge {
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        background: #f0f0f0;
        color: #666;
    }

    .action-cards {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-top: 24px;
        padding: 0 30px 30px;
    }

    .action-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 16px;
        border-radius: 15px;
        background: #000;
        color: #fff;
        text-decoration: none;
        font-weight: 700;
        font-size: 13px;
        transition: all 0.3s;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .action-btn.secondary {
        background: #fff;
        color: #000;
        border: 1px solid #000;
    }

    @media (max-width: 1024px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .dashboard-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<!-- WELCOME SECTION -->
<div class="welcome-card">
    <div class="welcome-text">
        <h1>Hello, {{ Auth::user()->name }}!</h1>
        <p>Pantau performa operasional pabrik kayu Anda secara real-time. Semua metrik utama tersedia dalam satu tampilan.</p>
        <div style="margin-top: 25px; display: flex; gap: 12px;">
            <a href="{{ route('kas-masuk.create') }}" class="btn-outline" style="background: #fff; color: #000; padding: 12px 24px;">
                <i class="fas fa-plus mr-2"></i> Input Kas Masuk
            </a>
            <a href="{{ route('kas-keluar.create') }}" class="btn-outline" style="background: transparent; color: #fff; border-color: rgba(255,255,255,0.3); padding: 12px 24px;">
                Input Kas Keluar
            </a>
        </div>
    </div>
    <div class="welcome-img"></div>
</div>

<!-- STATS SUMMARY -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-wallet"></i></div>
        <span class="stat-label">Saldo Saat Ini</span>
        <span class="stat-value">Rp{{ number_format($balanceToday ?? $netBalance, 0, ',', '.') }}</span>
        <div class="stat-footer">
            <span style="color: #10b981; font-weight: 700;">+{{ number_format($cashInToday ?? 0, 0, ',', '.') }}</span> hari ini
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-exchange-alt"></i></div>
        <span class="stat-label">Volume Transaksi</span>
        <span class="stat-value">{{ $totalTransactions ?? $recentTransactions->count() }}</span>
        <div class="stat-footer">Total aktivitas periode ini</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-arrow-down"></i></div>
        <span class="stat-label">Masuk (Bulan Ini)</span>
        <span class="stat-value">Rp{{ number_format($cashInThisMonth ?? $totalIncome, 0, ',', '.') }}</span>
        <div class="stat-footer">Pemasukan operasional</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-arrow-up"></i></div>
        <span class="stat-label">Keluar (Bulan Ini)</span>
        <span class="stat-value">Rp{{ number_format($cashOutThisMonth ?? $totalExpense, 0, ',', '.') }}</span>
        <div class="stat-footer">Pengeluaran operasional</div>
    </div>
</div>

<div class="dashboard-grid">
    <!-- RECENT TRANSACTIONS -->
    <div class="section-card">
        <div class="section-header">
            <h2>Transaksi Terbaru</h2>
            <a href="{{ route('transaksi.index') }}" class="btn-outline">Lihat Semua</a>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal & Deskripsi</th>
                        <th>Kategori</th>
                        <th style="text-align: right;">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTransactions->take(6) as $trx)
                    <tr>
                        <td>
                            <div style="font-weight: 700; color: #000;">{{ $trx->description }}</div>
                            <div style="font-size: 11px; color: #999;">{{ $trx->date->format('d M Y, H:i') }} • Oleh {{ $trx->user->name ?? 'System' }}</div>
                        </td>
                        <td><span class="badge">{{ $trx->category->name ?? 'General' }}</span></td>
                        <td style="text-align: right;">
                            <span class="{{ $trx->type == 'in' ? 'amount-in' : 'amount-out' }}">
                                {{ $trx->type == 'in' ? '+' : '-' }}Rp{{ number_format($trx->amount, 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 50px; color: #999;">
                            Belum ada transaksi tercatat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- CASH FLOW CHART & QUICK ACTIONS -->
    <div class="section-card">
        <div class="section-header">
            <h2>Arus Kas</h2>
            <div style="font-size: 11px; color: #999; font-weight: 700; text-transform: uppercase;">7 Hari Terakhir</div>
        </div>
        <div class="chart-container">
            <canvas id="cashFlowChart"></canvas>
        </div>
        <div class="action-cards">
            <a href="{{ route('report.journal') }}" class="action-btn">
                <i class="fas fa-file-invoice"></i> Laporan Jurnal
            </a>
            <a href="{{ route('cash.index') }}" class="action-btn secondary">
                <i class="fas fa-book"></i> Buku Kas
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('cashFlowChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($graphData['dates'] ?? []) !!},
                    datasets: [{
                        label: 'Arus Kas',
                        data: {!! json_encode($graphData['cashIn'] ?? []) !!},
                        borderColor: '#000',
                        backgroundColor: 'rgba(0,0,0,0.02)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#000',
                        borderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: '#000',
                            padding: 12,
                            cornerRadius: 10,
                            titleFont: { family: 'Inter', weight: 'bold' },
                            bodyFont: { family: 'JetBrains Mono' }
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            grid: { color: '#f8f8f8' },
                            ticks: { 
                                color: '#999',
                                font: { size: 10, family: 'JetBrains Mono' },
                                callback: function(value) {
                                    return value >= 1000000 ? (value/1000000).toFixed(1) + 'M' : value;
                                }
                            }
                        },
                        x: { 
                            grid: { display: false },
                            ticks: { color: '#999', font: { size: 10, family: 'Inter', weight: '600' } }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
