@extends('layouts.app')

@section('title', 'Financial Dashboard')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    html, body {
        margin: 0;
        padding: 0;
        width: 100%;
        overflow-x: hidden;
        background-color: #f8fafc;
    }

    * { 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        box-sizing: border-box;
    }
    /* Full width top section for the title and summary card */
    .dashboard-header-wrapper {
        padding: 10px 15px 0 15px;
        width: 100%;
    }

    .top-dashboard-section {
        padding: 0 15px;
        background: transparent;
        margin-bottom: 15px;
        width: 100%;
    }

    .details-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .details-nav {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .user-welcome {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .header-action-btn {
        width: 36px;
        height: 36px;
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #1e2a78;
        font-size: 14px;
        cursor: pointer;
        position: relative;
        transition: all 0.2s;
    }

    .header-action-btn:hover {
        background: #f8fafc;
        color: #3b82f6;
        border-color: #e2e8f0;
    }

    .notification-dot {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 8px;
        height: 8px;
        background: #3b82f6;
        border: 2px solid #ffffff;
        border-radius: 50%;
    }

    .greeting-text {
        font-size: 26px;
        font-weight: 800;
        background: linear-gradient(135deg, #1e2a78 0%, #3b82f6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .user-profile-circle {
        width: 36px;
        height: 36px;
        background: #1e2a78;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
    }

    /* Summary Card in Top Section */
    .detail-summary-card {
        background: #ffffff;
        border-radius: 40px;
        padding: 40px;
        display: flex;
        flex-direction: column;
        gap: 0;
        border: 1px solid #f1f5f9;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
    }

    .summary-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        width: 100%;
    }

    .summary-avatar {
        width: 70px;
        height: 70px;
        border-radius: 24px;
        background: #0056b3;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 800;
        font-size: 24px;
    }

    .summary-main {
        flex: 1;
    }

    .summary-amount {
        font-size: 42px;
        font-weight: 800;
        color: #1e2a78;
        letter-spacing: -1.5px;
        line-height: 1;
        margin-bottom: 5px;
    }

    .summary-label {
        font-size: 12px;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-top: 5px;
    }

    .summary-actions {
        display: flex;
        gap: 20px;
        align-items: center;
    }

    .action-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .action-call { 
        background: #22c55e; 
        color: white; 
        box-shadow: 0 10px 20px rgba(34, 197, 94, 0.2); 
    }
    
    .action-secondary { 
        color: #94a3b8; 
        font-size: 20px; 
    }

    /* Column layout below the top section */
    .chart-header-info {
        display: flex;
        flex-direction: column;
    }

    .chart-header-amount {
        font-size: 16px;
        font-weight: 800;
        color: #1e2a78;
        line-height: 1;
        margin-bottom: 3px;
    }

    .chart-header-label {
        font-size: 9px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .dashboard-wrapper {
        display: grid;
        grid-template-columns: 1fr;
        gap: 15px;
        padding: 0 15px 15px 15px;
        background: transparent;
    }

    /* RIGHT COLUMN: List of Recents */
    .recents-column {
        width: 100%;
        background: white;
        padding: 20px 0;
        border-radius: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        border: 1px solid #f1f5f9;
        display: flex;
        flex-direction: column;
        height: fit-content;
    }

    .recents-header {
        padding: 0 30px;
        margin-bottom: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }


    .dropdown-transaction {
        position: relative;
        display: inline-block;
    }

    .btn-add-transaction {
        padding: 6px 14px;
        background: #eff6ff;
        color: #3b82f6;
        border: 1px solid #dbeafe;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }

    .btn-add-transaction:hover {
        background: #dbeafe;
        color: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
    }

    .dropdown-menu-custom {
        display: none;
        position: absolute;
        right: 0;
        top: calc(100% + 8px);
        background: white;
        min-width: 180px;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.12);
        border: 1px solid #f1f5f9;
        z-index: 1000;
        padding: 8px 0;
        overflow: hidden;
    }

    .dropdown-menu-custom.show {
        display: block;
        animation: slideIn 0.2s ease-out;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .dropdown-section-label {
        padding: 8px 15px 4px;
        font-size: 9px;
        font-weight: 800;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .dropdown-menu-custom a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 15px;
        color: #475569;
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .dropdown-menu-custom a:hover {
        background: #f0f7ff;
        color: #1e2a78;
    }

    .dropdown-menu-custom a i {
        width: 16px;
        text-align: center;
        font-size: 14px;
        color: #1e2a78;
    }

    .dropdown-divider {
        height: 1px;
        background: #f1f5f9;
        margin: 4px 0;
    }

    .search-btn-round {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        font-size: 14px;
        cursor: pointer;
    }

    .transaction-list {
        flex: 1;
        overflow-y: auto;
        padding: 0 15px;
    }

    .transaction-item {
        padding: 10px 15px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        transition: all 0.2s;
        margin-bottom: 3px;
    }

    .transaction-item:hover {
        background: white;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    }

    .transaction-item.active {
        background: white;
        box-shadow: 0 10px 40px rgba(30, 42, 120, 0.08);
    }

    .icon-box-round {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
    }

    .icon-in { background: #fff5f5; color: #ff5c5c; }
    .icon-out { background: #f0f7ff; color: #3e63ff; }

    .item-info {
        flex: 1;
    }

    .item-title {
        font-weight: 800;
        font-size: 13px;
        color: #1e2a78;
        margin-bottom: 1px;
    }

    .item-subtitle {
        font-size: 10px;
        color: #94a3b8;
        font-weight: 600;
    }

    .item-meta {
        text-align: right;
    }

    .item-time {
        font-size: 9px;
        color: #94a3b8;
        font-weight: 600;
        margin-bottom: 2px;
    }

    /* LEFT COLUMN: Summary Cards */
    .details-column {
        flex: 1;
        background: white;
        padding: 40px;
        border-radius: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        border: 1px solid #f1f5f9;
        height: fit-content;
    }

    .transaction-flow-info {
        display: flex;
        align-items: center;
        gap: 20px;
        color: #94a3b8;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 40px;
    }

    .flow-tag {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Client Details Section */
    .section-label {
        font-size: 20px;
        font-weight: 800;
        color: #1e2a78;
        margin-bottom: 20px;
        display: block;
    }

    .details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 30px;
    }

    .detail-group label {
        display: block;
        font-size: 11px;
        color: #94a3b8;
        font-weight: 700;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .file-badges {
        display: flex;
        gap: 10px;
    }

    .file-badge {
        padding: 10px 18px;
        border-radius: 10px;
        color: white;
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
    }

    .badge-pdf { background: #fbc7d4; color: #ff4d4d; }
    .badge-doc { background: #1e2a78; }

    .voicemail-wave {
        background: #f8fafc;
        border-radius: 15px;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        height: 50px;
    }

    .wave-bars {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 3px;
    }

    .wave-bar { width: 3px; background: #cbd5e1; border-radius: 2px; }

    .wave-time {
        font-size: 13px;
        font-weight: 700;
        color: #1e2a78;
    }

    .wave-btn {
        width: 30px;
        height: 30px;
        background: #1e2a78;
        color: white;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }

    .message-body {
        font-size: 15px;
        line-height: 1.7;
        color: #64748b;
        font-weight: 500;
    }

    /* Dashboard Content Grid within Details Column */
    .dashboard-content-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 30px;
        height: 100%;
    }

    .top-row-grid {
        display: grid;
        grid-template-columns: 1.15fr 0.7fr 1.15fr;
        gap: 12px;
        padding: 0;
        margin-bottom: 20px;
        width: 100%;
    }

    .top-row-grid > div {
        min-width: 0;
    }

    .top-row-grid .details-column,
    .top-row-grid .top-products-container,
    .top-row-grid .detail-summary-card {
        margin: 0;
        height: 100%;
        padding: 12px;
        border-radius: 25px;
    }

    /* Summary Container (Now inside a grid) */
    .summary-container {
        background: transparent;
        border-radius: 0;
        padding: 0;
        box-shadow: none;
        border: none;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .summary-header {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 12px;
    }

    .period-info {
        text-align: right;
    }

    .period-label {
        font-size: 9px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .period-value {
        font-size: 13px;
        font-weight: 800;
        color: #1e2a78;
        margin: 0;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 8px;
        flex: 1;
    }

    .summary-card {
        background: #fdfbf7;
        border: 1px solid #f0f3ff;
        border-radius: 18px;
        padding: 8px;
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-width: 0;
    }

    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(30, 42, 120, 0.05);
    }

    .card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 8px;
    }

    .card-title {
        display: flex;
        flex-direction: column;
    }

    .card-title .label {
        font-size: 9px;
        font-weight: 800;
        color: #64748b;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .card-title .sub-label {
        font-size: 8px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
    }

    .card-icon {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }

    .icon-wallet { background: #e2e8f0; color: #475569; }
    .icon-volume { background: #f1f5f9; color: #1e2a78; }
    .icon-in { background: #fef2f2; color: #ef4444; }
    .icon-out { background: #f0f9ff; color: #3b82f6; }

    .card-value {
        font-size: 13px;
        font-weight: 800;
        color: #1e2a78;
        margin-bottom: 4px;
        letter-spacing: -0.5px;
    }

    .card-footer {
        display: flex;
        gap: 6px;
        align-items: center;
        font-size: 9px;
    }

    .footer-item {
        display: flex;
        flex-direction: column;
    }

    .footer-label {
        font-size: 8px;
        font-weight: 600;
        color: #94a3b8;
    }

    .footer-val {
        font-size: 9px;
        font-weight: 700;
    }

    .val-dark { color: #334155; }
    .val-red { color: #ef4444; }
    .val-muted { color: #94a3b8; font-weight: 500; }

    .footer-link {
        color: #92400e;
        font-weight: 700;
        text-decoration: none;
        margin-left: auto;
        font-size: 10px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .footer-link:hover {
        text-decoration: underline;
    }

    /* Top Products Section */
    .top-products-container {
        background: #ffffff;
        border-radius: 30px;
        padding: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        border: 1px solid #f1f5f9;
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow: hidden;
    }

    .top-products-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .top-products-title {
        font-size: 13px;
        font-weight: 800;
        color: #1e2a78;
        white-space: nowrap;
    }

    .top-products-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .product-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 15px;
        background: #f8fafc;
        border-radius: 20px;
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
        min-width: 0;
    }

    .product-item:hover {
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(30, 42, 120, 0.05);
        transform: translateY(-2px);
    }

    .product-rank {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: #fdfbf0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 12px;
        color: #4a3701;
        flex-shrink: 0;
    }

    .product-rank.rank-1, .product-rank.rank-2, .product-rank.rank-3 { 
        background: #fdfbf0; 
        color: #4a3701; 
    }

    .product-info {
        flex: 1;
        min-width: 0;
    }

    .product-name {
        font-size: 11px;
        font-weight: 700;
        color: #1e2a78;
        margin-bottom: 0px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-stats {
        font-size: 9px;
        color: #94a3b8;
        font-weight: 600;
    }

    .product-value {
        text-align: right;
        flex-shrink: 0;
    }

    .product-qty {
        font-size: 12px;
        font-weight: 800;
        color: #1e2a78;
    }

    .product-label {
        font-size: 8px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
    }

    /* Period Filter Dropdown Styles */
    .period-filter-container {
        position: relative;
        display: inline-block;
    }

    .period-filter-select {
        appearance: none;
        -webkit-appearance: none;
        background-color: #ffffff;
        border: 1px solid #f0f3ff;
        border-radius: 20px;
        padding: 10px 40px 10px 20px;
        font-size: 13px;
        font-weight: 700;
        color: #1e2a78;
        cursor: pointer;
        transition: all 0.2s;
        outline: none;
        min-width: 160px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }

    .period-filter-select:hover {
        background-color: #f8fafc;
        border-color: #e2e8f0;
        box-shadow: 0 4px 15px rgba(30, 42, 120, 0.05);
    }

    .period-filter-container::after {
        content: '\f078';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #1e2a78;
        pointer-events: none;
        font-size: 12px;
    }
</style>
@endsection

@section('content')
@php
    $userName = Auth::user()->name ?? 'Admin';
    $firstName = explode(' ', $userName)[0];
    $initials = collect(explode(' ', $userName))->map(function($segment) {
        return strtoupper(substr($segment, 0, 1));
    })->join('');
    if (strlen($initials) > 2) $initials = substr($initials, 0, 2);

    $hour = now()->hour;
    $greeting = 'Good Morning';
    if ($hour >= 12 && $hour < 17) $greeting = 'Good Afternoon';
    elseif ($hour >= 17 && $hour < 21) $greeting = 'Good Evening';
    elseif ($hour >= 21 || $hour < 5) $greeting = 'Good Night';
@endphp

<div class="dashboard-header-wrapper">
    <div class="details-header">
        <div class="details-nav">
            <h1 class="greeting-text">{{ $greeting }}, {{ $firstName }}!</h1>
        </div>
        <div class="user-welcome">
            <a href="{{ route('settings.profile') }}" class="header-action-btn" title="Pengaturan Akun">
                <i class="fas fa-cog"></i>
            </a>
            <div class="header-action-btn">
                <i class="fas fa-bell"></i>
                <div class="notification-dot"></div>
            </div>
            <div class="user-profile-circle">{{ $initials }}</div>
        </div>
    </div>
</div>

<!-- TOP FULL WIDTH SECTION -->
<div class="top-dashboard-section">
    @if(count($latestTransactions ?? []) > 0)
        @php $first = $latestTransactions[0]; @endphp
        
        <div class="top-row-grid">
            <!-- SUMMARY CARDS (Swapped to Top) -->
            <div class="details-column">
                <div class="dashboard-content-grid">
                    <div class="summary-container">
                        <div class="summary-header" style="justify-content: space-between; align-items: flex-end; padding: 0 5px;">
                            <div class="chart-header-info" style="text-align: left; display: flex; flex-direction: column;">
                                <span class="chart-header-amount" id="detailAmount" style="font-size: 18px; margin-bottom: 2px;">Rp{{ number_format($netBalance, 0, ',', '.') }}</span>
                                <span class="chart-header-label" id="detailCategory" style="font-size: 9px;">TOTAL LABA BERSIH</span>
                            </div>
                            <div class="period-info" style="display: flex; flex-direction: column; align-items: flex-end;">
                                <span class="period-label" style="font-size: 9px; margin-bottom: 2px;">PERIODE</span>
                                <h2 class="period-value" id="detailPeriodLabel" style="font-size: 14px;">{{ $periodLabel }}</h2>
                            </div>
                        </div>

                        <div class="summary-grid" style="gap: 15px; grid-template-columns: 1.2fr 0.8fr;">
                            <!-- Card 1: Saldo Bersih Hari Ini -->
                            <div class="summary-card" style="padding: 15px; border-radius: 20px;">
                                <div class="card-top">
                                    <div class="card-title">
                                        <span class="label">SALDO BERSIH</span>
                                        <span class="sub-label">HARI INI</span>
                                    </div>
                                    <div class="card-icon icon-wallet" style="width: 30px; height: 30px; font-size: 12px;">
                                        <i class="fas fa-wallet"></i>
                                    </div>
                                </div>
                                <div class="card-value" id="detailBalanceToday" style="font-size: 16px; margin-bottom: 5px;">Rp{{ number_format($balanceToday, 0, ',', '.') }}</div>
                                <div class="card-footer" style="gap: 8px; font-size: 10px;">
                                    <div class="footer-item">
                                        <span class="footer-label">Penjualan</span>
                                        <span class="footer-val val-dark" id="detailCashInToday">Rp{{ number_format($cashInToday, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="footer-item">
                                        <span class="footer-label">Pembelian</span>
                                        <span class="footer-val val-red" id="detailCashOutToday">Rp{{ number_format($cashOutToday, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2: Volume Transaksi -->
                            <div class="summary-card" style="padding: 15px; border-radius: 20px;">
                                <div class="card-top">
                                    <div class="card-title">
                                        <span class="label">VOLUME</span>
                                        <span class="sub-label">TRANSAKSI</span>
                                    </div>
                                    <div class="card-icon icon-volume" style="width: 30px; height: 30px; font-size: 12px;">
                                        <i class="fas fa-exchange-alt"></i>
                                    </div>
                                </div>
                                <div class="card-value" id="detailTotalTransactions" style="font-size: 16px; margin-bottom: 5px;">{{ $totalTransactions }}</div>
                                <div class="card-footer">
                                    <a href="{{ route('transaksi.index') }}" class="footer-link" style="font-size: 10px;">Lihat <i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="summary-grid" style="gap: 15px; margin-top: 15px; grid-template-columns: 1fr 1fr;">
                            <!-- Card 3: Total Penjualan -->
                            <div class="summary-card" style="padding: 15px; border-radius: 20px;">
                                <div class="card-top">
                                    <div class="card-title">
                                        <span class="label">TOTAL</span>
                                        <span class="sub-label">PENJUALAN</span>
                                    </div>
                                    <div class="card-icon icon-in" style="width: 30px; height: 30px; font-size: 12px;">
                                        <i class="fas fa-arrow-down"></i>
                                    </div>
                                </div>
                                <div class="card-value" id="detailTotalKasMasuk" style="font-size: 16px; margin-bottom: 5px;">Rp{{ number_format($totalKasMasuk, 0, ',', '.') }}</div>
                                <div class="card-footer" style="font-size: 10px;">
                                    <span class="footer-val val-dark" id="detailCashInPercentage">{{ $cashInPercentageTotal }}%</span>
                                    <span class="footer-label">masuk</span>
                                </div>
                            </div>

                            <!-- Card 4: Total Pembelian -->
                            <div class="summary-card" style="padding: 15px; border-radius: 20px;">
                                <div class="card-top">
                                    <div class="card-title">
                                        <span class="label">TOTAL</span>
                                        <span class="sub-label">PEMBELIAN</span>
                                    </div>
                                    <div class="card-icon icon-out" style="width: 30px; height: 30px; font-size: 12px;">
                                        <i class="fas fa-arrow-up"></i>
                                    </div>
                                </div>
                                <div class="card-value" id="detailTotalKasKeluar" style="font-size: 16px; margin-bottom: 5px;">Rp{{ number_format($totalKasKeluar, 0, ',', '.') }}</div>
                                <div class="card-footer" style="font-size: 10px;">
                                    <span class="footer-val val-dark" id="detailCashOutPercentage">{{ $cashOutPercentageTotal }}%</span>
                                    <span class="footer-label">keluar</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="top-products-container">
                <div class="top-products-header">
                    <h2 class="top-products-title">Produk Terlaris</h2>
                    <div class="period-info">
                        <span class="period-label">PERIODE</span>
                        <div class="period-value" style="font-size: 14px;">{{ $periodLabel }}</div>
                    </div>
                </div>

                <div class="top-products-list" id="topProductsList">
                    @forelse($topProducts as $index => $product)
                        <div class="product-item">
                            <div class="product-rank rank-{{ $index + 1 }}">
                                {{ $index + 1 }}
                            </div>
                            <div class="product-info">
                                <div class="product-name">{{ $product['name'] }}</div>
                                <div class="product-stats">Volume Penjualan</div>
                            </div>
                            <div class="product-value">
                                <div class="product-qty">{{ number_format($product['total'], 0, ',', '.') }}</div>
                                <div class="product-label">Unit</div>
                            </div>
                        </div>
                    @empty
                        <div style="padding: 40px; text-align: center; color: #94a3b8;">Tidak ada data produk</div>
                    @endforelse
                </div>
            </div>

            <div class="detail-summary-card">
                <div class="summary-card-top" style="justify-content: flex-end; align-items: flex-start;">
                    <div class="summary-actions">
                        <div class="period-filter-container">
                            <select class="period-filter-select" onchange="filterPeriod(this.value)">
                                <option value="all" {{ $periodType === 'all' ? 'selected' : '' }}>Semua Data</option>
                                <option value="current_month" {{ $periodType === 'current_month' ? 'selected' : '' }}>Bulan Ini</option>
                                @foreach([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'] as $val => $name)
                                    <option value="month:{{ $val }}" {{ ($periodType === 'month' && (int)$periodMonth === $val) ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <!-- TREND CHART CONTAINER -->
                <div class="chart-container" style="height: 220px; width: 100%; margin-top: 10px; position: relative;">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>
    @endif
</div>

<div class="dashboard-wrapper">
    <div class="recents-column">
        <div class="recents-header">
            <h2 class="top-products-title">Transaksi Terbaru</h2>
            <div class="dropdown-transaction">
                <button class="btn-add-transaction" id="transactionDropdownBtn">
                    <i class="fas fa-plus"></i> Transaksi
                </button>
                <div class="dropdown-menu-custom" id="transactionDropdownMenu">
                    <div class="dropdown-section-label">TRANSAKSI PRODUK</div>
                    <a href="{{ route('kas-masuk.create') }}"><i class="fas fa-shopping-cart"></i> + Penjualan</a>
                    <a href="{{ route('kas-keluar.create') }}"><i class="fas fa-cart-plus"></i> + Pembelian</a>
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-section-label">TRANSAKSI KAS</div>
                    <a href="{{ route('cash.in.create') }}"><i class="fas fa-arrow-left"></i> + Kas Masuk</a>
                    <a href="{{ route('cash.out.create') }}"><i class="fas fa-arrow-right"></i> + Kas Keluar</a>
                </div>
            </div>
        </div>

        <div class="transaction-list" id="latestTransactionsList">
            @forelse($latestTransactions ?? [] as $index => $transaction)
                <div class="transaction-item {{ $index === 0 ? 'active' : '' }}" onclick="selectTransaction({{ $index }})">
                    <div class="icon-box-round {{ $transaction['type'] === 'in' ? 'icon-in' : 'icon-out' }}">
                        <i class="fas {{ $transaction['type'] === 'in' ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                    </div>
                    <div class="item-info">
                        <div class="item-title">Rp{{ $transaction['amount'] }}</div>
                        <div class="item-subtitle">{{ $transaction['category'] }}</div>
                    </div>
                    <div class="item-meta" style="text-align: right;">
                        @if(isset($transaction['notes']) && $transaction['notes'] === 'RETUR')
                            <div style="font-size: 9px; font-weight: 800; color: #ef4444; background: #fef2f2; padding: 2px 6px; border-radius: 4px; margin-bottom: 4px; display: inline-block;">RETUR</div>
                        @endif
                        <div class="item-subtitle" style="font-size: 10px;">{{ $transaction['date'] }}</div>
                    </div>
                </div>
            @empty
                <div style="padding: 20px; text-align: center; color: #94a3b8; font-size: 12px;">No transactions found</div>
            @endforelse
        </div>
    </div>
</div>

<script>
    const transactions = {!! json_encode($latestTransactions ?? []) !!};

    function selectTransaction(index) {
        // Only update active state in list, details are now replaced by summary
        document.querySelectorAll('.transaction-item').forEach((el, i) => {
            el.classList.toggle('active', i === index);
        });
    }

    function filterPeriod(value) {
        let url = new URL(window.location.href);
        if (value === 'all') {
            url.searchParams.set('period_type', 'all');
            url.searchParams.delete('period_month');
        } else if (value === 'current_month') {
            url.searchParams.set('period_type', 'current_month');
            url.searchParams.delete('period_month');
        } else if (value.startsWith('month:')) {
            let month = value.split(':')[1];
            url.searchParams.set('period_type', 'month');
            url.searchParams.set('period_month', month);
        }
        window.location.href = url.toString();
    }
</script>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Initialize Trend Chart using Chart.js
    let trendChart;
    const sparklineData = {!! json_encode($sparklineData ?? []) !!};
    
    document.addEventListener('DOMContentLoaded', function() {
        // Dropdown Transaction Logic
        const dropdownBtn = document.getElementById('transactionDropdownBtn');
        const dropdownMenu = document.getElementById('transactionDropdownMenu');

        if (dropdownBtn && dropdownMenu) {
            dropdownBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdownMenu.classList.toggle('show');
            });

            document.addEventListener('click', function(e) {
                if (!dropdownMenu.contains(e.target) && !dropdownBtn.contains(e.target)) {
                    dropdownMenu.classList.remove('show');
                }
            });
        }

        const ctx = document.getElementById('trendChart').getContext('2d');
        
        // Create Gradients with stronger contrast
        const blueGradient = ctx.createLinearGradient(0, 0, 0, 300);
        blueGradient.addColorStop(0, 'rgba(30, 42, 120, 0.3)'); // Stronger fill for Penjualan
        blueGradient.addColorStop(1, 'rgba(30, 42, 120, 0.0)');

        const lightBlueGradient = ctx.createLinearGradient(0, 0, 0, 300);
        lightBlueGradient.addColorStop(0, 'rgba(59, 130, 246, 0.1)'); // Softer fill for Pembelian
        lightBlueGradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

        trendChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: sparklineData.dates || [],
                datasets: [
                    {
                        label: 'Penjualan',
                        data: sparklineData.cashIn || [],
                        borderColor: '#1e2a78', // Strong Dark Blue
                        backgroundColor: blueGradient,
                        fill: true,
                        tension: 0.5,
                        borderWidth: 3,
                        pointRadius: 0,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#1e2a78',
                        pointBorderWidth: 2,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#1e2a78',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 2
                    },
                    {
                        label: 'Pembelian',
                        data: sparklineData.cashOut || [],
                        borderColor: '#3b82f6', // Vivid Blue (from the button)
                        backgroundColor: lightBlueGradient,
                        fill: true,
                        tension: 0.5,
                        borderWidth: 3,
                        pointRadius: 0,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#3b82f6',
                        pointBorderWidth: 2,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#3b82f6',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Hide legend to match image
                    },
                    tooltip: {
                        enabled: true,
                        mode: 'index',
                        intersect: false,
                        backgroundColor: '#312e81',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#312e81',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 15,
                        displayColors: false,
                        caretSize: 8,
                        titleFont: { family: 'Plus Jakarta Sans', weight: '800', size: 14 },
                        bodyFont: { family: 'Plus Jakarta Sans', weight: '600', size: 12 },
                        callbacks: {
                            title: function() { return ''; },
                            label: function(context) {
                                let value = context.parsed.y;
                                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(value);
                            },
                            afterBody: function(context) {
                                const index = context[0].dataIndex;
                                return sparklineData.fullDates[index];
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { family: 'Plus Jakarta Sans', size: 11, weight: '500' },
                            color: '#94a3b8',
                            maxRotation: 0,
                            autoSkip: true,
                            maxTicksLimit: 7,
                            callback: function(val, index) {
                                // Convert d/m to Day Name if possible, or just show as is
                                // For now let's just show the labels from data
                                return this.getLabelForValue(val);
                            }
                        },
                        border: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { display: false }, // Hide grid lines to match image
                        ticks: {
                            font: { family: 'Plus Jakarta Sans', size: 11, weight: '500' },
                            color: '#94a3b8',
                            callback: function(value) {
                                if (value === 0) return '0';
                                if (value >= 1000000) return (value / 1000000) + 'm';
                                if (value >= 1000) return (value / 1000) + 'k';
                                return value;
                            }
                        },
                        border: { display: false }
                    }
                }
            }
        });
    });

    // Auto-refresh logic for summary cards
    new AutoRefresh({
        apiUrl: "{{ route('api.dashboard.data') }}?period_type={{ $periodType }}&period_month={{ $periodMonth }}&start_date={{ $startDate }}&end_date={{ $endDate }}",
        interval: 10000,
        onUpdate: (data) => {
            const formatCurrency = (val) => {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(val).replace('IDR', 'Rp');
            };

            if (data.periodLabel) document.getElementById('detailPeriodLabel').textContent = data.periodLabel;
            if (data.balanceToday !== undefined) document.getElementById('detailBalanceToday').textContent = formatCurrency(data.balanceToday);
            if (data.cashInToday !== undefined) document.getElementById('detailCashInToday').textContent = formatCurrency(data.cashInToday);
            if (data.cashOutToday !== undefined) document.getElementById('detailCashOutToday').textContent = formatCurrency(data.cashOutToday);
            if (data.totalTransactions !== undefined) document.getElementById('detailTotalTransactions').textContent = data.totalTransactions;
            if (data.cashInThisMonth !== undefined) document.getElementById('detailTotalKasMasuk').textContent = formatCurrency(data.cashInThisMonth);
            if (data.cashOutThisMonth !== undefined) document.getElementById('detailTotalKasKeluar').textContent = formatCurrency(data.cashOutThisMonth);
            if (data.cashInPercentageTotal !== undefined) document.getElementById('detailCashInPercentage').textContent = data.cashInPercentageTotal + '%';
            if (data.cashOutPercentageTotal !== undefined) document.getElementById('detailCashOutPercentage').textContent = data.cashOutPercentageTotal + '%';
            if (data.netBalance !== undefined) document.getElementById('detailAmount').textContent = formatCurrency(data.netBalance);

            // Update Chart
            if (data.sparklineData && trendChart) {
                trendChart.data.labels = data.sparklineData.dates;
                trendChart.data.datasets[0].data = data.sparklineData.cashIn;
                trendChart.data.datasets[1].data = data.sparklineData.cashOut;
                trendChart.update('none'); // Update without animation for smoother refresh
            }
// ... rest of the onUpdate function remains the same

            // Update Top Products list
            if (data.topProducts && data.topProducts.length > 0) {
                let html = '';
                data.topProducts.forEach((product, index) => {
                    html += `
                        <div class="product-item">
                            <div class="product-rank rank-${index + 1}">
                                ${index + 1}
                            </div>
                            <div class="product-info">
                                <div class="product-name">${product.name}</div>
                                <div class="product-stats">Volume Penjualan</div>
                            </div>
                            <div class="product-value">
                                <div class="product-qty">${new Intl.NumberFormat('id-ID').format(product.total)}</div>
                                <div class="product-label">Unit</div>
                            </div>
                        </div>
                    `;
                });
                document.getElementById('topProductsList').innerHTML = html;
            } else if (data.topProducts && data.topProducts.length === 0) {
                document.getElementById('topProductsList').innerHTML = '<div style="padding: 40px; text-align: center; color: #94a3b8;">Tidak ada data produk</div>';
            }
        }
    });
</script>
@endsection
