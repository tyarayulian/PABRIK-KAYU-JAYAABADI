<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KasKeluar extends Model
{
    protected $table = 'kas_keluar';

    protected $fillable = ['date', 'category_id', 'product_id', 'quantity', 'price', 'description', 'amount', 'is_processed', 'file_path', 'account_id', 'hutan', 'payment_account_id'];

    protected $casts = [
        'date' => 'datetime',
        'amount' => 'decimal:2',
        'is_processed' => 'boolean',
        'quantity' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    protected static function booted()
    {
        parent::booted();

        static::created(function ($kasKeluar) {
            $kasKeluar->syncJournalEntry();
            if ($kasKeluar->product_id) {
                $kasKeluar->product->syncStock();
            }
        });

        static::updated(function ($kasKeluar) {
            $kasKeluar->syncJournalEntry();
            if ($kasKeluar->product_id) {
                $kasKeluar->product->syncStock();
            }
            // If product_id was changed, sync the old product too
            if ($kasKeluar->isDirty('product_id') && $kasKeluar->getOriginal('product_id')) {
                \App\Models\Product::find($kasKeluar->getOriginal('product_id'))?->syncStock();
            }
        });

        static::deleted(function ($kasKeluar) {
            $kasKeluar->deleteJournalEntry();
            if ($kasKeluar->product_id) {
                $kasKeluar->product->syncStock();
            }
        });
    }

    public function journals()
    {
        return $this->hasMany(GeneralJournal::class, 'source_id')
            ->where('source', 'cash_out');
    }

    public function syncJournalEntry()
    {
        $this->deleteJournalEntry();

        // Gunakan payment_account_id jika dipilih, fallback ke Kas default
        $cashAccount = null;
        if ($this->payment_account_id) {
            $cashAccount = ChartOfAccount::find($this->payment_account_id);
        }
        if (!$cashAccount) {
            $cashAccount = ChartOfAccount::where('type', 'asset')
                ->where(function ($q) {
                    $q->where('name', 'like', '%Kas%')
                        ->orWhere('code', '1110');
                })->first();
        }
        if (!$cashAccount) {
            $cashAccount = ChartOfAccount::where('type', 'asset')->first();
        }

        if ($cashAccount) {
            // 1. Debit Expense / Inventory
            // If it's a product transaction (has product), use product's inventory account
            $debitAccountId = ($this->product_id && $this->product)
                ? $this->product->inventory_account_id
                : ($this->account_id ?: ($this->category->account_id ?? null));

            if (! $debitAccountId) {
                // Try to find a default expense account if nothing else is available
                $debitAccountId = ChartOfAccount::where('type', 'expense')->first()?->id;
            }

            if (! $debitAccountId) {
                throw new \Exception('Akun biaya/persediaan tidak ditemukan. Pastikan produk/kategori sudah terhubung dengan akun COA.');
            }

            GeneralJournal::create([
                'journal_date' => $this->date,
                'account_id' => $debitAccountId,
                'type' => 'debit',
                'amount' => $this->amount,
                'reference' => 'KK-'.$this->id,
                'source' => 'cash_out',
                'source_id' => $this->id,
            ]);

            // 2. Credit Kas/Bank
            GeneralJournal::create([
                'journal_date' => $this->date,
                'account_id' => $cashAccount->id,
                'type' => 'credit',
                'amount' => $this->amount,
                'reference' => 'KK-'.$this->id,
                'source' => 'cash_out',
                'source_id' => $this->id,
            ]);
        }
    }

    public function deleteJournalEntry()
    {
        GeneralJournal::where('source', 'cash_out')
            ->where('source_id', $this->id)
            ->delete();
    }
}
