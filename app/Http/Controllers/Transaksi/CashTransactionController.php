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
        // Get date filter from request
        $startDate = request('start_date');
        $endDate = request('end_date');

        // Get all cash in and out that are NOT product related
        $cashIns = KasMasuk::with(['category', 'category.account'])
            ->whereHas('category', function ($q) {
                $q->where('is_product', false);
            })
            ->when($startDate, function ($query) use ($startDate) {
                return $query->whereDate('date', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->whereDate('date', '<=', $endDate);
            })
            ->orderBy('id', 'desc')->get();

        $cashOuts = KasKeluar::with(['category', 'category.account'])
            ->whereHas('category', function ($q) {
                $q->where('is_product', false);
            })
            ->when($startDate, function ($query) use ($startDate) {
                return $query->whereDate('date', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->whereDate('date', '<=', $endDate);
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

    public function editIn($id)
    {
        $kasMasuk = KasMasuk::findOrFail($id);
        $categories = Category::where('is_active', true)
            ->where('is_product', false)
            ->where('type', 'cash_in')
            ->orderBy('name')->get();

        return view('transaksi.cash-in.edit', compact('kasMasuk', 'categories'));
    }

    public function editOut($id)
    {
        $kasKeluar = KasKeluar::findOrFail($id);
        $categories = Category::where('is_active', true)
            ->where('is_product', false)
            ->where('type', 'cash_out')
            ->orderBy('name')->get();

        return view('transaksi.cash-out.edit', compact('kasKeluar', 'categories'));
    }

    public function show($type, $id)
    {
        try {
            if ($type === 'income') {
                $transaction = KasMasuk::with(['category', 'category.account'])->findOrFail($id);
            } else {
                $transaction = KasKeluar::with(['category', 'category.account'])->findOrFail($id);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $transaction->id,
                    'date' => $transaction->date,
                    'type' => $type,
                    'category_name' => $transaction->category->name ?? '-',
                    'description' => $transaction->description,
                    'amount' => $transaction->amount,
                    'file_url' => $transaction->file_path ? asset('storage/' . $transaction->file_path) : null,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }
}
