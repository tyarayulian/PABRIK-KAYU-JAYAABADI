@extends('layouts.app')

@section('title', 'Transaksi')
@section('breadcrumb', 'Transaksi')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.8/pdfobject.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/modal.css') }}?v={{ time() }}">
<style>
    * {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    html {
        scrollbar-gutter: stable;
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
        padding: 24px;
        border-radius: 25px;
        border: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
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
    }

    .stat-card-label {
        font-size: 14px;
        color: #999;
        font-weight: 600;
        margin: 0;
    }

    .stat-card-value {
        font-size: 24px;
        font-weight: 800;
        color: #000;
        margin: 0;
    }

    .stat-card-meta {
        font-size: 12px;
        color: #999;
        margin-top: 4px;
    }

    .table-section {
        background: white;
        border-radius: 30px;
        border: 1px solid #f0f0f0;
        overflow: hidden;
        margin-bottom: 30px;
    }

    .table-title-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 24px;
        gap: 16px;
    }

    .table-title-section h2 {
        font-size: 20px;
        font-weight: 800;
        color: #000;
        margin: 0;
    }

    .filter-row {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        align-items: center;
        padding: 0 24px 24px 24px;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .filter-group label {
        font-size: 12px;
        font-weight: 700;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .filter-group input,
    .filter-group select {
        padding: 10px 16px;
        border: 1px solid #eee;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 500;
        color: #000;
        background: #fcfcfc;
        transition: all 0.2s;
        outline: none;
    }

    .filter-group input:focus,
    .filter-group select:focus {
        border-color: #000;
        background: #fff;
    }

    .btn-filter {
        background: #000;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-filter:hover {
        background: #333;
        transform: translateY(-2px);
    }

    .btn-reset-filter {
        background: #f5f5f5;
        color: #666;
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-add {
        background: #000;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-add:hover {
        background: #333;
        transform: translateY(-2px);
        color: white;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #fcfcfc;
        padding: 20px 24px;
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #f0f0f0;
    }

    td {
        padding: 20px 24px;
        font-size: 14px;
        color: #444;
        border-bottom: 1px solid #f0f0f0;
    }

    tr:last-child td {
        border-bottom: none;
    }

    tr:hover td {
        background: #fcfcfc;
    }

    .amount-positive {
        color: #16a34a;
        font-weight: 700;
    }

    .amount-negative {
        color: #dc2626;
        font-weight: 700;
    }

    .btn-delete {
        background: #fef2f2;
        color: #dc2626;
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-delete:hover {
        background: #fee2e2;
        transform: translateY(-2px);
    }

    .btn-cancel {
        background: #f5f5f5;
        color: #666;
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 2000;
        align-items: center;
        justify-content: center;
        /* NO BLUR */
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 30px;
        padding: 40px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.1);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .modal-header h2 {
        font-size: 24px;
        font-weight: 800;
        color: #000;
        margin: 0;
    }

    .modal-close-btn {
        background: #f5f5f5;
        border: none;
        font-size: 20px;
        color: #666;
        cursor: pointer;
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-group-modal {
        margin-bottom: 20px;
    }

    .form-group-modal label {
        display: block;
        margin-bottom: 10px;
        font-weight: 700;
        color: #000;
        font-size: 13px;
        text-transform: uppercase;
    }

    .form-group-modal input,
    .form-group-modal select,
    .form-group-modal textarea {
        width: 100%;
        padding: 15px;
        border: 1px solid #eee;
        border-radius: 15px;
        font-size: 14px;
        background: #fcfcfc;
        outline: none;
    }

    .modal-footer {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
    }

    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin: 30px 0;
    }

    .pagination-btn {
        min-width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border: 1px solid #eee;
        color: #000;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }

    .pagination-btn:hover:not(.disabled):not(.active) {
        background: #f5f5f5;
        border-color: #ddd;
    }

    .pagination-btn.active {
        background: #000;
        color: #fff;
        border-color: #000;
    }

    .pagination-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background: #f9f9f9;
    }

    /* Selection Styles */
    .row-selected {
        background-color: #f8fafc !important;
    }

    .selection-cell {
        width: 50px;
        text-align: center;
    }

    .custom-checkbox {
        width: 20px;
        height: 20px;
        border-radius: 6px;
        border: 2px solid #ddd;
        cursor: pointer;
        display: inline-block;
        position: relative;
        transition: all 0.2s;
    }

    .custom-checkbox.checked {
        background-color: #000;
        border-color: #000;
    }

    .custom-checkbox.checked::after {
        content: '\f00c';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        color: white;
        font-size: 10px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>
@endsection

@section('content')
<div class="page-container">
    <!-- PAGE HEADER -->
    <div class="page-header">
        <h1>Transaksi</h1>
        <p>Kelola semua transaksi kas masuk dan kas keluar</p>
    </div>

    <!-- STAT CARDS -->
    <div class="stat-cards-grid">
        <div class="stat-card">
            <div class="stat-icon income">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div class="stat-info">
                <p class="stat-card-label">Total Pemasukan</p>
                <p class="stat-card-value" id="statIncomeValue">Rp{{ number_format($cashIns->sum('amount'), 0, ',', '.') }}</p>
                <p class="stat-card-meta" id="statIncomeCount">{{ $cashIns->count() }} transaksi</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon expense">
                <i class="fas fa-arrow-up"></i>
            </div>
            <div class="stat-info">
                <p class="stat-card-label">Total Pengeluaran</p>
                <p class="stat-card-value" id="statExpenseValue">Rp{{ number_format($cashOuts->sum('amount'), 0, ',', '.') }}</p>
                <p class="stat-card-meta" id="statExpenseCount">{{ $cashOuts->count() }} transaksi</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon net">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="stat-info">
                <p class="stat-card-label">Saldo Bersih</p>
                <p class="stat-card-value" id="statNetValue">Rp{{ number_format($cashIns->sum('amount') - $cashOuts->sum('amount'), 0, ',', '.') }}</p>
                <p class="stat-card-meta">Pemasukan - Pengeluaran</p>
            </div>
        </div>
    </div>

    <!-- COMBINED TRANSAKSI LIST -->
    <div class="table-section" id="combinedTableSection">
        <!-- TITLE AND ADD BUTTON -->
        <div class="table-title-section">
            <div>
                <h2>Daftar Transaksi</h2>
                <p id="totalTransactionsCount" style="font-size: 14px; color: #999; margin-top: 4px;">Total: {{ $allTransactions->count() }} transaksi</p>
            </div>
            <div style="display: flex; gap: 12px;">
                <a href="{{ route('kas-masuk.create') }}" class="btn-add" style="text-decoration: none;">
                    <i class="fas fa-plus"></i> Pemasukan
                </a>
                <a href="{{ route('kas-keluar.create') }}" class="btn-add" style="background: #dc2626; text-decoration: none;">
                    <i class="fas fa-minus"></i> Pengeluaran
                </a>
                <button class="btn-filter" style="background: #f5f5f5; color: #000;" id="selectModeBtn" onclick="toggleSelectMode()">
                    <i class="fas fa-check-square"></i> Pilih
                </button>
                <button class="btn-delete" id="bulkDeleteBtn" onclick="bulkDeleteTransactions()" style="display: none;">
                    <i class="fas fa-trash"></i> Hapus Terpilih
                </button>
                <button class="btn-cancel" id="cancelSelectBtn" onclick="toggleSelectMode()" style="display: none;">
                    Batal
                </button>
            </div>
        </div>

        <div id="filterPanel" class="filter-row">
            <div style="display: flex; align-items: center; width: 100%; margin-bottom: 20px;">
                <div class="filter-group">
                    <label>Tipe Transaksi</label>
                    <select id="transactionTypeSelect" onchange="filterTable()">
                        <option value="all">Semua Transaksi</option>
                        <option value="income">Pemasukan</option>
                        <option value="expense">Pengeluaran</option>
                    </select>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 20px; width: 100%;">
                <div class="filter-group">
                    <label>Tipe Filter</label>
                    <select id="filterType" onchange="updateFilterOptions()">
                        <option value="monthly">Per Bulan</option>
                        <option value="yearly">Per Tahun</option>
                        <option value="custom">Custom Range</option>
                    </select>
                </div>

                <div class="filter-group" id="yearGroup">
                    <label>Tahun</label>
                    <select id="filterYear"></select>
                </div>

                <div class="filter-group" id="monthGroup">
                    <label>Bulan</label>
                    <select id="filterMonth" style="min-width: 120px; padding: 6px 10px; font-size: 12px;"></select>
                </div>

                <div class="filter-group" id="startDateGroup" style="display: none;">
                    <label>Mulai</label>
                    <input type="date" id="filterStartDate" style="padding: 6px 10px; font-size: 12px;">
                </div>

                <div class="filter-group" id="endDateGroup" style="display: none;">
                    <label>Akhir</label>
                    <input type="date" id="filterEndDate" style="padding: 6px 10px; font-size: 12px;">
                </div>

                <div style="display: flex; gap: 8px; margin-left: auto;">
                    <button class="btn-filter" onclick="applyDateFilter()" style="padding: 6px 14px; font-size: 12px;"><i class="fas fa-search"></i> Terapkan</button>
                    <button class="btn-reset-filter" onclick="resetDateFilter()" style="padding: 6px 14px; font-size: 12px;">Reset</button>
                </div>
            </div>
        </div>

        <!-- COLUMN HEADERS -->
        <div id="columnHeadersRow" style="display: grid; grid-template-columns: 50px 100px 150px 1fr 130px 90px 140px; gap: 0; align-items: center; padding: 20px 24px; background: #fcfcfc; border-bottom: 1px solid #f0f0f0; font-weight: 700; font-size: 12px; color: #999; text-transform: uppercase; letter-spacing: 0.05em;">
            <div id="checkboxHeaderCol" style="display: none; text-align: center;">
                <input type="checkbox" id="selectAllTransactions" onchange="selectAllTransactionCheckboxes()" style="cursor: pointer;">
            </div>
            <div style="text-align: center;">No</div>
            <div style="text-align: left;">Tanggal</div>
            <div style="text-align: left;">Kategori</div>
            <div style="text-align: left;">Keterangan</div>
            <div style="text-align: left;">Jumlah</div>
            <div style="text-align: left;">Berkas</div>
            <div style="text-align: left;">Aksi</div>
        </div>

        <!-- TRANSACTION LIST -->
        <div style="padding: 0;">
            @forelse($allTransactions as $index => $transaction)
                <div data-transaction-id="{{ $transaction['id'] }}" data-transaction-type="{{ $transaction['type'] }}" data-item-index="{{ $index }}" data-amount="Rp{{ number_format($transaction['amount'], 0, ',', '.') }}" class="transaction-row" style="display: grid; grid-template-columns: 50px 100px 150px 1fr 130px 90px 140px; gap: 0; align-items: center; padding: 20px 24px; border-bottom: 1px solid #f0f0f0; transition: all 0.2s; background: white;">
                    <!-- CHECKBOX COLUMN -->
                    <div id="checkboxCell-{{ $transaction['id'] }}" class="checkbox-col" style="display: none; text-align: center;">
                        <input type="checkbox" class="transaction-checkbox" value="{{ $transaction['id'] }}" onchange="toggleBulkDeleteBtnTransactions()" style="cursor: pointer;">
                    </div>

                    <!-- NO COLUMN -->
                    <div class="transaction-number" style="text-align: center; font-size: 13px; color: #999; font-weight: 500;">
                        {{ $loop->iteration }}
                    </div>

                    <!-- DATE COLUMN -->
                    <div style="text-align: left;">
                        <div style="font-size: 14px; color: #000; font-weight: 700;">
                            {{ $transaction['date']->locale('id')->translatedFormat('d M Y') }}
                        </div>
                        <div style="font-size: 12px; color: #999; margin-top: 2px;">{{ $transaction['date']->format('H:i') }}</div>
                    </div>

                    <!-- CATEGORY BADGE -->
                    <div style="text-align: left;">
                        <span style="font-size: 14px; font-weight: 500; color: #000;">{{ $transaction['account']->name }}</span>
                    </div>

                    <!-- DESCRIPTION -->
                    <div style="text-align: left; width: 100%; overflow: hidden;">
                        <div style="font-size: 14px; color: #666; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;" title="{{ $transaction['description'] ?? '-' }}">
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
                                    $isImage = in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif']);
                                    $isPdf = $fileExt === 'pdf';
                                @endphp
                                @if($isImage)
                                    <img src="{{ Storage::url($transaction['file_path']) }}" style="width: 32px; height: 32px; border-radius: 8px; object-fit: cover; cursor: pointer; border: 1px solid #eee;" onclick="openImageViewer('{{ Storage::url($transaction['file_path']) }}', '{{ basename($transaction['file_path']) }}')" title="Klik untuk lihat gambar">
                                @elseif($isPdf)
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #fef2f2; border: 1px solid #fee2e2; display: flex; align-items: center; justify-content: center; cursor: pointer;" onclick="openPdfViewer('{{ Storage::url($transaction['file_path']) }}', '{{ basename($transaction['file_path']) }}')" title="Klik untuk lihat PDF">
                                        <span style="color: #dc2626; font-size: 9px; font-weight: 800;">PDF</span>
                                    </div>
                                @else
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #f5f5f5; border: 1px solid #eee; display: flex; align-items: center; justify-content: center; cursor: pointer;" onclick="window.open('{{ Storage::url($transaction['file_path']) }}', '_blank')" title="Klik untuk download">
                                        <i class="fas fa-file" style="color: #666; font-size: 14px;"></i>
                                    </div>
                                @endif
                            </div>
                        @else
                            <span style="font-size: 13px; color: #ddd;">-</span>
                        @endif
                    </div>

                    <!-- ACTIONS -->
                    <div style="text-align: left; display: flex; gap: 8px; align-items: center;">
                        <button style="background: #f5f5f5; color: #000; border: none; padding: 0; width: 32px; height: 32px; border-radius: 8px; font-size: 12px; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center;" title="Lihat" onclick="showTransactionDetail({{ $transaction['id'] }}, '{{ $transaction['type'] }}')"><i class="fas fa-eye"></i></button>
                        <button style="background: #fcfcfc; color: #000; border: 1px solid #eee; padding: 0; width: 32px; height: 32px; border-radius: 8px; font-size: 12px; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center;" title="Edit" onclick="editTransaction({{ $transaction['id'] }}, '{{ $transaction['type'] }}')"><i class="fas fa-edit"></i></button>
                        <button style="background: #fef2f2; color: #dc2626; border: none; padding: 0; width: 32px; height: 32px; border-radius: 8px; font-size: 12px; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center;" title="Hapus" onclick="deleteTransaction({{ $transaction['id'] }}, '{{ $transaction['type'] }}')"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <p>Belum ada data transaksi yang ditemukan</p>
                </div>
            @endforelse
        </div>

        <!-- PAGINATION CONTAINER -->
        <div id="paginationContainer" class="pagination-container" style="display: none;"></div>
    </div>
</div>

<!-- MODAL TAMBAH TRANSAKSI -->
<div id="addTransactionModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Tambah Transaksi</h2>
            <button type="button" class="modal-close-btn" onclick="closeAddModal()">
                &times;
            </button>
        </div>
        <form id="transactionForm">
            @csrf
            <div class="form-group-modal">
                <label>Tipe Transaksi *</label>
                <div class="radio-group" style="display: flex; gap: 20px; margin-top: 10px;">
                    <div class="radio-option" style="display: flex; align-items: center; gap: 8px;">
                        <input type="radio" id="modalTypeIncome" name="type" value="income" checked onchange="updateModalAccounts()" style="width: auto;">
                        <label for="modalTypeIncome" style="margin: 0; text-transform: none; font-weight: 500;">Pemasukan</label>
                    </div>
                    <div class="radio-option" style="display: flex; align-items: center; gap: 8px;">
                        <input type="radio" id="modalTypeExpense" name="type" value="expense" onchange="updateModalAccounts()" style="width: auto;">
                        <label for="modalTypeExpense" style="margin: 0; text-transform: none; font-weight: 500;">Pengeluaran</label>
                    </div>
                </div>
            </div>

            <div class="form-group-modal">
                <label for="transactionDate">Tanggal *</label>
                <input type="date" id="transactionDate" name="date" required onchange="clearDateError()" onblur="clearDateError()">
                <span id="dateError" class="error-message">Anda belum memasukan tanggal</span>
            </div>

            <div class="form-group-modal">
                <label for="transactionAccount">Akun *</label>
                <select id="transactionAccount" name="category_id" required onchange="updateAccountLabel(); clearAccountError();" onblur="clearAccountError()">
                    <option value="">-- Pilih Akun --</option>
                    <optgroup id="incomeAccounts" label="Akun Pemasukan">
                        @foreach($inAccounts as $account)
                            <option value="{{ $account->id }}" data-code="{{ $account->code }}" data-name="{{ $account->name }}">{{ $account->code }} - {{ $account->name }}</option>
                        @endforeach
                    </optgroup>
                </select>
                <span id="accountError" class="error-message">Anda belum memilih akun</span>
            </div>

            <div class="form-group-modal">
                <label for="transactionDescription" id="descriptionLabel">Keterangan / Deskripsi</label>
                <textarea id="transactionDescription" name="description" placeholder="Masukkan keterangan..." style="min-height: 100px; resize: vertical;"></textarea>
                <small id="descriptionHint" style="display: none;"></small>
                <span id="descriptionError" class="error-message">Anda belum mengisi keterangan</span>
            </div>

            <div class="form-group-modal">
                <label for="transactionAmount">Jumlah (Rp) *</label>
                <input type="number" id="transactionAmount" name="amount" placeholder="0" min="0" step="0.01" required onchange="clearAmountError()" onblur="clearAmountError()" oninput="clearAmountError()">
                <span id="amountError" class="error-message">Anda belum memasukan jumlah</span>
            </div>

            <div class="form-group-modal">
                <label>File Lampiran (Opsional)</label>
                <div class="file-input-wrapper">
                    <label for="fileInput" class="file-input-label" id="fileLabel">
                        <i class="fas fa-cloud-upload-alt"></i> Klik untuk upload file (JPG, PNG, PDF max 2MB)
                    </label>
                    <input type="file" id="fileInput" name="file" accept=".jpeg,.png,.jpg,.pdf" onchange="handleFileSelect()" style="display: none;">
                </div>
                <div id="fileInfo" class="file-info"></div>
            </div>
        </form>

        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeAddModal()">Batal</button>
            <button type="button" class="btn-add" onclick="saveTransaction()">Simpan</button>
        </div>
    </div>
</div>

<!-- MODAL EDIT TRANSAKSI -->
<div id="editTransactionModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Transaksi</h2>
            <button type="button" class="modal-close-btn" onclick="closeEditModal()">
                &times;
            </button>
        </div>
        <form id="editTransactionForm">
            @csrf
            @method('PUT')
            <input type="hidden" id="editTransactionId">
            <input type="hidden" id="editTransactionType">

            <div class="form-group-modal">
                <label for="editTransactionDate">Tanggal *</label>
                <input type="date" id="editTransactionDate" name="date" required>
            </div>

            <div class="form-group-modal">
                <label for="editTransactionAccount">Akun *</label>
                <select id="editTransactionAccount" name="category_id" required onchange="updateEditAccountLabel()">
                    <option value="">-- Pilih Akun --</option>
                </select>
            </div>

            <div class="form-group-modal">
                <label for="editTransactionDescription" id="editDescriptionLabel">Keterangan / Deskripsi</label>
                <textarea id="editTransactionDescription" name="description" placeholder="Masukkan keterangan..." style="min-height: 100px; resize: vertical;"></textarea>
                <small id="editDescriptionHint" style="display: none;"></small>
            </div>

            <div class="form-group-modal">
                <label for="editTransactionAmount">Jumlah (Rp) *</label>
                <input type="text" id="editTransactionAmount" name="amount" placeholder="Rp 0" required>
            </div>

            <div class="form-group-modal">
                <label>File Lampiran (Opsional)</label>
                <div id="editCurrentFile" style="margin-bottom: 10px;"></div>
                <div class="file-input-wrapper">
                    <label for="editFileInput" class="file-input-label" id="editFileLabel">
                        <i class="fas fa-cloud-upload-alt"></i> Klik untuk ganti file (JPG, PNG, PDF max 2MB)
                    </label>
                    <input type="file" id="editFileInput" name="file" accept=".jpeg,.png,.jpg,.pdf" onchange="handleEditFileSelect()" style="display: none;">
                </div>
                <div id="editFileInfo" class="file-info"></div>
            </div>
        </form>

        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeEditModal()">Batal</button>
            <button type="button" class="btn-add" onclick="saveEditTransaction()">Perbarui</button>
        </div>
    </div>
</div>

<!-- DETAIL TRANSACTION MODAL -->
<div id="detailTransactionModal" class="modal-overlay">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h2>Detail Transaksi</h2>
            <button type="button" class="modal-close-btn" onclick="closeDetailModal()">
                &times;
            </button>
        </div>
        <div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label style="display: block; font-size: 12px; color: #999; text-transform: uppercase; font-weight: 700; margin-bottom: 8px;">Tanggal</label>
                    <div id="detailDate" style="font-size: 15px; color: #000; font-weight: 600;"></div>
                </div>
                <div>
                    <label style="display: block; font-size: 12px; color: #999; text-transform: uppercase; font-weight: 700; margin-bottom: 8px;">Tipe</label>
                    <div id="detailType" style="font-size: 14px; font-weight: 700; display: inline-block; padding: 6px 16px; border-radius: 12px;"></div>
                </div>
            </div>

            <div style="margin-top: 25px;">
                <label style="display: block; font-size: 12px; color: #999; text-transform: uppercase; font-weight: 700; margin-bottom: 8px;">Akun / Kategori</label>
                <div id="detailAccount" style="font-size: 15px; color: #000; font-weight: 600;"></div>
            </div>

            <div style="margin-top: 25px;">
                <label style="display: block; font-size: 12px; color: #999; text-transform: uppercase; font-weight: 700; margin-bottom: 8px;">Keterangan</label>
                <div id="detailDescription" style="font-size: 15px; color: #444; font-weight: 500; line-height: 1.6; background: #fcfcfc; padding: 15px; border-radius: 15px; border: 1px solid #eee;"></div>
            </div>

            <div style="margin-top: 25px;">
                <label style="display: block; font-size: 12px; color: #999; text-transform: uppercase; font-weight: 700; margin-bottom: 8px;">Jumlah</label>
                <div id="detailAmount" style="font-size: 24px; color: #000; font-weight: 800;"></div>
            </div>

            <div style="margin-top: 25px;">
                <label style="display: block; font-size: 12px; color: #999; text-transform: uppercase; font-weight: 700; margin-bottom: 8px;">File Lampiran</label>
                <div id="detailFile" style="font-size: 14px; color: #000;"></div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeDetailModal()">Tutup</button>
        </div>
    </div>
</div>

<script src="{{ asset('js/modal.js') }}?v={{ time() }}"></script>
<script>
    const ITEMS_PER_PAGE = 10;
    let currentPage = 1;
    let allVisibleTransactions = [];

    function updateFilterActiveCount() {
        // Function disabled as per UI request to remove "X aktif" label
    }

    function renderPaginationButtons() {
        const container = document.getElementById('paginationContainer');
        const totalPages = Math.ceil(allVisibleTransactions.length / ITEMS_PER_PAGE);
        
        if (totalPages <= 1) {
            container.style.display = 'none';
            return;
        }
        
        container.style.display = 'flex';
        container.innerHTML = '';
        
        // Previous button
        const prevBtn = document.createElement('button');
        prevBtn.className = 'pagination-btn';
        prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
        prevBtn.disabled = currentPage === 1;
        if (currentPage === 1) prevBtn.classList.add('disabled');
        prevBtn.onclick = () => {
            if (currentPage > 1) {
                currentPage--;
                displayCurrentPage();
                renderPaginationButtons();
            }
        };
        container.appendChild(prevBtn);
        
        // Calculate range of pages to show
        const maxPagesToShow = 5;
        let startPage = Math.max(1, currentPage - Math.floor(maxPagesToShow / 2));
        let endPage = Math.min(totalPages, startPage + maxPagesToShow - 1);
        
        if (endPage - startPage + 1 < maxPagesToShow) {
            startPage = Math.max(1, endPage - maxPagesToShow + 1);
        }
        
        // Add ellipsis at start if needed
        if (startPage > 1) {
            const firstBtn = document.createElement('button');
            firstBtn.className = 'pagination-btn';
            firstBtn.textContent = '1';
            firstBtn.onclick = () => {
                currentPage = 1;
                displayCurrentPage();
                renderPaginationButtons();
            };
            container.appendChild(firstBtn);
            
            if (startPage > 2) {
                const ellipsis = document.createElement('span');
                ellipsis.style.display = 'flex';
                ellipsis.style.alignItems = 'center';
                ellipsis.style.padding = '0 4px';
                ellipsis.style.color = '#9ca3af';
                ellipsis.textContent = '...';
                container.appendChild(ellipsis);
            }
        }
        
        // Page numbers
        for (let i = startPage; i <= endPage; i++) {
            const pageBtn = document.createElement('button');
            pageBtn.className = 'pagination-btn';
            pageBtn.textContent = i;
            if (i === currentPage) {
                pageBtn.classList.add('active');
            }
            pageBtn.onclick = () => {
                currentPage = i;
                displayCurrentPage();
                renderPaginationButtons();
            };
            container.appendChild(pageBtn);
        }
        
        // Add ellipsis at end if needed
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                const ellipsis = document.createElement('span');
                ellipsis.style.display = 'flex';
                ellipsis.style.alignItems = 'center';
                ellipsis.style.padding = '0 4px';
                ellipsis.style.color = '#9ca3af';
                ellipsis.textContent = '...';
                container.appendChild(ellipsis);
            }
            
            const lastBtn = document.createElement('button');
            lastBtn.className = 'pagination-btn';
            lastBtn.textContent = totalPages;
            lastBtn.onclick = () => {
                currentPage = totalPages;
                displayCurrentPage();
                renderPaginationButtons();
            };
            container.appendChild(lastBtn);
        }
        
        // Next button
        const nextBtn = document.createElement('button');
        nextBtn.className = 'pagination-btn';
        nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
        nextBtn.disabled = currentPage === totalPages;
        if (currentPage === totalPages) nextBtn.classList.add('disabled');
        nextBtn.onclick = () => {
            if (currentPage < totalPages) {
                currentPage++;
                displayCurrentPage();
                renderPaginationButtons();
            }
        };
        container.appendChild(nextBtn);
    }

    function displayCurrentPage() {
        const start = (currentPage - 1) * ITEMS_PER_PAGE;
        const end = start + ITEMS_PER_PAGE;
        const allRows = document.querySelectorAll('#combinedTableSection div[data-transaction-type]');
        
        allRows.forEach((row) => {
            // Cek apakah row ada di dalam array visible transactions
            const isInVisibleArray = allVisibleTransactions.some(r => r === row);
            
            if (isInVisibleArray) {
                // Cari index di array visible
                const indexInVisible = allVisibleTransactions.indexOf(row);
                
                if (indexInVisible >= start && indexInVisible < end) {
                    row.style.display = 'grid';
                    const numberDiv = row.querySelector('.transaction-number');
                    if (numberDiv) numberDiv.textContent = indexInVisible + 1;
                } else {
                    row.style.display = 'none';
                }
            }
        });
    }

    function applyPaginationToVisibleRows() {
        const allRows = document.querySelectorAll('#combinedTableSection div[data-transaction-type]');
        allVisibleTransactions = [];
        currentPage = 1;
        
        // Kumpulkan semua row yang visible (tidak hidden oleh filter)
        allRows.forEach(row => {
            const computedStyle = window.getComputedStyle(row);
            if (computedStyle.display !== 'none') {
                allVisibleTransactions.push(row);
            }
        });
        
        displayCurrentPage();
        renderPaginationButtons();
    }

    function initializePagination() {
        const allRows = document.querySelectorAll('#combinedTableSection div[data-transaction-type]');
        currentPage = 1;
        let visibleCount = 0;
        
        allRows.forEach((row, index) => {
            if (visibleCount >= ITEMS_PER_PAGE) {
                row.style.display = 'none';
            } else {
                row.style.display = 'grid';
                const numberDiv = row.querySelector('.transaction-number');
                if (numberDiv) numberDiv.textContent = visibleCount + 1;
                visibleCount++;
            }
        });
        
        renderPaginationButtons();
    }

    function openAddModal() {
        const modal = document.getElementById('addTransactionModal');
        modal.classList.add('active');
        setTimeout(() => {
            updateModalAccounts();
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('transactionDate').value = today;
            document.getElementById('transactionForm').reset();
            
            document.getElementById('dateError').classList.remove('active');
            document.getElementById('accountError').classList.remove('active');
            document.getElementById('amountError').classList.remove('active');
            document.getElementById('transactionDate').classList.remove('error');
            document.getElementById('transactionAccount').classList.remove('error');
            document.getElementById('transactionAmount').classList.remove('error');
        }, 100);
    }

    function closeAddModal() {
        const modal = document.getElementById('addTransactionModal');
        modal.classList.remove('active');
        document.getElementById('transactionForm').reset();
        document.getElementById('fileLabel').classList.remove('has-file');
        document.getElementById('fileInfo').classList.remove('active');
    }

    function clearDateError() {
        document.getElementById('dateError').classList.remove('active');
        document.getElementById('transactionDate').classList.remove('error');
    }

    function clearAccountError() {
        document.getElementById('accountError').classList.remove('active');
        document.getElementById('transactionAccount').classList.remove('error');
    }

    function clearAmountError() {
        document.getElementById('amountError').classList.remove('active');
        document.getElementById('transactionAmount').classList.remove('error');
    }

    function updateModalAccounts() {
        const type = document.querySelector('input[name="type"]:checked').value;
        const accountSelect = document.getElementById('transactionAccount');
        const incomeOptgroup = document.getElementById('incomeAccounts');

        accountSelect.innerHTML = '<option value="">-- Pilih Akun --</option>';

        if (type === 'income') {
            const incomeOptions = `
                <optgroup label="Akun Pemasukan">
                    @foreach($inAccounts as $account)
                        <option value="{{ $account->id }}" data-code="{{ $account->code }}" data-name="{{ $account->name }}">{{ $account->code }} - {{ $account->name }}</option>
                    @endforeach
                </optgroup>
            `;
            accountSelect.innerHTML += incomeOptions;
        } else {
            const expenseOptions = `
                <optgroup label="Akun Pengeluaran">
                    @foreach($outAccounts as $account)
                        <option value="{{ $account->id }}" data-code="{{ $account->code }}" data-name="{{ $account->name }}">{{ $account->code }} - {{ $account->name }}</option>
                    @endforeach
                </optgroup>
            `;
            accountSelect.innerHTML += expenseOptions;
        }

        accountSelect.value = '';
        updateAccountLabel();
    }

    function updateAccountLabel() {
        const selectElement = document.getElementById('transactionAccount');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const selectedName = selectedOption.dataset.name || '';
        const selectedCode = selectedOption.dataset.code || '';
        const type = document.querySelector('input[name="type"]:checked').value;
        const descLabel = document.getElementById('descriptionLabel');
        const descHint = document.getElementById('descriptionHint');
        const descField = document.getElementById('transactionDescription');

        const serviceAccounts = ['Jasa Lainnya', 'Pendapatan Lainnya', 'Revenue Lainnya'];
        const expenseAccounts = ['Beban Lainnya', 'Operasional Lainnya', 'Expense Lainnya'];

        if (type === 'income' && serviceAccounts.some(name => selectedName.includes(name))) {
            descLabel.textContent = 'Jenis Jasa (Wajib Diisi) *';
            descHint.textContent = '⚠️ Silakan isi jenis jasa apa yang Anda terima';
            descHint.style.display = 'block';
            descField.placeholder = 'Contoh: Jasa Reparasi, Jasa Konsultasi, dll';
            descField.required = true;
            descField.style.borderColor = '#ffc107';
        } else if (type === 'expense' && expenseAccounts.some(name => selectedName.includes(name))) {
            descLabel.textContent = 'Detail Pengeluaran (Wajib Diisi) *';
            descHint.textContent = '⚠️ Silakan isi detail pembelian';
            descHint.style.display = 'block';
            descField.placeholder = 'Contoh: Biaya Akomodasi, Biaya Riset, dll';
            descField.required = true;
            descField.style.borderColor = '#ff6b6b';
        } else if (selectedCode === '5100' || selectedName.includes('Beban Gaji')) {
            descLabel.textContent = 'Catatan Gaji (Opsional)';
            descHint.style.display = 'none';
            descField.placeholder = 'Masukkan catatan atau keterangan...';
            descField.required = false;
            descField.style.borderColor = '';
        } else {
            descLabel.textContent = 'Keterangan / Deskripsi';
            descHint.style.display = 'none';
            descField.placeholder = 'Masukkan keterangan...';
            descField.required = false;
            descField.style.borderColor = '';
        }
    }

    function handleFileSelect() {
        const fileInput = document.getElementById('fileInput');
        const fileLabel = document.getElementById('fileLabel');
        const fileInfo = document.getElementById('fileInfo');

        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const fileSize = (file.size / 1024 / 1024).toFixed(2);

            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2MB');
                fileInput.value = '';
                return;
            }

            fileLabel.classList.add('has-file');
            fileInfo.classList.add('active');
            
            let previewHtml = `<div style="margin-bottom: 10px; font-weight: 500; color: #065f46;"><i class="fas fa-check-circle"></i> ${file.name} (${fileSize} MB)</div>`;
            
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    fileInfo.innerHTML = previewHtml + `
                        <div style="position: relative; border-radius: 8px; overflow: hidden; border: 1px solid #e5e7eb; display: inline-block;">
                            <img src="${e.target.result}" style="max-width: 100%; max-height: 200px; display: block;">
                        </div>`;
                };
                reader.readAsDataURL(file);
            } else if (file.type === 'application/pdf') {
                const reader = new FileReader();
                reader.onload = function(e) {
                     fileInfo.innerHTML = previewHtml + `
                        <div style="margin-top: 10px;">
                            <embed src="${e.target.result}" type="application/pdf" width="100%" height="300px" style="border-radius: 8px; border: 1px solid #e5e7eb;">
                        </div>`;
                };
                 reader.readAsDataURL(file);
            } else {
                 fileInfo.innerHTML = previewHtml;
            }
        } else {
            fileLabel.classList.remove('has-file');
            fileInfo.classList.remove('active');
            fileInfo.innerHTML = '';
        }
    }

    function saveTransaction() {
        const form = document.getElementById('transactionForm');
        const type = document.querySelector('input[name="type"]:checked').value;
        const dateField = document.getElementById('transactionDate');
        const accountField = document.getElementById('transactionAccount');
        const amountField = document.getElementById('transactionAmount');
        const descField = document.getElementById('transactionDescription');
        const selectElement = document.getElementById('transactionAccount');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const selectedName = selectedOption.dataset.name || '';

        const dateError = document.getElementById('dateError');
        const accountError = document.getElementById('accountError');
        const amountError = document.getElementById('amountError');

        const serviceAccounts = ['Jasa Lainnya', 'Pendapatan Lainnya', 'Revenue Lainnya'];
        const expenseAccounts = ['Beban Lainnya', 'Operasional Lainnya', 'Expense Lainnya'];

        let hasError = false;

        if (!dateField.value.trim()) {
            dateError.classList.add('active');
            dateField.classList.add('error');
            hasError = true;
        } else {
            dateError.classList.remove('active');
            dateField.classList.remove('error');
        }

        if (!accountField.value) {
            accountError.classList.add('active');
            accountField.classList.add('error');
            hasError = true;
        } else {
            accountError.classList.remove('active');
            accountField.classList.remove('error');
        }

        if (!amountField.value || amountField.value <= 0) {
            amountError.classList.add('active');
            amountField.classList.add('error');
            hasError = true;
        } else {
            amountError.classList.remove('active');
            amountField.classList.remove('error');
        }

        if (hasError) {
            return;
        }

        if (type === 'income' && serviceAccounts.some(name => selectedName.includes(name)) && !descField.value.trim()) {
            Swal.fire({
                icon: 'warning',
                title: 'Keterangan Wajib',
                text: 'Silakan isi jenis jasa terlebih dahulu!',
                confirmButtonColor: '#8b6f47'
            });
            descField.focus();
            return;
        }

        if (type === 'expense' && expenseAccounts.some(name => selectedName.includes(name)) && !descField.value.trim()) {
            Swal.fire({
                icon: 'warning',
                title: 'Keterangan Wajib',
                text: 'Silakan isi detail pembelian terlebih dahulu!',
                confirmButtonColor: '#8b6f47'
            });
            descField.focus();
            return;
        }

        const formData = new FormData(form);
        const endpoint = type === 'income' ? '{{ route("cash.in.store", [], false) }}' : '{{ route("cash.out.store", [], false) }}';

        fetch(endpoint, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || 'Gagal menyimpan data');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                closeAddModal();
                showTransactionNotification(data.message, 'success');
                setTimeout(() => {
                    location.reload();
                }, 1300);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message || 'Terjadi kesalahan saat menyimpan',
                    confirmButtonColor: '#ef4444',
                    background: '#ffffff',
                    color: '#111827'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: error.message || 'Gagal menyimpan transaksi',
                confirmButtonColor: '#ef4444',
                background: '#ffffff',
                color: '#111827'
            });
            console.error('Detailed error:', error);
        });
    }

    function editTransaction(id, type) {
        const endpoint = type === 'income' 
            ? `{{ route("cash.in.show", ":id", false) }}`.replace(':id', id)
            : `{{ route("cash.out.show", ":id", false) }}`.replace(':id', id);
        
        fetch(endpoint, {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Gagal mengambil data');
            return response.json();
        })
        .then(data => {
            const transaction = data.data || data;
            document.getElementById('editTransactionId').value = id;
            document.getElementById('editTransactionType').value = type;
            document.getElementById('editTransactionDate').value = transaction.date.split(' ')[0];
            document.getElementById('editTransactionAmount').value = formatRupiah(transaction.amount);
            document.getElementById('editTransactionDescription').value = transaction.description || '';
            
            if (transaction.file_path) {
                const fileName = transaction.file_path.split('/').pop();
                const fileExt = fileName.split('.').pop().toLowerCase();
                const isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExt);
                const isPdf = fileExt === 'pdf';
                const fileUrl = `/storage/${transaction.file_path}`;
                
                let fileHtml = '<div style="border: 1px solid #d1d5db; border-radius: 6px; margin-bottom: 12px; overflow: hidden;">';
                fileHtml += '<p style="margin: 0 0 12px 0; padding: 12px; background: #f9fafb; font-size: 12px; font-weight: 600; color: #6b7280; border-bottom: 1px solid #e5e7eb;">📎 File saat ini:</p>';
                
                if (isImage) {
                    fileHtml += `<div style="padding: 12px;">
                        <img src="${fileUrl}" style="max-width: 100%; height: auto; border-radius: 4px; border: 1px solid #d1d5db;">
                    </div>`;
                } else if (isPdf) {
                    fileHtml += `<div style="padding: 12px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <span style="font-size: 12px; color: #6b7280;">${fileName}</span>
                            <a href="${fileUrl}" download="${fileName}" style="color: #3b82f6; font-size: 12px; cursor: pointer; text-decoration: none;" title="Download">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                        <iframe src="${fileUrl}" style="width: 100%; height: 400px; border: 1px solid #d1d5db; border-radius: 4px;"></iframe>
                    </div>`;
                } else {
                    fileHtml += `<div style="padding: 12px;">
                        <a href="${fileUrl}" target="_blank" style="color: #3b82f6; font-weight: 500; font-size: 12px;">📥 Download ${fileName}</a>
                    </div>`;
                }
                
                fileHtml += '</div>';
                document.getElementById('editCurrentFile').innerHTML = fileHtml;
            } else {
                document.getElementById('editCurrentFile').innerHTML = '';
            }
            
            updateEditAccountOptions();
            document.getElementById('editTransactionAccount').value = transaction.category_id;
            updateEditAccountLabel();
            
            const modal = document.getElementById('editTransactionModal');
            modal.classList.add('active');
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Memuat Data',
                text: error.message,
                confirmButtonColor: '#ef4444'
            });
        });
    }

    function closeEditModal() {
        const modal = document.getElementById('editTransactionModal');
        modal.classList.remove('active');
        document.getElementById('editTransactionForm').reset();
        document.getElementById('editFileLabel').classList.remove('has-file');
        document.getElementById('editFileInfo').classList.remove('active');
    }

    function updateEditAccountOptions() {
        const type = document.getElementById('editTransactionType').value;
        const accountSelect = document.getElementById('editTransactionAccount');
        const currentValue = accountSelect.value;
        
        accountSelect.innerHTML = '<option value="">-- Pilih Akun --</option>';
        
        if (type === 'income') {
            const incomeOptions = `
                <optgroup label="Akun Pemasukan">
                    @foreach($inAccounts as $account)
                        <option value="{{ $account->id }}" data-code="{{ $account->code }}" data-name="{{ $account->name }}">{{ $account->code }} - {{ $account->name }}</option>
                    @endforeach
                </optgroup>
            `;
            accountSelect.innerHTML += incomeOptions;
        } else {
            const expenseOptions = `
                <optgroup label="Akun Pengeluaran">
                    @foreach($outAccounts as $account)
                        <option value="{{ $account->id }}" data-code="{{ $account->code }}" data-name="{{ $account->name }}">{{ $account->code }} - {{ $account->name }}</option>
                    @endforeach
                </optgroup>
            `;
            accountSelect.innerHTML += expenseOptions;
        }
        
        accountSelect.value = currentValue;
    }

    function updateEditAccountLabel() {
        const selectElement = document.getElementById('editTransactionAccount');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const selectedName = selectedOption.dataset.name || '';
        const descLabel = document.getElementById('editDescriptionLabel');
        const descHint = document.getElementById('editDescriptionHint');
        const descField = document.getElementById('editTransactionDescription');

        const serviceAccounts = ['Jasa Lainnya', 'Pendapatan Lainnya', 'Revenue Lainnya', 'Beban Lainnya', 'Operasional Lainnya', 'Expense Lainnya'];

        if (serviceAccounts.some(name => selectedName.includes(name))) {
            descLabel.textContent = selectedName.includes('Beban') ? 'Detail Pengeluaran (Wajib Diisi) *' : 'Jenis Jasa (Wajib Diisi) *';
            descHint.textContent = selectedName.includes('Beban') ? '⚠️ Silakan isi detail pembelian' : '⚠️ Silakan isi jenis jasa apa yang Anda terima';
            descHint.style.display = 'block';
            descField.required = true;
            descField.style.borderColor = selectedName.includes('Beban') ? '#ff6b6b' : '#ffc107';
        } else {
            descLabel.textContent = 'Keterangan / Deskripsi';
            descHint.style.display = 'none';
            descField.required = false;
            descField.style.borderColor = '';
        }
    }

    function handleEditFileSelect() {
        const fileInput = document.getElementById('editFileInput');
        const fileLabel = document.getElementById('editFileLabel');
        const fileInfo = document.getElementById('editFileInfo');

        if (fileInput.files && fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const fileSize = (file.size / 1024 / 1024).toFixed(2);

            if (file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Terlalu Besar',
                    text: 'Ukuran file maksimal 2MB',
                });
                fileInput.value = '';
                fileLabel.classList.remove('has-file');
                fileInfo.classList.remove('active');
                return;
            }

            const allowedFormats = ['image/jpeg', 'image/png', 'application/pdf'];
            if (!allowedFormats.includes(file.type)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Format Salah',
                    text: 'Format file tidak didukung. Gunakan JPG, PNG, atau PDF.',
                });
                fileInput.value = '';
                fileLabel.classList.remove('has-file');
                fileInfo.classList.remove('active');
                return;
            }

            fileLabel.classList.add('has-file');
            fileInfo.classList.add('active');
            
            let previewHtml = `<div style="margin-bottom: 10px; font-weight: 500; color: #065f46;"><i class="fas fa-check-circle"></i> ${file.name} (${fileSize} MB)</div>`;
            
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    fileInfo.innerHTML = previewHtml + `
                        <div style="position: relative; border-radius: 8px; overflow: hidden; border: 1px solid #e5e7eb; display: inline-block;">
                            <img src="${e.target.result}" style="max-width: 100%; max-height: 200px; display: block;">
                        </div>`;
                };
                reader.readAsDataURL(file);
            } else if (file.type === 'application/pdf') {
                const reader = new FileReader();
                reader.onload = function(e) {
                     fileInfo.innerHTML = previewHtml + `
                        <div style="margin-top: 10px;">
                            <embed src="${e.target.result}" type="application/pdf" width="100%" height="300px" style="border-radius: 8px; border: 1px solid #e5e7eb;">
                        </div>`;
                };
                 reader.readAsDataURL(file);
            } else {
                 fileInfo.innerHTML = previewHtml;
            }
        } else {
            fileLabel.classList.remove('has-file');
            fileInfo.classList.remove('active');
            fileInfo.innerHTML = '';
        }
    }

    function saveEditTransaction() {
        const id = document.getElementById('editTransactionId').value;
        const type = document.getElementById('editTransactionType').value;
        const form = document.getElementById('editTransactionForm');
        const formData = new FormData(form);
        
        // Ensure numeric value is sent
        const rawAmount = parseRupiah(document.getElementById('editTransactionAmount').value);
        formData.set('amount', rawAmount);

        const endpoint = type === 'income'
            ? `{{ route("cash.in.update", ":id", false) }}`.replace(':id', id)
            : `{{ route("cash.out.update", ":id", false) }}`.replace(':id', id);

        fetch(endpoint, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-HTTP-Method-Override': 'PUT'
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || 'Gagal menyimpan data');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                closeEditModal();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 1200,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    background: '#ffffff',
                    color: '#111827',
                    iconColor: '#14b8a6',
                    allowOutsideClick: false,
                    didOpen: () => {
                        const progressBar = document.querySelector('.swal2-timer-progress-bar');
                        if (progressBar) {
                            progressBar.style.backgroundColor = '#14b8a6';
                        }
                    },
                    willClose: () => location.reload()
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message || 'Terjadi kesalahan saat menyimpan',
                    confirmButtonColor: '#ef4444',
                    background: '#ffffff',
                    color: '#111827'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: error.message || 'Gagal memperbarui transaksi',
                confirmButtonColor: '#ef4444',
                background: '#ffffff',
                color: '#111827'
            });
        });
    }

    function deleteTransaction(id, type) {
        Modal.delete('transaksi ini', function() {
            const endpoint = type === 'income' 
                ? `{{ route("cash.in.destroy", ":id", false) }}`.replace(':id', id)
                : `{{ route("cash.out.destroy", ":id", false) }}`.replace(':id', id);

            fetch(endpoint, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.message || 'Gagal menghapus data');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Find and remove the transaction row from DOM
                    const transactionRow = document.querySelector(`div[data-transaction-id="${id}"]`);
                    
                    if (transactionRow) {
                        transactionRow.remove();
                        
                        // Remove from allVisibleTransactions array
                        allVisibleTransactions = allVisibleTransactions.filter(row => 
                            row.getAttribute('data-transaction-id') !== id.toString()
                        );
                    }
                    
                    // Recalculate totals from visible (not hidden by filters) transactions
                    let totalIncome = 0;
                    let totalExpense = 0;
                    let incomeCount = 0;
                    let expenseCount = 0;
                    let visibleRowCount = 0;
                    
                    const section = document.getElementById('combinedTableSection');
                    const rows = section.querySelectorAll('div[data-transaction-type]');
                    
                    rows.forEach(row => {
                        const computedStyle = window.getComputedStyle(row);
                        
                        if (computedStyle.display !== 'none') {
                            visibleRowCount++;
                            const transType = row.getAttribute('data-transaction-type');
                            
                            const amountDiv = row.children[5];
                            const amountText = amountDiv ? amountDiv.textContent.trim() : '0';
                            const amount = parseInt(amountText.replace(/\D/g, '')) || 0;
                            
                            if (transType === 'income') {
                                totalIncome += amount;
                                incomeCount++;
                            } else if (transType === 'expense') {
                                totalExpense += amount;
                                expenseCount++;
                            }
                        }
                    });
                    
                    // Update stat cards with new totals
                    updateStatCards(totalIncome, totalExpense, incomeCount, expenseCount);
                    
                    // Update total transactions count
                    const totalCountElement = document.getElementById('totalTransactionsCount');
                    if (totalCountElement) {
                        totalCountElement.textContent = `Total: ${visibleRowCount} transaksi`;
                    }
                    
                    // Update empty states
                    updateEmptyStates(visibleRowCount);
                    
                    // Reapply pagination respecting the current filter
                    currentPage = 1;
                    applyPaginationToVisibleRows();
                    
                    // Show success notification
                    showTransactionNotification(data.message || 'Transaksi berhasil dihapus', 'success');
                } else {
                    alert(data.message || 'Terjadi kesalahan saat menghapus');
                }
            })
            .catch(error => {
                alert(error.message || 'Gagal menghapus transaksi');
            });
        });
    }

    function filterTable() {
        applyDateFilter();
    }

    function populateYearSelect() {
        const yearSelect = document.getElementById('filterYear');
        const now = new Date();
        const currentYear = now.getFullYear();
        const startYear = 2020;

        yearSelect.innerHTML = '';
        for (let year = currentYear; year >= startYear; year--) {
            const option = document.createElement('option');
            option.value = year;
            option.text = year;
            if (year === currentYear) option.selected = true;
            yearSelect.appendChild(option);
        }
    }

    function populateMonthSelect() {
        const monthSelect = document.getElementById('filterMonth');
        const now = new Date();
        const currentMonth = now.getMonth() + 1;

        const months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        monthSelect.innerHTML = '';
        months.forEach((month, index) => {
            const option = document.createElement('option');
            option.value = String(index + 1).padStart(2, '0');
            option.text = month;
            if (index + 1 === currentMonth) option.selected = true;
            monthSelect.appendChild(option);
        });
    }

    function updateFilterOptions() {
        const filterType = document.getElementById('filterType').value;
        const yearGroup = document.getElementById('yearGroup');
        const monthGroup = document.getElementById('monthGroup');
        const startDateGroup = document.getElementById('startDateGroup');
        const endDateGroup = document.getElementById('endDateGroup');

        if (filterType === 'monthly') {
            yearGroup.style.display = 'flex';
            monthGroup.style.display = 'flex';
            startDateGroup.style.display = 'none';
            endDateGroup.style.display = 'none';
        } else if (filterType === 'yearly') {
            yearGroup.style.display = 'flex';
            monthGroup.style.display = 'none';
            startDateGroup.style.display = 'none';
            endDateGroup.style.display = 'none';
        } else if (filterType === 'custom') {
            yearGroup.style.display = 'none';
            monthGroup.style.display = 'none';
            startDateGroup.style.display = 'flex';
            endDateGroup.style.display = 'flex';
        } else {
            yearGroup.style.display = 'none';
            monthGroup.style.display = 'none';
            startDateGroup.style.display = 'none';
            endDateGroup.style.display = 'none';
        }
        applyDateFilter();
    }

    function applyDateFilter() {
        const filterType = document.getElementById('filterType').value;
        const year = document.getElementById('filterYear').value;
        const month = document.getElementById('filterMonth').value;
        const startDate = document.getElementById('filterStartDate').value;
        const endDate = document.getElementById('filterEndDate').value;

        let startDateTime = null;
        let endDateTime = null;

        if (filterType === 'monthly' && year && month) {
            startDateTime = new Date(year, parseInt(month) - 1, 1);
            endDateTime = new Date(year, parseInt(month), 0, 23, 59, 59);
        } else if (filterType === 'yearly' && year) {
            startDateTime = new Date(year, 0, 1);
            endDateTime = new Date(year, 11, 31, 23, 59, 59);
        } else if (filterType === 'custom' && startDate && endDate) {
            startDateTime = new Date(startDate);
            endDateTime = new Date(endDate);
            endDateTime.setHours(23, 59, 59);
        }

        filterTransactionsByDate(startDateTime, endDateTime);
    }

    function filterTransactionsByDate(startDate, endDate) {
        const transactionDivs = document.querySelectorAll('.transaction-row');
        const selectedType = document.getElementById('transactionTypeSelect').value;
        let visibleRows = 0;

        let totalIncome = 0;
        let totalExpense = 0;
        let countIncome = 0;
        let countExpense = 0;

        transactionDivs.forEach(div => {
            const dateDiv = div.children[2].querySelector('div:first-child');
            if (!dateDiv) return;

            const dateText = dateDiv.textContent.trim();
            const transactionDate = parseDate(dateText);
            const type = div.dataset.transactionType;

            const dateMatch = (!startDate || !endDate) || (transactionDate >= startDate && transactionDate <= endDate);
            const typeMatch = (selectedType === 'all' || selectedType === type);

            if (dateMatch && typeMatch) {
                div.style.display = 'grid';
                visibleRows++;

                const amountText = div.children[5].textContent.trim();
                const amount = parseInt(amountText.replace(/\D/g, ''));

                if (type === 'income') {
                    totalIncome += amount;
                    countIncome++;
                } else {
                    totalExpense += amount;
                    countExpense++;
                }
            } else {
                div.style.display = 'none';
            }
        });

        updateEmptyStates(visibleRows);

        const totalCountElement = document.getElementById('totalTransactionsCount');
        if (totalCountElement) {
            totalCountElement.textContent = `Total: ${visibleRows} transaksi`;
        }

        updateStatCards(totalIncome, totalExpense, countIncome, countExpense);
        applyPaginationToVisibleRows();
        updateFilterActiveCount();
    }

    function updateStatCards(income, expense, incomeCount, expenseCount) {
        const formatter = new Intl.NumberFormat('id-ID');
        
        const incomeEl = document.getElementById('statIncomeValue');
        if (incomeEl) {
            const formattedIncome = formatter.format(income);
            incomeEl.textContent = 'Rp' + formattedIncome;
        }
        
        const incomeCountEl = document.getElementById('statIncomeCount');
        if (incomeCountEl) {
            incomeCountEl.textContent = incomeCount + ' transaksi';
        }
        
        const expenseEl = document.getElementById('statExpenseValue');
        if (expenseEl) {
            const formattedExpense = formatter.format(expense);
            expenseEl.textContent = 'Rp' + formattedExpense;
        }
        
        const expenseCountEl = document.getElementById('statExpenseCount');
        if (expenseCountEl) {
            expenseCountEl.textContent = expenseCount + ' transaksi';
        }
        
        const net = income - expense;
        const netEl = document.getElementById('statNetValue');
        if (netEl) {
            const formattedNet = formatter.format(net);
            netEl.textContent = 'Rp' + formattedNet;
        }
    }

    function parseDate(dateString) {
        const monthMap = {
            'Jan': '01', 'Feb': '02', 'Mar': '03', 'Apr': '04', 
            'Mei': '05', 'Jun': '06', 'Jul': '07', 'Agu': '08',
            'Sep': '09', 'Okt': '10', 'Nov': '11', 'Des': '12'
        };
        
        const parts = dateString.trim().split(' ');
        if (parts.length < 3) return new Date();
        
        const day = parts[0];
        const monthStr = parts[1];
        const year = parts[2];
        const month = monthMap[monthStr] || '01';
        
        return new Date(year, parseInt(month) - 1, day);
    }

    function updateEmptyStates(visibleRows) {
        const section = document.getElementById('combinedTableSection');
        let emptyState = section.querySelector('.empty-state');

        if (visibleRows === 0) {
            if (!emptyState) {
                emptyState = document.createElement('div');
                emptyState.className = 'empty-state';
                emptyState.innerHTML = '<p>Belum ada transaksi</p>';
                section.appendChild(emptyState);
            }
            emptyState.style.display = '';
        } else {
            if (emptyState) {
                emptyState.style.display = 'none';
            }
        }
    }

    function resetDateFilter() {
        document.getElementById('filterType').value = 'monthly';
        populateYearSelect();
        populateMonthSelect();
        updateFilterOptions();
        applyDateFilter();
    }

    window.addEventListener('click', function(event) {
        const modal = document.getElementById('addTransactionModal');
        if (event.target === modal) {
            closeAddModal();
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        populateYearSelect();
        populateMonthSelect();
        updateFilterOptions();

        const today = new Date().toISOString().split('T')[0];
        const transactionDateInput = document.getElementById('transactionDate');
        if (transactionDateInput) {
            transactionDateInput.value = today;
        }

        // Initialize all visible transactions first
        const allRows = document.querySelectorAll('#combinedTableSection div[data-transaction-type]');
        allVisibleTransactions = Array.from(allRows);
        
        // Update total count
        const totalCountElement = document.getElementById('totalTransactionsCount');
        if (totalCountElement) {
            totalCountElement.textContent = `Total: ${allVisibleTransactions.length} transaksi`;
        }
        
        // Initialize currency formatting for amount input
        initCurrencyInput('#editTransactionAmount');
        
        // Initialize pagination untuk halaman awal
        initializePagination();
        
        // Kemudian apply filter
        applyDateFilter();
        
        // Update filter active count
        updateFilterActiveCount();
    });

    let currentTransactionDetail = null;

    function showTransactionDetail(id, type) {
        const endpoint = `{{ route("api.cash.detail", ["type" => ":type", "id" => ":id"], false) }}`
            .replace(':type', type)
            .replace(':id', id);
            
        fetch(endpoint)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data) {
                    const transaction = data.data;
                    const modal = document.getElementById('detailTransactionModal');
                    
                    document.getElementById('detailDate').textContent = new Date(transaction.date).toLocaleDateString('id-ID', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    
                    document.getElementById('detailType').textContent = transaction.type === 'income' ? 'Pemasukan' : 'Pengeluaran';
                    document.getElementById('detailType').style.background = transaction.type === 'income' ? 'rgba(20, 184, 166, 0.1)' : 'rgba(239, 68, 68, 0.1)';
                    document.getElementById('detailType').style.color = transaction.type === 'income' ? '#14b8a6' : '#ef4444';
                    
                    document.getElementById('detailAccount').textContent = transaction.account_name || '-';
                    
                    document.getElementById('detailDescription').textContent = transaction.description || '-';
                    
                    const amountColor = transaction.type === 'income' ? '#14b8a6' : '#ef4444';
                    const amountSymbol = transaction.type === 'income' ? '+' : '-';
                    document.getElementById('detailAmount').innerHTML = `<span style="color: ${amountColor};">${amountSymbol}Rp${parseInt(transaction.amount).toLocaleString('id-ID')}</span>`;
                    
                    if (transaction.file_path) {
                        const fileName = transaction.file_path.split('/').pop();
                        const extension = fileName.split('.').pop().toLowerCase();
                        const isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(extension);
                        const isPdf = extension === 'pdf';
                        
                        let previewHtml = '';
                        if (isImage) {
                            previewHtml = `
                                <div style="margin-top: 12px; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; background: #f8fafc; display: flex; justify-content: center; align-items: center; padding: 10px;">
                                    <img src="${transaction.file_url}" style="max-width: 100%; max-height: 250px; border-radius: 8px; object-fit: contain; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);" onclick="openViewer('${transaction.file_url}', '${fileName}')" title="Klik untuk memperbesar">
                                </div>
                            `;
                        } else if (isPdf) {
                            previewHtml = `
                                <div style="margin-top: 12px; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; background: #f8fafc; height: 300px;">
                                    <iframe src="${transaction.file_url}#toolbar=0" style="width: 100%; height: 100%; border: none;"></iframe>
                                </div>
                                <p style="font-size: 11px; color: #64748b; margin-top: 6px; text-align: center;">Klik "Lihat Full" untuk tampilan PDF lebih luas</p>
                            `;
                        }

                        document.getElementById('detailFile').innerHTML = `
                            <div style="display: flex; flex-direction: column; gap: 8px;">
                                <div style="display: flex; align-items: center; gap: 12px; padding: 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
                                    <div style="flex: 1; min-width: 0;">
                                        <p style="margin: 0; font-size: 13px; font-weight: 600; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            ${fileName}
                                        </p>
                                    </div>
                                    <div style="display: flex; gap: 8px;">
                                        <button type="button" onclick="openViewer('${transaction.file_url}', '${fileName}')" style="background: #8b6f47; color: white; border: none; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer;">
                                            Lihat Full
                                        </button>
                                        <a href="${transaction.file_url}" download="${fileName}" style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; text-decoration: none;">
                                            Unduh
                                        </a>
                                    </div>
                                </div>
                                ${previewHtml}
                            </div>
                        `;
                    } else {
                        document.getElementById('detailFile').textContent = '-';
                    }
                    
                    modal.classList.add('active');
                } else {
                    Swal.fire('Error', 'Gagal memuat detail transaksi', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Gagal memuat detail transaksi', 'error');
            });
    }

    function closeDetailModal() {
        const modal = document.getElementById('detailTransactionModal');
        modal.classList.remove('active');
    }

    function showTransactionNotification(message, type = 'success') {
        if (typeof showNotification === 'function') {
            showNotification(message, type);
        }
    }

    function toggleSelectMode() {
        const columnHeadersRow = document.getElementById('columnHeadersRow');
        const checkboxHeaderCol = document.getElementById('checkboxHeaderCol');
        const selectModeBtn = document.getElementById('selectModeBtn');
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        const cancelSelectBtn = document.getElementById('cancelSelectBtn');
        const transactionRows = document.querySelectorAll('.transaction-row');
        const selectAll = document.getElementById('selectAllTransactions');
        const isVisible = checkboxHeaderCol.style.display !== 'none';
        
        if (isVisible) {
            // Turn OFF select mode - hide checkboxes, remove extra column
            checkboxHeaderCol.style.display = 'none';
            columnHeadersRow.style.gridTemplateColumns = '50px 100px 150px 1fr 130px 90px 140px';
            transactionRows.forEach(row => {
                row.style.gridTemplateColumns = '50px 100px 150px 1fr 130px 90px 140px';
                row.querySelector('.checkbox-col').style.display = 'none';
            });
            selectModeBtn.style.display = 'block';
            bulkDeleteBtn.style.display = 'none';
            cancelSelectBtn.style.display = 'none';
            document.querySelectorAll('.transaction-checkbox').forEach(cb => cb.checked = false);
            selectAll.checked = false;
        } else {
            // Turn ON select mode - show checkboxes, add extra column
            checkboxHeaderCol.style.display = 'block';
            columnHeadersRow.style.gridTemplateColumns = '40px 50px 100px 150px 1fr 130px 90px 140px';
            transactionRows.forEach(row => {
                row.style.gridTemplateColumns = '40px 50px 100px 150px 1fr 130px 90px 140px';
                row.querySelector('.checkbox-col').style.display = 'block';
            });
            selectModeBtn.style.display = 'none';
            cancelSelectBtn.style.display = 'block';
        }
    }

    function selectAllTransactionCheckboxes() {
        const selectAllCheckbox = document.getElementById('selectAllTransactions');
        const checkboxes = document.querySelectorAll('.transaction-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
        toggleBulkDeleteBtnTransactions();
    }

    function toggleBulkDeleteBtnTransactions() {
        const checkboxes = document.querySelectorAll('.transaction-checkbox');
        const checkedCheckboxes = document.querySelectorAll('.transaction-checkbox:checked');
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        
        bulkDeleteBtn.style.display = checkedCheckboxes.length > 0 ? 'block' : 'none';
        
        const selectAllCheckbox = document.getElementById('selectAllTransactions');
        selectAllCheckbox.checked = checkboxes.length > 0 && checkedCheckboxes.length === checkboxes.length;
    }

    function bulkDeleteTransactions() {
        const checkedCheckboxes = document.querySelectorAll('.transaction-checkbox:checked');
        
        if (checkedCheckboxes.length === 0) {
            alert('Silakan pilih minimal satu transaksi untuk dihapus');
            return;
        }
        
        Modal.delete(`${checkedCheckboxes.length} transaksi terpilih`, function() {
            showTransactionNotification(`Menghapus ${checkedCheckboxes.length} transaksi...`, 'success');
            
            const ids = Array.from(checkedCheckboxes).map(checkbox => checkbox.value);
            
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('cash.destroyBulk', [], false) }}';
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);
            
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);
            
            ids.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = id;
                form.appendChild(input);
            });
            
            document.body.appendChild(form);
            setTimeout(() => form.submit(), 500);
        });
    }
</script>
@endsection

@section('scripts')
<script>
</script>
@endsection
