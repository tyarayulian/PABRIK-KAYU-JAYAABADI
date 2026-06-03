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

        if (!$this->product) return;

        // Use the same reference for all journal entries of this return
        $reference = 'RJ-'.$this->id;

        // 1. Debit Retur Penjualan
        $returnAccount = ChartOfAccount::where('name', 'like', '%Retur Penjualan%')->first()
            ?? ChartOfAccount::where('code', '4110')->first()
            ?? ChartOfAccount::where('name', 'like', '%Retur%')->where('type', 'revenue')->first();

        // If still not found, try to find or create a default one
        if (!$returnAccount) {
            $returnAccount = ChartOfAccount::firstOrCreate(
                ['code' => '4110'],
                ['name' => 'Retur Penjualan', 'type' => 'revenue', 'is_active' => true]
            );
        }

        $returnAccountId = $returnAccount->id;

        if ($returnAccountId) {
            GeneralJournal::create([
                'journal_date' => $this->date,
                'account_id' => $returnAccountId,
                'type' => 'debit',
                'amount' => $this->amount, // Sales Price Total
                'reference' => $reference,
                'source' => 'sales_return',
                'source_id' => $this->id,
            ]);
        }

        // 2. Credit Kas (Asset type, preferentially contains 'Kas' or code 1110)
        $cashAccount = ChartOfAccount::where('type', 'asset')
            ->where(function ($q) {
                $q->where('name', 'like', '%Kas%')
                    ->orWhere('code', '1110');
            })
            ->first();
            
        if (!$cashAccount) {
            $cashAccount = ChartOfAccount::where('type', 'asset')->first();
        }

        if ($cashAccount) {
            GeneralJournal::create([
                'journal_date' => $this->date,
                'account_id' => $cashAccount->id,
                'type' => 'credit',
                'amount' => $this->amount, // Sales Price Total
                'reference' => $reference,
                'source' => 'sales_return',
                'source_id' => $this->id,
            ]);
        }

        // 3. Jurnal Stok: Debit Persediaan, Credit HPP
        if ($this->product->inventory_account_id && $this->product->hpp_account_id && $this->quantity > 0) {
            // Use Cost (Modal) for Stock Journal
            $hppAmount = $this->product->cost * $this->quantity;

            // Debit Persediaan (Asset)
            GeneralJournal::create([
                'journal_date' => $this->date,
                'account_id' => $this->product->inventory_account_id,
                'type' => 'debit',
                'amount' => $hppAmount,
                'reference' => $reference,
                'source' => 'sales_return',
                'source_id' => $this->id,
            ]);

            // Credit HPP (Expense/COGS)
            GeneralJournal::create([
                'journal_date' => $this->date,
                'account_id' => $this->product->hpp_account_id,
                'type' => 'credit',
                'amount' => $hppAmount,
                'reference' => $reference,
                'source' => 'sales_return',
                'source_id' => $this->id,
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
