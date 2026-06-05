<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\ChartOfAccount;
use App\Models\GeneralJournal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BukuBesarController extends Controller
{
    public function index(Request $request)
    {
        // Auto-sync before displaying
        GeneralJournal::syncAll();

        $filterType = $request->input('filter_type', 'per_bulan');
        $yearInput = $request->input('year');
        $monthInput = $request->input('month');
        $startDateInput = $request->input('start_date');
        $endDateInput = $request->input('end_date');
        $accountId = $request->input('account_id');

        $year = $yearInput ?: Carbon::now()->year;
        $month = $monthInput ?: Carbon::now()->month;
        $startDate = null;
        $endDate = null;

        if ($filterType === 'per_bulan') {
            if ($monthInput) {
                // Handle YYYY-MM format from input month
                $date = Carbon::parse($monthInput);
                $month = $date->month;
                $year = $date->year;
            }
            $startDate = Carbon::create($year, $month, 1)->startOfDay();
            $endDate = Carbon::create($year, $month, 1)->endOfMonth()->endOfDay();
        } elseif ($filterType === 'per_tahun') {
            $startDate = Carbon::create($year, 1, 1)->startOfDay();
            $endDate = Carbon::create($year, 12, 31)->endOfDay();
        } elseif ($filterType === 'custom' && $startDateInput && $endDateInput) {
            $startDate = Carbon::parse($startDateInput)->startOfDay();
            $endDate = Carbon::parse($endDateInput)->endOfDay();
        } elseif ($filterType === 'all') {
            $startDate = null;
            $endDate = Carbon::now()->endOfDay();
        }

        $orderRaw = "CASE 
            WHEN type = 'asset' THEN 1 
            WHEN type = 'liability' THEN 2 
            WHEN type = 'equity' THEN 3 
            WHEN type = 'revenue' THEN 4 
            WHEN type = 'cogs' THEN 5 
            WHEN type = 'expense' THEN 6 
            ELSE 7 END";

        $allAccounts = ChartOfAccount::where('is_active', true)
            ->orderByRaw($orderRaw)
            ->orderBy('code')
            ->get();

        $accounts = ChartOfAccount::where('is_active', true)
            ->when($accountId, function ($q) use ($accountId) {
                $q->where('id', $accountId);
            })
            ->with(['journals' => function ($query) use ($startDate, $endDate) {
                if ($startDate && $endDate) {
                    $query->whereBetween('journal_date', [$startDate, $endDate]);
                }

                $query->orderBy('journal_date', 'asc')->orderBy('id', 'asc');
            }])
            ->orderByRaw($orderRaw)
            ->orderBy('code')
            ->get();

        $ledgerData = [];
        foreach ($accounts as $account) {
            // Hitung Saldo Awal dari transaksi sebelum periode yang dipilih
            $beginningBalance = 0;
            if ($startDate) {
                $normalIsDebit = in_array($account->type, ['asset', 'expense', 'cogs']);

                $prevDebit = GeneralJournal::where('account_id', $account->id)
                    ->where('journal_date', '<', $startDate)
                    ->where('type', 'debit')
                    ->sum('amount');

                $prevCredit = GeneralJournal::where('account_id', $account->id)
                    ->where('journal_date', '<', $startDate)
                    ->where('type', 'credit')
                    ->sum('amount');

                if ($normalIsDebit) {
                    $beginningBalance = $prevDebit - $prevCredit;
                } else {
                    $beginningBalance = $prevCredit - $prevDebit;
                }
            }

            // Skip if no transactions in period AND no beginning balance AND we are not filtering by specific account
            if (! $accountId && $account->journals->count() === 0 && $beginningBalance == 0) {
                continue;
            }

            $debitTotal = 0;
            $creditTotal = 0;
            $currentBalance = $beginningBalance;
            $transactions = [];

            $normalIsDebit = in_array($account->type, ['asset', 'expense', 'cogs']);

            foreach ($account->journals as $journal) {
                if ($journal->type === 'debit') {
                    $debitTotal += $journal->amount;
                    $currentBalance += ($normalIsDebit ? $journal->amount : -$journal->amount);
                } else {
                    $creditTotal += $journal->amount;
                    $currentBalance += ($normalIsDebit ? -$journal->amount : $journal->amount);
                }

                $transactions[] = [
                    'journal' => $journal,
                    'balance' => $currentBalance,
                ];
            }

            $ledgerData[] = [
                'account' => $account,
                'beginning_balance' => $beginningBalance,
                'debit_total' => $debitTotal,
                'credit_total' => $creditTotal,
                'transactions' => $transactions,
                'final_balance' => $currentBalance,
            ];
        }

        // ledgerData is already ordered by accounts query order
        
        $years = range(Carbon::now()->year - 5, Carbon::now()->year + 1);
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        return view('report.ledger', compact('ledgerData', 'allAccounts', 'accountId', 'year', 'month', 'years', 'months', 'filterType', 'startDate', 'endDate'));
    }

    public function exportExcel(Request $request)
    {
        // Auto-sync before exporting
        GeneralJournal::syncAll();
        $filterType = $request->input('filter_type', 'per_bulan');
        $yearInput = $request->input('year');
        $monthInput = $request->input('month');
        $startDateInput = $request->input('start_date');
        $endDateInput = $request->input('end_date');
        $accountId = $request->input('account_id');

        $year = $yearInput ?: Carbon::now()->year;
        $month = Carbon::now()->month;
        $startDate = null;
        $endDate = null;

        if ($filterType === 'per_bulan') {
            if ($monthInput) {
                $date = Carbon::parse($monthInput);
                $month = $date->month;
                $year = $date->year;
            } else {
                $month = Carbon::now()->month;
                $year = Carbon::now()->year;
            }
            $startDate = Carbon::create($year, $month, 1)->startOfDay();
            $endDate = Carbon::create($year, $month, 1)->endOfMonth()->endOfDay();
        } elseif ($filterType === 'per_tahun') {
            $startDate = Carbon::create($year, 1, 1)->startOfDay();
            $endDate = Carbon::create($year, 12, 31)->endOfDay();
        } elseif ($filterType === 'custom' && $startDateInput && $endDateInput) {
            $startDate = Carbon::parse($startDateInput)->startOfDay();
            $endDate = Carbon::parse($endDateInput)->endOfDay();
        } elseif ($filterType === 'all') {
            $startDate = null;
            $endDate = Carbon::now()->endOfDay();
        }

        $orderRaw = "CASE 
            WHEN type = 'asset' THEN 1 
            WHEN type = 'liability' THEN 2 
            WHEN type = 'equity' THEN 3 
            WHEN type = 'revenue' THEN 4 
            WHEN type = 'cogs' THEN 5 
            WHEN type = 'expense' THEN 6 
            ELSE 7 END";

        $accounts = ChartOfAccount::where('is_active', true)
            ->when($accountId, function ($q) use ($accountId) {
                $q->where('id', $accountId);
            })
            ->with(['journals' => function ($query) use ($startDate, $endDate) {
                if ($startDate && $endDate) {
                    $query->whereBetween('journal_date', [$startDate, $endDate]);
                }

                $query->orderBy('journal_date', 'asc')->orderBy('id', 'asc');
            }])
            ->orderByRaw($orderRaw)
            ->orderBy('code')
            ->get();

        $accountsList = $accounts;

        $fileName = 'Buku_Besar_'.date('Ymd_His').'.csv';

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($accountsList, $filterType, $month, $year, $startDate, $endDate) {
            $file = fopen('php://output', 'w');
            fwrite($file, (chr(0xEF).chr(0xBB).chr(0xBF)));

            fputcsv($file, ['PABRIK KAYU JAYA ABADI']);
            fputcsv($file, ['Buku Besar']);

            $months = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
            ];

            $periode = 'Semua Data';
            if ($filterType === 'per_bulan') {
                $periode = 'Periode: '.($months[$month] ?? '').' '.$year;
            } elseif ($filterType === 'per_tahun') {
                $periode = 'Tahun: '.$year;
            } elseif ($filterType === 'custom' && $startDate && $endDate) {
                $periode = 'Periode: '.$startDate->format('d/m/Y').' s/d '.$endDate->format('d/m/Y');
            }
            fputcsv($file, [$periode]);
            fputcsv($file, []);

            foreach ($accountsList as $account) {
                // Hitung Saldo Awal dari transaksi sebelum periode yang dipilih
                $beginningBalance = 0;
                if ($startDate) {
                    $normalIsDebit = in_array($account->type, ['asset', 'expense', 'cogs']);

                    $prevDebit = GeneralJournal::where('account_id', $account->id)
                        ->where('journal_date', '<', $startDate)
                        ->where('type', 'debit')
                        ->sum('amount');

                    $prevCredit = GeneralJournal::where('account_id', $account->id)
                        ->where('journal_date', '<', $startDate)
                        ->where('type', 'credit')
                        ->sum('amount');

                    if ($normalIsDebit) {
                        $beginningBalance = $prevDebit - $prevCredit;
                    } else {
                        $beginningBalance = $prevCredit - $prevDebit;
                    }
                }

                if ($account->journals->count() > 0 || $beginningBalance != 0) {
                    fputcsv($file, ['AKUN: '.$account->code.' - '.$account->name]);
                    fputcsv($file, ['Kategori: '.strtoupper($account->type)]);

                    if ($beginningBalance != 0) {
                        fputcsv($file, ['', 'SALDO AWAL PERIODE', '', '', '', '', $beginningBalance]);
                    }

                    fputcsv($file, ['Tanggal', 'Keterangan', 'Ref', 'Debit (Rp)', 'Kredit (Rp)', '', 'Saldo (Rp)']);

                    $balance = $beginningBalance;
                    $normalIsDebit = in_array($account->type, ['asset', 'expense', 'cogs']);

                    foreach ($account->journals as $j) {
                        $debit = ($j->type === 'debit' ? $j->amount : 0);
                        $credit = ($j->type === 'credit' ? $j->amount : 0);

                        if ($j->type === 'debit') {
                            $balance += ($normalIsDebit ? $j->amount : -$j->amount);
                        } else {
                            $balance += ($normalIsDebit ? -$j->amount : $j->amount);
                        }

                        $description = $j->description ?: $account->name;
                        fputcsv($file, [$j->journal_date->format('d/m/Y'), $description, $j->reference ?? '-', $debit, $credit, '', $balance]);
                    }

                    // Saldo Akhir
                    fputcsv($file, ['', 'TOTAL', '', $account->journals->where('type', 'debit')->sum('amount'), $account->journals->where('type', 'credit')->sum('amount'), '', $balance]);
                    fputcsv($file, []); // Spacer
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function print(Request $request)
    {
        // Auto-sync before displaying
        GeneralJournal::syncAll();

        $filterType = $request->input('filter_type', 'per_bulan');
        $yearInput = $request->input('year');
        $monthInput = $request->input('month');
        $startDateInput = $request->input('start_date');
        $endDateInput = $request->input('end_date');
        $accountId = $request->input('account_id');

        $year = $yearInput ?: Carbon::now()->year;
        $month = $monthInput ?: Carbon::now()->month;
        $startDate = null;
        $endDate = null;

        if ($filterType === 'per_bulan') {
            if ($monthInput) {
                $date = Carbon::parse($monthInput);
                $month = $date->month;
                $year = $date->year;
            }
            $startDate = Carbon::create($year, $month, 1)->startOfDay();
            $endDate = Carbon::create($year, $month, 1)->endOfMonth()->endOfDay();
        } elseif ($filterType === 'per_tahun') {
            $startDate = Carbon::create($year, 1, 1)->startOfDay();
            $endDate = Carbon::create($year, 12, 31)->endOfDay();
        } elseif ($filterType === 'custom' && $startDateInput && $endDateInput) {
            $startDate = Carbon::parse($startDateInput)->startOfDay();
            $endDate = Carbon::parse($endDateInput)->endOfDay();
        } elseif ($filterType === 'all') {
            $startDate = null;
            $endDate = Carbon::now()->endOfDay();
        }

        $accountsQuery = ChartOfAccount::where('is_active', true);
        if ($accountId) {
            $accountsQuery->where('id', $accountId);
        }
        $accounts = $accountsQuery->orderBy('code')->get();

        $ledgerData = [];
        foreach ($accounts as $account) {
            $journalQuery = GeneralJournal::where('account_id', $account->id);

            if ($startDate) {
                $journalQuery->where('journal_date', '>=', $startDate);
            }
            if ($endDate) {
                $journalQuery->where('journal_date', '<=', $endDate);
            }

            $journals = $journalQuery->orderBy('journal_date')->get();

            if ($journals->isEmpty()) {
                continue;
            }

            $beginningBalance = 0;
            if ($startDate) {
                $normalIsDebit = in_array($account->type, ['asset', 'expense', 'cogs']);

                $prevDebit = GeneralJournal::where('account_id', $account->id)
                    ->where('journal_date', '<', $startDate)
                    ->where('type', 'debit')
                    ->sum('amount');

                $prevCredit = GeneralJournal::where('account_id', $account->id)
                    ->where('journal_date', '<', $startDate)
                    ->where('type', 'credit')
                    ->sum('amount');

                if ($normalIsDebit) {
                    $beginningBalance = $prevDebit - $prevCredit;
                } else {
                    $beginningBalance = $prevCredit - $prevDebit;
                }
            }

            $balance = $beginningBalance;
            $transactions = [];
            $debitTotal = 0;
            $creditTotal = 0;
            $normalIsDebit = in_array($account->type, ['asset', 'expense', 'cogs']);

            foreach ($journals as $journal) {
                if ($journal->type === 'debit') {
                    $debitTotal += $journal->amount;
                    $balance += ($normalIsDebit ? $journal->amount : -$journal->amount);
                } else {
                    $creditTotal += $journal->amount;
                    $balance += ($normalIsDebit ? -$journal->amount : $journal->amount);
                }

                $transactions[] = [
                    'journal' => $journal,
                    'balance' => $balance,
                ];
            }

            $ledgerData[] = [
                'account' => $account,
                'beginning_balance' => $beginningBalance,
                'transactions' => $transactions,
                'debit_total' => $debitTotal,
                'credit_total' => $creditTotal,
                'final_balance' => $balance,
            ];
        }

        $allAccounts = ChartOfAccount::where('is_active', true)->orderBy('code')->get();

        return view('report.ledger-print', compact('ledgerData', 'allAccounts', 'filterType', 'year', 'month', 'startDate', 'endDate', 'accountId'));
    }
}
