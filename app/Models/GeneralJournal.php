<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class GeneralJournal extends Model
{
    protected $fillable = [
        'journal_date',
        'account_id',
        'type',
        'amount',
        'reference',
        'source',
        'source_id',
    ];

    protected $casts = [
        'journal_date' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function account()
    {
        return $this->belongsTo(ChartOfAccount::class, 'account_id');
    }

    /**
     * Synchronize all journal entries and general ledgers
     */
    public static function syncAll()
    {
        try {
            \DB::beginTransaction();

            // 1. Delete all auto-generated journal entries (keep opening_balance)
            self::whereIn('source', ['cash_in', 'cash_out', 'product_stock', 'initial_stock', 'sales_return'])->delete();

            // 2. Re-sync opening balances for all accounts
            self::where('source', 'opening_balance')->delete();
            $openingAccounts = \App\Models\ChartOfAccount::where('opening_balance', '>', 0)->get();
            $modalAccount = \App\Models\ChartOfAccount::where('code', '3100')->first()
                ?? \App\Models\ChartOfAccount::where('type', 'equity')->first();

            foreach ($openingAccounts as $account) {
                $date = $account->opening_balance_date ?? \Carbon\Carbon::parse('2000-01-01');
                $isDebitNormal = in_array($account->type, ['asset', 'expense', 'cogs']);

                // Buat entri untuk akun itu sendiri
                self::create([
                    'journal_date' => $date,
                    'account_id'   => $account->id,
                    'type'         => $isDebitNormal ? 'debit' : 'credit',
                    'amount'       => $account->opening_balance,
                    'reference'    => 'OB-' . $account->id,
                    'source'       => 'opening_balance',
                    'source_id'    => $account->id,
                ]);

                // Untuk akun Asset: otomatis buat pasangan ke Modal Pemilik
                if ($isDebitNormal && $modalAccount && $modalAccount->id !== $account->id) {
                    self::create([
                        'journal_date' => $date,
                        'account_id'   => $modalAccount->id,
                        'type'         => 'credit',
                        'amount'       => $account->opening_balance,
                        'reference'    => 'OB-' . $account->id,
                        'source'       => 'opening_balance',
                        'source_id'    => $account->id,
                    ]);
                }
                // Untuk akun Equity/Liability yang diisi manual: tidak perlu pasangan
            }

            // 2. Collect all source transactions to sort them chronologically
            $transactions = collect();

            // Initial Stocks
            $products = \App\Models\Product::where('initial_stock', '>', 0)->get();
            foreach ($products as $p) {
                $transactions->push([
                    'type' => 'initial_stock',
                    'date' => Carbon::parse('2000-01-01'), // Oldest date for initial stock
                    'model' => $p
                ]);
            }

            // Kas Masuk
            $kasMasuk = \App\Models\KasMasuk::all();
            foreach ($kasMasuk as $km) {
                $transactions->push([
                    'type' => 'cash_in',
                    'date' => $km->date,
                    'model' => $km
                ]);
            }

            // Kas Keluar
            $kasKeluar = \App\Models\KasKeluar::all();
            foreach ($kasKeluar as $kk) {
                $transactions->push([
                    'type' => 'cash_out',
                    'date' => $kk->date,
                    'model' => $kk
                ]);
            }

            // Sales Returns
            $salesReturns = \App\Models\SalesReturn::all();
            foreach ($salesReturns as $sr) {
                $transactions->push([
                    'type' => 'sales_return',
                    'date' => $sr->date,
                    'model' => $sr
                ]);
            }

            // Product Stock Adjustments
            $productStocks = \App\Models\ProductStock::all();
            foreach ($productStocks as $ps) {
                $transactions->push([
                    'type' => 'product_stock',
                    'date' => $ps->date,
                    'model' => $ps
                ]);
            }

            // 3. Sort ALL transactions by date
            $sortedTransactions = $transactions->sortBy('date');

            // 4. Process each transaction in order
            foreach ($sortedTransactions as $t) {
                if ($t['type'] === 'initial_stock') {
                    $t['model']->syncInitialStockJournalEntry();
                } else {
                    $t['model']->syncJournalEntry();
                }
            }

            // 5. Update General Ledgers table
            $accounts = \App\Models\ChartOfAccount::all();
            foreach ($accounts as $account) {
                $debit = self::where('account_id', $account->id)->where('type', 'debit')->sum('amount');
                $credit = self::where('account_id', $account->id)->where('type', 'credit')->sum('amount');

                $balance = 0;
                if (in_array($account->type, ['asset', 'expense', 'cogs'])) {
                    $balance = $debit - $credit;
                } else {
                    $balance = $credit - $debit;
                }

                \App\Models\GeneralLedger::updateOrCreate(
                    ['account_id' => $account->id],
                    [
                        'debit_total' => $debit,
                        'credit_total' => $credit,
                        'balance' => $balance,
                    ]
                );
            }

            \DB::commit();

            return true;
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Synchronization failed: '.$e->getMessage());

            return false;
        }
    }
}
