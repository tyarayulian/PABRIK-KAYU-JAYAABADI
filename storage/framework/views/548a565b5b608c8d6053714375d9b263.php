<?php $__env->startSection('title', 'Neraca Saldo'); ?>
<?php $__env->startSection('breadcrumb', 'Laporan > Neraca Saldo'); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="<?php echo e(asset('css/print-report.css')); ?>?v=<?php echo e(time()); ?>">
<style>
    * {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .main-content {
        background-color: transparent !important;
        box-shadow: none !important;
        border: none !important;
    }

    .trial-container {
        max-width: 1000px;
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
        transition: all 0.2s;
    }

    .btn-filter:hover {
        background: #1e293b; color: white;
    }

    .btn-reset-filter {
        background: #fff; color: #1e2a78; border: 1px solid #e2e8f0; padding: 0 24px; 
        height: 36px; border-radius: 8px; font-weight: 700; font-size: 12px; 
        cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none;
        transition: all 0.2s;
    }

    .btn-reset-filter:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .btn-outline {
        background: #fff; color: #1e2a78; border: 1px solid #e2e8f0; padding: 0 16px; 
        height: 36px; border-radius: 8px; font-weight: 700; font-size: 12px; display: inline-flex; 
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

    .trial-table {
        width: 100%;
        border-collapse: collapse;
    }

    .trial-table th {
        padding: 12px 24px;
        text-align: left;
        font-weight: 800;
        color: #475569;
        font-size: 10px;
        text-transform: uppercase;
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
        letter-spacing: 0.05em;
    }

    .category-header-row td {
        padding: 12px 24px !important;
        font-weight: 800;
        background: #ffffff;
        color: #111827 !important;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #f1f5f9;
    }

    .trial-table td {
        padding: 14px 24px;
        border-bottom: 1px solid #f8fafc;
        font-size: 13px;
        color: #1e293b;
        font-weight: 600;
    }

    .amount { 
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700; 
        text-align: right; 
        font-size: 14px;
        letter-spacing: -0.01em;
    }

    .text-debit { color: #059669; }
    .text-credit { color: #f43f5e; }
    .text-zero-debit { color: #059669; }
    .text-zero-credit { color: #f43f5e; }

    .status-bar {
        padding: 20px 24px; 
        background: #ffffff; 
        border-top: 1px solid #f1f5f9; 
        display: flex; 
        justify-content: space-between; 
        align-items: center;
    }

    .status-label {
        font-size: 10px;
        font-weight: 800;
        color: #94a3b8;
        text-transform: uppercase;
        margin-bottom: 2px;
    }

    .status-value {
        font-weight: 700;
        font-size: 15px;
        display: flex;
        align-items: center;
        gap: 6px;
        letter-spacing: 0.02em;
    }

    .total-item {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .total-label {
        font-size: 10px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 2px;
    }

    .total-value {
        font-size: 14px;
        font-weight: 700;
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

        .trial-container {
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
        .trial-table {
            font-size: 9pt !important;
        }

        .trial-table th {
            font-size: 8pt !important;
            padding: 3mm 2mm !important;
            background: #f5f5f5 !important;
            border: 1px solid #000 !important;
            color: #000 !important;
            -webkit-print-color-adjust: exact !important;
        }

        .trial-table td {
            padding: 2mm !important;
            font-size: 9pt !important;
            border: 1px solid #ddd !important;
            color: #000 !important;
        }

        /* Category headers */
        .category-header-row td { 
            background: #e5e7eb !important; 
            color: #000 !important; 
            -webkit-print-color-adjust: exact !important; 
            border-bottom: 1pt solid #000 !important;
            border-top: 1pt solid #000 !important;
            font-weight: 800 !important;
            padding: 2mm !important;
        }

        /* Amount alignment */
        .amount {
            font-family: 'Courier New', monospace !important;
            text-align: right !important;
            font-weight: 600 !important;
        }

        /* Total row */
        .total-row td {
            font-weight: 800 !important;
            border-top: 2px solid #000 !important;
            border-bottom: 2px double #000 !important;
            background: #f5f5f5 !important;
            -webkit-print-color-adjust: exact !important;
        }

        /* Status bar */
        .status-bar {
            padding: 5mm 0 !important;
            margin-top: 5mm !important;
            border-top: 2px solid #000 !important;
        }

        /* Remove colors */
        .text-debit,
        .text-credit {
            color: #000 !important;
        }

        /* Page breaks */
        tr {
            page-break-inside: avoid;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="trial-container">
        <div class="table-section">
            <div style="text-align: center; padding: 50px 24px 30px 24px; border-bottom: 1px solid #f1f5f9; margin-bottom: 20px;">
                <h1 style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0; letter-spacing: -0.5px;">NERACA SALDO</h1>
                <div style="font-size: 18px; font-weight: 800; color: #1e293b; text-transform: uppercase; margin-top: 5px;">Pabrik Kayu Jaya Abadi</div>
                <div style="font-size: 14px; color: #64748b; font-weight: 500; margin-top: 8px;">
                    <?php if($filterType === 'per_bulan' && !request('month')): ?>
                        Periode: <?php echo e(\Carbon\Carbon::now()->startOfMonth()->format('d/m/Y')); ?> - <?php echo e(\Carbon\Carbon::now()->endOfMonth()->format('d/m/Y')); ?>

                    <?php elseif($filterType === 'per_bulan' && request('month')): ?>
                        Periode: <?php echo e(\Carbon\Carbon::create($year, $month, 1)->startOfMonth()->format('d/m/Y')); ?> - <?php echo e(\Carbon\Carbon::create($year, $month, 1)->endOfMonth()->format('d/m/Y')); ?>

                    <?php elseif($filterType === 'per_tahun'): ?>
                        Periode: 01/01/<?php echo e($year); ?> - 31/12/<?php echo e($year); ?>

                    <?php elseif($startDate && $endDate): ?>
                        Periode: <?php echo e(\Carbon\Carbon::parse($startDate)->format('d/m/Y')); ?> - <?php echo e(\Carbon\Carbon::parse($endDate)->format('d/m/Y')); ?>

                    <?php else: ?>
                        Periode: Semua Data
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="filter-row">
                <form method="GET" action="<?php echo e(route('report.trial-balance')); ?>" style="display: flex; gap: 12px; flex: 1; align-items: flex-end; flex-wrap: wrap;">
                    <input type="hidden" name="filter_type" value="custom">

                    <div class="filter-group">
                        <label>MULAI</label>
                        <input type="date" name="start_date" value="<?php echo e($startDate ? \Carbon\Carbon::parse($startDate)->format('Y-m-d') : ''); ?>" style="height: 36px; padding: 0 12px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 13px;">
                    </div>
                    <div class="filter-group">
                        <label>AKHIR</label>
                        <input type="date" name="end_date" value="<?php echo e($endDate ? \Carbon\Carbon::parse($endDate)->format('Y-m-d') : ''); ?>" style="height: 36px; padding: 0 12px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 13px;">
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <button type="submit" class="btn-filter" style="height: 36px; padding: 0 20px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-filter"></i> Terapkan
                        </button>
                        <a href="<?php echo e(route('report.trial-balance')); ?>" class="btn-reset-filter" style="height: 36px; padding: 0 20px; display: flex; align-items: center;">Reset</a>
                    </div>
                </form>
                <div style="display: flex; gap: 8px; margin-left: 12px;">
                    <button type="button" onclick="window.print()" class="btn-outline" style="height: 36px; padding: 0 16px; display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-print"></i> PDF
                    </button>
                    <a href="<?php echo e(route('report.trial-balance', array_merge(request()->all(), ['export' => 'excel']))); ?>" class="btn-outline" style="height: 36px; padding: 0 16px; display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-file-excel"></i> Excel
                    </a>
                </div>
            </div>

            <?php if(count($trialBalance) > 0): ?>
                <table class="trial-table">
                    <thead>
                        <tr>
                            <th style="width: 150px;">KODE AKUN</th>
                            <th>NAMA AKUN</th>
                            <th style="text-align: right; width: 220px;">DEBIT (RP)</th>
                            <th style="text-align: right; width: 220px;">KREDIT (RP)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $trialBalance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $accounts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td style="font-weight: 700;"><?php echo e($account['code']); ?></td>
                                    <td><?php echo e($account['name']); ?></td>
                                    <td class="amount <?php echo e($account['debit'] > 0 ? 'text-debit' : 'text-zero-debit'); ?>">
                                        Rp<?php echo e(number_format($account['debit'], 0, ',', '.')); ?>

                                    </td>
                                    <td class="amount <?php echo e($account['credit'] > 0 ? 'text-credit' : 'text-zero-credit'); ?>">
                                        Rp<?php echo e(number_format($account['credit'], 0, ',', '.')); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <div class="status-bar">
                    <div>
                        <div class="status-label">STATUS</div>
                        <?php if(abs($totalDebit - $totalCredit) < 0.01): ?>
                            <div class="status-value" style="color: #059669;">
                                <i class="fas fa-check-circle"></i> BALANCE
                            </div>
                        <?php else: ?>
                            <div class="status-value" style="color: #f43f5e;">
                                <i class="fas fa-times-circle"></i> UNBALANCED
                            </div>
                        <?php endif; ?>
                    </div>
                    <div style="display: flex; gap: 40px;">
                        <div class="total-item">
                            <span class="total-label">TOTAL DEBIT</span>
                            <span class="total-value text-debit">Rp<?php echo e(number_format($totalDebit, 0, ',', '.')); ?></span>
                        </div>
                        <div class="total-item">
                            <span class="total-label">TOTAL KREDIT</span>
                            <span class="total-value text-credit">Rp<?php echo e(number_format($totalCredit, 0, ',', '.')); ?></span>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div style="padding: 100px 0; text-align: center;">
                    <div style="color: #94a3b8;">
                        <i class="fas fa-balance-scale" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3;"></i>
                        <p>Tidak ada data neraca saldo ditemukan untuk periode ini.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp4\htdocs\pabrik-kayu1\resources\views/report/neraca_saldo/index.blade.php ENDPATH**/ ?>