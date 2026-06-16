<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'wood_type', 'product_category', 'size', 'cubic_content',
        'unit', 'price', 'cost', 'stock', 'initial_stock', 
        'category_id', 'sales_account_id', 'hpp_account_id', 'inventory_account_id', 'finished_goods_account_id', 'is_active'
    ];

    protected static function booted()
    {
        parent::booted();

        static::created(function ($product) {
            $product->syncInitialStockJournalEntry();
        });

        static::updated(function ($product) {
            $product->syncInitialStockJournalEntry();

            // Jika cost berubah, resync semua jurnal transaksi yang terkait
            $costChanged = $product->getOriginal('cost') != $product->cost;
            if ($costChanged) {
                $product->salesTransactions()->each(function($kasMasuk) {
                    $kasMasuk->syncJournalEntry();
                });
                $product->salesReturns()->each(function($retur) {
                    $retur->syncJournalEntry();
                });
                $product->stockHistory()->each(function($ps) {
                    $ps->syncJournalEntry();
                });
            }
        });

        static::deleted(function ($product) {
            $product->deleteInitialStockJournalEntry();
            // Delete related history and transactions
            $product->stockHistory()->each(fn($sh) => $sh->delete());
            $product->salesTransactions()->each(fn($s) => $s->delete());
            $product->purchaseTransactions()->each(fn($p) => $p->delete());
        });
    }

    public function syncInitialStockJournalEntry()
    {
        $this->deleteInitialStockJournalEntry();

        if ($this->initial_stock > 0) {
            $inventoryAccountId = $this->inventory_account_id;
            $equityAccount = ChartOfAccount::where('code', '3100')->first() ?? ChartOfAccount::where('type', 'equity')->first();

            if ($inventoryAccountId && $equityAccount) {
                $amount = $this->initial_stock * $this->cost;

                // Debit Inventory
                GeneralJournal::create([
                    'journal_date' => $this->created_at ?: now(),
                    'account_id' => $inventoryAccountId,
                    'type' => 'debit',
                    'amount' => $amount,
                    'reference' => 'INIT-'.$this->id,
                    'source' => 'initial_stock',
                    'source_id' => $this->id,
                ]);

                // Credit Equity (Modal Pemilik)
                GeneralJournal::create([
                    'journal_date' => $this->created_at ?: now(),
                    'account_id' => $equityAccount->id,
                    'type' => 'credit',
                    'amount' => $amount,
                    'reference' => 'INIT-'.$this->id,
                    'source' => 'initial_stock',
                    'source_id' => $this->id,
                ]);
            }
        }
    }

    public function deleteInitialStockJournalEntry()
    {
        GeneralJournal::where('source', 'initial_stock')
            ->where('source_id', $this->id)
            ->delete();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function salesAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'sales_account_id');
    }

    public function hppAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'hpp_account_id');
    }

    public function inventoryAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'inventory_account_id');
    }

    public function finishedGoodsAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'finished_goods_account_id');
    }

    public function stockHistory()
    {
        return $this->hasMany(ProductStock::class, 'product_id')->orderBy('date', 'desc');
    }

    public function salesTransactions()
    {
        return $this->hasMany(KasMasuk::class, 'product_id')->orderBy('date', 'desc');
    }

    public function purchaseTransactions()
    {
        return $this->hasMany(KasKeluar::class, 'product_id')->orderBy('date', 'desc');
    }

    public function getCurrentStockAttribute()
    {
        return (float) $this->stock;
    }

    public function salesReturns()
    {
        return $this->hasMany(SalesReturn::class, 'product_id')->orderBy('date', 'desc');
    }

    public function syncStock()
    {
        $initial = (float) $this->initial_stock;
        $added_adjustment = $this->stockHistory()->sum('quantity');
        $sold = $this->salesTransactions()->sum('quantity');
        $returned = $this->salesReturns()->sum('quantity'); // stok kembali dari retur

        $currentStock = $initial + $added_adjustment - $sold + $returned;
        
        $this->stock = $currentStock;
        $this->saveQuietly();
        
        return $currentStock;
    }

    public function getAllStockHistoryAttribute()
    {
        $historyList = collect();

        // Add Initial Stock if exists
        if ($this->initial_stock > 0) {
            $historyList->push((object) [
                'id' => $this->id,
                'date' => $this->created_at->startOfDay(), // Force to start of day to ensure it's first
                'quantity' => (float) $this->initial_stock,
                'price' => (float) $this->cost,
                'description' => 'Stok Awal (Saat Registrasi Produk)',
                'type' => 'initial',
            ]);
        }

        $adjustments = $this->stockHistory->map(function ($item) {
            return (object) [
                'id' => $item->id,
                'date' => \Carbon\Carbon::parse($item->date),
                'quantity' => (float) $item->quantity,
                'price' => (float) $item->price,
                'description' => $item->description ?? 'Stok Masuk',
                'type' => 'adjustment',
            ];
        });

        $purchases = $this->purchaseTransactions->map(function ($item) {
            return (object) [
                'id' => $item->id,
                'date' => \Carbon\Carbon::parse($item->date),
                'quantity' => (float) $item->quantity,
                'price' => (float) $item->price,
                'description' => $item->description ?? 'Pembelian Stok',
                'type' => 'purchase',
            ];
        });

        $sales = $this->salesTransactions->map(function ($item) {
            return (object) [
                'id' => $item->id,
                'date' => \Carbon\Carbon::parse($item->date),
                'quantity' => -(float) $item->quantity,
                'price' => (float) $item->price,
                'description' => $item->description ?? 'Penjualan Stok',
                'type' => 'sale',
            ];
        });

        $returns = $this->salesReturns->map(function ($item) {
            return (object) [
                'id' => $item->id,
                'date' => \Carbon\Carbon::parse($item->date),
                'quantity' => (float) $item->quantity,
                'price' => (float) ($item->amount / max($item->quantity, 1)),
                'description' => 'Retur Penjualan' . ($item->description ? ': ' . $item->description : ''),
                'type' => 'return',
            ];
        });

        // Sort by date ascending, but ensure 'initial' comes first if dates are tied
        return $historyList->concat($adjustments)->concat($sales)->concat($returns)
            ->sort(function($a, $b) {
                if ($a->date->equalTo($b->date)) {
                    if ($a->type === 'initial') return -1;
                    if ($b->type === 'initial') return 1;
                    return 0;
                }
                return $a->date->lt($b->date) ? -1 : 1;
            })->values();
    }

    public function getStockAllocationAttribute()
    {
        $history = $this->all_stock_history;
        $inflows = $history->whereIn('type', ['initial', 'adjustment', 'purchase'])->values();

        // Ambil semua penjualan urut tanggal
        $outflows = $this->salesTransactions()->orderBy('date', 'asc')->get();

        // Ambil semua retur penjualan urut tanggal
        $returns = $this->salesReturns()->orderBy('date', 'asc')->get();

        $allocation = [];
        $outflowQueue = [];
        foreach ($outflows as $o) {
            $outflowQueue[] = [
                'id'          => $o->id,
                'date'        => $o->date,
                'quantity'    => (float) $o->quantity,
                'description' => $o->description ?? 'Penjualan',
                'type'        => 'sale',
            ];
        }

        // Tambahkan retur sebagai "pengembalian" ke queue (qty negatif = stok kembali)
        $returnQueue = [];
        foreach ($returns as $r) {
            $returnQueue[] = [
                'id'          => $r->id,
                'date'        => $r->date,
                'quantity'    => (float) $r->quantity,
                'description' => 'Retur Penjualan' . ($r->description ? ': ' . $r->description : ''),
                'type'        => 'return',
            ];
        }

        foreach ($inflows as $inflow) {
            $key = $inflow->type.'_'.$inflow->id;
            $remaining = (float) $inflow->quantity;
            $soldTo = [];

            // Kurangi stok batch dengan penjualan
            if ($remaining > 0) {
                for ($i = 0; $i < count($outflowQueue); $i++) {
                    if ($remaining <= 0) break;
                    if ($outflowQueue[$i]['quantity'] <= 0) continue;

                    $deduct = min($remaining, $outflowQueue[$i]['quantity']);
                    $outflowQueue[$i]['quantity'] -= $deduct;
                    $remaining -= $deduct;

                    $soldTo[] = [
                        'date'        => $outflowQueue[$i]['date'],
                        'quantity'    => $deduct,
                        'description' => $outflowQueue[$i]['description'],
                        'type'        => 'sale',
                    ];
                }
            }

            // Tambahkan retur ke soldItems (tampil di history batch ini)
            foreach ($returnQueue as $ret) {
                $soldTo[] = [
                    'date'        => $ret['date'],
                    'quantity'    => $ret['quantity'],
                    'description' => $ret['description'],
                    'type'        => 'return',
                ];
                $remaining += $ret['quantity']; // stok kembali
            }

            // Sort soldTo by date
            usort($soldTo, fn($a, $b) => $a['date'] <=> $b['date']);

            $allocation[$key] = [
                'sold_items' => $soldTo,
                'remaining'  => $remaining,
            ];
        }

        return $allocation;
    }
}
