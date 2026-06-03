@extends('layouts.app')

@section('title', 'Buku Besar')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    * {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    :root {
        --primary-navy: #1e2a78;
        --secondary-navy: #2a3bb1;
        --bg-light: #f8fafc;
        --border-color: #e2e8f0;
        --text-main: #1e293b;
        --text-muted: #64748b;
    }

    body {
        background-color: var(--bg-light);
        color: var(--text-main);
    }

    .header-card {
        background: white;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
        overflow: hidden;
    }

    .header-content {
        padding: 24px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid var(--border-color);
    }

    .header-left h1 {
        font-size: 20px;
        font-weight: 800;
        color: var(--text-main);
        margin: 0;
        letter-spacing: -0.02em;
    }

    .header-left p {
        font-size: 12px;
        color: var(--text-muted);
        margin: 2px 0 0 0;
    }

    /* ACTION BUTTONS STYLE */
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

    /* FILTER SECTION */
    .filter-section {
        padding: 20px 30px;
        background: #ffffff;
    }

    .filter-grid {
        display: flex;
        gap: 12px;
        align-items: flex-end;
    }

    .filter-group { 
        display: flex; 
        flex-direction: column; 
        gap: 6px; 
    }

    .filter-group label { 
        font-size: 10px; 
        font-weight: 700; 
        color: #94a3b8; 
        text-transform: uppercase; 
        letter-spacing: 0.05em; 
        margin-left: 2px; 
    }

    .form-control {
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        color: var(--text-main);
        background: #ffffff;
        height: 36px;
        outline: none;
    }

    .btn-filter {
        background: #1e2a78 !important;
        color: #ffffff !important;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-filter:hover {
        background: #151d54 !important;
    }

    .btn-reset {
        background: #ffffff;
        color: #64748b;
        border: 1px solid #e2e8f0;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
    }

    .btn-reset:hover {
        background: #f8fafc;
        color: #1e293b;
    }

    /* ACCOUNT CARDS */
    .account-card {
        background: white;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        margin-bottom: 24px;
        overflow: hidden;
    }

    .account-banner {
        background: #1e2a78;
        color: #ffffff !important;
        padding: 12px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .account-info {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #ffffff !important;
    }

    .account-code {
        color: #ffffff !important;
        font-weight: 700;
        font-size: 15px;
    }

    .account-name {
        font-size: 15px;
        font-weight: 700;
        color: #ffffff !important;
    }

    .account-type {
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        opacity: 0.9;
        color: #ffffff !important;
    }

    .ledger-table {
        width: 100%;
        border-collapse: collapse;
    }

    .ledger-table th {
        padding: 12px 24px;
        text-align: left;
        font-weight: 700;
        color: var(--text-muted);
        font-size: 10px;
        text-transform: uppercase;
        background: #f8fafc;
        border-bottom: 1px solid var(--border-color);
    }

    .ledger-table td {
        padding: 12px 24px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
    }

    .amount {
        text-align: right;
        font-weight: 600;
    }

    .text-debit { color: #10b981; }
    .text-credit { color: #f43f5e; }

    .balance-footer {
        background: #f8fafc;
        font-weight: 700;
    }

    .balance-footer td {
        padding: 15px 24px;
        border-top: 1px solid var(--border-color);
    }

    .highlight-balance {
        background: var(--primary-navy);
        color: white;
    }

    @media print {
        .filter-section, .btn-export, .sidebar { display: none !important; }
        .account-card { border: 1px solid #000; border-radius: 0; }
    }
</style>
@endsection

@section('content')
<div class="header-card">
    <div style="text-align: center; padding: 32px 24px 10px 24px; border-bottom: 1px solid var(--border-color);">
        <h1 style="font-size: 16px; font-weight: 800; color: #1e293b; margin: 0; text-transform: uppercase; letter-spacing: 0.1em;">Buku Besar</h1>
        <h2 style="font-size: 14px; font-weight: 800; color: #1e293b; margin: 4px 0 0 0; text-transform: uppercase; letter-spacing: 0.05em;">Pabrik Kayu Jaya Abadi</h2>
        <p style="font-size: 12px; color: #94a3b8; margin-top: 6px;">
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
        </p>
    </div>

    <div class="filter-section">
        <form method="GET" action="{{ route('report.ledger') }}">
            <input type="hidden" name="filter_type" value="custom">
            <div class="filter-grid" style="align-items: flex-end;">
                <div class="filter-group">
                    <label>Mulai</label>
                    <input type="date" name="start_date" class="form-control" value="{{ is_string($startDate) ? $startDate : ($startDate ? $startDate->format('Y-m-d') : '') }}">
                </div>
                <div class="filter-group">
                    <label>Akhir</label>
                    <input type="date" name="end_date" class="form-control" value="{{ is_string($endDate) ? $endDate : ($endDate ? $endDate->format('Y-m-d') : '') }}">
                </div>
                <div class="filter-group">
                    <label>Akun</label>
                    <select name="account_id" class="form-control" style="width: 160px;">
                        <option value="">-- Semua Akun --</option>
                        @foreach($allAccounts as $acc)
                            <option value="{{ $acc->id }}" {{ $accountId == $acc->id ? 'selected' : '' }}>
                                {{ $acc->code }} - {{ $acc->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-filter" style="height: 36px; padding: 0 16px; display: flex; align-items: center; gap: 6px; white-space: nowrap;">
                    <i class="fas fa-filter"></i> Terapkan
                </button>
                <a href="{{ route('report.ledger') }}" class="btn-reset" style="height: 36px; display: inline-flex; align-items: center; justify-content: center; white-space: nowrap;">Reset</a>
                
                <div style="display: flex; gap: 12px; margin-left: auto;">
                    <button type="button" onclick="window.print()" class="btn-outline" style="white-space: nowrap;">
                        <i class="fas fa-print"></i> PDF
                    </button>
                    <a href="{{ route('report.ledger.export', request()->all()) }}" class="btn-outline" style="white-space: nowrap;">
                        <i class="fas fa-file-excel"></i> Excel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@if(count($ledgerData) > 0)
    @foreach($ledgerData as $data)
        <div class="account-card">
            <div class="account-banner">
                <div class="account-info">
                    <span class="account-code">{{ $data['account']->code }} - </span>
                    <span class="account-name">{{ $data['account']->name }}</span>
                </div>
                <div class="account-type">Kategori: {{ $data['account']->type }}</div>
            </div>
            
            <table class="ledger-table">
                <thead>
                    <tr>
                        <th style="width: 15%; white-space: nowrap;">Tanggal</th>
                        <th style="width: 35%;">Keterangan</th>
                        <th style="width: 10%;">Ref</th>
                        <th style="width: 13%; text-align: right;">Debit (Rp)</th>
                        <th style="width: 13%; text-align: right;">Kredit (Rp)</th>
                        <th style="width: 14%; text-align: right;">Saldo (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="color: #64748b; font-weight: 500; white-space: nowrap;">
                            @if($startDate)
                                {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}
                            @elseif(count($data['transactions']) > 0)
                                {{ $data['transactions'][0]['journal']->journal_date->format('d M Y') }}
                            @endif
                            <div style="font-size: 11px; color: #94a3b8; margin-top: 2px;">00:00</div>
                        </td>
                        <td style="font-weight: 700; color: var(--primary-navy);">Saldo Awal</td>
                        <td style="color: var(--text-muted);">-</td>
                        <td class="amount">-</td>
                        <td class="amount">-</td>
                        <td class="amount" style="font-weight: 800; color: var(--primary-navy);">
                            {{ number_format($data['beginning_balance'], 0, ',', '.') }}
                        </td>
                    </tr>

                    @foreach($data['transactions'] as $transaction)
                        <tr>
                            <td style="color: #64748b; font-weight: 500; white-space: nowrap;">
                                {{ $transaction['journal']->journal_date->format('d M Y') }}
                                <div style="font-size: 11px; color: #94a3b8; margin-top: 2px;">{{ $transaction['journal']->journal_date->format('H:i') }}</div>
                            </td>
                            <td>
                                <div style="font-weight: 600;">
                                    {{ $transaction['journal']->description ?: $data['account']->name }}
                                </div>
                            </td>
                            <td style="font-size: 11px; color: var(--text-muted);">
                                {{ $transaction['journal']->reference ?? '-' }}
                            </td>
                            <td class="amount text-debit">
                                @if($transaction['journal']->type === 'debit')
                                    {{ number_format($transaction['journal']->amount, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="amount text-credit">
                                @if($transaction['journal']->type === 'credit')
                                    {{ number_format($transaction['journal']->amount, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="amount" style="color: var(--text-main);">
                                {{ number_format($transaction['balance'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="balance-footer">
                        <td colspan="3" style="text-align: right; color: var(--text-muted); font-size: 10px; text-transform: uppercase;">MUTASI & SALDO AKHIR</td>
                        <td class="amount text-debit">{{ number_format($data['debit_total'], 0, ',', '.') }}</td>
                        <td class="amount text-credit">{{ number_format($data['credit_total'], 0, ',', '.') }}</td>
                        <td class="amount highlight-balance">
                            {{ number_format($data['final_balance'], 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endforeach
@else
    <div class="account-card" style="padding: 60px; text-align: center;">
        <i class="fas fa-folder-open" style="font-size: 32px; color: var(--border-color); margin-bottom: 15px;"></i>
        <p style="color: var(--text-muted); font-size: 14px;">Tidak ada aktivitas transaksi untuk periode ini.</p>
    </div>
@endif
@endsection
