<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductStock extends Model
{
    protected $fillable = ['product_id', 'date', 'quantity', 'price', 'description'];

    protected $casts = [
        'date' => 'date',
        'quantity' => 'decimal:2',
        'price' => 'decimal:2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected static function booted()
    {
        parent::booted();

        static::created(function ($productStock) {
            $productStock->syncJournalEntry();
            if ($productStock->product_id) {
                $productStock->product->syncStock();
            }
        });

        static::updated(function ($productStock) {
            $productStock->syncJournalEntry();
            if ($productStock->product_id) {
                $productStock->product->syncStock();
            }
            // If product_id was changed, sync the old product too
            if ($productStock->isDirty('product_id') && $productStock->getOriginal('product_id')) {
                \App\Models\Product::find($productStock->getOriginal('product_id'))?->syncStock();
            }
        });

        static::deleted(function ($productStock) {
            $productStock->deleteJournalEntry();
            if ($productStock->product_id) {
                $productStock->product->syncStock();
            }
        });
    }

    public function syncJournalEntry()
    {
        $this->deleteJournalEntry();

        if ($this->product && $this->quantity != 0) {
            // Pakai akun Persediaan Produk Jadi jika ada, fallback ke inventory_account_id
            $inventoryAccountId = $this->product->finished_goods_account_id 
                ?? $this->product->inventory_account_id;
            
            $equityAccount = ChartOfAccount::where('code', '3100')->first() 
                ?? ChartOfAccount::where('type', 'equity')->first();

            if ($inventoryAccountId && $equityAccount) {
                $isIncrease = $this->quantity > 0;
                $absQuantity = abs($this->quantity);
                $amount = $absQuantity * ($this->price ?: $this->product->cost);

                if ($isIncrease) {
                    // Masuk stok produk jadi: Debit Persediaan Produk Jadi, Credit Modal
                    GeneralJournal::create([
                        'journal_date' => $this->date,
                        'account_id' => $inventoryAccountId,
                        'type' => 'debit',
                        'amount' => $amount,
                        'reference' => 'PS-'.$this->id,
                        'source' => 'product_stock',
                        'source_id' => $this->id,
                    ]);
                    GeneralJournal::create([
                        'journal_date' => $this->date,
                        'account_id' => $equityAccount->id,
                        'type' => 'credit',
                        'amount' => $amount,
                        'reference' => 'PS-'.$this->id,
                        'source' => 'product_stock',
                        'source_id' => $this->id,
                    ]);
                } else {
                    // Keluar stok: Debit Modal, Credit Persediaan Produk Jadi
                    GeneralJournal::create([
                        'journal_date' => $this->date,
                        'account_id' => $equityAccount->id,
                        'type' => 'debit',
                        'amount' => $amount,
                        'reference' => 'PS-'.$this->id,
                        'source' => 'product_stock',
                        'source_id' => $this->id,
                    ]);
                    GeneralJournal::create([
                        'journal_date' => $this->date,
                        'account_id' => $inventoryAccountId,
                        'type' => 'credit',
                        'amount' => $amount,
                        'reference' => 'PS-'.$this->id,
                        'source' => 'product_stock',
                        'source_id' => $this->id,
                    ]);
                }
            }
        }
    }

    public function deleteJournalEntry()
    {
        GeneralJournal::where('source', 'product_stock')
            ->where('source_id', $this->id)
            ->delete();
    }
}
