# Developer Notes - Tambah Transaksi Feature

## What Was Changed

### 1. Database Migration
- Added `file_path` column to `cash_in` and `cash_out` tables
- Migration: `2025_12_18_171535_add_file_attachment_to_cash_tables.php`
- File can be nullable (optional upload)

### 2. Models Updated
- `CashIn.php`: Added `file_path` to `$fillable`
- `CashOut.php`: Added `file_path` to `$fillable`

### 3. Controllers Updated
- `CashInController.php`: File upload handling in `store()` method
- `CashOutController.php`: File upload handling in `store()` method
- Validation: `file|mimes:jpeg,png,jpg,pdf|max:2048`
- File storage: `storage/app/public/transactions/cash-in/` and `cash-out/`

### 4. Frontend Updates
- Dashboard modal form with:
  - **Tipe Transaksi**: Kas Masuk / Kas Keluar (Radio buttons)
  - **Tanggal**: Date input (auto-fills today)
  - **Kategori**: Filtered by transaction type (Revenue for Kas Masuk, Expense for Kas Keluar)
  - **Jumlah**: Number with Indonesian formatting (1.000.000)
  - **Keterangan**: Optional description
  - **Upload File**: Optional file upload (JPG, PNG, PDF - Max 2MB)

### 5. Category Filtering Logic
```javascript
- When "Kas Masuk" selected → Show only Revenue accounts (4xxx)
- When "Kas Keluar" selected → Show only Expense accounts (5xxx)
- Filter uses data-type attribute on option elements
```

## How to Test

### Test 1: Category Filtering
1. Click "Tambah Transaksi" button
2. Open browser DevTools (F12)
3. Go to Console tab
4. Click on "Kas Masuk" → See console logs showing visible categories
5. Click on "Kas Keluar" → See console logs showing different categories

**Expected**: When switching transaction types, kategori dropdown changes

### Test 2: File Upload
1. Fill form with test data
2. Click file upload area or "Choose File"
3. Select a JPG/PNG/PDF file
4. Check console for: "File dipilih: [filename] Size: [bytes] Type: [type]"
5. Should see checkmark and filename displayed

**Expected**: File preview shows with green checkmark

### Test 3: Form Submission
1. Fill all required fields
2. Select a file (optional)
3. Click "Simpan Transaksi"
4. Check console for "Form Data yang dikirim"
5. Should show all form fields including file (if selected)

**Expected**: 
- If file included: `file: File - [filename] ([bytes] bytes)`
- Success message appears
- Dashboard reloads with new transaction

## Console Debugging

Open DevTools Console (F12) to see:
- Category filtering logs
- File selection validation
- Form data submission details
- Response status codes

Common messages:
```
✓ File dipilih: invoice.pdf Size: 1500 bytes Type: application/pdf
✓ File valid!
✓ Transaction type selected: in
✓ Total visible categories: 4
```

## File Storage Details

Files are stored at:
- **Kas Masuk**: `storage/app/public/transactions/cash-in/CashIn_[timestamp]_[unique].pdf`
- **Kas Keluar**: `storage/app/public/transactions/cash-out/CashOut_[timestamp]_[unique].pdf`

Access URL:
- `/storage/transactions/cash-in/CashIn_1234567890_abc123.pdf`

## Troubleshooting

### File Upload Not Working
1. Check browser console for errors (F12)
2. Verify file is selected (should show in modal)
3. Check file size < 2MB
4. Check file format is JPG/PNG/PDF
5. Check `storage/app/public/transactions/` directory exists

### Category Not Filtering
1. Open DevTools Console (F12)
2. Look for "Transaction type selected" log
3. Verify categories exist in database (Check Master Akun page)
4. Clear browser cache and reload

### Form Not Submitting
1. Check all required fields are filled
2. Verify kategori is selected (not showing grey)
3. Check amount > 0
4. Look for validation error in alert
5. Check console for fetch errors

## Important Files

- `resources/views/dashboard.blade.php` - Main modal form + JavaScript
- `app/Http/Controllers/CashInController.php` - Cash In file handling
- `app/Http/Controllers/CashOutController.php` - Cash Out file handling
- `database/migrations/2025_12_18_171535_add_file_attachment_to_cash_tables.php` - Database schema
- `config/filesystems.php` - Storage configuration
- `public/storage` - Symlink to storage/app/public

## Form Field Mapping

| Frontend | Database | Type |
|----------|----------|------|
| Tanggal | date | date |
| Kategori | category_id | integer |
| Jumlah | amount | decimal(15,2) |
| Keterangan | description | text |
| File | file_path | string |
