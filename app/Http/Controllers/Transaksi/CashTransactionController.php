<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\KasKeluar;
use App\Models\KasMasuk;

class CashTransactionController extends Controller
{
    public function index()
    {
        // Get all cash in and out that are NOT product related
        $cashIns = KasMasuk::with(['category', 'category.account'])
            ->whereHas('category', function ($q) {
                $q->where('is_product', false);
            })
            ->orderBy('id', 'desc')->get();

        $cashOuts = KasKeluar::with(['category', 'category.account'])
            ->whereHas('category', function ($q) {
                $q->where('is_product', false);
            })
            ->orderBy('id', 'desc')->get();

        $allTransactions = collect()
            ->merge($cashIns->map(fn ($t) => [
                'id' => $t->id,
                'date' => $t->date,
                'account' => $t->category->account ?? null,
                'category' => $t->category,
                'description' => $t->description,
                'amount' => $t->amount,
                'file_path' => $t->file_path,
                'type' => 'income',
                'created_at' => $t->created_at,
            ]))
            ->merge($cashOuts->map(fn ($t) => [
                'id' => $t->id,
                'date' => $t->date,
                'account' => $t->category->account ?? null,
                'category' => $t->category,
                'description' => $t->description,
                'amount' => $t->amount,
                'file_path' => $t->file_path,
                'type' => 'expense',
                'created_at' => $t->created_at,
            ]))
            ->sort(function ($a, $b) {
                return $b['created_at'] <=> $a['created_at'];
            })
            ->values();

        // Categories for general cash transactions (not penjualan/pembelian products)
        $akunMasuk = Category::where('is_active', true)
            ->where('is_product', false)
            ->where('type', 'cash_in')
            ->orderBy('name')->get();

        $akunKeluar = Category::where('is_active', true)
            ->where('is_product', false)
            ->where('type', 'cash_out')
            ->orderBy('name')->get();

        return view('cash.index', compact('cashIns', 'cashOuts', 'allTransactions', 'akunMasuk', 'akunKeluar'));
    }

    public function createIn()
    {
        $categories = Category::where('is_active', true)
            ->where('is_product', false)
            ->where('type', 'cash_in')
            ->orderBy('name')->get();

        return view('transaksi.cash-in.create', compact('categories'));
    }

    public function createOut()
    {
        $categories = Category::where('is_active', true)
            ->where('is_product', false)
            ->where('type', 'cash_out')
            ->orderBy('name')->get();

        return view('transaksi.cash-out.create', compact('categories'));
    }
}
