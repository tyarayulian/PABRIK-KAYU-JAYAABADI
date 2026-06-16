<?php
// Test Case Export - Pabrik Kayu Jaya Abadi
// Akses: http://127.0.0.1:8000/test_case.php

$filename = 'TestCase_PabrikKayu_November2026.csv';

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Pragma: no-cache');
header('Expires: 0');

$out = fopen('php://output', 'w');
// BOM untuk Excel agar baca UTF-8 dengan benar
fwrite($out, "\xEF\xBB\xBF");

// =============================================
// SOAL
// =============================================
fputcsv($out, ['SOAL PENGUJIAN - PABRIK KAYU JAYA ABADI']);
fputcsv($out, ['Periode: November 2026']);
fputcsv($out, []);

fputcsv($out, ['SALDO AWAL (1 November 2026)']);
fputcsv($out, ['Akun', 'Kode', 'Saldo']);
fputcsv($out, ['Kas', '1101', 'Rp 15.000.000']);
fputcsv($out, ['Bank BRI', '1102', 'Rp 35.000.000']);
fputcsv($out, ['Modal Pemilik', '3101', '(otomatis dari sistem)']);
fputcsv($out, []);

fputcsv($out, ['DATA PRODUK']);
fputcsv($out, ['Produk', 'HPP/Kubik', 'Stok Awal']);
fputcsv($out, ['Kayu Senggon Balok 8x12x4', 'Rp 1.000.000', '0 kubik']);
fputcsv($out, []);

fputcsv($out, ['DATA TRANSAKSI']);
fputcsv($out, ['Tanggal', 'Jenis Transaksi', 'Keterangan']);
fputcsv($out, ['02/11/2026', 'Input Stok', 'Menambah stok produk Kayu Senggon Balok 8x12x4 sebanyak 30 kubik dengan HPP Rp 1.000.000/kubik']);
fputcsv($out, ['05/11/2026', 'Pembelian', 'Membeli bahan baku kayu senggon sebanyak 15 kubik dari UD. Hutan Lestari senilai Rp 1.000.000/kubik, total Rp 15.000.000, dibayar via Bank BRI']);
fputcsv($out, ['10/11/2026', 'Penjualan', 'Menjual kayu senggon balok olahan sebanyak 8 kubik kepada CV. Mebel Indah seharga Rp 2.200.000/kubik, total Rp 17.600.000, diterima via Kas']);
fputcsv($out, ['14/11/2026', 'Penjualan', 'Menjual kayu senggon balok olahan sebanyak 5 kubik kepada Toko Bangunan Maju seharga Rp 2.200.000/kubik, total Rp 11.000.000, diterima via Bank BRI']);
fputcsv($out, ['18/11/2026', 'Pemasukan', 'Menerima pendapatan jasa potong kayu dari PT. Rimba sebesar Rp 3.000.000, diterima via Kas']);
fputcsv($out, ['22/11/2026', 'Pengeluaran', 'Membayar biaya operasional (listrik & air) sebesar Rp 600.000 via Bank BRI']);
fputcsv($out, ['27/11/2026', 'Retur Penjualan', 'CV. Mebel Indah mengembalikan 2 kubik dari transaksi 10/11/2026 karena barang tidak sesuai spesifikasi, senilai Rp 4.400.000']);
fputcsv($out, []);
fputcsv($out, []);

// =============================================
// JAWABAN
// =============================================
fputcsv($out, ['JAWABAN']);
fputcsv($out, []);

// Stok
fputcsv($out, ['1. PERGERAKAN STOK PRODUK']);
fputcsv($out, ['Tanggal', 'Keterangan', 'Masuk (Kubik)', 'Keluar (Kubik)', 'Sisa Stok']);
fputcsv($out, ['02/11/2026', 'Input Stok', 30, '', 30]);
fputcsv($out, ['10/11/2026', 'Penjualan ke CV. Mebel Indah', '', 8, 22]);
fputcsv($out, ['14/11/2026', 'Penjualan ke Toko Bangunan Maju', '', 5, 17]);
fputcsv($out, ['27/11/2026', 'Retur dari CV. Mebel Indah', 2, '', 19]);
fputcsv($out, ['', 'STOK AKHIR', '', '', 19]);
fputcsv($out, []);

// Jurnal Umum
fputcsv($out, ['2. JURNAL UMUM']);
fputcsv($out, ['No', 'Tanggal', 'Ref', 'Akun', 'Debit (Rp)', 'Kredit (Rp)']);
fputcsv($out, [1, '01/11/2026', 'OB', 'Kas', 15000000, '']);
fputcsv($out, ['', '01/11/2026', 'OB', 'Modal Pemilik', '', 15000000]);
fputcsv($out, [2, '01/11/2026', 'OB', 'Bank BRI', 35000000, '']);
fputcsv($out, ['', '01/11/2026', 'OB', 'Modal Pemilik', '', 35000000]);
fputcsv($out, [3, '02/11/2026', 'PS-x', 'Persediaan Produk Jadi', 30000000, '']);
fputcsv($out, ['', '02/11/2026', 'PS-x', 'Modal Pemilik', '', 30000000]);
fputcsv($out, [4, '05/11/2026', 'KK-x', 'Persediaan Bahan Baku', 15000000, '']);
fputcsv($out, ['', '05/11/2026', 'KK-x', 'Bank BRI', '', 15000000]);
fputcsv($out, [5, '10/11/2026', 'KM-x', 'Kas', 17600000, '']);
fputcsv($out, ['', '10/11/2026', 'KM-x', 'Pendapatan Penjualan', '', 17600000]);
fputcsv($out, [6, '10/11/2026', 'HPP-x', 'HPP', 8000000, '']);
fputcsv($out, ['', '10/11/2026', 'HPP-x', 'Modal Pemilik', '', 8000000]);
fputcsv($out, [7, '14/11/2026', 'KM-x', 'Bank BRI', 11000000, '']);
fputcsv($out, ['', '14/11/2026', 'KM-x', 'Pendapatan Penjualan', '', 11000000]);
fputcsv($out, [8, '14/11/2026', 'HPP-x', 'HPP', 5000000, '']);
fputcsv($out, ['', '14/11/2026', 'HPP-x', 'Modal Pemilik', '', 5000000]);
fputcsv($out, [9, '18/11/2026', 'KM-x', 'Kas', 3000000, '']);
fputcsv($out, ['', '18/11/2026', 'KM-x', 'Pendapatan Lain-lain', '', 3000000]);
fputcsv($out, [10, '22/11/2026', 'KK-x', 'Biaya Operasional', 600000, '']);
fputcsv($out, ['', '22/11/2026', 'KK-x', 'Bank BRI', '', 600000]);
fputcsv($out, [11, '27/11/2026', 'RJ-x', 'Retur Penjualan', 4400000, '']);
fputcsv($out, ['', '27/11/2026', 'RJ-x', 'Kas', '', 4400000]);
fputcsv($out, [12, '27/11/2026', 'RJ-x-S', 'Persediaan Produk Jadi', 2000000, '']);
fputcsv($out, ['', '27/11/2026', 'RJ-x-S', 'HPP', '', 2000000]);
fputcsv($out, ['', '', '', 'TOTAL', 146600000, 146600000]);
fputcsv($out, []);

// Neraca Saldo
fputcsv($out, ['3. NERACA SALDO']);
fputcsv($out, ['Akun', 'Kode', 'Debit (Rp)', 'Kredit (Rp)']);
fputcsv($out, ['Kas', '1101', 31200000, '']);
fputcsv($out, ['Bank BRI', '1102', 30400000, '']);
fputcsv($out, ['Persediaan Bahan Baku', '1105', 15000000, '']);
fputcsv($out, ['Persediaan Produk Jadi', '1106', 32000000, '']);
fputcsv($out, ['Modal Pemilik', '3101', '', 93000000]);
fputcsv($out, ['Pendapatan Penjualan', '4101', '', 28600000]);
fputcsv($out, ['Retur Penjualan', '4102', 4400000, '']);
fputcsv($out, ['HPP', '5101', 11000000, '']);
fputcsv($out, ['Pendapatan Lain-lain', '4103', '', 3000000]);
fputcsv($out, ['Biaya Operasional', '6101', 600000, '']);
fputcsv($out, ['TOTAL', '', 124600000, 124600000]);
fputcsv($out, []);

// Laba Rugi
fputcsv($out, ['4. LAPORAN LABA RUGI - November 2026']);
fputcsv($out, ['Keterangan', 'Jumlah (Rp)']);
fputcsv($out, ['Pendapatan Penjualan', 28600000]);
fputcsv($out, ['Retur Penjualan', -4400000]);
fputcsv($out, ['Pendapatan Lain-lain', 3000000]);
fputcsv($out, ['Total Pendapatan Bersih', 27200000]);
fputcsv($out, ['HPP', -11000000]);
fputcsv($out, ['Laba Kotor', 16200000]);
fputcsv($out, ['Biaya Operasional', -600000]);
fputcsv($out, ['LABA BERSIH', 15600000]);
fputcsv($out, []);

// Neraca
fputcsv($out, ['5. NERACA - 30 November 2026']);
fputcsv($out, ['AKTIVA', 'Jumlah (Rp)', 'EKUITAS', 'Jumlah (Rp)']);
fputcsv($out, ['Kas', 31200000, 'Modal Pemilik', 93000000]);
fputcsv($out, ['Bank BRI', 30400000, 'Laba Tahun Berjalan', 15600000]);
fputcsv($out, ['Persediaan Bahan Baku', 15000000, '', '']);
fputcsv($out, ['Persediaan Produk Jadi', 32000000, '', '']);
fputcsv($out, ['Total Aktiva', 108600000, 'Total Ekuitas', 108600000]);
fputcsv($out, []);

// =============================================
// BUKU BESAR
// =============================================
fputcsv($out, ['6. BUKU BESAR']);
fputcsv($out, []);

// Kas
fputcsv($out, ['Kas (1101)']);
fputcsv($out, ['Tanggal', 'Keterangan', 'Debit (Rp)', 'Kredit (Rp)', 'Saldo (Rp)']);
fputcsv($out, ['01/11/2026', 'Saldo Awal (OB) - Modal Pemilik', 15000000, '', 15000000]);
fputcsv($out, ['10/11/2026', 'Pendapatan Penjualan (CV. Mebel Indah)', 17600000, '', 32600000]);
fputcsv($out, ['18/11/2026', 'Pendapatan Lain-lain', 3000000, '', 35600000]);
fputcsv($out, ['27/11/2026', 'Retur Penjualan', '', 4400000, 31200000]);
fputcsv($out, ['', 'SALDO AKHIR', '', '', 31200000]);
fputcsv($out, []);

// Bank BRI
fputcsv($out, ['Bank BRI (1102)']);
fputcsv($out, ['Tanggal', 'Keterangan', 'Debit (Rp)', 'Kredit (Rp)', 'Saldo (Rp)']);
fputcsv($out, ['01/11/2026', 'Saldo Awal (OB) - Modal Pemilik', 35000000, '', 35000000]);
fputcsv($out, ['05/11/2026', 'Persediaan Bahan Baku', '', 15000000, 20000000]);
fputcsv($out, ['14/11/2026', 'Pendapatan Penjualan (Toko Bangunan Maju)', 11000000, '', 31000000]);
fputcsv($out, ['22/11/2026', 'Biaya Operasional', '', 600000, 30400000]);
fputcsv($out, ['', 'SALDO AKHIR', '', '', 30400000]);
fputcsv($out, []);

// Persediaan Bahan Baku
fputcsv($out, ['Persediaan Bahan Baku (1105)']);
fputcsv($out, ['Tanggal', 'Keterangan', 'Debit (Rp)', 'Kredit (Rp)', 'Saldo (Rp)']);
fputcsv($out, ['05/11/2026', 'Pembelian Kayu - Bank BRI', 15000000, '', 15000000]);
fputcsv($out, ['', 'SALDO AKHIR', '', '', 15000000]);
fputcsv($out, []);

// Persediaan Produk Jadi
fputcsv($out, ['Persediaan Produk Jadi (1106)']);
fputcsv($out, ['Tanggal', 'Keterangan', 'Debit (Rp)', 'Kredit (Rp)', 'Saldo (Rp)']);
fputcsv($out, ['02/11/2026', 'Input Stok - Modal Pemilik', 30000000, '', 30000000]);
fputcsv($out, ['27/11/2026', 'Retur Penjualan - HPP', 2000000, '', 32000000]);
fputcsv($out, ['', 'SALDO AKHIR', '', '', 32000000]);
fputcsv($out, []);

// Modal Pemilik
fputcsv($out, ['Modal Pemilik (3101)']);
fputcsv($out, ['Tanggal', 'Keterangan', 'Debit (Rp)', 'Kredit (Rp)', 'Saldo (Rp)']);
fputcsv($out, ['01/11/2026', 'Saldo Awal Kas (OB)', '', 15000000, 15000000]);
fputcsv($out, ['01/11/2026', 'Saldo Awal Bank BRI (OB)', '', 35000000, 50000000]);
fputcsv($out, ['02/11/2026', 'Input Stok Produk Jadi', '', 30000000, 80000000]);
fputcsv($out, ['10/11/2026', 'HPP Penjualan (8 kubik)', '', 8000000, 88000000]);
fputcsv($out, ['14/11/2026', 'HPP Penjualan (5 kubik)', '', 5000000, 93000000]);
fputcsv($out, ['', 'SALDO AKHIR', '', '', 93000000]);
fputcsv($out, []);

// Pendapatan Penjualan
fputcsv($out, ['Pendapatan Penjualan (4101)']);
fputcsv($out, ['Tanggal', 'Keterangan', 'Debit (Rp)', 'Kredit (Rp)', 'Saldo (Rp)']);
fputcsv($out, ['10/11/2026', 'Penjualan ke CV. Mebel Indah - Kas', '', 17600000, 17600000]);
fputcsv($out, ['14/11/2026', 'Penjualan ke Toko Bangunan Maju - Bank BRI', '', 11000000, 28600000]);
fputcsv($out, ['', 'SALDO AKHIR', '', '', 28600000]);
fputcsv($out, []);

// Retur Penjualan
fputcsv($out, ['Retur Penjualan (4102)']);
fputcsv($out, ['Tanggal', 'Keterangan', 'Debit (Rp)', 'Kredit (Rp)', 'Saldo (Rp)']);
fputcsv($out, ['27/11/2026', 'Retur dari CV. Mebel Indah - Kas', 4400000, '', 4400000]);
fputcsv($out, ['', 'SALDO AKHIR', '', '', 4400000]);
fputcsv($out, []);

// Pendapatan Lain-lain
fputcsv($out, ['Pendapatan Lain-lain (4103)']);
fputcsv($out, ['Tanggal', 'Keterangan', 'Debit (Rp)', 'Kredit (Rp)', 'Saldo (Rp)']);
fputcsv($out, ['18/11/2026', 'Jasa Potong Kayu PT. Rimba - Kas', '', 3000000, 3000000]);
fputcsv($out, ['', 'SALDO AKHIR', '', '', 3000000]);
fputcsv($out, []);

// HPP
fputcsv($out, ['HPP - Harga Pokok Penjualan (5101)']);
fputcsv($out, ['Tanggal', 'Keterangan', 'Debit (Rp)', 'Kredit (Rp)', 'Saldo (Rp)']);
fputcsv($out, ['10/11/2026', 'HPP Penjualan 8 kubik - Modal Pemilik', 8000000, '', 8000000]);
fputcsv($out, ['14/11/2026', 'HPP Penjualan 5 kubik - Modal Pemilik', 5000000, '', 13000000]);
fputcsv($out, ['27/11/2026', 'HPP Retur 2 kubik - Persediaan Produk Jadi', '', 2000000, 11000000]);
fputcsv($out, ['', 'SALDO AKHIR', '', '', 11000000]);
fputcsv($out, []);

// Biaya Operasional
fputcsv($out, ['Biaya Operasional (6101)']);
fputcsv($out, ['Tanggal', 'Keterangan', 'Debit (Rp)', 'Kredit (Rp)', 'Saldo (Rp)']);
fputcsv($out, ['22/11/2026', 'Biaya Listrik & Air - Bank BRI', 600000, '', 600000]);
fputcsv($out, ['', 'SALDO AKHIR', '', '', 600000]);

fclose($out);
