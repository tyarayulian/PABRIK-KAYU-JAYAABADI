@extends('layouts.app')

@section('title', 'Transaksi Kas')
@section('breadcrumb', 'Transaksi Kas')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.8/pdfobject.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    * {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    html {
        scrollbar-gutter: stable;
    }

    .main-content {
        background-color: transparent !important;
        box-shadow: none !important;
        border: none !important;
    }

    .page-header {
        margin-bottom: 30px;
    }

    .page-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #000;
        margin-bottom: 8px;
    }

    .page-header p {
        font-size: 14px;
        color: #666;
    }

    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: #fff;
        padding: 18px 24px;
        border-radius: 20px;
        border: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .stat-icon.income {
        background-color: #f0fdf4;
        color: #16a34a;
    }

    .stat-icon.expense {
        background-color: #fef2f2;
        color: #dc2626;
    }

    .stat-icon.net {
        background-color: #f8fafc;
        color: #475569;
    }

    .stat-info {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .stat-card-label {
        font-size: 12px;
        color: #94a3b8;
        font-weight: 700;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .stat-card-value {
        font-size: 20px;
        font-weight: 800;
        color: #1e293b;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .stat-card-meta {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 500;
    }

    .table-section {
        background: white;
        border-radius: 20px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        width: 100%;
        box-sizing: border-box;
    }

    .table-title-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 24px 32px;
        gap: 16px;
        border-bottom: 1px solid #f1f5f9;
        background: white;
    }

    .table-title-section h2 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
        letter-spacing: -0.01em;
    }

    .table-title-section p {
        font-size: 14px;
        color: #64748b;
        margin: 0;
    }

    .filter-row {
        display: flex;
        gap: 16px;
        flex-wrap: nowrap;
        align-items: flex-end;
        padding: 24px 32px;
        background: white;
        border-bottom: 1px solid #f1f5f9;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .filter-group label {
        font-size: 11px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-left: 4px;
    }

    .filter-group input,
    .filter-group select {
        padding: 10px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
        color: #1e293b;
        background: #f8fafc;
        transition: all 0.2s;
        outline: none;
        height: 42px;
        box-sizing: border-box;
    }

    .filter-group input:focus {
        border-color: #1e2a78;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(30, 42, 120, 0.1);
    }

    .filter-actions {
        display: flex;
        gap: 8px;
        height: 42px;
        align-items: center;
    }

    .btn-filter {
        background: #0f172a;
        color: white;
        border: none;
        padding: 0 20px;
        height: 42px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-filter:hover {
        background: #1e293b;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .btn-reset-filter {
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #e2e8f0;
        padding: 0 16px;
        height: 42px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        text-decoration: none;
    }

    .btn-reset-filter:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .search-group {
        flex: 1;
        min-width: 250px;
        margin-left: auto;
    }

    .search-wrapper {
        position: relative;
        width: 100%;
    }

    .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }

    .search-input {
        width: 100%;
        padding: 10px 16px 10px 42px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
        background: #f8fafc;
        outline: none;
        height: 42px;
        transition: all 0.2s;
        box-sizing: border-box;
    }

    .search-input:focus {
        border-color: #1e2a78;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(30, 42, 120, 0.1);
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        transition: all 0.2s;
        cursor: pointer;
        text-decoration: none;
        border: none;
    }

    .btn-action-primary {
        background: #1e2a78;
        color: white;
        box-shadow: 0 4px 6px -1px rgba(30, 42, 120, 0.2);
    }

    .btn-action-primary:hover {
        background: #151f5e;
        transform: translateY(-1px);
        box-shadow: 0 10px 15px -3px rgba(30, 42, 120, 0.3);
        color: white;
    }

    .btn-outline {
        background: #fff;
        color: #1e2a78;
        border: 1px solid #1e2a78;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        transition: all 0.2s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }

    .btn-outline:hover {
        background: #f8fafc;
        border-color: #151f5e;
        color: #151f5e;
        transform: translateY(-1px);
    }

    .tabs-container {
        display: flex;
        gap: 60px;
        padding: 0 32px;
        border-bottom: 2px solid #f1f5f9;
        margin-bottom: 0;
        justify-content: center;
        background: white;
    }

    .tab-button {
        padding: 16px 0;
        font-size: 14px;
        font-weight: 700;
        color: #94a3b8;
        border: none;
        background: none;
        cursor: pointer;
        border-bottom: 3px solid transparent;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: all 0.2s;
        min-width: 100px;
    }

    .tab-button:hover {
        color: #64748b;
    }

    .tab-button.active {
        color: #1e2a78;
        border-bottom-color: #1e2a78;
    }

    .transaction-row {
        display: grid;
        grid-template-columns: 40px 120px 150px 1fr 140px 80px 120px;
        gap: 12px;
        align-items: start;
        padding: 18px 32px;
        border-bottom: 1px solid #f8fafc;
        transition: all 0.2s;
        background: white;
    }

    .transaction-row:hover {
        background: #fcfcfd !important;
    }

    .column-headers-grid {
        display: grid;
        grid-template-columns: 40px 120px 150px 1fr 140px 80px 120px;
        gap: 12px;
        align-items: center;
        padding: 16px 32px;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        font-weight: 700;
        font-size: 11px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .amount-positive { color: #059669; font-weight: 700; }
    .amount-negative { color: #f43f5e; font-weight: 700; }

    .empty-state {
        text-align: center;
        padding: 80px 32px;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 16px;
        color: #e2e8f0;
    }

    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 32px;
        padding-bottom: 32px;
    }

    .pagination-btn {
        min-width: 40px;
        height: 40px;
        border: 1px solid #e2e8f0;
        background: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s;
        font-weight: 600;
    }

    .pagination-btn:hover:not(.disabled):not(.active) {
        background: #f8fafc;
        color: #1e2a78;
        border-color: #1e2a78;
    }

    .pagination-btn.active {
        background: #1e2a78;
        color: white;
        border-color: #1e2a78;
    }

    .pagination-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 2000;
        align-items: center;
        justify-content: center;
        /* NO BLUR */
    }

    .modal-overlay.active { display: flex; }

    .modal-content {
        background: white;
        border-radius: 24px;
        padding: 32px;
        width: 90%;
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-header {
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h2 { font-size: 24px; font-weight: 800; color: #0f172a; margin: 0; }

    .modal-close-btn {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        font-size: 18px;
        color: #64748b;
        cursor: pointer;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }

    .btn-modal-cancel {
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #e2e8f0;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
    }

    .btn-modal-submit {
        background: #1e2a78;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<div style="padding: 0 20px 40px 20px;">
    <!-- STAT CARDS -->
    <div class="stat-cards-grid" style="margin-top: 30px;">
        <div class="stat-card">
            <div class="stat-icon income">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div class="stat-info">
                <div class="stat-card-label">Total Pemasukan</div>
                <div class="stat-card-value" id="statIncomeValue">Rp{{ number_format($allTransactions->where('type', 'income')->sum('amount'), 0, ',', '.') }}</div>
                <div class="stat-card-meta" id="statIncomeCount">{{ $allTransactions->where('type', 'income')->count() }} transaksi</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon expense">
                <i class="fas fa-arrow-up"></i>
            </div>
            <div class="stat-info">
                <div class="stat-card-label">Total Pengeluaran</div>
                <div class="stat-card-value" id="statExpenseValue">Rp{{ number_format($allTransactions->where('type', 'expense')->sum('amount'), 0, ',', '.') }}</div>
                <div class="stat-card-meta" id="statExpenseCount">{{ $allTransactions->where('type', 'expense')->count() }} transaksi</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon net">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="stat-info">
                <div class="stat-card-label">Saldo Kas</div>
                <div class="stat-card-value" id="statNetValue">Rp{{ number_format($allTransactions->where('type', 'income')->sum('amount') - $allTransactions->where('type', 'expense')->sum('amount'), 0, ',', '.') }}</div>
                <div class="stat-card-meta">Pemasukan - Pengeluaran</div>
            </div>
        </div>
    </div>

    <!-- COMBINED TRANSAKSI LIST -->
    <div class="table-section" id="combinedTableSection">
        <!-- TITLE AND ADD BUTTON -->
        <div class="table-title-section">
            <div>
                <h2>Riwayat Transaksi Kas</h2>
                <p id="totalTransactionsCount">Menampilkan total <strong>{{ $allTransactions->count() }}</strong> transaksi</p>
            </div>
            <div style="display: flex; gap: 12px; align-items: center;">
                <a href="{{ route('cash.in.create') }}" class="btn-action btn-action-primary">
                    <i class="fas fa-plus"></i> Pemasukan
                </a>
                <a href="{{ route('cash.out.create') }}" class="btn-action btn-action-primary" style="background: #dc2626;">
                    <i class="fas fa-minus"></i> Pengeluaran
                </a>
            </div>
        </div>

        <!-- FILTER ROW -->
        <div id="filterPanel" class="filter-row">
            <div class="filter-group">
                <label>MULAI</label>
                <input type="date" id="filterStartDate" value="{{ request('start_date') }}">
            </div>

            <div class="filter-group">
                <label>AKHIR</label>
                <input type="date" id="filterEndDate" value="{{ request('end_date') }}">
            </div>

            <div class="filter-actions">
                <button class="btn-filter" onclick="applyDateFilter()">
                    <i class="fas fa-filter"></i> Terapkan
                </button>
                <a href="{{ route('cash.index') }}" class="btn-reset-filter">
                    Reset
                </a>
            </div>

            <div class="search-group">
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="transactionSearch" class="search-input" placeholder="Cari keterangan..." onkeyup="filterTable()">
                </div>
            </div>
        </div>

        <!-- TRANSACTION TYPE TABS -->
        <div class="tabs-container">
            <button onclick="filterByTransactionType('all')" class="tab-button active" data-tab="all">Semua</button>
            <button onclick="filterByTransactionType('income')" class="tab-button" data-tab="income">Pemasukan</button>
            <button onclick="filterByTransactionType('expense')" class="tab-button" data-tab="expense">Pengeluaran</button>
        </div>

        <!-- COLUMN HEADERS -->
        <div class="column-headers-grid">
            <div style="text-align: center;">NO</div>
            <div style="text-align: left;">TANGGAL</div>
            <div style="text-align: left;">KATEGORI</div>
            <div style="text-align: left;">KETERANGAN</div>
            <div style="text-align: left;">JUMLAH</div>
            <div style="text-align: left;">BERKAS</div>
            <div style="text-align: left;">AKSI</div>
        </div>

        <!-- TRANSACTION LIST -->
        <div style="padding: 0;">
            @forelse($allTransactions as $index => $transaction)
                <div data-transaction-id="{{ $transaction['id'] }}" data-transaction-type="{{ $transaction['type'] }}" data-amount="Rp{{ number_format($transaction['amount'], 0, ',', '.') }}" class="transaction-row">
                    <!-- NO COLUMN -->
                    <div class="transaction-number" style="text-align: center; font-size: 13px; color: #94a3b8; font-weight: 500;">
                        {{ $loop->iteration }}
                    </div>

                    <!-- DATE COLUMN -->
                    <div style="text-align: left;">
                        <div style="font-size: 14px; color: #1e293b; font-weight: 600;">
                            {{ \Carbon\Carbon::parse($transaction['date'])->locale('id')->translatedFormat('d M Y') }}
                        </div>
                        <div style="font-size: 12px; color: #94a3b8; margin-top: 2px;">{{ \Carbon\Carbon::parse($transaction['date'])->format('H:i') }}</div>
                    </div>

                    <!-- CATEGORY -->
                    <div style="text-align: left;">
                        <div style="font-size: 14px; color: #1e293b; font-weight: 600;">
                            {{ $transaction['category']->name ?? 'N/A' }}
                        </div>
                    </div>

                    <!-- DESCRIPTION -->
                    <div style="text-align: left; width: 100%; overflow: hidden;">
                        <div style="font-size: 14px; color: #475569; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;" title="{{ $transaction['description'] ?? '-' }}">
                            {{ $transaction['description'] ?? '-' }}
                        </div>
                    </div>

                    <!-- AMOUNT -->
                    <div style="text-align: left;">
                        @if($transaction['type'] === 'income')
                            <div class="amount-positive">
                                +Rp{{ number_format($transaction['amount'], 0, ',', '.') }}
                            </div>
                        @else
                            <div class="amount-negative">
                                -Rp{{ number_format($transaction['amount'], 0, ',', '.') }}
                            </div>
                        @endif
                    </div>

                    <!-- FILE -->
                    <div style="text-align: left;">
                        @if($transaction['file_path'])
                            <div style="position: relative; display: inline-block;">
                                @php
                                    $fileExt = strtolower(pathinfo($transaction['file_path'], PATHINFO_EXTENSION));
                                    $isImage = in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                    $fileUrl = url('/storage/' . $transaction['file_path']);
                                @endphp
                                @if($isImage)
                                    <img src="{{ $fileUrl }}" style="width: 36px; height: 36px; border-radius: 8px; object-fit: cover; cursor: pointer; border: 1px solid #e2e8f0;" onclick="openViewer('{{ $fileUrl }}', 'image')">
                                @else
                                    <div style="width: 36px; height: 36px; border-radius: 8px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; cursor: pointer;" onclick="openViewer('{{ $fileUrl }}', 'file')">
                                        <i class="fas fa-file" style="color: #64748b;"></i>
                                    </div>
                                @endif
                            </div>
                        @else
                            <span style="font-size: 13px; color: #d1d5db;">-</span>
                        @endif
                    </div>

                    <!-- ACTIONS -->
                    <div style="text-align: left; display: flex; gap: 8px; align-items: center;">
                        <button style="background: #f1f5f9; color: #1e293b; border: 1px solid #e2e8f0; width: 34px; height: 34px; border-radius: 10px; cursor: pointer; display: flex; align-items: center; justify-content: center;" onclick="showTransactionDetail({{ $transaction['id'] }}, '{{ $transaction['type'] }}')"><i class="fas fa-eye"></i></button>
                        
                        <button style="background: #f8fafc; color: #1e2a78; border: 1px solid #e2e8f0; width: 34px; height: 34px; border-radius: 10px; cursor: pointer; display: flex; align-items: center; justify-content: center;" onclick="editTransaction('{{ $transaction['type'] }}', {{ $transaction['id'] }})"><i class="fas fa-edit"></i></button>
                        
                        <button style="background: #fff1f2; color: #f43f5e; border: 1px solid #ffe4e6; width: 34px; height: 34px; border-radius: 10px; cursor: pointer; display: flex; align-items: center; justify-content: center;" onclick="deleteTransaction('{{ $transaction['type'] }}', {{ $transaction['id'] }})"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <p>Belum ada data transaksi kas yang ditemukan</p>
                </div>
            @endforelse
        </div>

        <!-- PAGINATION CONTAINER -->
        <div id="paginationContainer" class="pagination-container" style="display: none;"></div>
    </div>
</div>

<!-- DETAIL TRANSACTION MODAL -->
<div id="detailTransactionModal" class="modal-overlay">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h2>Detail Transaksi</h2>
            <button type="button" class="modal-close-btn" onclick="closeDetailModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div style="padding: 24px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label style="display: block; font-size: 12px; color: #6b7280; text-transform: uppercase; font-weight: 600; margin-bottom: 6px;">Tanggal</label>
                    <div id="detailDate" style="font-size: 14px; color: #111827; font-weight: 500;"></div>
                </div>
                <div>
                    <label style="display: block; font-size: 12px; color: #6b7280; text-transform: uppercase; font-weight: 600; margin-bottom: 6px;">Tipe</label>
                    <div id="detailType" style="font-size: 14px; color: #111827; font-weight: 500; display: inline-block; padding: 6px 12px; background: #f3f4f6; border-radius: 6px;"></div>
                </div>
            </div>

            <div style="margin-top: 20px;">
                <label style="display: block; font-size: 12px; color: #6b7280; text-transform: uppercase; font-weight: 600; margin-bottom: 6px;">Kategori</label>
                <div id="detailCategory" style="font-size: 14px; color: #111827; font-weight: 500;"></div>
            </div>

            <div style="margin-top: 20px;">
                <label style="display: block; font-size: 12px; color: #6b7280; text-transform: uppercase; font-weight: 600; margin-bottom: 6px;">Keterangan</label>
                <div id="detailDescription" style="font-size: 14px; color: #111827; font-weight: 400; line-height: 1.6;"></div>
            </div>

            <div style="margin-top: 20px;">
                <label style="display: block; font-size: 12px; color: #6b7280; text-transform: uppercase; font-weight: 600; margin-bottom: 6px;">Jumlah</label>
                <div id="detailAmount" style="font-size: 18px; color: #111827; font-weight: 700;"></div>
            </div>

            <div style="margin-top: 20px;">
                <label style="display: block; font-size: 12px; color: #6b7280; text-transform: uppercase; font-weight: 600; margin-bottom: 6px;">File Lampiran</label>
                <div id="detailFile" style="font-size: 14px; color: #111827;"></div>
            </div>
        </div>

        <div class="modal-footer" style="padding: 16px 24px; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end; gap: 12px;">
            <button type="button" class="btn-modal-cancel" onclick="closeDetailModal()">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal Pemasukan/Pengeluaran -->
<div id="transactionModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle">Tambah Pemasukan</h2>
            <button class="modal-close-btn" onclick="closeModal()">&times;</button>
        </div>
        <form id="transactionForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="type" id="txType">
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #334155; font-size: 13px; text-transform: uppercase;">Tanggal</label>
                <input type="date" name="date" id="txDate" required value="{{ date('Y-m-d') }}" style="width: 100%; padding: 12px 16px; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 15px; box-sizing: border-box; background: #f8fafc;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #334155; font-size: 13px; text-transform: uppercase;">Kategori</label>
                <select name="category_id" id="txCategory" required style="width: 100%; padding: 12px 16px; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 15px; box-sizing: border-box; background: #f8fafc;">
                    <option value="">Pilih Kategori</option>
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #334155; font-size: 13px; text-transform: uppercase;">Keterangan</label>
                <textarea name="description" id="txDescription" required style="width: 100%; padding: 12px 16px; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 15px; box-sizing: border-box; background: #f8fafc; resize: vertical; min-height: 80px;"></textarea>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #334155; font-size: 13px; text-transform: uppercase;">Jumlah (Rp)</label>
                <input type="number" name="amount" id="txAmount" required min="1" style="width: 100%; padding: 12px 16px; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 15px; box-sizing: border-box; background: #f8fafc;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #334155; font-size: 13px; text-transform: uppercase;">Lampiran (Optional)</label>
                <input type="file" name="file" id="txFile" style="width: 100%; padding: 10px; border: 2px dashed #d1d5db; border-radius: 12px; background: #f9fafb;">
            </div>

            <div class="modal-footer" style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px;">
                <button type="button" class="btn-modal-cancel" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-modal-submit">Simpan Transaksi</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const ITEMS_PER_PAGE = 10;
    let currentPage = 1;
    let allVisibleTransactions = [];
    let currentTransactionTypeFilter = 'all';
    const akunMasuk = @json($akunMasuk);
    const akunKeluar = @json($akunKeluar);

    function filterTable() {
        const searchQuery = document.getElementById('transactionSearch').value.toLowerCase();
        const rows = document.querySelectorAll('.transaction-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const type = row.dataset.transactionType;
            const fullText = row.innerText.toLowerCase();
            
            const typeMatch = (currentTransactionTypeFilter === 'all' || currentTransactionTypeFilter === type);
            const searchMatch = !searchQuery || fullText.includes(searchQuery);

            if (typeMatch && searchMatch) {
                row.style.display = 'grid';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        document.getElementById('totalTransactionsCount').innerHTML = `Menampilkan total <strong>${visibleCount}</strong> transaksi`;
        updatePagination(visibleCount);
    }

    function filterByTransactionType(type) {
        currentTransactionTypeFilter = type;
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.tab === type);
        });
        filterTable();
    }

    function applyDateFilter() {
        const start = document.getElementById('filterStartDate').value;
        const end = document.getElementById('filterEndDate').value;
        let url = new URL(window.location.href);
        if (start) url.searchParams.set('start_date', start);
        if (end) url.searchParams.set('end_date', end);
        window.location.href = url.toString();
    }

    function showTransactionDetail(id, type) {
        const url = `/api/cash/${type}/${id}`;
        fetch(url)
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    const data = res.data;
                    document.getElementById('detailDate').textContent = new Date(data.date).toLocaleDateString('id-ID', {day:'numeric', month:'long', year:'numeric'});
                    document.getElementById('detailType').textContent = data.type === 'income' ? 'Pemasukan' : 'Pengeluaran';
                    document.getElementById('detailCategory').textContent = data.category_name || '-';
                    document.getElementById('detailDescription').textContent = data.description || '-';
                    document.getElementById('detailAmount').textContent = 'Rp' + parseInt(data.amount).toLocaleString('id-ID');
                    
                    if (data.file_url) {
                        document.getElementById('detailFile').innerHTML = `<a href="${data.file_url}" target="_blank" style="color: #1e2a78; font-weight: 600;">Lihat Lampiran</a>`;
                    } else {
                        document.getElementById('detailFile').textContent = '-';
                    }
                    
                    document.getElementById('detailTransactionModal').classList.add('active');
                }
            });
    }

    function closeDetailModal() {
        document.getElementById('detailTransactionModal').classList.remove('active');
    }

    function openModal(type, id = null) {
        const modal = document.getElementById('transactionModal');
        const form = document.getElementById('transactionForm');
        const title = document.getElementById('modalTitle');
        const txTypeInput = document.getElementById('txType');
        const categorySelect = document.getElementById('txCategory');
        
        txTypeInput.value = type;
        categorySelect.innerHTML = '<option value="">Pilih Kategori</option>';
        
        const categories = type === 'income' ? akunMasuk : akunKeluar;
        categories.forEach(cat => {
            const opt = document.createElement('option');
            opt.value = cat.id;
            opt.textContent = cat.name;
            categorySelect.appendChild(opt);
        });

        if (id) {
            title.textContent = type === 'income' ? 'Edit Pemasukan' : 'Edit Pengeluaran';
            document.getElementById('formMethod').value = 'PUT';
            fetchTransactionDetail(type, id);
        } else {
            title.textContent = type === 'income' ? 'Tambah Pemasukan' : 'Tambah Pengeluaran';
            document.getElementById('formMethod').value = 'POST';
            form.reset();
            document.getElementById('txDate').value = '{{ date('Y-m-d') }}';
            form.action = type === 'income' ? '{{ route('cash.in.store') }}' : '{{ route('cash.out.store') }}';
        }

        modal.classList.add('active');
    }

    function closeModal() {
        document.getElementById('transactionModal').classList.remove('active');
    }

    function fetchTransactionDetail(type, id) {
        const url = type === 'income' ? `/cash/in/${id}` : `/cash/out/${id}`;
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                const data = res.data;
                document.getElementById('txDate').value = data.date.split(' ')[0];
                document.getElementById('txCategory').value = data.category_id;
                document.getElementById('txDescription').value = data.description;
                document.getElementById('txAmount').value = data.amount;
                document.getElementById('transactionForm').action = type === 'income' ? `/cash/in/${id}` : `/cash/out/${id}`;
            }
        });
    }

    document.getElementById('transactionForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                Swal.fire('Berhasil', res.message, 'success').then(() => location.reload());
            } else {
                Swal.fire('Gagal', res.message, 'error');
            }
        });
    });

    function deleteTransaction(type, id) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1e2a78',
            cancelButtonColor: '#f1f5f9',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = type === 'income' ? `/cash/in/${id}` : `/cash/out/${id}`;
                fetch(url, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        Swal.fire('Dihapus!', res.message, 'success').then(() => location.reload());
                    }
                });
            }
        });
    }

    function editTransaction(type, id) {
        openModal(type, id);
    }

    function openViewer(url, type) {
        window.open(url, '_blank');
    }
</script>
@endsection
