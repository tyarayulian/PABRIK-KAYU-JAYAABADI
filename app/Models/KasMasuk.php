<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KasMasuk extends Model
{
    protected $table = 'kas_masuk';

    protected $fillable = ['date', 'category_id', 'product_id', 'quantity', 'price', 'description', 'amount', 'file_path', 'account_id', 'payment_account_id'];

    protected $casts = [
        'date' => 'datetime',
        'amount' => 'decimal:2',
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

        static::created(function ($kasMasuk) {
            $kasMasuk->syncJournalEntry();
            if ($kasMasuk->product_id) {
                $kasMasuk->product->syncStock();
            }
        });

        static::updated(function ($kasMasuk) {
            $kasMasuk->syncJournalEntry();
            if ($kasMasuk->product_id) {
                $kasMasuk->product->syncStock();
            }
            // If product_id was changed, sync the old product too
            if ($kasMasuk->isDirty('product_id') && $kasMasuk->getOriginal('product_id')) {
                \App\Models\Product::find($kasMasuk->getOriginal('product_id'))?->syncStock();
            }
        });

        static::deleted(function ($kasMasuk) {
            $kasMasuk->deleteJournalEntry();
            if ($kasMasuk->product_id) {
                $kasMasuk->product->syncStock();
            }
        });
    }

    public function journals()
    {
        return $this->hasMany(GeneralJournal::class, 'source_id')
            ->where('source', 'cash_in');
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
            // 1. Debit Kas/Bank
            GeneralJournal::create([
                'journal_date' => $this->date,
                'account_id' => $cashAccount->id,
                'type' => 'debit',
                'amount' => $this->amount,
                'reference' => 'KM-'.$this->id,
                'source' => 'cash_in',
                'source_id' => $this->id,
            ]);

            // 2. Credit Revenue/Sales
            // If it's a product transaction (has product), use product's sales account
            $salesAccountId = ($this->product_id && $this->product)
                ? $this->product->sales_account_id
                : ($this->account_id ?: ($this->category->account_id ?? null));

            if (! $salesAccountId) {
                // Try to find a default revenue account if nothing else is available
                $salesAccountId = ChartOfAccount::where('type', 'revenue')->first()?->id;
            }

            if (! $salesAccountId) {
                throw new \Exception('Akun pendapatan tidak ditemukan. Pastikan produk/kategori sudah terhubung dengan akun COA.');
            }

            GeneralJournal::create([
                'journal_date' => $this->date,
                'account_id' => $salesAccountId,
                'type' => 'credit',
                'amount' => $this->amount,
                'reference' => 'KM-'.$this->id,
                'source' => 'cash_in',
                'source_id' => $this->id,
            ]);

            // 3. HPP Logic (Only if it's a product transaction)
            if ($this->product_id && $this->product && $this->quantity > 0) {
                if ($this->product->hpp_account_id) {
                    $hppAmount = $this->product->cost * $this->quantity;

                    // Debit HPP (COGS)
                    GeneralJournal::create([
                        'journal_date' => $this->date,
                        'account_id' => $this->product->hpp_account_id,
                        'type' => 'debit',
                        'amount' => $hppAmount,
                        'reference' => 'HPP-'.$this->id,
                        'source' => 'cash_in',
                        'source_id' => $this->id,
                    ]);

                    // Credit Modal/Ekuitas (bukan persediaan bahan baku)
                    $equityAccount = ChartOfAccount::where('code', '3100')->first()
                        ?? ChartOfAccount::where('type', 'equity')->first();

                    if ($equityAccount) {
                        GeneralJournal::create([
                            'journal_date' => $this->date,
                            'account_id' => $equityAccount->id,
                            'type' => 'credit',
                            'amount' => $hppAmount,
                            'reference' => 'HPP-'.$this->id,
                            'source' => 'cash_in',
                            'source_id' => $this->id,
                        ]);
                    }
                }
            }
        }
    }

    public function deleteJournalEntry()
    {
        GeneralJournal::where('source', 'cash_in')
            ->where('source_id', $this->id)
            ->delete();
    }
}
