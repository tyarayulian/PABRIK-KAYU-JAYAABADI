<?php $__env->startSection('title', 'Transaksi'); ?>
<?php $__env->startSection('breadcrumb', 'Transaksi'); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.8/pdfobject.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="<?php echo e(asset('css/modal.css')); ?>?v=<?php echo e(time()); ?>">
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

    .stat-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        margin-bottom: 4px;
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
        border-radius: 30px;
        border: 1px solid #f0f0f0;
        overflow: hidden;
        margin-bottom: 30px;
    }

    .table-title-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 30px;
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

    .btn-danger-action {
        background: #ef4444;
        color: white;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.2s;
    }

    .btn-danger-action:hover {
        background: #dc2626;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.2);
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

    .btn-add {
        background: #000;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 15px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    /* Combined Table Grid Styling */
    .table-container {
        width: 100%;
    }

    .table-header-grid {
        display: grid;
        grid-template-columns: 60px 100px 100px 1.5fr 1fr 120px 130px;
        padding: 20px 30px;
        background: #fff;
        border-bottom: 1px solid #f0f0f0;
        align-items: center;
    }

    .header-item {
        font-size: 13px;
        font-weight: 700;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .table-row-grid {
        display: grid;
        grid-template-columns: 60px 100px 100px 1.5fr 1fr 120px 130px;
        padding: 20px 30px;
        background: #fff;
        border-bottom: 1px solid #f8f8f8;
        align-items: center;
        transition: all 0.2s;
    }

    .table-row-grid:hover {
        background-color: #fafafa;
    }

    .row-item {
        font-size: 15px;
        color: #000;
    }

    .amount-positive { color: #16a34a; font-weight: 700; }
    .amount-negative { color: #dc2626; font-weight: 700; }

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        padding: 30px;
        background: #fff;
        border-top: 1px solid #f0f0f0;
    }

    .pagination-btn {
        min-width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        border: none;
        background: #f5f5f5;
        color: #666;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .pagination-btn:hover:not(:disabled) {
        background: #eee;
        color: #000;
    }

    .pagination-btn.active {
        background: #000;
        color: #fff;
    }

    .pagination-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Modal Styles */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        z-index: 2000;
        align-items: center;
        justify-content: center;
        /* NO BLUR */
    }

    .modal-overlay.active { display: flex; }

    .modal-content {
        background: white;
        border-radius: 30px;
        padding: 40px;
        width: 90%;
        max-width: 550px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h2 { font-size: 24px; font-weight: 800; color: #000; margin: 0; }
    
    .modal-close-btn {
        background: none;
        border: none;
        font-size: 24px;
        color: #999;
        cursor: pointer;
    }

    .btn-modal-cancel { 
        background: #f5f5f5; 
        color: #666; 
        border: none; 
        padding: 15px 30px; 
        border-radius: 15px; 
        cursor: pointer; 
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-modal-cancel:hover { background: #eee; color: #000; }

    .btn-modal-submit { 
        background: #000; 
        color: white; 
        border: none; 
        padding: 15px 30px; 
        border-radius: 15px; 
        cursor: pointer; 
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-modal-submit:hover { background: #333; transform: translateY(-2px); }

    .empty-state {
        padding: 60px;
        text-align: center;
        color: #999;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 20px;
        color: #eee;
    }
    
    .controls-section, .filter-section, .filter-title { display: none; }
    .radio-group { display: flex; gap: 20px; }
    .radio-option { display: flex; align-items: center; gap: 8px; cursor: pointer; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #000; font-size: 14px; }
    .form-group input, .form-group select { width: 100%; padding: 12px; border: 1px solid #eee; border-radius: 12px; font-size: 14px; }

        box-shadow: 0 4px 6px -1px rgba(139, 111, 71, 0.2);
    }

    .btn-add:hover {
        background: #7a5e3a;
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(139, 111, 71, 0.3);
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

    .table-section {
        background: white;
        border-radius: 20px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        width: 100%;
        box-sizing: border-box;
    }

    .table-section > div:not(.table-title-section):not(.filter-row) {
        display: block;
        width: 100%;
        box-sizing: border-box;
        min-width: 800px;
    }

    .table-section > div[style*="grid"] {
        display: grid !important;
        width: 100%;
        box-sizing: border-box;
        min-width: 800px;
    }

    .table-header {
        padding: 16px 32px;
        border-bottom: 1px solid #f1f5f9;
        background: #f8fafc;
    }

    .table-header h3 {
        font-size: 14px;
        font-weight: 600;
        color: #111827;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead tr {
        background: #f9fafb;
        border-bottom: 2px solid #e5e7eb;
    }

    th {
        padding: 12px 20px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    tbody tr {
        border-bottom: 1px solid #f3f4f6;
        transition: background 0.2s;
    }

    tbody tr:hover {
        background: #f9fafb;
    }

    td {
        padding: 14px 20px;
        font-size: 14px;
        color: #111827;
    }

    .table-section [style*="grid-template-columns"] > div {
        min-width: 0;
        overflow: hidden;
    }

    .amount-positive {
        color: #059669;
        font-weight: 700;
    }

    .amount-negative {
        color: #f43f5e;
        font-weight: 700;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0;
        background: transparent;
        border-radius: 0;
        font-size: 14px;
        font-weight: 500;
        color: #1e293b;
        border: none;
    }

    .btn-delete {
        background: #fff1f2;
        color: #e11d48;
        border: 1px solid #ffe4e6;
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-delete:hover {
        background: #ffe4e6;
        border-color: #fecdd3;
        transform: translateY(-1px);
    }

    .btn-cancel {
        background: #f8fafc;
        color: #475569;
        border: 1px solid #e2e8f0;
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-cancel:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }

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

    .empty-state p {
        margin: 0;
        font-size: 15px;
        font-weight: 500;
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
        transition: all 0.3s ease;
    }

    .modal-overlay.active {
        display: flex;
        animation: fadeIn 0.3s ease;
    }

    .modal-content {
        background: white;
        border-radius: 24px;
        padding: 32px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        max-height: 90vh;
        overflow-y: auto;
        border: 1px solid #f1f5f9;
        animation: zoomIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes zoomIn {
        from { 
            opacity: 0;
            transform: scale(0.9);
        }
        to { 
            opacity: 1;
            transform: scale(1);
        }
    }

    .modal-header {
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
    }

    .modal-header h2 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.025em;
    }

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
        transition: all 0.2s;
        border-radius: 12px;
    }

    .modal-close-btn:hover {
        background: #ef4444;
        color: white;
        border-color: #ef4444;
    }

    .modal-close-btn:active {
        transform: scale(0.95);
    }

    .form-group-modal {
        margin-bottom: 20px;
    }

    .form-group-modal label {
        display: block;
        margin-bottom: 8px;
        font-weight: 700;
        color: #334155;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .form-group-modal input,
    .form-group-modal select,
    .form-group-modal textarea {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font-size: 15px;
        color: #1e293b;
        background: #f8fafc;
        transition: all 0.2s;
        box-sizing: border-box;
    }

    .form-group-modal textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-group-modal input:focus,
    .form-group-modal select:focus,
    .form-group-modal textarea:focus {
        outline: none;
        border-color: #1e2a78;
        background: white;
        box-shadow: 0 0 0 4px rgba(30, 42, 120, 0.1);
    }

    .form-group-modal small {
        display: block;
        color: #64748b;
        font-size: 12px;
        margin-top: 4px;
    }

    .modal-footer {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid #f1f5f9;
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
        transition: all 0.2s;
    }

    .btn-modal-cancel:hover {
        background: #e2e8f0;
        color: #1e293b;
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
        transition: all 0.2s;
        box-shadow: 0 4px 6px -1px rgba(30, 42, 120, 0.2);
    }

    .btn-modal-submit:hover {
        background: #16205a;
        transform: translateY(-1px);
        box-shadow: 0 10px 15px -3px rgba(30, 42, 120, 0.3);
    }

    .file-input-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .file-input-label {
        display: block;
        padding: 10px 12px;
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: #f9fafb;
    }

    .file-input-label:hover {
        border-color: #1e2a78;
        background: #f3f4f6;
    }

    .file-input-label.has-file {
        border-color: #1e2a78;
        background: #f0f7ff;
    }

    #fileInput {
        display: none;
    }

    .file-info {
        display: none;
        margin-top: 8px;
        padding: 8px 12px;
        background: #f0f7ff;
        border: 1px solid #eef2ff;
        border-radius: 6px;
        font-size: 12px;
        color: #1e2a78;
    }

    .file-info.active {
        display: block;
    }

    .error-message {
        display: none;
        color: #ef4444;
        font-size: 12px;
        margin-top: 4px;
    }

    .error-message.active {
        display: block;
    }

    .form-group-modal input.error,
    .form-group-modal select.error {
        border-color: #ef4444 !important;
        background-color: #fef2f2;
    }

    @media (max-width: 1200px) {
        .filter-row {
            flex-wrap: wrap;
        }

        .filter-group {
            flex: 0 1 calc(50% - 6px);
        }
    }

    @media (max-width: 768px) {
        .controls-row {
            flex-direction: column;
        }

        .form-group {
            min-width: 100%;
        }

        .stat-cards-grid {
            grid-template-columns: 1fr;
        }

        .filter-row {
            flex-direction: column;
        }

        .filter-group {
            width: 100%;
        }
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
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
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
        box-shadow: 0 4px 6px -1px rgba(30, 42, 120, 0.2);
    }

    .pagination-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background: #f8fafc;
        color: #94a3b8;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div style="padding: 0 20px 40px 20px;">
    <!-- STAT CARDS -->
    <div class="stat-cards-grid" style="margin-top: 30px;">
        <div class="stat-card">
            <div class="stat-icon income">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div class="stat-info">
                <div class="stat-card-label">Total Pemasukan</div>
                <div class="stat-card-value" id="statIncomeValue">Rp<?php echo e(number_format($cashIns->sum('amount'), 0, ',', '.')); ?></div>
                <div class="stat-card-meta" id="statIncomeCount"><?php echo e($cashIns->count()); ?> transaksi</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon expense">
                <i class="fas fa-arrow-up"></i>
            </div>
            <div class="stat-info">
                <div class="stat-card-label">Total Pengeluaran</div>
                <div class="stat-card-value" id="statExpenseValue">Rp<?php echo e(number_format($cashOuts->sum('amount'), 0, ',', '.')); ?></div>
                <div class="stat-card-meta" id="statExpenseCount"><?php echo e($cashOuts->count()); ?> transaksi</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon net">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="stat-info">
                <div class="stat-card-label">Saldo Bersih</div>
                <div class="stat-card-value" id="statNetValue">Rp<?php echo e(number_format($cashIns->sum('amount') - $cashOuts->sum('amount'), 0, ',', '.')); ?></div>
                <div class="stat-card-meta">Pemasukan - Pengeluaran</div>
            </div>
        </div>
    </div>

    <!-- COMBINED TRANSAKSI LIST -->
    <div class="table-section" id="combinedTableSection">
        <!-- TITLE AND ADD BUTTON -->
        <div class="table-title-section">
            <div>
                <h2>Daftar Transaksi</h2>
                <p id="totalTransactionsCount">Menampilkan total <strong><?php echo e($allTransactions->count()); ?></strong> transaksi</p>
            </div>
            <div style="display: flex; gap: 12px; align-items: center;">
                <a href="<?php echo e(route('kas-masuk.create')); ?>" class="btn-action btn-action-primary" style="background: #f0f4ff; color: #1e2a78; border: 1px solid #e2e8f0; box-shadow: none;">
                    <i class="fas fa-plus"></i> Penjualan
                </a>
                <a href="<?php echo e(route('kas-keluar.create')); ?>" class="btn-action btn-action-primary" style="background: #fff1f2; color: #f43f5e; border: 1px solid #ffe4e6; box-shadow: none;">
                    <i class="fas fa-plus"></i> Pembelian
                </a>
                <button class="btn-outline" id="selectModeBtn" onclick="toggleSelectMode()">
                    <i class="fas fa-check-square"></i> Pilih
                </button>
                <button class="btn-danger-action" id="bulkDeleteBtn" onclick="bulkDeleteTransactions()" style="display: none;">
                    <i class="fas fa-trash"></i> Hapus Terpilih
                </button>
                <button class="btn-outline" id="cancelSelectBtn" onclick="toggleSelectMode()" style="display: none;">
                    Batal
                </button>
            </div>
        </div>

        <!-- FILTER ROW -->
        <div id="filterPanel" class="filter-row">
            <div class="filter-group">
                <label>MULAI</label>
                <input type="date" id="filterStartDate" value="<?php echo e(request('start_date')); ?>">
            </div>

            <div class="filter-group">
                <label>AKHIR</label>
                <input type="date" id="filterEndDate" value="<?php echo e(request('end_date')); ?>">
            </div>

            <div class="filter-actions">
                <button class="btn-filter" onclick="applyDateFilter()">
                    <i class="fas fa-filter"></i> Terapkan
                </button>
                <a href="<?php echo e(route('transaksi.index')); ?>" class="btn-reset-filter">
                    Reset
                </a>
            </div>

            <div class="search-group">
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="transactionSearch" class="search-input" placeholder="Cari keterangan atau produk..." onkeyup="filterTable()">
                </div>
            </div>
        </div>

        <!-- TRANSACTION TYPE TABS -->
        <div class="tabs-container">
            <button onclick="filterByTransactionType('all')" class="tab-button active" data-tab="all">Semua</button>
            <button onclick="filterByTransactionType('income')" class="tab-button" data-tab="income">Penjualan</button>
            <button onclick="filterByTransactionType('expense')" class="tab-button" data-tab="expense">Pembelian</button>
        </div>

        <!-- COLUMN HEADERS -->
        <div id="columnHeadersRow" style="display: grid; grid-template-columns: 40px 100px 130px 120px 1fr 60px 140px 80px 100px; gap: 12px; align-items: center; padding: 16px 32px; background: #f8fafc; border-bottom: 2px solid #e2e8f0; font-weight: 700; font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">
            <div id="checkboxHeaderCol" style="display: none; text-align: center;">
                <input type="checkbox" id="selectAllTransactions" onchange="selectAllTransactionCheckboxes()" style="cursor: pointer;">
            </div>
            <div style="text-align: center;">NO</div>
            <div style="text-align: left;">TANGGAL</div>
            <div style="text-align: left;">PRODUK</div>
            <div style="text-align: left;">ASAL KAYU</div>
            <div style="text-align: left;">KETERANGAN</div>
            <div style="text-align: center;">QTY</div>
            <div style="text-align: left;">JUMLAH</div>
            <div style="text-align: left;">BERKAS</div>
            <div style="text-align: left;">AKSI</div>
        </div>

        <!-- TRANSACTION LIST -->
        <div style="padding: 0;">
            <?php $__empty_1 = true; $__currentLoopData = $allTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div data-transaction-id="<?php echo e($transaction['id']); ?>" data-transaction-type="<?php echo e($transaction['type']); ?>" data-item-index="<?php echo e($index); ?>" data-amount="Rp<?php echo e(number_format($transaction['amount'], 0, ',', '.')); ?>" class="transaction-row" style="display: grid; grid-template-columns: 40px 100px 130px 120px 1fr 60px 140px 80px 100px; gap: 12px; align-items: start; padding: 18px 32px; border-bottom: 1px solid #f8fafc; transition: all 0.2s; background: white;" onmouseover="this.style.background='#fcfcfd'" onmouseout="this.style.background='white'">
                    <!-- CHECKBOX COLUMN -->
                    <div id="checkboxCell-<?php echo e($transaction['id']); ?>" class="checkbox-col" style="display: none; text-align: center;">
                        <input type="checkbox" class="transaction-checkbox" value="<?php echo e($transaction['id']); ?>" onchange="toggleBulkDeleteBtnTransactions()" style="cursor: pointer;">
                    </div>

                    <!-- NO COLUMN -->
                    <div class="transaction-number" style="text-align: center; font-size: 13px; color: #94a3b8; font-weight: 500;">
                        <?php echo e($loop->iteration); ?>

                    </div>

                    <!-- DATE COLUMN -->
                    <div style="text-align: left;">
                        <div style="font-size: 14px; color: #1e293b; font-weight: 600;">
                            <?php echo e($transaction['date']->locale('id')->translatedFormat('d M Y')); ?>

                        </div>
                        <div style="font-size: 12px; color: #94a3b8; margin-top: 2px;"><?php echo e($transaction['date']->format('H:i')); ?></div>
                    </div>

                    <!-- CATEGORY BADGE -->
                    <div style="text-align: left;">
                        <div style="display: flex; flex-direction: column; gap: 4px;">
                            <span class="badge">
                                <?php if(isset($transaction['product']) && $transaction['product']): ?>
                                    <?php if($transaction['type'] === 'expense'): ?>
                                        Kayu <?php echo e($transaction['product']->wood_type); ?>

                                    <?php else: ?>
                                        <?php echo e($transaction['product']->name); ?>

                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php echo e($transaction['category']->name ?? ($transaction['account']->name ?? 'N/A')); ?>

                                <?php endif; ?>
                            </span>
                            <?php if(isset($transaction['account']) && $transaction['account']): ?>
                                <span style="font-size: 11px; color: #a0aec0; font-weight: 500;">
                                    <?php echo e($transaction['account']->name); ?>

                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- ASAL KAYU -->
                    <div style="text-align: left;">
                        <span style="font-size: 14px; color: #475569; font-weight: 500;">
                            <?php echo e($transaction['hutan'] ?? '-'); ?>

                        </span>
                    </div>

                    <!-- DESCRIPTION -->
                    <div style="text-align: left; width: 100%; overflow: hidden;">
                        <div style="font-size: 14px; color: #475569; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;" title="<?php echo e($transaction['description'] ?? '-'); ?>">
                            <?php echo e($transaction['description'] ?? '-'); ?>

                        </div>
                    </div>

                    <!-- QUANTITY -->
                    <div style="text-align: center;">
                        <span style="font-size: 14px; color: #475569; font-weight: 600;">
                            <?php echo e((isset($transaction['product']) && $transaction['product']) ? ($transaction['quantity'] != 0 ? (int)$transaction['quantity'] : '-') : '-'); ?>

                        </span>
                    </div>

                    <!-- AMOUNT -->
                    <div style="text-align: left;">
                        <?php if($transaction['type'] === 'income'): ?>
                            <div class="amount-positive">
                                +Rp<?php echo e(number_format($transaction['amount'], 0, ',', '.')); ?>

                            </div>
                        <?php else: ?>
                            <div class="amount-negative">
                                -Rp<?php echo e(number_format($transaction['amount'], 0, ',', '.')); ?>

                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- FILE -->
                    <div style="text-align: left;">
                        <?php if($transaction['file_path']): ?>
                            <div style="position: relative; display: inline-block;">
                                <?php
                                    $fileExt = strtolower(pathinfo($transaction['file_path'], PATHINFO_EXTENSION));
                                    $isImage = in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                    $isPdf = $fileExt === 'pdf';
                                    $fileUrl = url('/storage/' . $transaction['file_path']);
                                    
                                    $actualFileName = basename($transaction['file_path']);
                                    $prefix = $transaction['type'] === 'income' ? 'Penjualan' : 'Pembelian';
                                    
                                    // Replace KasMasuk/KasKeluar with Penjualan/Pembelian for display
                                    $displayFileName = str_replace(['KasMasuk_', 'KasKeluar_'], [$prefix . '_', $prefix . '_'], $actualFileName);
                                ?>
                                <?php if($isImage): ?>
                                    <img src="<?php echo e($fileUrl); ?>" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" style="width: 36px; height: 36px; border-radius: 8px; object-fit: cover; cursor: pointer; border: 1px solid #e2e8f0; box-shadow: 0 1px 2px rgba(0,0,0,0.05);" onclick="openViewer('<?php echo e($fileUrl); ?>', '<?php echo e($displayFileName); ?>')" title="Klik untuk lihat gambar">
                                    <div style="width: 36px; height: 36px; border-radius: 8px; background: #f1f5f9; border: 1px solid #e2e8f0; display: none; align-items: center; justify-content: center; cursor: pointer; font-size: 11px; color: #64748b; font-weight: 600;" onclick="this.previousElementSibling.style.display=''; this.style.display='none';" title="File tidak dapat dimuat">
                                        <i class="fas fa-exclamation" style="color: #ef4444; font-size: 14px;"></i>
                                    </div>
                                <?php elseif($isPdf): ?>
                                    <div style="width: 36px; height: 36px; border-radius: 8px; background: #fff1f2; border: 1px solid #ffe4e6; display: flex; align-items: center; justify-content: center; cursor: pointer;" onclick="openViewer('<?php echo e($fileUrl); ?>', '<?php echo e($displayFileName); ?>')" title="Klik untuk lihat PDF">
                                        <span style="color: #e11d48; font-size: 10px; font-weight: 800; letter-spacing: 0.05em;">PDF</span>
                                    </div>
                                <?php else: ?>
                                    <div style="width: 36px; height: 36px; border-radius: 8px; background: #f1f5f9; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; cursor: pointer;" onclick="openViewer('<?php echo e($fileUrl); ?>', '<?php echo e($displayFileName); ?>')" title="Klik untuk download">
                                        <i class="fas fa-file" style="color: #64748b; font-size: 14px;"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <span style="font-size: 13px; color: #d1d5db;">-</span>
                        <?php endif; ?>
                    </div>

                    <!-- ACTIONS -->
                    <div style="text-align: left; display: flex; gap: 8px; align-items: center;">
                        <button style="background: #f1f5f9; color: #1e293b; border: 1px solid #e2e8f0; padding: 0; width: 34px; height: 34px; border-radius: 10px; font-size: 14px; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center;" title="Lihat" onclick="showTransactionDetail(<?php echo e($transaction['id']); ?>, '<?php echo e($transaction['type']); ?>')" onmouseover="this.style.background='#e2e8f0'; this.style.borderColor='#cbd5e1'" onmouseout="this.style.background='#f1f5f9'; this.style.borderColor='#e2e8f0'"><i class="fas fa-eye"></i></button>
                        
                        <?php
                            $editUrl = $transaction['type'] === 'income' 
                                ? route('kas-masuk.edit', $transaction['id']) 
                                : route('kas-keluar.edit', $transaction['id']);
                        ?>
                        <a href="<?php echo e($editUrl); ?>" style="background: #f8fafc; color: #1e2a78; border: 1px solid #e2e8f0; padding: 0; width: 34px; height: 34px; border-radius: 10px; font-size: 14px; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; text-decoration: none;" title="Edit" onmouseover="this.style.background='#f1f5f9'; this.style.borderColor='#1e2a78'" onmouseout="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'"><i class="fas fa-edit"></i></a>
                        
                        <button style="background: #fff1f2; color: #f43f5e; border: 1px solid #ffe4e6; padding: 0; width: 34px; height: 34px; border-radius: 10px; font-size: 14px; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center;" title="Hapus" onclick="deleteTransaction(<?php echo e($transaction['id']); ?>, '<?php echo e($transaction['type']); ?>')" onmouseover="this.style.background='#ffe4e6'; this.style.borderColor='#fecdd3'" onmouseout="this.style.background='#fff1f2'; this.style.borderColor='#ffe4e6'"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <p>Belum ada data transaksi yang ditemukan</p>
                </div>
            <?php endif; ?>
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
                <label style="display: block; font-size: 12px; color: #6b7280; text-transform: uppercase; font-weight: 600; margin-bottom: 6px;">Produk</label>
                <div id="detailAccount" style="font-size: 14px; color: #111827; font-weight: 500;"></div>
            </div>

            <div style="margin-top: 20px; display: none;" id="detailHutanContainer">
                <label style="display: block; font-size: 12px; color: #6b7280; text-transform: uppercase; font-weight: 600; margin-bottom: 6px;">Asal Kayu</label>
                <div id="detailHutan" style="font-size: 14px; color: #111827; font-weight: 500;"></div>
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

<?php echo $__env->make('components.file-viewer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script>
    const ITEMS_PER_PAGE = 10;
    let currentPage = 1;
    let allVisibleTransactions = [];
    let currentTransactionTypeFilter = 'all';

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

    function deleteTransaction(id, type) {
        Modal.delete('transaksi ini', function() {
            const endpoint = type === 'income' 
                ? `<?php echo e(route("kas-masuk.destroy", ":id", false)); ?>`.replace(':id', id)
                : `<?php echo e(route("kas-keluar.destroy", ":id", false)); ?>`.replace(':id', id);

            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            formData.append('_method', 'DELETE');

            fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
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
                        if (typeof Toast !== 'undefined') {
                            Toast.error(data.message || 'Terjadi kesalahan saat menghapus');
                        } else {
                            showTransactionNotification(data.message || 'Terjadi kesalahan', 'error');
                        }
                    }
                })
                .catch(error => {
                    if (typeof Toast !== 'undefined') {
                        Toast.error(error.message || 'Gagal menghapus transaksi');
                    } else {
                        showTransactionNotification(error.message || 'Gagal menghapus transaksi', 'error');
                    }
                });
        });
    }

    let searchTimer;
    function filterTable() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            applyDateFilter();
        }, 300);
    }

    function filterByTransactionType(type) {
        currentTransactionTypeFilter = type;
        
        // Update tab button styling
        document.querySelectorAll('.tab-button').forEach(btn => {
            if (btn.dataset.tab === type) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
        
        applyDateFilter();
    }

    function populateYearSelect() {
        const yearSelect = document.getElementById('filterYear');
        const now = new Date();
        const currentYear = now.getFullYear();
        const startYear = 2020; // Fixed start year

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
        const startDate = document.getElementById('filterStartDate').value;
        const endDate = document.getElementById('filterEndDate').value;

        let startDateTime = null;
        let endDateTime = null;

        if (startDate && endDate) {
            startDateTime = new Date(startDate);
            endDateTime = new Date(endDate);
            endDateTime.setHours(23, 59, 59);
        }

        filterTransactionsByDate(startDateTime, endDateTime);
    }

    function filterTransactionsByDate(startDate, endDate) {
        const transactionDivs = document.querySelectorAll('.transaction-row');
        const selectedType = currentTransactionTypeFilter;
        const searchQuery = document.getElementById('transactionSearch').value.toLowerCase();
        let visibleRows = 0;

        let totalIncome = 0;
        let totalExpense = 0;
        let countIncome = 0;
        let countExpense = 0;

        transactionDivs.forEach(div => {
            const dateDiv = div.querySelector('.transaction-number').nextElementSibling;
            if (!dateDiv) return;

            const dateText = dateDiv.textContent.trim();
            const transactionDate = parseDate(dateText);
            const type = div.dataset.transactionType;

            // Comprehensive search: search in everything (Description, Category, Product, Amount, Date, Qty)
            const fullText = div.innerText.toLowerCase();
            const searchMatch = !searchQuery || fullText.includes(searchQuery);

            const dateMatch = (!startDate || !endDate) || (transactionDate >= startDate && transactionDate <= endDate);
            const typeMatch = (selectedType === 'all' || selectedType === type);

            if (dateMatch && typeMatch && searchMatch) {
                div.style.display = 'grid';
                visibleRows++;

                const amountText = div.dataset.amount || "";
                const amount = parseInt(amountText.replace(/\D/g, '')) || 0;

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
            totalCountElement.innerHTML = `Menampilkan total <strong>${visibleRows}</strong> transaksi`;
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
        document.getElementById('filterStartDate').value = '';
        document.getElementById('filterEndDate').value = '';
        document.getElementById('transactionSearch').value = '';
        applyDateFilter();
    }

    window.addEventListener('click', function(event) {
        const modal = document.getElementById('addTransactionModal');
        if (event.target === modal) {
            closeAddModal();
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
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
            totalCountElement.innerHTML = `Menampilkan total <strong>${allVisibleTransactions.length}</strong> transaksi`;
        }
        
        // Initialize pagination untuk halaman awal
        initializePagination();
        
        // Kemudian apply filter
        applyDateFilter();
        
        // Update filter active count
        updateFilterActiveCount();
    });

    let currentTransactionDetail = null;

    function showTransactionDetail(id, type) {
        const endpoint = `<?php echo e(route("api.cash.detail", ["type" => ":type", "id" => ":id"], false)); ?>`
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
                    
                    document.getElementById('detailType').textContent = transaction.type === 'income' ? 'Penjualan' : 'Pembelian';
                    document.getElementById('detailType').style.background = transaction.type === 'income' ? 'rgba(20, 184, 166, 0.1)' : 'rgba(239, 68, 68, 0.1)';
                    document.getElementById('detailType').style.color = transaction.type === 'income' ? '#14b8a6' : '#ef4444';
                    
                    document.getElementById('detailAccount').textContent = transaction.account_name || '-';
                    
                    const hutanContainer = document.getElementById('detailHutanContainer');
                    const detailHutan = document.getElementById('detailHutan');
                    if (transaction.type === 'expense' && transaction.hutan) {
                        detailHutan.textContent = transaction.hutan;
                        hutanContainer.style.display = 'block';
                    } else {
                        hutanContainer.style.display = 'none';
                    }
                    
                    document.getElementById('detailDescription').textContent = transaction.description || '-';
                    
                    const amountColor = transaction.type === 'income' ? '#14b8a6' : '#ef4444';
                    const amountSymbol = transaction.type === 'income' ? '+' : '-';
                    document.getElementById('detailAmount').innerHTML = `<span style="color: ${amountColor};">${amountSymbol}Rp${parseInt(transaction.amount).toLocaleString('id-ID')}</span>`;
                    
                    if (transaction.file_path) {
                        let fileName = transaction.file_path.split('/').pop();
                        const prefix = transaction.type === 'income' ? 'Penjualan' : 'Pembelian';
                        
                        // Replace KasMasuk/KasKeluar with Penjualan/Pembelian for display
                        fileName = fileName.replace('KasMasuk_', prefix + '_').replace('KasKeluar_', prefix + '_');

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
                                        <button type="button" onclick="openViewer('${transaction.file_url}', '${fileName}')" style="background: #1e2a78; color: white; border: none; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer;">
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
        
        const standardGrid = '40px 100px 130px 120px 1fr 60px 120px 60px 100px';
        const selectionGrid = '40px 40px 100px 130px 120px 1fr 60px 120px 60px 100px';
        
        if (isVisible) {
            // Turn OFF select mode
            checkboxHeaderCol.style.display = 'none';
            columnHeadersRow.style.gridTemplateColumns = standardGrid;
            transactionRows.forEach(row => {
                row.style.gridTemplateColumns = standardGrid;
                row.querySelector('.checkbox-col').style.display = 'none';
            });
            selectModeBtn.style.display = 'inline-flex';
            bulkDeleteBtn.style.display = 'none';
            cancelSelectBtn.style.display = 'none';
            document.querySelectorAll('.transaction-checkbox').forEach(cb => cb.checked = false);
            selectAll.checked = false;
        } else {
            // Turn ON select mode
            checkboxHeaderCol.style.display = 'block';
            columnHeadersRow.style.gridTemplateColumns = selectionGrid;
            transactionRows.forEach(row => {
                row.style.gridTemplateColumns = selectionGrid;
                row.querySelector('.checkbox-col').style.display = 'block';
            });
            selectModeBtn.style.display = 'none';
            cancelSelectBtn.style.display = 'inline-flex';
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
            if (typeof Toast !== 'undefined') {
                Toast.error('Silakan pilih minimal satu transaksi untuk dihapus');
            }
            return;
        }
        
        Modal.delete(`${checkedCheckboxes.length} transaksi terpilih`, function() {
            showTransactionNotification(`Menghapus ${checkedCheckboxes.length} transaksi...`, 'success');
            
            const ids = Array.from(checkedCheckboxes).map(checkbox => checkbox.value);
            
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?php echo e(route('cash.destroyBulk', [], false)); ?>';
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '<?php echo e(csrf_token()); ?>';
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp4\htdocs\pabrik-kayu1\resources\views/transaksi-produk/index.blade.php ENDPATH**/ ?>