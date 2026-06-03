# Testing Guide - Tambah Transaksi Feature

## ✅ Perubahan yang Telah Dilakukan

### 1. Database
- ✓ Kolom `file_path` ditambahkan ke `cash_in` dan `cash_out` tables
- ✓ Migration telah dijalankan: `2025_12_18_171535_add_file_attachment_to_cash_tables`

### 2. Backend
- ✓ CashInController & CashOutController menangani file upload
- ✓ Validasi file: JPG, PNG, PDF (Max 2MB)
- ✓ File disimpan ke: `storage/app/public/transactions/cash-in/` dan `cash-out/`
- ✓ CashIn & CashOut Model support `file_path` field

### 3. Frontend
- ✓ Modal form di dashboard dengan semua fields
- ✓ Category filtering berdasarkan transaction type
- ✓ File upload with preview
- ✓ Number formatting dengan separator
- ✓ Form validation & error handling
- ✓ Console logging untuk debugging

## 🧪 Step-by-Step Testing

### Test 1: Buka Modal Transaksi
```
1. Buka Dashboard
2. Klik tombol "Tambah Transaksi" (tombol coklat di bawah)
3. Modal harus terbuka dengan form kosong
4. Tanggal harus terisi otomatis dengan hari ini
5. "Kas Masuk" harus dipilih secara default
```

### Test 2: Kategori Filtering - Kas Masuk
```
1. Pastikan "Kas Masuk" (●) dipilih
2. Klik dropdown "Kategori"
3. Lihat kategori yang ditampilkan - hanya kategori dengan tipe Revenue (Pendapatan)
   Contoh: "4100 - Penjualan Produk", "4200 - Jasa", dsb
4. Tidak boleh ada kategori Expense (5xxx)
```

### Test 3: Kategori Filtering - Kas Keluar
```
1. Klik radio button "Kas Keluar" (●)
2. Klik dropdown "Kategori"
3. Lihat kategori yang ditampilkan - hanya kategori dengan tipe Expense (Beban)
   Contoh: "5100 - Beban Gaji", "5200 - Beban Bahan Baku", dsb
4. Tidak boleh ada kategori Revenue (4xxx)
5. Klik "Kas Masuk" lagi - kategori harus berubah kembali
```

### Test 4: Upload File - Berhasil
```
1. Buka modal "Tambah Transaksi"
2. Isi form:
   - Tanggal: biarkan default (hari ini)
   - Tipe: Kas Masuk
   - Kategori: Pilih salah satu (misal "4100 - Penjualan Produk")
   - Jumlah: 1000000
   - Keterangan: "Test upload"
3. Klik area "Upload File" atau "Choose File"
4. Pilih file JPG, PNG, atau PDF dari komputer (ukuran < 2MB)
5. File harus ditampilkan dengan ✓ checkmark
6. Klik "Simpan Transaksi"
7. Harus muncul pesan sukses: "✓ Pencatatan kas masuk berhasil ditambahkan"
8. Dashboard akan reload dan menampilkan transaksi baru
```

### Test 5: Upload File - Validation Error
```
Coba upload dengan kondisi error berikut:

A. File terlalu besar
   1. Pilih file > 2MB
   2. Harus muncul alert: "⚠️ File terlalu besar. Maksimal 2MB."
   3. File tidak boleh ditampilkan

B. Format salah
   1. Pilih file dengan format .doc, .xlsx, .txt, dsb
   2. Harus muncul alert: "⚠️ Format file tidak didukung. Gunakan JPG, PNG, atau PDF."
   3. File tidak boleh ditampilkan

C. Tidak upload file (optional)
   1. Biarkan file upload kosong
   2. Isi form lainnya (Tanggal, Kategori, Jumlah)
   3. Klik "Simpan Transaksi"
   4. Harus berhasil (file optional)
   5. Cek database - file_path harus NULL
```

### Test 6: Validasi Form
```
1. Klik "Simpan Transaksi" tanpa isi apa-apa
2. Harus muncul alert berurutan:
   - "⚠️ Tanggal harus diisi"
   - (isi tanggal, coba lagi)
   - "⚠️ Jumlah harus lebih dari 0"
   - (isi jumlah, coba lagi)
   - "⚠️ Kategori harus dipilih"
```

### Test 7: Number Formatting
```
1. Di field "Jumlah", ketik: 1000000
2. Display harus berubah menjadi: 1.000.000
3. Ketik tambahan: 2 → display: 1.000.0002 (ini normal, akan di-fix saat submit)
4. Submit form - harus terkirim dengan nilai angka asli: 10000002
```

### Test 8: Lihat File yang Diupload
```
1. Upload transaksi dengan file
2. Buka public/storage/transactions/cash-in/ atau cash-out/
3. File harus ada dengan nama: CashIn_[timestamp]_[unique].pdf
4. Akses via browser: http://localhost/storage/transactions/cash-in/CashIn_...pdf
5. File harus terbuka/download
```

## 🔍 Debugging dengan Console

### Buka DevTools
```
Tekan F12 atau Ctrl+Shift+I
Klik tab "Console"
```

### Lihat Log untuk Category Filtering
```
Ketika membuka modal atau switch Kas Masuk/Keluar, lihat:
✓ Transaction type selected: in/out
✓ Option: 4100 - Penjualan Produk, Type: revenue, Show: true
✓ Total visible categories: 4
```

### Lihat Log untuk File Upload
```
Ketika select file, lihat:
✓ File dipilih: invoice.pdf Size: 1500 bytes Type: application/pdf
✓ File valid!

Atau jika error:
✗ Format file tidak didukung. Gunakan JPG, PNG, atau PDF.
```

### Lihat Log untuk Form Submit
```
Ketika klik "Simpan Transaksi", lihat:
✓ Form Data yang dikirim:
  - date: 2025-12-18
  - category_id: 1
  - description: Test
  - amount: 1000000
  - file: File - invoice.pdf (1500 bytes)
✓ Response status: 200
```

## ⚠️ Troubleshooting

### File Upload Tidak Bekerja

**Gejala**: File tidak ditampilkan atau error saat submit

**Solusi**:
1. Buka DevTools Console (F12)
2. Lihat apakah ada error message
3. Verifikasi:
   - File < 2MB
   - Format JPG/PNG/PDF
   - Directory `storage/app/public/transactions/` ada
4. Check permission folder `storage/` writable
   ```bash
   chmod -R 775 storage/
   ```

### Kategori Tidak Berubah saat Switch Tipe

**Gejala**: Kategori tetap sama saat switch Kas Masuk/Keluar

**Solusi**:
1. Buka DevTools Console (F12)
2. Ketik: `updateCategoryOptions()`
3. Enter
4. Lihat kategori berubah
5. Jika tidak, clear cache browser: Ctrl+Shift+Delete

### Form Tidak Submit

**Gejala**: Klik tombol tapi tidak ada yang terjadi

**Solusi**:
1. Buka DevTools Console (F12)
2. Cari error message (warna merah)
3. Verifikasi form isi semua field wajib:
   - Tanggal: harus ada
   - Kategori: harus ada (tidak grey)
   - Jumlah: harus > 0
4. Cek network tab: request harus ke `/cash/in` atau `/cash/out`

### File Tidak Tersimpan di Database

**Gejala**: Transaksi tersimpan tapi file_path NULL

**Solusi**:
1. Verifikasi file dipilih saat submit (lihat console)
2. Cek Response error message
3. Verifikasi format file valid
4. Check storage directory permissions:
   ```bash
   chmod -R 777 storage/app/public/
   ```

## 📊 Verifikasi di Database

Buka command line dan masukkan SQL:

```sql
-- Lihat transaksi dengan file
SELECT id, date, amount, file_path FROM cash_in WHERE file_path IS NOT NULL LIMIT 5;
SELECT id, date, amount, file_path FROM cash_out WHERE file_path IS NOT NULL LIMIT 5;

-- Lihat transaksi terbaru
SELECT id, date, amount, category_id FROM cash_in ORDER BY id DESC LIMIT 3;
```

## ✅ Checklist

- [ ] Database migration berjalan (status: Ran)
- [ ] Bisa buka modal "Tambah Transaksi"
- [ ] Kategori berubah saat switch Kas Masuk/Keluar
- [ ] Bisa upload file (< 2MB, JPG/PNG/PDF)
- [ ] Form submit berhasil tanpa file (optional)
- [ ] Form submit berhasil dengan file
- [ ] File tersimpan di storage/app/public/transactions/
- [ ] File_path tertampan di database
- [ ] Dashboard reload dan tampil transaksi baru
- [ ] Console tidak ada error

## 📞 Need Help?

Jika ada error, tangkap di Console (F12) dan kirim:
1. Error message lengkap
2. Screenshot Console
3. Network response (tab Network)
