<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesReturn extends Model
{
    protected $fillable = [
        'date', 
        'product_id', 
        'kas_masuk_id',
        'quantity', 
        'amount', 
        'description', 
        'account_id', 
        'return_account_id', 
        'file_path'
    ];

    protected $casts = [
        'date' => 'datetime',
        'amount' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function kasMasuk(): BelongsTo
    {
        return $this->belongsTo(KasMasuk::class, 'kas_masuk_id');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(ChartOfAccount::class, 'account_id');
    }

    public function returnAccount(): BelongsTo
    {
        return $this->belongsTo(ChartOfAccount::class, 'return_account_id');
    }

    protected static function booted()
    {
        parent::booted();

        static::created(function ($salesReturn) {
            $salesReturn->syncJournalEntry();
            if ($salesReturn->product_id) {
                $salesReturn->product->syncStock();
            }
        });

        static::updated(function ($salesReturn) {
            $salesReturn->syncJournalEntry();
            if ($salesReturn->product_id) {
                $salesReturn->product->syncStock();
            }
            if ($salesReturn->isDirty('product_id') && $salesReturn->getOriginal('product_id')) {
                Product::find($salesReturn->getOriginal('product_id'))?->syncStock();
            }
        });

        static::deleted(function ($salesReturn) {
            $salesReturn->deleteJournalEntry();
            if ($salesReturn->product_id) {
                $salesReturn->product->syncStock();
            }
        });
    }

    public function syncJournalEntry()
    {
        $this->deleteJournalEntry();

        // Load product if not already loaded
        if (!$this->relationLoaded('product')) {
            $this->load('product', 'kasMasuk');
        }

        if (!$this->product) return;

        // === JURNAL 1: Pembatalan Pendapatan ===
        $reference1 = 'RJ-'.$this->id;

        // Debit Retur Penjualan
        $returnAccount = ChartOfAccount::where('name', 'like', '%Retur Penjualan%')->first()
            ?? ChartOfAccount::where('code', '4102')->first()
            ?? ChartOfAccount::where('code', '4110')->first()
            ?? ChartOfAccount::where('name', 'like', '%Retur%')->where('type', 'revenue')->first();

        if (!$returnAccount) {
            $returnAccount = ChartOfAccount::firstOrCreate(
                ['code' => '4102'],
                ['name' => 'Retur Penjualan', 'type' => 'revenue', 'is_active' => true]
            );
        }

        GeneralJournal::create([
            'journal_date' => $this->date,
            'account_id'   => $returnAccount->id,
            'type'         => 'debit',
            'amount'       => $this->amount,
            'reference'    => $reference1,
            'source'       => 'sales_return',
            'source_id'    => $this->id,
        ]);

        // Kredit Kas/Bank
        $cashAccountId = null;
        if ($this->kasMasuk && $this->kasMasuk->payment_account_id) {
            $cashAccountId = $this->kasMasuk->payment_account_id;
        } else {
            $cashAccount = ChartOfAccount::where('type', 'asset')
                ->where(function ($q) {
                    $q->where('name', 'like', '%Kas%')
                      ->orWhere('code', '1101');
                })->first()
                ?? ChartOfAccount::where('type', 'asset')->first();
            $cashAccountId = $cashAccount?->id;
        }

        if ($cashAccountId) {
            GeneralJournal::create([
                'journal_date' => $this->date,
                'account_id'   => $cashAccountId,
                'type'         => 'credit',
                'amount'       => $this->amount,
                'reference'    => $reference1,
                'source'       => 'sales_return',
                'source_id'    => $this->id,
            ]);
        }

        // === JURNAL 2: Pengembalian Stok ===
        if ($this->product->hpp_account_id && $this->quantity > 0) {
            $reference2 = 'RJ-'.$this->id.'-S';
            $hppAmount = $this->product->cost * $this->quantity;

            $finishedGoodsAccountId = $this->product->finished_goods_account_id
                ?? $this->product->inventory_account_id;

            if ($finishedGoodsAccountId) {
                // Debit Persediaan Produk Jadi
                GeneralJournal::create([
                    'journal_date' => $this->date,
                    'account_id'   => $finishedGoodsAccountId,
                    'type'         => 'debit',
                    'amount'       => $hppAmount,
                    'reference'    => $reference2,
                    'source'       => 'sales_return',
                    'source_id'    => $this->id,
                ]);
            }

            // Kredit HPP
            GeneralJournal::create([
                'journal_date' => $this->date,
                'account_id'   => $this->product->hpp_account_id,
                'type'         => 'credit',
                'amount'       => $hppAmount,
                'reference'    => $reference2,
                'source'       => 'sales_return',
                'source_id'    => $this->id,
            ]);
        }
    }

    public function deleteJournalEntry()
    {
        GeneralJournal::where('source', 'sales_return')
            ->where('source_id', $this->id)
            ->delete();
    }
}
