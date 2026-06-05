<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\ChartOfAccount;
use App\Models\GeneralJournal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NeracaSaldoController extends Controller
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

        $year = $yearInput ?: date('Y');
        $month = null;
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
            $year = $yearInput ?: date('Y');
            $startDate = Carbon::create($year, 1, 1)->startOfDay();
            $endDate = Carbon::create($year, 12, 31)->endOfDay();
        } elseif ($filterType === 'custom') {
            if ($startDateInput) {
                $startDate = Carbon::parse($startDateInput)->startOfDay();
            }
            if ($endDateInput) {
                $endDate = Carbon::parse($endDateInput)->endOfDay();
            }
        } elseif ($filterType === 'all') {
            $startDate = null;
            $endDate = null;
        } else {
            // Default to all data (empty dates)
            $startDate = null;
            $endDate = null;
        }

        $accounts = ChartOfAccount::where('is_active', true)
            ->withCount(['journals as activity_count' => function ($query) use ($startDate, $endDate) {
                if ($startDate && $endDate) {
                    $query->whereBetween('journal_date', [$startDate, $endDate]);
                } elseif ($startDate) {
                    $query->where('journal_date', '>=', $startDate);
                } elseif ($endDate) {
                    $query->where('journal_date', '<=', $endDate);
                }
            }])
            ->orderByRaw("CASE 
                WHEN type = 'asset' THEN 1 
                WHEN type = 'liability' THEN 2 
                WHEN type = 'equity' THEN 3 
                WHEN type = 'revenue' THEN 4 
                WHEN type = 'cogs' THEN 5 
                WHEN type = 'expense' THEN 6 
                ELSE 7 END")
            ->orderBy('code')
            ->get();
        $trialBalance = [];
        $totalDebit = 0;
        $totalCredit = 0;

        $typeLabels = [
            'asset' => '1. ASET',
            'liability' => '2. KEWAJIBAN',
            'equity' => '3. MODAL / EKUITAS',
            'revenue' => '4. PENDAPATAN',
            'cogs' => '5. BEBAN',
            'expense' => '5. BEBAN',
        ];

        foreach ($accounts as $account) {
            // Hitung Saldo Awal (sebelum startDate)
            $beginningBalance = 0;
            if ($startDate) {
                $prevDebit = GeneralJournal::where('account_id', $account->id)
                    ->where('journal_date', '<', $startDate)
                    ->where('type', 'debit')
                    ->sum('amount');

                $prevCredit = GeneralJournal::where('account_id', $account->id)
                    ->where('journal_date', '<', $startDate)
                    ->where('type', 'credit')
                    ->sum('amount');

                if (in_array($account->type, ['asset', 'expense', 'cogs'])) {
                    $beginningBalance = $prevDebit - $prevCredit;
                } else {
                    $beginningBalance = $prevCredit - $prevDebit;
                }
            }

            // LOGIKA SINKRONISASI DENGAN BUKU BESAR:
            if ($account->activity_count === 0 && $beginningBalance == 0) {
                continue;
            }

            // Calculate total debit and credit
            $debitQuery = GeneralJournal::where('account_id', $account->id)->where('type', 'debit');
            $creditQuery = GeneralJournal::where('account_id', $account->id)->where('type', 'credit');

            if ($endDate) {
                // Jika ada endDate, hitung saldo akhir per tanggal tersebut (sinkron Buku Besar)
                $debitSum = $debitQuery->where('journal_date', '<=', $endDate)->sum('amount');
                $creditSum = $creditQuery->where('journal_date', '<=', $endDate)->sum('amount');
            } else {
                // Jika "Semua Data", ambil total keseluruhan tanpa batas (sinkron Buku Besar)
                $debitSum = $debitQuery->sum('amount');
                $creditSum = $creditQuery->sum('amount');
            }

            // LOGIKA SINKRONISASI SALDO AKHIR DENGAN BUKU BESAR:
            // Saldo akhir dihitung berdasarkan net balance (Debit - Kredit atau sebaliknya)
            $netDebit = 0;
            $netCredit = 0;
            $isNormalDebit = in_array($account->type, ['asset', 'expense', 'cogs']);

            if ($isNormalDebit) {
                $balance = $debitSum - $creditSum;
                if ($balance >= 0) {
                    $netDebit = $balance;
                } else {
                    $netCredit = abs($balance);
                }
            } else {
                $balance = $creditSum - $debitSum;
                if ($balance >= 0) {
                    $netCredit = $balance;
                } else {
                    $netDebit = abs($balance);
                }
            }

            $typeLabel = $typeLabels[$account->type] ?? strtoupper($account->type);
            $trialBalance[$typeLabel][] = [
                'code' => $account->code,
                'name' => $account->name,
                'debit' => $netDebit,
                'credit' => $netCredit,
            ];

            $totalDebit += $netDebit;
            $totalCredit += $netCredit;
        }

        $years = range(Carbon::now()->year - 5, Carbon::now()->year + 1);
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        return view('report.trial_balance', compact(
            'trialBalance', 'totalDebit', 'totalCredit', 'year', 'month',
            'years', 'months', 'filterType', 'startDate', 'endDate'
        ));
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

        $year = $yearInput ?: Carbon::now()->year;
        $month = $monthInput ?: Carbon::now()->month;
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
        }

        $query = GeneralJournal::with('account');

        if ($filterType === 'per_bulan') {
            $query->whereYear('journal_date', $year)->whereMonth('journal_date', $month);
        } elseif ($filterType === 'per_tahun') {
            $query->whereYear('journal_date', $year);
        } elseif ($filterType === 'custom' && $startDateInput && $endDateInput) {
            $startDate = Carbon::parse($startDateInput)->startOfDay();
            $endDate = Carbon::parse($endDateInput)->endOfDay();
            $query->whereBetween('journal_date', [$startDate, $endDate]);
        }

        $journals = $query->get();

        $accounts = [];
        foreach ($journals as $journal) {
            $accountId = $journal->account_id;
            if (!isset($accounts[$accountId])) {
                $accounts[$accountId] = [
                    'code' => $journal->account->code,
                    'name' => $journal->account->name,
                    'type' => $journal->account->type,
                    'debit' => 0,
                    'credit' => 0,
                ];
            }

            if ($journal->type === 'debit') {
                $accounts[$accountId]['debit'] += $journal->amount;
            } else {
                $accounts[$accountId]['credit'] += $journal->amount;
            }
        }

        $trialBalance = [];
        $categoryOrder = ['asset', 'liability', 'equity', 'revenue', 'expense', 'cogs'];
        foreach ($categoryOrder as $category) {
            $trialBalance[$category] = [];
        }

        foreach ($accounts as $account) {
            $debit = $account['debit'];
            $credit = $account['credit'];

            if (in_array($account['type'], ['asset', 'expense', 'cogs'])) {
                $balance = $debit - $credit;
                if ($balance > 0) {
                    $finalDebit = $balance;
                    $finalCredit = 0;
                } else {
                    $finalDebit = 0;
                    $finalCredit = abs($balance);
                }
            } else {
                $balance = $credit - $debit;
                if ($balance > 0) {
                    $finalDebit = 0;
                    $finalCredit = $balance;
                } else {
                    $finalDebit = abs($balance);
                    $finalCredit = 0;
                }
            }

            if ($finalDebit != 0 || $finalCredit != 0) {
                $trialBalance[$account['type']][] = [
                    'code' => $account['code'],
                    'name' => $account['name'],
                    'debit' => $finalDebit,
                    'credit' => $finalCredit,
                ];
            }
        }

        $totalDebit = 0;
        $totalCredit = 0;
        foreach ($trialBalance as $accounts) {
            foreach ($accounts as $account) {
                $totalDebit += $account['debit'];
                $totalCredit += $account['credit'];
            }
        }

        return view('report.trial_balance-print', compact('trialBalance', 'totalDebit', 'totalCredit', 'filterType', 'year', 'month', 'startDate', 'endDate'));
    }

    public function exportExcel(Request $request)
    {
        // Auto-sync before exporting
        GeneralJournal::syncAll();

        // Implementation for CSV export similar to BukuBesarController
        $filterType = $request->input('filter_type', 'per_bulan');
        $yearInput = $request->input('year');
        $monthInput = $request->input('month');
        $startDateInput = $request->input('start_date');
        $endDateInput = $request->input('end_date');

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
        } elseif ($filterType === 'custom') {
            if ($startDateInput) {
                $startDate = Carbon::parse($startDateInput)->startOfDay();
            }
            if ($endDateInput) {
                $endDate = Carbon::parse($endDateInput)->endOfDay();
            }
        } elseif ($filterType === 'all') {
            $startDate = null;
            $endDate = Carbon::now()->endOfDay();
        } else {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        }

        $accounts = ChartOfAccount::where('is_active', true)
            ->withCount(['journals as activity_count' => function ($query) use ($startDate, $endDate) {
                if ($startDate && $endDate) {
                    $query->whereBetween('journal_date', [$startDate, $endDate]);
                } elseif ($startDate) {
                    $query->where('journal_date', '>=', $startDate);
                } elseif ($endDate) {
                    $query->where('journal_date', '<=', $endDate);
                }
            }])
            ->orderByRaw("CASE 
                WHEN type = 'asset' THEN 1 
                WHEN type = 'liability' THEN 2 
                WHEN type = 'equity' THEN 3 
                WHEN type = 'revenue' THEN 4 
                WHEN type = 'cogs' THEN 5 
                WHEN type = 'expense' THEN 6 
                ELSE 7 END")
            ->orderBy('code')
            ->get();

        $fileName = 'Neraca_Saldo_'.date('Ymd_His').'.csv';

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($accounts, $filterType, $month, $year, $startDate, $endDate) {
            $file = fopen('php://output', 'w');
            fwrite($file, (chr(0xEF).chr(0xBB).chr(0xBF)));

            fputcsv($file, ['PABRIK KAYU JAYA ABADI']);
            fputcsv($file, ['Neraca Saldo']);

            $months = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
            ];

            $periode = 'Semua Data';
            if ($filterType === 'per_bulan') {
                $periode = 'Periode: '.($months[$month] ?? '').' '.$year;
            } elseif ($filterType === 'per_tahun') {
                $periode = 'Tahun: '.$year;
            } elseif ($filterType === 'custom') {
                if ($startDate && $endDate) {
                    $periode = 'Periode: '.$startDate->format('d/m/Y').' s/d '.$endDate->format('d/m/Y');
                } elseif ($startDate) {
                    $periode = 'Dari: '.$startDate->format('d/m/Y');
                } elseif ($endDate) {
                    $periode = 'Hingga: '.$endDate->format('d/m/Y');
                }
            }
            fputcsv($file, [$periode]);
            fputcsv($file, []);
            fputcsv($file, ['Kode Akun', 'Nama Akun', 'Debit (Rp)', 'Kredit (Rp)']);

            $totalDebit = 0;
            $totalCredit = 0;

            foreach ($accounts as $account) {
                // Hitung Saldo Awal (sebelum startDate)
                $beginningBalance = 0;
                if ($startDate) {
                    $prevDebit = GeneralJournal::where('account_id', $account->id)
                        ->where('journal_date', '<', $startDate)
                        ->where('type', 'debit')
                        ->sum('amount');

                    $prevCredit = GeneralJournal::where('account_id', $account->id)
                        ->where('journal_date', '<', $startDate)
                        ->where('type', 'credit')
                        ->sum('amount');

                    if (in_array($account->type, ['asset', 'expense', 'cogs'])) {
                        $beginningBalance = $prevDebit - $prevCredit;
                    } else {
                        $beginningBalance = $prevCredit - $prevDebit;
                    }
                }

                // SINKRONISASI DENGAN BUKU BESAR
                if ($account->activity_count === 0 && $beginningBalance == 0) {
                    continue;
                }

                $debitQuery = GeneralJournal::where('account_id', $account->id)->where('type', 'debit');
                $creditQuery = GeneralJournal::where('account_id', $account->id)->where('type', 'credit');

                if ($startDate && $endDate) {
                    $debitSum = $debitQuery->where('journal_date', '<=', $endDate)->sum('amount');
                    $creditSum = $creditQuery->where('journal_date', '<=', $endDate)->sum('amount');
                } else {
                    $debitSum = $debitQuery->sum('amount');
                    $creditSum = $creditQuery->sum('amount');
                }

                // LOGIKA SINKRONISASI SALDO AKHIR DENGAN BUKU BESAR
                $netDebit = 0;
                $netCredit = 0;
                $isNormalDebit = in_array($account->type, ['asset', 'expense', 'cogs']);

                if ($isNormalDebit) {
                    $balance = $debitSum - $creditSum;
                    if ($balance >= 0) {
                        $netDebit = $balance;
                    } else {
                        $netCredit = abs($balance);
                    }
                } else {
                    $balance = $creditSum - $debitSum;
                    if ($balance >= 0) {
                        $netCredit = $balance;
                    } else {
                        $netDebit = abs($balance);
                    }
                }

                fputcsv($file, [$account->code, $account->name, $netDebit, $netCredit]);
                $totalDebit += $netDebit;
                $totalCredit += $netCredit;
            }

            fputcsv($file, ['', 'TOTAL', $totalDebit, $totalCredit]);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
