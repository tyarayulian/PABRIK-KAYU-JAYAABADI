<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\KasKeluar;
use App\Models\KasMasuk;

class TransaksiProdukController extends Controller
{
    public function index()
    {
        $cashIns = KasMasuk::where(function ($query) {
            $query->whereNotNull('product_id')
                ->orWhereHas('category', function ($q) {
                    $q->where('transaction_type', 'penjualan');
                });
        })
            ->with(['category', 'category.account', 'product'])
            ->orderBy('id', 'desc')
            ->get();

        $cashOuts = KasKeluar::where(function ($query) {
            $query->whereNotNull('product_id')
                ->orWhereHas('category', function ($q) {
                    $q->where('transaction_type', 'pembelian');
                });
        })
            ->with(['category', 'category.account', 'product'])
            ->orderBy('id', 'desc')
            ->get();

        $allTransactions = collect()
            ->merge($cashIns->map(fn ($t) => [
                'id' => $t->id,
                'date' => $t->date,
                'account' => $this->getAccountForTransaction($t, 'income'),
                'category' => $t->category,
                'product' => $t->product,
                'hutan' => $t->hutan ?? null,
                'quantity' => $t->quantity,
                'description' => $t->description,
                'amount' => $t->amount,
                'file_path' => $t->file_path,
                'type' => 'income',
                'created_at' => $t->created_at,
            ]))
            ->merge($cashOuts->map(fn ($t) => [
                'id' => $t->id,
                'date' => $t->date,
                'account' => $this->getAccountForTransaction($t, 'expense'),
                'category' => $t->category,
                'product' => $t->product,
                'hutan' => $t->hutan ?? null,
                'quantity' => $t->quantity,
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

        $akunMasuk = Category::where('is_active', true)
            ->where('transaction_type', 'penjualan')
            ->orderBy('name')->get();

        $akunKeluar = Category::where('is_active', true)
            ->where('transaction_type', 'pembelian')
            ->orderBy('name')->get();

        return view('transaksi-produk.index', compact('cashIns', 'cashOuts', 'allTransactions', 'akunMasuk', 'akunKeluar'));
    }

    private function getAccountForTransaction($transaction, $type)
    {
        if ($transaction->product) {
            if ($type === 'income' && $transaction->product->sales_account_id) {
                return \App\Models\ChartOfAccount::find($transaction->product->sales_account_id);
            } elseif ($type === 'expense' && $transaction->product->inventory_account_id) {
                return \App\Models\ChartOfAccount::find($transaction->product->inventory_account_id);
            }
        }

        return $transaction->category->account ?? null;
    }
}
